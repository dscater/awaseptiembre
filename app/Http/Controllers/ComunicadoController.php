<?php

namespace App\Http\Controllers;

use App\Comunicado;
use App\HistorialAccion;
use App\Inscripcion;
use App\Materia;
use App\Notificacion;
use App\NotificacionUser;
use App\Paralelo;
use App\Profesor;
use App\ProfesorMateria;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComunicadoController extends Controller
{
    public $validacion = [];

    public $mensajes = [
        'gestion.required' => 'Este campo es obligatorio',
        'nivel.required' => 'Este campo es obligatorio',
        'grado.required' => 'Este campo es obligatorio',
        'paralelo_id.required' => 'Este campo es obligatorio',
        'profesor_materia_id.required' => 'Este campo es obligatorio',
        'materia_id.required' => 'Este campo es obligatorio',
        'fecha_inicio.required' => 'Este campo es obligatorio',
        'fecha_inicio.date' => 'Debes indicar una fecha valida',
        'fecha_fin.required' => 'Este campo es obligatorio',
        'fecha_fin.date' => 'Debes indicar una fecha valida',
        'descripcion.required' => 'Este campo es obligatorio',
    ];

    public function index()
    {
        $fecha_actual = date("Y-m-d");
        DB::update("UPDATE comunicados SET estado='VENCIDO' WHERE fecha_fin < $fecha_actual");
        $comunicados = Comunicado::orderBy("id", "desc")->get();
        if (Auth::user()->tipo == "PROFESOR") {
            $id_profesor_materias = ProfesorMateria::where('profesor_id', Auth::user()->profesor->id)
                ->pluck("id");
            $comunicados = Comunicado::whereIn("profesor_materia_id", $id_profesor_materias)->orderBy("id", "desc")->get();
        }
        if (Auth::user()->tipo == "ESTUDIANTE") {
            $comunicados = Comunicado::select("comunicados.*")
                ->join("notificacions", "notificacions.registro_id", "=", "comunicados.id")
                ->join("notificacion_users", "notificacion_users.notificacion_id", "=", "notificacions.id")
                ->where("notificacions.modulo", "comunicado")
                ->where("notificacion_users.user_id", Auth::user()->id)
                ->orderBy("id", "desc")->get();
        }
        return view("comunicados.index", compact("comunicados"));
    }

    public function create()
    {
        $paralelos = Paralelo::all();
        foreach ($paralelos as $value) {
            $array_paralelos[$value->id] = $value->paralelo;
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
            $array_gestiones[] = [date("Y") => date("Y")];
        }

        $profesor = null;
        if (Auth::user()->tipo == 'PROFESOR') {
            $profesor = Profesor::where("user_id", Auth::user()->id)->get()->first();
        }
        return view("comunicados.create", compact("array_paralelos", "array_gestiones", "profesor"));
    }

    public function store(Request $request)
    {
        if (Auth::user()->tipo == 'PROFESOR') {
            $this->validacion = [
                'gestion' => 'required',
                'profesor_materia_id' => 'required',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date',
                'descripcion' => 'required',
            ];
        } else {
            $this->validacion = [
                'gestion' => 'required',
                'nivel' => 'required',
                'grado' => 'required',
                'paralelo_id' => 'required',
                'materia_id' => 'required',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date',
                'descripcion' => 'required',
            ];
        }

        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            // crear el Comunicado
            $request["user_id"] = Auth::user()->id;
            $request["estado"] = "VIGENTE";
            $request["fecha_registro"] = date("Y-m-d");

            // si es profesor armar materia
            if (Auth::user()->tipo == 'PROFESOR') {
                $profesor_materia = ProfesorMateria::find($request->profesor_materia_id);
                $request["nivel"] = $profesor_materia->nivel;
                $request["grado"] = $profesor_materia->grado;
                $request["paralelo_id"] = $profesor_materia->paralelo_id;
                $request["turno"] = $profesor_materia->turno;
                $request["materia_id"] = $profesor_materia->materia_id;
            } else {
                $profesor_materia = ProfesorMateria::where("nivel", $request->nivel)
                    ->where("grado", $request->grado)
                    ->where("paralelo_id", $request->paralelo_id)
                    ->where("turno", $request->turno)
                    ->where("gestion", $request->gestion)
                    ->where("materia_id", $request->materia_id)
                    ->get()->first();
                if ($profesor_materia) {
                    $request["profesor_materia_id"] = $profesor_materia->id;
                }
            }

            $nuevo_comunicado = Comunicado::create(array_map('mb_strtoupper', $request->all()));
            $nuevo_comunicado->descripcion = nl2br(mb_strtoupper($request->descripcion));
            $nuevo_comunicado->save();
            $datos_original = HistorialAccion::getDetalleRegistro($nuevo_comunicado, "comunicados");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' REGISTRO UN COMUNICADO',
                'datos_original' => $datos_original,
                'modulo' => 'COMUNICADOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            // inicializar Entregas/Notificaciones
            // crear notificacion
            $notificacion = Notificacion::create([
                "registro_id" => $nuevo_comunicado->id,
                "modulo" => "comunicado",
                "descripcion" => "COMUNICADO DE LA MATERIA DE " . $nuevo_comunicado->materia->nombre,
            ]);

            $inscripcions = Inscripcion::select("inscripcions.*")
                ->where("gestion", $nuevo_comunicado->gestion)
                ->where("nivel", $nuevo_comunicado->nivel)
                ->where("grado", $nuevo_comunicado->grado)
                ->where("paralelo_id", $nuevo_comunicado->paralelo_id)
                ->where("turno", $nuevo_comunicado->turno)
                ->where("inscripcions.status", 1)
                ->get();
            if (count($inscripcions) == 0) {
                throw new Exception("No se creó el comunicado debido a que no existen estudiantes en el Nivel, Grado, Paralelo y Turno seleccionados.");
            }

            foreach ($inscripcions as $i) {
                // registrar notificacion-user
                NotificacionUser::create([
                    "notificacion_id" => $notificacion->id,
                    "user_id" => $i->estudiante->user->id,
                    "visto" => 0,
                ]);
            }

            DB::commit();
            return redirect()->route("comunicados.index")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("comunicados.index")->with("error_swal", $e->getMessage());
        }
    }

    public function show(Comunicado $comunicado)
    {
        if (Auth::user()->tipo == "ESTUDIANTE") {
            $notificacion_user = NotificacionUser::select("notificacion_users.*")
                ->join("notificacions", "notificacions.id", "=", "notificacion_users.notificacion_id")
                ->where("notificacions.modulo", "comunicado")
                ->where("notificacion_users.user_id", Auth::user()->id)
                ->where("notificacions.registro_id", $comunicado->id)
                ->orderBy("id", "desc")->get()->first();
            $notificacion_user->visto = 1;
            $notificacion_user->save();
        }

        return view("comunicados.show", compact("comunicado"));
    }

    public function edit(Comunicado $comunicado)
    {
        $paralelos = Paralelo::all();
        foreach ($paralelos as $value) {
            $array_paralelos[$value->id] = $value->paralelo;
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

        $profesor = null;
        if (Auth::user()->tipo == 'PROFESOR') {
            $profesor = Profesor::where("user_id", Auth::user()->id)->get()->first();
        }
        return view("comunicados.edit", compact("comunicado", "array_paralelos", "array_gestiones", "profesor"));
    }

    public function update(Request $request, Comunicado $comunicado)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            // eliminar notificacion
            $notificacion = Notificacion::where("registro_id", $comunicado->id)->where("modulo", "comunicado")->get()->first();
            if ($notificacion) {
                $notificacion->notificacion_users()->delete();
                $notificacion->delete();
            }

            // si es profesor armar materia
            if (Auth::user()->tipo == 'PROFESOR') {
                $profesor_materia = ProfesorMateria::find($request->profesor_materia_id);
                $request["materia_id"] = $profesor_materia->materia_id;
            } else {
                $profesor_materia = ProfesorMateria::where("nivel", $request->nivel)
                    ->where("grado", $request->grado)
                    ->where("paralelo_id", $request->paralelo_id)
                    ->where("turno", $request->turno)
                    ->where("gestion", $request->gestion)
                    ->where("materia_id", $request->materia_id)
                    ->get()->first();
                if ($profesor_materia) {
                    $request["profesor_materia_id"] = $profesor_materia->id;
                }
            }

            $datos_original = HistorialAccion::getDetalleRegistro($comunicado, "comunicados");
            $comunicado->update(array_map('mb_strtoupper', $request->all()));
            $comunicado->descripcion = nl2br(mb_strtoupper($request->descripcion));
            $comunicado->save();
            $eliminados = $request->eliminados;
            if (isset($eliminados)) {
                foreach ($eliminados as $eliminado) {
                    if ($eliminado) {
                        $archivo = ComunicadoArchivo::findOrFail($eliminado);
                        $archivo->delete();
                    }
                }
            }

            $id_modificados = $request->id_modificados;
            $modificados = $request->modificados;
            if (isset($id_modificados)) {
                for ($i = 0; $i < count($id_modificados); $i++) {
                    $archivo = ComunicadoArchivo::findOrFail($id_modificados[$i]);
                    $archivo->update([
                        "link" => $modificados[$i]
                    ]);
                }
            }
            $links = $request->links;
            if (isset($links)) {
                foreach ($links as $link) {
                    $comunicado->comunicado_archivos()->create([
                        "link" => $link
                    ]);
                }
            }

            $datos_nuevo = HistorialAccion::getDetalleRegistro($comunicado, "comunicados");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' MODIFICÓ UN COMUNICADO',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'COMUNICADOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            // inicializar Entregas/Notificaciones
            // crear notificacion
            $notificacion = Notificacion::create([
                "registro_id" => $comunicado->id,
                "modulo" => "comunicado",
                "descripcion" => "COMUNICADO DE LA MATERIA DE " . $comunicado->materia->nombre,
            ]);

            $inscripcions = Inscripcion::select("inscripcions.*")
                ->where("gestion", $comunicado->gestion)
                ->where("nivel", $comunicado->nivel)
                ->where("grado", $comunicado->grado)
                ->where("paralelo_id", $comunicado->paralelo_id)
                ->where("turno", $comunicado->turno)
                ->where("inscripcions.status", 1)
                ->get();
            if (count($inscripcions) == 0) {
                throw new Exception("No se creó el comunicado debido a que no existen estudiantes en el Nivel, Grado, Paralelo y Turno seleccionados.");
            }

            foreach ($inscripcions as $i) {
                // registrar notificacion-user
                NotificacionUser::create([
                    "notificacion_id" => $notificacion->id,
                    "user_id" => $i->estudiante->user->id,
                    "visto" => 0,
                ]);
            }

            DB::commit();
            return redirect()->route("comunicados.index")->with("bien", "Registro actualizado");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("comunicados.index")->with("error_swal", $e->getMessage());
        }
    }
    public function destroy(Comunicado $comunicado)
    {
        DB::beginTransaction();
        try {
            // eliminar notificacion
            $notificacion = Notificacion::where("registro_id", $comunicado->id)->where("modulo", "comunicado")->get()->first();
            if ($notificacion) {
                $notificacion->notificacion_users()->delete();
                $notificacion->delete();
            }
            $datos_original = HistorialAccion::getDetalleRegistro($comunicado, "comunicados");
            $comunicado->delete();
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' ELIMINÓ UN COMUNICADO',
                'datos_original' => $datos_original,
                'modulo' => 'COMUNICADOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return redirect()->route("comunicados.index")->with("bien", "Registro eliminado");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("comunicados.index")->with("error", $e->getMessage());
        }
    }
}
