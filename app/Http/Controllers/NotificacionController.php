<?php

namespace App\Http\Controllers;

use App\NotificacionUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    public function index(Request $request)
    {
        $ultimo_id = $request->ultimo_id;
        $no_vistos = count(NotificacionUser::where("user_id", Auth::user()->id)->where("visto", 0)->get());
        $total = count(NotificacionUser::where("user_id", Auth::user()->id)->get());
        $notificaciones = NotificacionUser::where("user_id", Auth::user()->id)->orderBy("created_at", "desc")->get();
        if ($ultimo_id != 0) {
            $notificaciones = NotificacionUser::where("user_id", Auth::user()->id)->where("visto", 0)->where("id", ">", $ultimo_id)->orderBy("created_at", "desc")->get();
        }

        $html = "";
        $ultimo_id = 0;
        if (count($notificaciones) > 0) {
            $ultimo_id = $notificaciones[0]->id;
            $html = view("notificacions.notificacions", compact("notificaciones"))->render();
        }
        if ($total > 0) {
            $ultimo_id = NotificacionUser::where("user_id", Auth::user()->id)->get()->last()->id;
        }

        return response()->JSON([
            "no_vistos" => $no_vistos,
            "html" => $html,
            "ultimo_id" => $ultimo_id
        ]);
    }
}
