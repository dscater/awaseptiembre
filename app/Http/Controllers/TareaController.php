<?php

namespace App\Http\Controllers;

use App\Entrega;
use App\HistorialAccion;
use App\Inscripcion;
use App\Notificacion;
use App\NotificacionUser;
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
        'profesor_materia_id' => 'required',
        'nombre' => 'required',
        'fecha_asignacion' => 'required|date',
        'fecha_limite' => 'required|date',
    ];

    public $mensajes = [
        'profesor_materia_id.required' => 'Este campo es obligatorio',
        'nombre.required' => 'Este campo es obligatorio',
        'fecha_asignacion.required' => 'Este campo es obligatorio',
        'fecha_asignacion.date' => 'Debes indicar una fecha valida',
        'fecha_limite.required' => 'Este campo es obligatorio',
        'fecha_limite.date' => 'Debes indicar una fecha valida',
    ];

    public function index()
    {
        $tareas = Tarea::orderBy("id", "desc")->get();
        if (Auth::user()->tipo == "PROFESOR") {
            $tareas = Tarea::where("user_id", Auth::user()->id)->orderBy("id", "desc")->get();
        }
        return view("tareas.index", compact("tareas"));
    }

    public function create()
    {
        $gestion = date("Y");
        $materias = ProfesorMateria::where('profesor_id', Auth::user()->profesor->id)
            ->where('gestion', $gestion)
            ->get();

        $array_materias[''] = 'Seleccione...';
        foreach ($materias as $value) {
            $array_materias[$value->id] = $value->materia->nombre . ' | ' . $value->nivel . ' | ' . $value->grado . '° ' . $value->paralelo->paralelo;
        }
        return view("tareas.create", compact("array_materias"));
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            // crear el Tarea
            $gestion = date("Y");
            $profesor_materia = ProfesorMateria::find($request->profesor_materia_id);
            $request["materia_id"] = $profesor_materia->materia_id;
            $request["user_id"] = Auth::user()->id;
            $request["estado"] = "VIGENTE";
            $request["gestion"] = $gestion;
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
                    "materia_id" => $nueva_tarea->materia_id,
                    "tarea_id" => $nueva_tarea->id,
                    "estado" => "SIN ENTREGAR",
                    "enviado" => "NO",
                    "fecha_registro" => date("Y-m-d")
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
        return view("tareas.show", compact("tarea"));
    }

    public function edit(Tarea $tarea)
    {
        $gestion = date("Y");
        $materias = ProfesorMateria::where('profesor_id', Auth::user()->profesor->id)
            ->where('gestion', $gestion)
            ->get();

        $array_materias[''] = 'Seleccione...';
        foreach ($materias as $value) {
            $array_materias[$value->id] = $value->materia->nombre . ' | ' . $value->nivel . ' | ' . $value->grado . '° ' . $value->paralelo->paralelo;
        }
        return view("tareas.edit", compact("tarea", "array_materias"));
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
