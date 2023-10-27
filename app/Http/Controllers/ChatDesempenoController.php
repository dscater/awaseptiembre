<?php

namespace App\Http\Controllers;

use App\ChatDesempeno;
use App\DesempenoEstudiante;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChatDesempenoController extends Controller
{
    public function index(DesempenoEstudiante $desempeno_estudiante)
    {
        $estudiante = $desempeno_estudiante->estudiante;
        $options = '<option value="">Seleccione...</option>';
        if ($estudiante->user_tutor) {
            $options .= '<option value="' . $estudiante->user_tutor->id . '">' . $estudiante->full_name_tutor . '</option>';
        }
        if ($estudiante->user_madre) {
            $options .= '<option value="' . $estudiante->user_madre->id . '">' . $estudiante->full_name_madre . '</option>';
        }
        return view("chat_desempeno.index", compact("desempeno_estudiante", "options"));
    }

    public function getMensajes(Request $request)
    {
        $user = Auth::user();
        $receptor_id = $request->receptor_id;
        $mensajes = ChatDesempeno::where([["emisor_id", $receptor_id], ["receptor_id", $user->id]])
            ->orWhere([["emisor_id", $user->id], ["receptor_id", $receptor_id]])
            ->get();
        $html = view("chat_desempeno.parcial.mensajes", compact("mensajes"))->render();
        // return "Sin mensjaes";
        $existen_mensajes = false;
        if (count($mensajes) > 0) {
            $existen_mensajes = true;
        }

        return response()->JSON([
            "sw" => $existen_mensajes,
            "html" => $html
        ]);
    }


    public function getNuevosMensajes(Request $request)
    {
        $user = Auth::user();
        $ultimo_id = $request->ultimo_id;
        $receptor_id = $request->receptor_id;
        $mensajes = [];
        $html = "";
        $existen_mensajes = 1;
        if ($ultimo_id && $ultimo_id > 0) {
            $mensajes = ChatDesempeno::where([["emisor_id", $user->id], ["receptor_id", $receptor_id], ["id", ">", $ultimo_id]])
                ->orWhere([["emisor_id", $receptor_id], ["receptor_id", $user->id], ["id", ">", $ultimo_id]])
                ->get();
            $html = view("chat_desempeno.parcial.mensajes", compact("mensajes"))->render();
            if (count($mensajes) <= 0) {
                $html = "";
                $existen_mensajes = 2;
            }
        } else {
            $mensajes = ChatDesempeno::where([["emisor_id", $receptor_id], ["receptor_id", $user->id]])
                ->orWhere([["emisor_id", $user->id], ["receptor_id", $receptor_id]])
                ->get();
            $existen_mensajes = 1;
            $html = view("chat_desempeno.parcial.mensajes", compact("mensajes"))->render();
            if (count($mensajes) <= 0) {
                $html = '<div class="row vacio">
                <div class="col-md-12 text-center"><i class="text-white">SIN MENSAJES</i></div>
            </div>';
                $existen_mensajes = 0;
            }
        }


        $lista_mensajes = ChatDesempeno::where([["emisor_id", $receptor_id], ["receptor_id", $user->id]])
            ->orWhere([["emisor_id", $user->id], ["receptor_id", $receptor_id]])
            ->get();

        // marcar vistos si elusuario es receptor
        ChatDesempeno::where("receptor_id", $user->id)->where("emisor_id", $receptor_id)->update(["visto" => 1]);
        $mensajes_actuales = [];
        if (count($lista_mensajes) > 0) {
            foreach ($lista_mensajes as $value) {
                $mensajes_actuales[] = ["id" => $value->id, "hace" => $value->created_at->diffForHumans()];
            }
        }

        return response()->JSON(["html" => $html, "existen_mensajes" => $existen_mensajes, "mensajes_actuales" => $mensajes_actuales]);
    }

    public function store(DesempenoEstudiante $desempeno_estudiante, Request $request)
    {
        $mensaje = $request->mensaje;
        $receptor_id = $request->receptor_id;
        $emisor_id = Auth::user()->id;
        $nuevo_chat_desempeno = $desempeno_estudiante->chat_desempenos()->create([
            "emisor_id" => $emisor_id,
            "receptor_id" => $receptor_id,
            "mensaje" => $mensaje,
            "visto" => 0,
        ]);

        $mensaje = $nuevo_chat_desempeno;
        $html_mensaje = view("chat_desempeno.parcial.mensaje", compact("mensaje"))->render();;
        return response()->JSON(["mensaje" => $mensaje, "html_mensaje" => $html_mensaje]);
    }
}
