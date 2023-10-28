<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesor;
use App\Inscripcion;
use App\Paralelo;
use App\TrimestreActividad;
use App\Calificacion;
use App\CalificacionTrimestre;
use App\ProfesorMateria;
use App\Estudiante;
use App\HistorialAccion;
use App\Notificacion;
use App\NotificacionUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CalificacionController extends Controller
{
    public $validacion = [
        'gestion' => 'required',
        'profesor_materia_id' => 'required',
        'inscripcion_id' => 'required',
        'ponderacion' => 'required|numeric|min:0|max:100',
    ];

    public $mensajes = [
        'gestion.required' => 'Este campo es obligatorio',
        'profesor_materia_id.required' => 'Este campo es obligatorio',
        'inscripcion_id.required' => 'Este campo es obligatorio',
        'ponderacion.required' => 'Este campo es obligatorio',
        'ponderacion.numeric' => 'Debes indicar un valor númerico',
        'ponderacion.min' => 'El valor debe ser mayor o igual a :min',
        'ponderacion.max' => 'El valor no puede ser mayor a :max',
    ];

    public function index(Profesor $profesor)
    {
        $calificacions = Calificacion::orderBy("id", "desc")->get();
        if (Auth::user()->tipo == 'PROFESOR') {
            $id_profesor_materias = ProfesorMateria::where('profesor_id', Auth::user()->profesor->id)
                ->pluck("id");
            $calificacions = Calificacion::whereIn("profesor_materia_id", $id_profesor_materias)->orderBy("id", "desc")->get();
        }
        if (Auth::user()->tipo == "ESTUDIANTE") {
            $calificacions = Calificacion::select("calificacions.*")
                ->join("notificacions", "notificacions.registro_id", "=", "calificacions.id")
                ->join("notificacion_users", "notificacion_users.notificacion_id", "=", "notificacions.id")
                ->where("notificacions.modulo", "calificacion")
                ->where("notificacion_users.user_id", Auth::user()->id)
                ->orderBy("id", "desc")->get();
        }
        return view('calificacions.index', compact('calificacions'));
    }

    public function create()
    {
        $gestion_min = Inscripcion::min('gestion');
        $gestion_max = Inscripcion::max('gestion');

        $array_gestiones = [];
        if ($gestion_min) {
            $array_gestiones[''] = 'Seleccione...';
            for ($i = (int)$gestion_min; $i <= (int)$gestion_max; $i++) {
                $array_gestiones[$i] = $i;
            }
        } else {
            $array_gestiones = [date("Y")];
        }

        $profesor = null;
        if (Auth::user()->tipo == 'PROFESOR') {
            $profesor = Profesor::where("user_id", Auth::user()->id)->get()->first();
        }
        return view('calificacions.create', compact('array_gestiones', 'profesor'));
    }


    public function store(Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            // crear la Calificacion
            $profesor_materia = ProfesorMateria::find($request->profesor_materia_id);
            $inscripcion = Inscripcion::find($request->inscripcion_id);
            $request["estudiante_id"] = $inscripcion->estudiante_id;
            $request["materia_id"] = $profesor_materia->materia_id;
            $request["fecha_registro"] = date("Y-m-d");
            $nueva_calificacion = Calificacion::create(array_map('mb_strtoupper', $request->all()));
            $nueva_calificacion->descripcion = nl2br(mb_strtoupper($request->descripcion));
            $nueva_calificacion->save();

            $datos_original = HistorialAccion::getDetalleRegistro($nueva_calificacion, "calificacions");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' REGISTRO UNA CALIFICACIÓN',
                'datos_original' => $datos_original,
                'modulo' => 'CALIFICACIONES',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            // crear notificacion
            $notificacion = Notificacion::create([
                "registro_id" => $nueva_calificacion->id,
                "modulo" => "calificacion",
                "descripcion" => "SE REGISTRO UNA CALIFICACIÓN EN LA MATERIA DE " . $nueva_calificacion->materia->nombre,
            ]);

            // registrar notificacion-user
            NotificacionUser::create([
                "notificacion_id" => $notificacion->id,
                "user_id" => $inscripcion->estudiante->user->id,
                "visto" => 0,
            ]);

            DB::commit();
            return redirect()->route("calificacions.index")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("calificacions.index")->with("error", $e->getMessage());
        }
    }
    public function edit(Calificacion $calificacion)
    {
        $gestion_min = Inscripcion::min('gestion');
        $gestion_max = Inscripcion::max('gestion');

        $array_gestiones = [];
        if ($gestion_min) {
            $array_gestiones[''] = 'Seleccione...';
            for ($i = (int)$gestion_min; $i <= (int)$gestion_max; $i++) {
                $array_gestiones[$i] = $i;
            }
        } else {
            $array_gestiones = [date("Y")];
        }

        $profesor = null;
        if (Auth::user()->tipo == 'PROFESOR') {
            $profesor = Profesor::where("user_id", Auth::user()->id)->get()->first();
        }
        return view('calificacions.edit', compact('calificacion', 'array_gestiones', 'profesor'));
    }

    public function show(Calificacion $calificacion)
    {
        if (Auth::user()->tipo == "ESTUDIANTE") {
            $notificacion_user = NotificacionUser::select("notificacion_users.*")
                ->join("notificacions", "notificacions.id", "=", "notificacion_users.notificacion_id")
                ->where("notificacions.modulo", "calificacion")
                ->where("notificacion_users.user_id", Auth::user()->id)
                ->where("notificacions.registro_id", $calificacion->id)
                ->orderBy("id", "desc")->get()->first();
            $notificacion_user->visto = 1;
            $notificacion_user->save();
        }
        return view('calificacions.show', compact('calificacion'));
    }

    public function update(Calificacion $calificacion, Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($calificacion, "calificacions");
            // actualizar la Calificacion
            $profesor_materia = ProfesorMateria::find($request->profesor_materia_id);
            $inscripcion = Inscripcion::find($request->inscripcion_id);
            $request["estudiante_id"] = $inscripcion->estudiante_id;
            $request["materia_id"] = $profesor_materia->materia_id;
            $calificacion->update(array_map('mb_strtoupper', $request->all()));
            $calificacion->descripcion = nl2br(mb_strtoupper($request->descripcion));
            $calificacion->save();

            $datos_nuevo = HistorialAccion::getDetalleRegistro($calificacion, "calificacions");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' MODIFICÓ UNA CALIFICACIÓN',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'CALIFICACIONES',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return redirect()->route("calificacions.index")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("calificacions.index")->with("error", $e->getMessage());
        }
    }


    public function destroy(Calificacion $calificacion)
    {
        DB::beginTransaction();
        try {
            // eliminar notificacion
            $notificacion = Notificacion::where("registro_id", $calificacion->id)->where("modulo", "calificacion")->get()->first();
            if ($notificacion) {
                $notificacion->notificacion_users()->delete();
                $notificacion->delete();
            }

            $datos_original = HistorialAccion::getDetalleRegistro($calificacion, "calificacions");
            $calificacion->delete();
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' ELIMINÓ UNA CALIFICACIÓN',
                'datos_original' => $datos_original,
                'modulo' => 'CALIFICACIONES',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return redirect()->route("calificacions.index")->with("bien", "Registro eliminado");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("calificacions.index")->with("error", $e->getMessage());
        }
    }

    public function calificacion_estudiante(Estudiante $estudiante)
    {
        $gestion_min = Inscripcion::min('gestion');
        $gestion_max = Inscripcion::max('gestion');

        $array_gestiones = [];
        if ($gestion_min) {
            $array_gestiones[''] = 'Seleccione...';
            for ($i = (int)$gestion_min; $i <= (int)$gestion_max; $i++) {
                $array_gestiones[$i] = $i;
            }
        }

        $paralelos = paralelo::all();
        $array_paralelos[''] = 'Seleccione...';

        foreach ($paralelos as $value) {
            $array_paralelos[$value->id] = $value->paralelo;
        }


        return view('calificacions.calificacion_estudiante', compact('estudiante', 'array_gestiones', 'array_paralelos'));
    }

    public function getEstudiantesMateria(Request $request)
    {
        $materia = $request->materia;
        $gestion = $request->gestion;

        $profesor_materia = ProfesorMateria::find($materia);

        $inscripcions = Inscripcion::where('inscripcions.nivel', $profesor_materia->nivel)
            ->where('inscripcions.grado', $profesor_materia->grado)
            ->where('inscripcions.paralelo_id', $profesor_materia->paralelo_id)
            ->where('inscripcions.turno', $profesor_materia->turno)
            ->where('inscripcions.gestion', $gestion)
            ->where('inscripcions.status', 1)
            ->get();

        $html = '<option>Seleccione...</option>';
        if (count($inscripcions) > 0) {
            foreach ($inscripcions as $inscripcion) {
                $html .= ' <option value="' . $inscripcion->id . '">' . $inscripcion->estudiante->full_name . '</option>';
            }
        } else {
            $html = '<option>- Sin resultados -</option>';
        }

        return response()->JSON([
            'sw' => true,
            'html' => $html
        ]);
    }
}
