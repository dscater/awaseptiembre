<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Administrativo;
use App\Profesor;
use App\User;
use App\Paralelo;
use App\Estudiante;
use App\Inscripcion;
use App\Calificacion;
use App\CalificacionTrimestre;
use App\Campo;
use App\Area;
use App\Materia;
use App\MateriaGrado;
use App\TrimestreActividad;
use App\ProfesorMateria;
use App\PagoEstudiante;
use App\Asistencia;
use App\Comunicado;
use App\DesempenoEstudiante;
use App\Entrega;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ReporteController extends Controller
{
    public function index()
    {
        $usuarios = Administrativo::select('administrativos.*')
            ->join('users', 'users.id', '=', 'administrativos.user_id')
            ->where('users.estado', 1)
            ->get();

        $gestion_min = Profesor::min('fecha_registro');
        $gestion_max = Profesor::max('fecha_registro');
        $gestion_min = date('Y', strtotime($gestion_min));
        $gestion_max = date('Y', strtotime($gestion_max));

        $array_gestiones = [];
        if ($gestion_min) {
            $array_gestiones[''] = 'Seleccione...';
            for ($i = (int)$gestion_min; $i <= (int)$gestion_max; $i++) {
                $array_gestiones[$i] = $i;
            }
        }

        $administrativos = Administrativo::select('administrativos.*')
            ->where('administrativos.user_id', NULL)
            ->where('administrativos.estado', 1)
            ->get();

        $profesors = Profesor::select('profesors.*')
            ->where('profesors.estado', 1)
            ->get();

        $array_personal = [];
        foreach ($administrativos as $value) {
            $array_personal[$value->id . '-a'] = $value->paterno . ' ' . $value->materno . ' ' . $value->nombre;
        }

        foreach ($profesors as $value) {
            $array_personal[$value->id . '-p'] = $value->paterno . ' ' . $value->materno . ' ' . $value->nombre;
        }

        $array_profesors['todos'] = 'Todos';
        foreach ($profesors as $value) {
            $array_profesors[$value->id] = $value->paterno . ' ' . $value->materno . ' ' . $value->nombre;
        }

        $paralelos = paralelo::all();
        $array_paralelos[''] = 'Seleccione...';
        foreach ($paralelos as $value) {
            $array_paralelos[$value->id] = $value->paralelo;
        }

        $array_paralelos2['todos'] = 'TODOS';
        foreach ($paralelos as $value) {
            $array_paralelos2[$value->id] = $value->paralelo;
        }

        $estudiantes = Estudiante::select('estudiantes.*')
            ->where('estudiantes.estado', 1)
            ->get();

        $array_estudiantes[''] = 'Seleccione...';
        foreach ($estudiantes as $value) {
            $array_estudiantes[$value->id] = $value->nombre . ' ' . $value->paterno . ' ' . $value->materno;
        }

        $gestion_min = Inscripcion::min('gestion');
        $gestion_max = Inscripcion::max('gestion');

        $array_gestiones_insc = [];
        if ($gestion_min) {
            $array_gestiones_insc[''] = 'Seleccione...';
            for ($i = (int)$gestion_min; $i <= (int)$gestion_max; $i++) {
                $array_gestiones_insc[$i] = $i;
            }
        }

        return view('reportes.index', compact('usuarios', 'array_gestiones', 'array_gestiones_insc', 'array_personal', 'array_paralelos', 'array_paralelos2', 'array_estudiantes', 'array_profesors'));
    }

    public function usuarios(Request $request)
    {
        $filtro = $request->filtro;
        $tipo = $request->tipo;
        $fecha_ini = $request->fecha_ini;
        $fecha_fin = $request->fecha_fin;

        $usuarios = Administrativo::select('administrativos.*', 'users.id as user_id', 'users.name as usuario', 'users.foto', 'users.tipo')
            ->join('users', 'users.id', '=', 'administrativos.user_id')
            ->where('users.estado', 1)
            ->whereIn('users.tipo', ['ADMINISTRADOR', 'SECRETARIA ACADÉMICA'])
            ->orderBy('administrativos.nombre', 'ASC')
            ->get();

        if ($filtro != 'todos') {
            switch ($filtro) {
                case 'tipo':
                    if ($tipo != 'todos') {
                        $usuarios = Administrativo::select('administrativos.*', 'users.id as user_id', 'users.name as usuario', 'users.foto', 'users.tipo')
                            ->join('users', 'users.id', '=', 'administrativos.user_id')
                            ->where('users.estado', 1)
                            ->where('users.tipo', $tipo)
                            ->orderBy('administrativos.nombre', 'ASC')
                            ->get();
                    }
                    break;
            }
        }

        $pdf = PDF::loadView('reportes.usuarios', compact('usuarios'))->setPaper('legal', 'landscape');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('Usuarios.pdf');
    }

    public function personal(Request $request)
    {
        $filtro = $request->filtro;
        $gestion = $request->gestion;

        $administrativos = Administrativo::select('administrativos.*')
            ->where('administrativos.estado', 1)
            ->where('administrativos.user_id', NULL)
            ->orderBy('administrativos.nombre', 'ASC')
            ->get();

        $profesors = Profesor::select('profesors.*', 'users.id as user_id', 'users.name as usuario', 'users.foto', 'users.tipo')
            ->join('users', 'users.id', '=', 'profesors.user_id')
            ->where('users.estado', 1)
            ->orderBy('profesors.nombre', 'ASC')
            ->get();
        if ($filtro != 'todos') {
            switch ($filtro) {
                case 'administrativos':
                    $profesors = [];
                    break;
                case 'profesores':
                    $administrativos = [];
                    break;
                case 'gestion':
                    $administrativos = Administrativo::select('administrativos.*')
                        ->where('administrativos.estado', 1)
                        ->where('administrativos.user_id', NULL)
                        ->where('administrativos.fecha_registro', 'LIKE', "%$gestion%")
                        ->orderBy('administrativos.nombre', 'ASC')
                        ->get();

                    $profesors = Profesor::select('profesors.*', 'users.id as user_id', 'users.name as usuario', 'users.foto', 'users.tipo')
                        ->join('users', 'users.id', '=', 'profesors.user_id')
                        ->where('users.estado', 1)
                        ->where('profesors.fecha_registro', 'LIKE', "$gestion%")
                        ->orderBy('profesors.nombre', 'ASC')
                        ->get();
                    break;
            }
        }

        $pdf = PDF::loadView('reportes.personal', compact('administrativos', 'profesors', 'filtro', 'gestion'))->setPaper('legal', 'landscape');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('Personal.pdf');
    }

    public function kardex_personal(Request $request)
    {
        $filtro = $request->filtro;
        $gestion = $request->gestion;
        $personal = $request->personal;

        $administrativos = Administrativo::select('administrativos.*')
            ->where('administrativos.estado', 1)
            ->where('administrativos.user_id', NULL)
            ->orderBy('administrativos.nombre', 'ASC')
            ->get();

        $profesors = Profesor::select('profesors.*', 'users.id as user_id', 'users.name as usuario', 'users.foto', 'users.tipo')
            ->join('users', 'users.id', '=', 'profesors.user_id')
            ->where('profesors.estado', 1)
            ->orderBy('profesors.nombre', 'ASC')
            ->get();
        if ($filtro != 'todos') {
            switch ($filtro) {
                case 'administrativos':
                    $profesors = [];
                    break;
                case 'profesores':
                    $administrativos = [];
                    break;
                case 'individual':
                    $a_p = \explode('-', $personal);
                    if ($a_p[1] == 'a') {
                        $administrativos = Administrativo::select('administrativos.*')
                            ->where('administrativos.id', $a_p[0])
                            ->where('administrativos.estado', 1)
                            // ->where('administrativos.user_id', NULL)
                            ->orderBy('administrativos.nombre', 'ASC')
                            ->get();
                        $profesors = [];
                    } else {
                        $profesors = Profesor::select('profesors.*', 'users.id as user_id', 'users.name as usuario', 'users.foto', 'users.tipo')
                            ->join('users', 'users.id', '=', 'profesors.user_id')
                            ->where('profesors.id', $a_p[0])
                            ->where('profesors.estado', 1)
                            ->orderBy('profesors.nombre', 'ASC')
                            ->get();
                        $administrativos = [];
                    }
                    break;
            }
        }

        $array_meses = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        ];

        $pdf = PDF::loadView('reportes.kardex_personal', compact('administrativos', 'profesors', 'filtro', 'array_meses'))->setPaper('legal', 'portrait');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('kardex_persoanl.pdf');
    }

    public function asignacion_materias(Request $request)
    {
        $profesor = $request->profesor;
        $gestion = $request->gestion;

        $asignacions = [];

        $profesors = Profesor::select('profesors.*')
            ->where('profesors.estado', 1)
            ->get();
        if ($profesor != 'todos') {
            $profesors = Profesor::select('profesors.*')
                ->where('profesors.id', $profesor)
                ->where('profesors.estado', 1)
                ->get();
        }

        foreach ($profesors as $p) {
            $asignacions[$p->id] = ProfesorMateria::where('profesor_id', $p->id)
                ->where('gestion', $gestion)
                ->get();
        }

        $pdf = PDF::loadView('reportes.asignacion_materias', compact('profesors', 'asignacions'))->setPaper('A4', 'portrait');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('AsignacionMaterias.pdf');
    }

    public function actividad_profesors(Request $request)
    {
        $filtro = $request->filtro;
        $profesor = $request->profesor;
        $gestion = $request->gestion;
        $profesors = Profesor::where("estado", 1)->get();
        if ($profesor != 'todos' && $filtro != 'todos') {
            $profesors = Profesor::where("id", $profesor)->get();
        }

        $pdf = PDF::loadView('reportes.actividad_profesors', compact('profesors', 'gestion'))->setPaper('letter', 'portrait');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('actividad_profesors.pdf');
    }

    public function notificacions(Request $request)
    {
        $filtro = $request->filtro;
        $estudiante = $request->estudiante;
        $nivel = $request->nivel;
        $grado = $request->grado;
        $paralelo = $request->paralelo;
        $turno = $request->turno;
        $materia = $request->materia;
        $gestion = $request->gestion;


        $inscripcions = Inscripcion::where("nivel", $nivel)
            ->where("grado", $grado)
            ->where("paralelo_id", $paralelo)
            ->where("turno", $turno)
            ->where("gestion", $gestion)
            ->where("status", 1)
            ->get();

        $desempeno_materia = [];
        foreach ($inscripcions as $inscripcion) {
            $desempeno_materia[$inscripcion->id] = DesempenoEstudiante::where("estudiante_id", $inscripcion->estudiante_id)->get();
            if ($materia != "todos") {
                $desempeno_materia[$inscripcion->id] = DesempenoEstudiante::where("estudiante_id", $inscripcion->estudiante_id)
                    ->where("materia_id", $materia)->get();
            }
        }

        $materia_id = $materia;
        $pdf = PDF::loadView('reportes.notificacions', compact('inscripcions', 'gestion', 'materia_id', 'desempeno_materia'))->setPaper('letter', 'portrait');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('notificacions.pdf');
    }

    public function calificaciones(Request $request)
    {
        $estudiante = $request->estudiante;
        $nivel = $request->nivel;
        $grado = $request->grado;
        $materia = $request->materia;
        $paralelo = $request->paralelo;
        $turno = $request->turno;
        $gestion = $request->gestion;
        $estudiante = Estudiante::find($estudiante);

        $inscripcion = Inscripcion::where("estudiante_id", $estudiante->id)
            ->where("nivel", $nivel)
            ->where("grado", $grado)
            ->where("paralelo_id", $paralelo)
            ->where("turno", $turno)
            ->where("gestion", $gestion)
            ->where("status", 1)
            ->get()->first();


        $calificaciones = [];
        if ($inscripcion) {
            if ($materia == 'todos') {
                $calificaciones = Calificacion::where("inscripcion_id", $inscripcion->id)
                    ->get();
            } else {
                $calificaciones = Calificacion::where("inscripcion_id", $inscripcion->id)
                    ->where("materia_id", $materia)
                    ->get();
            }
        }

        $pdf = PDF::loadView('reportes.calificaciones', compact('inscripcion', 'gestion', 'calificaciones', 'estudiante', 'materia'))->setPaper('letter', 'portrait');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('calificaciones.pdf');
    }
    public function comunicados(Request $request)
    {
        $filtro = $request->filtro;
        $estado = $request->estado;

        $comunicados = [];
        if (Auth::user()->tipo == "PROFESOR") {
            $id_profesor_materias = ProfesorMateria::where('profesor_id', Auth::user()->profesor->id)
                ->pluck("id");
            $comunicados = Comunicado::whereIn("profesor_materia_id", $id_profesor_materias)->get();
            if ($filtro != 'todos' && $estado != 'todos') {
                $comunicados = Comunicado::whereIn("profesor_materia_id", $id_profesor_materias)
                    ->where("estado", $estado)->get();
            }
        }
        if (Auth::user()->tipo == "ESTUDIANTE") {
            $comunicados = Comunicado::select("comunicados.*")
                ->join("notificacions", "notificacions.registro_id", "=", "comunicados.id")
                ->join("notificacion_users", "notificacion_users.notificacion_id", "=", "notificacions.id")
                ->where("notificacions.modulo", "comunicado")
                ->where("notificacion_users.user_id", Auth::user()->id)
                ->get();
            if ($filtro != 'todos' && $estado != 'todos') {
                $comunicados = Comunicado::select("comunicados.*")
                    ->join("notificacions", "notificacions.registro_id", "=", "comunicados.id")
                    ->join("notificacion_users", "notificacion_users.notificacion_id", "=", "notificacions.id")
                    ->where("notificacions.modulo", "comunicado")
                    ->where("notificacion_users.user_id", Auth::user()->id)
                    ->where("comunicados.estado", $estado)
                    ->get();
            }
        }
        if (Auth::user()->tipo != "ESTUDIANTE" && Auth::user()->tipo != "PROFESOR") {

            $comunicados = Comunicado::all();

            if ($filtro != 'todos' && $estado != 'todos') {
                $comunicados = Comunicado::where("estado", $estado)->get();
            }
        }
        $pdf = PDF::loadView('reportes.comunicados', compact('comunicados'))->setPaper('letter', 'portrait');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('comunicados.pdf');
    }

    public function grafico_inscripcions()
    {
        $usuarios = Administrativo::select('administrativos.*')
            ->join('users', 'users.id', '=', 'administrativos.user_id')
            ->where('users.estado', 1)
            ->get();

        $gestion_min = Profesor::min('fecha_registro');
        $gestion_max = Profesor::max('fecha_registro');
        $gestion_min = date('Y', strtotime($gestion_min));
        $gestion_max = date('Y', strtotime($gestion_max));

        $array_gestiones = [];
        if ($gestion_min) {
            $array_gestiones[''] = 'Seleccione...';
            for ($i = (int)$gestion_min; $i <= (int)$gestion_max; $i++) {
                $array_gestiones[$i] = $i;
            }
        }

        $administrativos = Administrativo::select('administrativos.*')
            ->where('administrativos.user_id', NULL)
            ->where('administrativos.estado', 1)
            ->get();

        $profesors = Profesor::select('profesors.*')
            ->where('profesors.estado', 1)
            ->get();

        $array_personal = [];
        foreach ($administrativos as $value) {
            $array_personal[$value->id . '-a'] = $value->paterno . ' ' . $value->materno . ' ' . $value->nombre;
        }

        foreach ($profesors as $value) {
            $array_personal[$value->id . '-p'] = $value->paterno . ' ' . $value->materno . ' ' . $value->nombre;
        }

        $array_profesors['todos'] = 'Todos';
        foreach ($profesors as $value) {
            $array_profesors[$value->id] = $value->paterno . ' ' . $value->materno . ' ' . $value->nombre;
        }

        $paralelos = paralelo::all();
        $array_paralelos[''] = 'Seleccione...';
        foreach ($paralelos as $value) {
            $array_paralelos[$value->id] = $value->paralelo;
        }

        $estudiantes = Estudiante::select('estudiantes.*')
            ->where('estudiantes.estado', 1)
            ->get();

        $array_estudiantes[''] = 'Seleccione...';
        foreach ($estudiantes as $value) {
            $array_estudiantes[$value->id] = $value->nombre . ' ' . $value->paterno . ' ' . $value->materno;
        }

        $gestion_min = Inscripcion::min('gestion');
        $gestion_max = Inscripcion::max('gestion');

        $array_gestiones_insc = [];
        if ($gestion_min) {
            $array_gestiones_insc[''] = 'Seleccione...';
            for ($i = (int)$gestion_min; $i <= (int)$gestion_max; $i++) {
                $array_gestiones_insc[$i] = $i;
            }
        }

        return view('reportes.grafico_inscripcions', compact('usuarios', 'array_gestiones', 'array_gestiones_insc', 'array_personal', 'array_paralelos', 'array_estudiantes', 'array_profesors'));
    }

    public function grafico_inscripcions_datos(Request $request)
    {
        $filtro = $request->filtro;
        $nivel = $request->nivel;
        $grado = $request->grado;
        $paralelo = $request->paralelo;
        $turno = $request->turno;
        $gestion = $request->gestion;

        $grados = [1, 2, 3, 4, 5, 6];
        $datos = [["1", 0], ["2", 0], ["3", 0], ["4", 0], ["5", 0], ["6", 0]];
        if ($filtro == "grado" && $grado != 'todos') {
            $grados = [$grado];
            $datos = [[$grado, 0]];
        }
        foreach ($grados as $value) {
            $total_inscripcios = count(Inscripcion::where("status", 1)->where("grado", $value)->get());
            if ($filtro == 'nivel' && $nivel != 'todos') {
                $total_inscripcios = count(Inscripcion::where("status", 1)->where("grado", $value)->where("nivel", $nivel)->get());
            }
            if ($filtro == 'paralelo' && $paralelo != 'todos') {
                $total_inscripcios = count(Inscripcion::where("status", 1)->where("grado", $value)->where("paralelo_id", $paralelo)->get());
            }
            if ($filtro == 'paralelo' && $paralelo != 'todos') {
                $total_inscripcios = count(Inscripcion::where("status", 1)->where("grado", $value)->where("paralelo_id", $paralelo)->get());
            }
            if ($filtro == 'turno' && $turno != 'todos') {
                $total_inscripcios = count(Inscripcion::where("status", 1)->where("grado", $value)->where("turno", $turno)->get());
            }
            if ($filtro == 'gestion' && $gestion != 'todos') {
                $total_inscripcios = count(Inscripcion::where("status", 1)->where("grado", $value)->where("gestion", $gestion)->get());
            }
            $datos[(int)$value - 1][1] = $total_inscripcios;
        }


        return response()->JSON($datos);
    }

    public function grafico_tareas()
    {
        $usuarios = Administrativo::select('administrativos.*')
            ->join('users', 'users.id', '=', 'administrativos.user_id')
            ->where('users.estado', 1)
            ->get();

        $gestion_min = Profesor::min('fecha_registro');
        $gestion_max = Profesor::max('fecha_registro');
        $gestion_min = date('Y', strtotime($gestion_min));
        $gestion_max = date('Y', strtotime($gestion_max));

        $array_gestiones = [];
        if ($gestion_min) {
            $array_gestiones[''] = 'Seleccione...';
            for ($i = (int)$gestion_min; $i <= (int)$gestion_max; $i++) {
                $array_gestiones[$i] = $i;
            }
        }

        $administrativos = Administrativo::select('administrativos.*')
            ->where('administrativos.user_id', NULL)
            ->where('administrativos.estado', 1)
            ->get();

        $profesors = Profesor::select('profesors.*')
            ->where('profesors.estado', 1)
            ->get();

        $array_personal = [];
        foreach ($administrativos as $value) {
            $array_personal[$value->id . '-a'] = $value->paterno . ' ' . $value->materno . ' ' . $value->nombre;
        }

        foreach ($profesors as $value) {
            $array_personal[$value->id . '-p'] = $value->paterno . ' ' . $value->materno . ' ' . $value->nombre;
        }

        $array_profesors['todos'] = 'Todos';
        foreach ($profesors as $value) {
            $array_profesors[$value->id] = $value->paterno . ' ' . $value->materno . ' ' . $value->nombre;
        }

        $paralelos = paralelo::all();
        $array_paralelos[''] = 'Seleccione...';
        foreach ($paralelos as $value) {
            $array_paralelos[$value->id] = $value->paralelo;
        }

        $estudiantes = Estudiante::select('estudiantes.*')
            ->where('estudiantes.estado', 1)
            ->get();

        $array_estudiantes[''] = 'Seleccione...';
        foreach ($estudiantes as $value) {
            $array_estudiantes[$value->id] = $value->nombre . ' ' . $value->paterno . ' ' . $value->materno;
        }

        $gestion_min = Inscripcion::min('gestion');
        $gestion_max = Inscripcion::max('gestion');

        $array_gestiones_insc = [];
        if ($gestion_min) {
            $array_gestiones_insc[''] = 'Seleccione...';
            for ($i = (int)$gestion_min; $i <= (int)$gestion_max; $i++) {
                $array_gestiones_insc[$i] = $i;
            }
        }

        return view('reportes.grafico_tareas', compact('usuarios', 'array_gestiones', 'array_gestiones_insc', 'array_personal', 'array_paralelos', 'array_estudiantes', 'array_profesors'));
    }

    public function grafico_tareas_datos(Request $request)
    {
        $estudiante = $request->estudiante;
        $nivel = $request->nivel;
        $grado = $request->grado;
        $materia = $request->materia;
        $paralelo = $request->paralelo;
        $turno = $request->turno;
        $gestion = $request->gestion;

        $inscripcion = Inscripcion::where("estudiante_id", $estudiante)
            ->where("nivel", $nivel)
            ->where("grado", $grado)
            ->where("paralelo_id", $paralelo)
            ->where("turno", $turno)
            ->where("gestion", $gestion)
            ->get()->first();
        $datos = [];
        if ($inscripcion) {
            if ($materia == 'todos') {
                $no_entregados = count(Entrega::where("inscripcion_id", $inscripcion->id)
                    ->where("estado", "SIN ENTREGAR")
                    ->get());
                $entregados = count(Entrega::where("inscripcion_id", $inscripcion->id)
                    ->where("estado", "ENTREGADO")
                    ->get());
            } else {

                $no_entregados = count(Entrega::where("inscripcion_id", $inscripcion->id)
                    ->where("materia_id", $materia)
                    ->where("estado", "SIN ENTREGAR")
                    ->get());
                $entregados = count(Entrega::where("inscripcion_id", $inscripcion->id)
                    ->where("materia_id", $materia)
                    ->where("estado", "ENTREGADO")
                    ->get());
            }
            $datos[] = ["ENTREGADOS", (int)$entregados];
            $datos[] = ["SIN ENTREGAR", (int)$no_entregados];
        }

        return response()->JSON([
            "datos" => $datos,
            "estudiante" => $inscripcion->estudiante
        ]);
    }

    public function est_ap_rep(Request $request)
    {
        $filtro = $request->filtro;
        $nivel = $request->nivel;
        $grado = $request->grado;
        $paralelo = $request->paralelo;
        $turno = $request->turno;
        $gestion = $request->gestion;

        $inscripcions = Inscripcion::select("inscripcions.*");

        if ($filtro != 'todos') {
            $inscripcions->where("estado", $filtro);
        }

        if ($grado != 'todos') {
            $inscripcions->where("grado", $grado);
        }

        if ($paralelo != 'todos') {
            $inscripcions->where("paralelo_id", $paralelo);
        }

        if ($turno != 'todos') {
            $inscripcions->where("turno", $turno);
        }
        $inscripcions = $inscripcions->where("nivel", $nivel)
            ->where("gestion", $gestion)
            ->where("status", 1)
            ->get();
        $pdf = PDF::loadView('reportes.est_ap_rep', compact('inscripcions', 'gestion'))->setPaper('letter', 'portrait');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('calificaciones.pdf');
    }
}
