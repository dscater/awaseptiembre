<?php

namespace App\Http\Controllers;

use App\Entrega;
use App\EntregaArchivo;
use App\HistorialAccion;
use App\Inscripcion;
use App\Notificacion;
use App\NotificacionUser;
use App\ProfesorMateria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EntregaController extends Controller
{
    public $validacion = [
        'observaciones' => 'required',
    ];

    public $mensajes = [
        'observaciones.required' => 'Este campo es obligatorio',
    ];

    public function index()
    {
        $fecha_actual = date("Y-m-d");
        DB::update("UPDATE tareas SET estado='VENCIDO' WHERE fecha_limite < $fecha_actual");

        $entregas = Entrega::orderBy("id", "desc")->where("activo", 1)->get();
        if (Auth::user()->tipo == "PROFESOR") {
            $id_profesor_materias = ProfesorMateria::where('profesor_id', Auth::user()->profesor->id)
                ->pluck("id");
            $entregas = Entrega::whereIn("profesor_materia_id", $id_profesor_materias)->where("activo", 1)->orderBy("id", "desc")->get();
        }
        if (Auth::user()->tipo == "ESTUDIANTE") {
            $entregas = Entrega::select("entregas.*")
                ->join("tareas", "tareas.id", "=", "entregas.tarea_id")
                ->join("notificacions", "notificacions.registro_id", "=", "tareas.id")
                ->join("notificacion_users", "notificacion_users.notificacion_id", "=", "notificacions.id")
                ->where("notificacions.modulo", "tarea")
                ->where("notificacion_users.user_id", Auth::user()->id)
                ->where("entregas.activo", 1)
                ->orderBy("id", "desc")->get();
        }
        return view("entregas.index", compact("entregas"));
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
        return view("entregas.create", compact("array_gestiones", 'profesor'));
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            // crear el Entrega
            $profesor_materia = ProfesorMateria::find($request->profesor_materia_id);
            $request["materia_id"] = $profesor_materia->materia_id;
            $request["user_id"] = Auth::user()->id;
            $request["estado"] = "VIGENTE";
            $request["fecha_registro"] = date("Y-m-d");
            $nueva_entrega = Entrega::create(array_map('mb_strtoupper', $request->except("links")));
            $nueva_entrega->descripcion = nl2br(mb_strtoupper($request->descripcion));
            $nueva_entrega->save();
            $links = $request->links;
            if (isset($links)) {
                foreach ($links as $link) {
                    $nueva_entrega->entrega_archivos()->create([
                        "link" => $link
                    ]);
                }
            }
            $datos_original = HistorialAccion::getDetalleRegistro($nueva_entrega, "entregas");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' REGISTRO UNA ENTREGA',
                'datos_original' => $datos_original,
                'modulo' => 'ENTREGAS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            // inicializar Entregas/Notificaciones
            // crear notificacion
            $notificacion = Notificacion::create([
                "registro_id" => $nueva_entrega->id,
                "modulo" => "entrega",
                "descripcion" => "SE ASIGNÓ UNA ENTREGA EN LA MATERIA DE " . $nueva_entrega->materia->nombre,
            ]);


            // registrar notificacion-user
            NotificacionUser::create([
                "notificacion_id" => $notificacion->id,
                "user_id" => 0, //profesor
                "visto" => 0,
            ]);

            DB::commit();
            return redirect()->route("entregas.index")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("entregas.index")->with("error", $e->getMessage());
        }
    }

    public function show(Entrega $entrega)
    {
        if (Auth::user()->tipo == "ESTUDIANTE" || Auth::user()->tipo == "PROFESOR") {
            $notificacion_user = NotificacionUser::select("notificacion_users.*")
                ->join("notificacions", "notificacions.id", "=", "notificacion_users.notificacion_id")
                ->where("notificacions.modulo", "entrega")
                ->where("notificacion_users.user_id", Auth::user()->id)
                ->where("notificacions.registro_id", $entrega->id)
                ->orderBy("id", "desc")->get()->first();
            if ($notificacion_user) {
                $notificacion_user->visto = 1;
                $notificacion_user->save();
            }
        }
        return view("entregas.show", compact("entrega"));
    }

    public function edit(Entrega $entrega)
    {
        return view("entregas.edit", compact("entrega"));
    }

    public function update(Request $request, Entrega $entrega)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $aux_activo = $entrega->activo;
            $datos_original = HistorialAccion::getDetalleRegistro($entrega, "entregas");
            $request["enviado"] = "SI";
            $request["estado"] = "ENTREGADO";
            $request["activo"] = 1;
            $request["fecha_entrega"] = date("Y-m-d");
            $entrega->update(array_map('mb_strtoupper', $request->except("links", "id_modificados", "modificados", "eliminados")));
            $entrega->observaciones = nl2br(mb_strtoupper($request->observaciones));
            $entrega->save();
            $eliminados = $request->eliminados;
            if (isset($eliminados)) {
                foreach ($eliminados as $eliminado) {
                    if ($eliminado) {
                        $archivo = EntregaArchivo::findOrFail($eliminado);
                        $archivo->delete();
                    }
                }
            }

            $id_modificados = $request->id_modificados;
            $modificados = $request->modificados;
            if (isset($id_modificados)) {
                for ($i = 0; $i < count($id_modificados); $i++) {
                    $archivo = EntregaArchivo::findOrFail($id_modificados[$i]);
                    $archivo->update([
                        "link" => $modificados[$i]
                    ]);
                }
            }
            $links = $request->links;
            if (isset($links)) {
                foreach ($links as $link) {
                    $entrega->entrega_archivos()->create([
                        "link" => $link
                    ]);
                }
            }

            $datos_nuevo = HistorialAccion::getDetalleRegistro($entrega, "entregas");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' REALIZÓ/ACTUALZÓ UNA ENTREGA',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'ENTREGAS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            if ($aux_activo == 0) {
                // inicializar Entregas/Notificaciones al profesor
                // crear notificacion
                $notificacion = Notificacion::create([
                    "registro_id" => $entrega->id,
                    "modulo" => "entrega",
                    "descripcion" => "SE REGISTRO UNA ENTREGA DE LA TAREA " . $entrega->tarea->nombre,
                ]);


                // registrar notificacion-user
                $profesor_materia = ProfesorMateria::find($entrega->profesor_materia_id);
                $profesor = $profesor_materia->profesor;
                NotificacionUser::create([
                    "notificacion_id" => $notificacion->id,
                    "user_id" => $profesor->user->id, //profesor
                    "visto" => 0,
                ]);
            }

            DB::commit();
            return redirect()->route("entregas.index")->with("bien", "Registro actualizado");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("entregas.index")->with("error", $e->getMessage());
        }
    }

    public function registra_calificacion(Request $request, Entrega $entrega)
    {
        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($entrega, "entregas");
            $entrega->update(array_map('mb_strtoupper', $request->all()));
            $datos_nuevo = HistorialAccion::getDetalleRegistro($entrega, "entregas");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' REGISTRO LA CALIFICACIÓN DE UNA ENTREGA',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'ENTREGAS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return redirect()->route("entregas.index")->with("bien", "Registro actualizado");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("entregas.index")->with("error", $e->getMessage());
        }
    }

    public function destroy(Entrega $entrega)
    {
        DB::beginTransaction();
        try {
            // eliminar notificacion
            $notificacion = Notificacion::where("registro_id", $entrega->id)->where("modulo", "entrega")->get()->first();
            if ($notificacion) {
                $notificacion->notificacion_users()->delete();
                $notificacion->delete();
            }
            $entrega->entrega_archivos()->delete();
            $datos_original = HistorialAccion::getDetalleRegistro($entrega, "entregas");
            $request["fecha_entrega"] = NULL;
            $entrega->enviado = "NO";
            $entrega->estado = "SIN ENTREGAR";
            $entrega->observaciones = "";
            $entrega->activo = 0;
            $entrega->save();
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' ELIMINÓ UNA ENTREGA',
                'datos_original' => $datos_original,
                'modulo' => 'ENTREGAS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return redirect()->route("entregas.index")->with("bien", "Registro eliminado");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("entregas.index")->with("error", $e->getMessage());
        }
    }
}
