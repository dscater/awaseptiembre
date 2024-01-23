<?php

namespace App\Http\Controllers;

use App\ConfiguracionCorreo;
use App\EnvioCorreo;
use App\Estudiante;
use App\HistorialAccion;
use App\Inscripcion;
use App\Mail\Correo;
use App\Paralelo;
use App\Profesor;
use App\ProfesorMateria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class EnvioCorreoController extends Controller
{
    public function index(Request $request)
    {
        $envio_correos = EnvioCorreo::orderBy("id", "desc")->get();
        if (Auth::user()->tipo == 'PROFESOR') {
            $envio_correos = EnvioCorreo::where("user_id", Auth::user()->id)->orderBy("id", "desc")->get();
        }
        return view("envio_correos.index", compact("envio_correos"));
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
            $array_gestiones = [date("Y") => date("Y")];
        }


        $estudiantes = Estudiante::where("estado", 1)->orderBy("paterno", "asc")->get();
        $array_estudiantes[""] = "- Seleccionar Estudiante -";

        foreach ($estudiantes as $value) {
            $array_estudiantes[$value->id] = $value->paterno . ($value->materno ? ' ' . $value->materno . ' ' : ' ') . $value->nombre;
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
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // crear el Comunicado
            $request["user_id"] = Auth::user()->id;

            // si es profesor armar materia
            if (Auth::user()->tipo == 'PROFESOR') {
                $profesor_materia = ProfesorMateria::find($request->profesor_materia_id);
                $request["nivel"] = $profesor_materia->nivel;
                $request["grado"] = $profesor_materia->grado;
                $request["paralelo_id"] = $profesor_materia->paralelo_id;
                $request["turno"] = $profesor_materia->turno;
                $request["materia_id"] = $profesor_materia->materia_id;
            }

            $datos = [];
            if ($request->tipo == 'INDIVIDUAL') {
                $ultima_inscripcion = Inscripcion::where("estudiante_id", $request->estudiante_id)
                    ->orderBy("id", "asc")->get()->last();

                $datos = [
                    "tipo" => $request->tipo,
                    "gestion" => $request->gestion,
                    "estudiante_id" => $request->estudiante_id,
                    "nivel" => $ultima_inscripcion->nivel,
                    "grado" => $ultima_inscripcion->grado,
                    "paralelo_id" => $ultima_inscripcion->paralelo_id,
                    "turno" => $ultima_inscripcion->turno,
                    "texto" => "",
                    "user_id" => $request->user_id,
                ];
            } else {
                $datos = [
                    "tipo" => $request->tipo,
                    "gestion" => $request->gestion,
                    "nivel" => $request->nivel,
                    "grado" => $request->grado,
                    "paralelo_id" => $request->paralelo_id,
                    "materia_id" => $request->materia_id,
                    "turno" => $request->turno,
                    "texto" => "",
                    "user_id" => $request->user_id,
                ];
            }

            $nuevo_envio_correo = EnvioCorreo::create(array_map('mb_strtoupper', $datos));
            $nuevo_envio_correo->texto = nl2br(mb_strtoupper($request->texto));

            if ($request->hasFile("archivo")) {
                $file = $request->archivo;
                $nom_archivo = time() . '_' . $nuevo_envio_correo->id . '.' . $file->getClientOriginalExtension();
                $nuevo_envio_correo->archivo = $nom_archivo;
                $file->move(public_path() . '/files/', $nom_archivo);
            }
            $nuevo_envio_correo->save();

            $datos_original = HistorialAccion::getDetalleRegistro($nuevo_envio_correo, "envio_correos");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' REALIZÓ EL ENVÍO DE UN CORREO ' . $request->tipo,
                'datos_original' => $datos_original,
                'modulo' => 'ENVÍO DE CORREOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            // ENVIAR CORREO(S)
            $configuracion_correo = ConfiguracionCorreo::get()->first();
            $host = "smtp.hostinger.com";
            $puerto = "587";
            $encriptado = "tls";
            $correo = "ue21septiembre@emsytsrl.com";
            $nombre = "AWASEPTIEMBRE";
            $password = "MiClave-123";
            $driver = "smtp";
            if ($configuracion_correo) {
                $host = $configuracion_correo->host;
                $puerto = $configuracion_correo->puerto;
                $encriptado = $configuracion_correo->encriptado;
                $correo = $configuracion_correo->correo;
                $nombre = $configuracion_correo->nombre;
                $password = $configuracion_correo->password;
                $driver = $configuracion_correo->driver;
            }
            // Configurar el servicio de correo con la configuración de Gmail dinámicamente
            Config::set([
                'mail.mailers.smtp.host' => $host,
                'mail.mailers.smtp.port' => $puerto,
                'mail.mailers.smtp.encryption' => $encriptado,
                'mail.mailers.smtp.username' => $nombre,
                'mail.mailers.smtp.password' => $password,
                'mail.from.address' => $correo,
                'mail.from.name' => $nombre,
            ]);

            if ($nuevo_envio_correo->tipo == 'INDIVIDUAL') {
                $estudiante = Estudiante::findOrFail($nuevo_envio_correo->estudiante_id);
                $correo_tutor = $estudiante->correo_padre_tutor;
                $correo_madre = $estudiante->correo_madre;
                if ($correo_tutor) {
                    Mail::to($correo_tutor)
                        ->send(new Correo(public_path("/files/" . $nuevo_envio_correo->archivo), $nuevo_envio_correo->archivo, $nuevo_envio_correo->texto, $nombre, $nombre));
                }

                if ($correo_madre) {
                    Mail::to($correo_madre)
                        ->send(new Correo(public_path("/files/" . $nuevo_envio_correo->archivo), $nuevo_envio_correo->archivo, $nuevo_envio_correo->texto, $nombre, $nombre));
                }
            } else {
                $inscripcions = Inscripcion::select("inscripcions.*")
                    ->where("gestion", $nuevo_envio_correo->gestion)
                    ->where("nivel", $nuevo_envio_correo->nivel)
                    ->where("grado", $nuevo_envio_correo->grado)
                    ->where("paralelo_id", $nuevo_envio_correo->paralelo_id)
                    ->where("turno", $nuevo_envio_correo->turno)
                    ->where("inscripcions.status", 1)
                    ->get();
                foreach ($inscripcions as $i) {
                    $estudiante = Estudiante::findOrFail($i->estudiante_id);
                    $correo_tutor = $estudiante->correo_padre_tutor;
                    $correo_madre = $estudiante->correo_madre;
                    if ($correo_tutor) {
                        Mail::to($correo_tutor)
                            ->send(new Correo(public_path("/files/" . $nuevo_envio_correo->archivo), $nuevo_envio_correo->archivo, $nuevo_envio_correo->texto, $nombre, $nombre));
                    }
                    if ($correo_madre) {
                        Mail::to($correo_madre)
                            ->send(new Correo(public_path("/files/" . $nuevo_envio_correo->archivo), $nuevo_envio_correo->archivo, $nuevo_envio_correo->texto, $nombre, $nombre));
                    }
                }
            }


            DB::commit();
            return redirect()->route("envio_correos.index")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("envio_correos.index")->with("error_swal", $e->getMessage());
        }
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
