<?php

namespace App\Http\Controllers;

use App\Estudiante;
use App\Inscripcion;
use App\Paralelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnvioCorreoController extends Controller
{
    public function index(Request $request)
    {
        return view("envio_correos.index");
    }
    public function create()
    {
        $gestion_min = Inscripcion::min('gestion');
        $gestion_max = Inscripcion::max('gestion');

        // $array_gestiones = [];
        // if ($gestion_min) {
        //     $array_gestiones[''] = 'Seleccione...';
        //     for ($i = (int)$gestion_min; $i <= (int)$gestion_max; $i++) {
        //         $array_gestiones[$i] = $i;
        //     }
        // } else {
        //     $array_gestiones = [date("Y")];
        // }

        $array_gestiones = [date("Y")];

        $estudiantes = Estudiante::where("estado", 1)->orderBy("paterno", "asc")->get();
        $array_estudiantes[""] = "- Seleccionar Estudiante -";

        foreach ($estudiantes as $value) {
            $array_estudiantes[$value->id] = $value->paterno . $value->matero ? ' ' . $value->paterno : ' ' . $value->nombre1;
        }

        $paralelos = Paralelo::all();
        foreach ($paralelos as $value) {
            $array_paralelos[$value->id] = $value->paralelo;
        }
        $profesor = null;
        if (Auth::user()->tipo == 'PROFESOR') {
            $profesor = Profesor::where("user_id", Auth::user()->id)->get()->first();
        }

        return view("envio_correos.create", compact("array_gestiones", "array_estudiantes", "array_paralelos", "profesor"));
    }
    public function store()
    {
    }
    public function edit($id)
    {
    }
    public function update($id, Request $request)
    {
    }
    public function show($id)
    {
    }
    public function destroy($id)
    {
    }
}
