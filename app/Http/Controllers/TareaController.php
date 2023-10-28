<?php

namespace App\Http\Controllers;

use App\Entrega;
use App\HistorialAccion;
use App\Inscripcion;
use App\Notificacion;
use App\NotificacionUser;
use App\Profesor;
use App\ProfesorMateria;
use App\Tarea;
use App\TareaArchivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TareaController extends Controller
{
    public $validacion = [
        'gestion' => 'required',
        'profesor_materia_id' => 'required',
        'nombre' => 'required',
        'fecha_asignacion' => 'required|date',
        'fecha_limite' => 'required|date',
    ];

    public $mensajes = [
        'gestion.required' => 'Este campo es obligatorio',
        'profesor_materia_id.required' => 'Este campo es obligatorio',
        'nombre.required' => 'Este campo es obligatorio',
        'fecha_asignacion.required' => 'Este campo es obligatorio',
        'fecha_asignacion.date' => 'Debes indicar una fecha valida',
        'fecha_limite.required' => 'Este campo es obligatorio',
        'fecha_limite.date' => 'Debes indicar una fecha valida',
    ];

    public function index()
    {
        $fecha_actual = date("Y-m-d");
        DB::update("UPDATE tareas SET estado='VENCIDO' WHERE fecha_limite < $fecha_actual");

        $tareas = Tarea::orderBy("id", "desc")->get();
        if (Auth::user()->tipo == "PROFESOR") {
            $id_profesor_materias = ProfesorMateria::where('profesor_id', Auth::user()->profesor->id)
                ->pluck("id");
            $tareas = Tarea::whereIn("profesor_materia_id", $id_profesor_materias)->orderBy("id", "desc")->get();
        }
        return view("tareas.index", compact("tareas"));
    }

    public function tareas_estudiante(Request $request)
    {
        $fecha_actual = date("Y-m-d");
        DB::update("UPDATE tareas SET estado='VENCIDO' WHERE fecha_limite < '$fecha_actual'");
        if ($request->ajax()) {
            $gestion =  $request->gestion;
            $inscripcion = Inscripcion::where("status", 1)
                ->where("gestion", $gestion)
                ->where("estudiante_id", Auth::user()->estudiante->id)
                ->get()->first();
            $html = "";
            if ($inscripcion) {
                $entregas = Entrega::select("entregas.*")
                    ->join("tareas", "tareas.id", "=", "entregas.tarea_id")
                    ->where("inscripcion_id", $inscripcion->id)
                    ->where("tareas.gestion", $gestion)
                    ->orderBy("id", "desc")
                    ->get();
                $html = view("tareas.parcial.tareas_entregas", compact("entregas"))->render();
            }
            return response()->JSON($html);
        }
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

        return view("tareas.tareas_estudiante", compact("array_gestiones"));
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
        return view("tareas.create", compact("array_gestiones", 'profesor'));
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            // crear el Tarea
            $profesor_materia = ProfesorMateria::find($request->profesor_materia_id);
            $request["materia_id"] = $profesor_materia->materia_id;
            $request["user_id"] = Auth::user()->id;
            $request["estado"] = "VIGENTE";
            $request["fecha_registro"] = date("Y-m-d");
            $nueva_tarea = Tarea::create(array_map('mb_strtoupper', $request->except("links")));
            $nueva_tarea->descripcion = nl2br(mb_strtoupper($request->descripcion));
            $nueva_tarea->save();
            $links = $request->links;
            if (isset($links)) {
                foreach ($links as $link) {
                    $nueva_tarea->tarea_archivos()->create([
                        "link" => $link
                    ]);
                }
            }
            $datos_original = HistorialAccion::getDetalleRegistro($nueva_tarea, "tareas");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' REGISTRO UNA TAREA',
                'datos_original' => $datos_original,
                'modulo' => 'TAREAS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            // inicializar Entregas/Notificaciones

            // crear notificacion
            $notificacion = Notificacion::create([
                "registro_id" => $nueva_tarea->id,
                "modulo" => "tarea",
                "descripcion" => "SE ASIGNÓ UNA TAREA EN LA MATERIA DE " . $nueva_tarea->materia->nombre,
            ]);

            $inscripcions = Inscripcion::select("inscripcions.*")
                ->where("gestion", $profesor_materia->gestion)
                ->where("nivel", $profesor_materia->nivel)
                ->where("grado", $profesor_materia->grado)
                ->where("paralelo_id", $profesor_materia->paralelo_id)
                ->where("turno", $profesor_materia->turno)
                ->where("inscripcions.status", 1)
                ->get();

            foreach ($inscripcions as $i) {
                // registrar entrega
                Entrega::create([
                    "user_id" => $i->estudiante->user->id,
                    "inscripcion_id" => $i->id,
                    "profesor_materia_id" => $profesor_materia->id,
                    "materia_id" => $nueva_tarea->materia_id,
                    "tarea_id" => $nueva_tarea->id,
                    "estado" => "SIN ENTREGAR",
                    "enviado" => "NO",
                    "fecha_registro" => date("Y-m-d"),
                    "activo" => 0,
                ]);
                // registrar notificacion-user
                NotificacionUser::create([
                    "notificacion_id" => $notificacion->id,
                    "user_id" => $i->estudiante->user->id,
                    "visto" => 0,
                ]);
            }

            DB::commit();
            return redirect()->route("tareas.index")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("tareas.index")->with("error", $e->getMessage());
        }
    }

    public function show(Tarea $tarea)
    {
        if (Auth::user()->tipo == "ESTUDIANTE") {
            $notificacion_user = NotificacionUser::select("notificacion_users.*")
                ->join("notificacions", "notificacions.id", "=", "notificacion_users.notificacion_id")
                ->where("notificacions.modulo", "tarea")
                ->where("notificacion_users.user_id", Auth::user()->id)
                ->where("notificacions.registro_id", $tarea->id)
                ->orderBy("id", "desc")->get()->first();
            $notificacion_user->visto = 1;
            $notificacion_user->save();
        }
        return view("tareas.show", compact("tarea"));
    }

    public function edit(Tarea $tarea)
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
        return view("tareas.edit", compact("tarea", "array_gestiones", "profesor"));
    }

    public function update(Request $request, Tarea $tarea)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($tarea, "tareas");
            $tarea->update(array_map('mb_strtoupper', $request->except("links", "id_modificados", "modificados", "eliminados")));
            $tarea->descripcion = nl2br(mb_strtoupper($request->descripcion));
            $tarea->save();
            $eliminados = $request->eliminados;
            if (isset($eliminados)) {
                foreach ($eliminados as $eliminado) {
                    if ($eliminado) {
                        $archivo = TareaArchivo::findOrFail($eliminado);
                        $archivo->delete();
                    }
                }
            }

            $id_modificados = $request->id_modificados;
            $modificados = $request->modificados;
            if (isset($id_modificados)) {
                for ($i = 0; $i < count($id_modificados); $i++) {
                    $archivo = TareaArchivo::findOrFail($id_modificados[$i]);
                    $archivo->update([
                        "link" => $modificados[$i]
                    ]);
                }
            }
            $links = $request->links;
            if (isset($links)) {
                foreach ($links as $link) {
                    $tarea->tarea_archivos()->create([
                        "link" => $link
                    ]);
                }
            }

            $datos_nuevo = HistorialAccion::getDetalleRegistro($tarea, "tareas");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' MODIFICÓ UNA TAREA',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'TAREAS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return redirect()->route("tareas.index")->with("bien", "Registro actualizado");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("tareas.index")->with("error", $e->getMessage());
        }
    }
    public function destroy(Tarea $tarea)
    {
        DB::beginTransaction();
        try {
            // eliminar notificacion
            $notificacion = Notificacion::where("registro_id", $tarea->id)->where("modulo", "tarea")->get()->first();
            if ($notificacion) {
                $notificacion->notificacion_users()->delete();
                $notificacion->delete();
            }
            $tarea->tarea_archivos()->delete();
            $tarea->entregas()->delete();
            $datos_original = HistorialAccion::getDetalleRegistro($tarea, "tareas");
            $tarea->delete();
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' ELIMINÓ UNA TAREA',
                'datos_original' => $datos_original,
                'modulo' => 'TAREAS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return redirect()->route("tareas.index")->with("bien", "Registro eliminado");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("tareas.index")->with("error", $e->getMessage());
        }
    }
}
