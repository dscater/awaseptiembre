<?php

namespace App\Http\Controllers;

use App\ActividadProfesor;
use App\Profesor;
use Illuminate\Http\Request;

class ActividadProfesorController extends Controller
{
    public function index(Profesor $profesor)
    {
        $gestion_min = ActividadProfesor::min('fecha');
        $gestion_max = ActividadProfesor::max('fecha');

        if ($gestion_min) {
            $gestion_min = date("Y", strtotime($gestion_min));
        }
        if ($gestion_max) {
            $gestion_max = date("Y", strtotime($gestion_max));
        }

        $array_gestiones = [];
        if ($gestion_min) {
            $array_gestiones[''] = 'Seleccione...';
            for ($i = (int)$gestion_min; $i <= (int)$gestion_max; $i++) {
                $array_gestiones[$i] = $i;
            }
        } else {
            $array_gestiones[date("Y")] = date("Y");
        }

        return view('actividad_profesors.index', compact('profesor', "array_gestiones"));
    }

    public function lista()
    {
        $actividad_profesors = ActividadProfesor::orderBy("fecha", "desc")
            ->orderBy("created_at", "desc")
            ->get();

        return view('actividad_profesors.lista', compact('actividad_profesors'));
    }


    public function getActividadesProfesor(Profesor $profesor, Request $request)
    {
        $gestion = $request->gestion;
        $actividad_profesors = ActividadProfesor::where("user_id", $profesor->user_id)
            ->where("fecha", "LIKE", "$gestion%")
            ->orderBy("fecha", "desc")
            ->orderBy("created_at", "desc")
            ->get();

        $html = view("actividad_profesors.parcial.actividades", compact("actividad_profesors"))->render();

        return response()->JSON($html);
    }

    public function store(Profesor $profesor, Request $request)
    {
        $request["fecha_registro"] = date("Y-m-d");
        $profesor->user->actividad_profesors()->create(array_map("mb_strtoupper", $request->all()));
        return response()->JSON([
            "sw" => true,
            "msg" => "Registro éxitoso",
        ]);
    }

    public function update(ActividadProfesor $actividad_profesor, Request $request)
    {
        $actividad_profesor->update(array_map("mb_strtoupper", $request->all()));
        return response()->JSON([
            'sw' => false,
            'msg' => 'Actualización éxitosa'
        ]);
    }

    public function destroy(ActividadProfesor $actividad_profesor)
    {
        $profesor_id = $actividad_profesor->user->profesor->id;
        $actividad_profesor->delete();
        return redirect()->route('actividad_profesors.index', $profesor_id)->with('bien', 'Registro eliminado correctamente');
        // return response()->JSON([
        //     'sw' => false,
        //     'msg' => 'Eliminación éxitosa'
        // ]);
    }
}
