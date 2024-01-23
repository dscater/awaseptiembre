<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inscripcion;
use App\Estudiante;
use App\Paralelo;
use App\Materia;
use App\Calificacion;
use App\CalificacionTrimestre;
use App\HistorialAccion;
use App\ProfesorMateria;
use App\TrimestreActividad;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InscripcionController extends Controller
{
    public function index()
    {
        $inscripcions = Inscripcion::where('status', 1)->get();
        return view('inscripcions.index', compact('inscripcions'));
    }

    public function create()
    {
        $estudiantes = Estudiante::select('estudiantes.*')
            ->where('estudiantes.estado', 1)
            ->get();
        $paralelos = Paralelo::all();

        $array_estudiantes[''] = 'Seleccione...';
        $array_paralelos[''] = 'Seleccione...';

        foreach ($estudiantes as $value) {
            $array_estudiantes[$value->id] = $value->nombre . ' ' . $value->paterno . ' ' . $value->materno;
        }
        foreach ($paralelos as $value) {
            $array_paralelos[$value->id] = $value->paralelo;
        }
        return view('inscripcions.create', compact('array_estudiantes', 'array_paralelos'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $existe = Inscripcion::where("gestion", $request->gestion)
                ->where("estudiante_id", $request->estudiante_id)
                ->where("status", 1)
                ->get()->first();

            if ($existe) {
                throw new Exception("El estudiante ya se encuentra registro en la gestión: " . $request->gestion);
            }

            $request['fecha_registro'] = date('Y-m-d');
            $request['estado'] = 'REPROBADO';
            $request['status'] = 1;
            $nueva_inscripcion = new Inscripcion(array_map('mb_strtoupper', $request->all()));

            $datos_original = HistorialAccion::getDetalleRegistro($nueva_inscripcion, "inscripcions");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' REGISTRO UNA INSCRIPCIÓN',
                'datos_original' => $datos_original,
                'modulo' => 'INSCRIPCIONES/CANTIDAD ESTUDIANTES',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            // REGISTRAR LAS MATERIAS ASIGNADAS AL GRADO Y NIVEL
            // Materia
            // MateriaGrado
            $materia_grados = Materia::select('materias.*')
                ->join('materia_grados', 'materia_grados.materia_id', '=', 'materias.id')
                ->where('materias.nivel', $nueva_inscripcion->nivel)
                ->where('grado', $nueva_inscripcion->grado)
                ->get();

            if (count($materia_grados) == 0) {
                throw new Exception("No hay materias asignadas al NIVEL y GRADO que seleccionó. Comuniquese con un Administrador/Secretaria");
                // return redirect()->route('inscripcions.index')->with('error', 'Error. No hay materias asignadas al NIVEL y GRADO que seleccionó. Comuniquese con un Administrador/Secretaria');
            }

            $nueva_inscripcion->save();
            DB::commit();
            return redirect()->route('inscripcions.index')->with('bien', 'Registro realizado con éxito');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("inscripcions.index")->with("error_swal", $e->getMessage());
        }
    }

    public function edit(Inscripcion $inscripcion)
    {
        $estudiantes = Estudiante::select('estudiantes.*')
            ->where('estudiantes.estado', 1)
            ->get();
        $paralelos = Paralelo::all();

        $array_estudiantes[''] = 'Seleccione...';
        $array_paralelos[''] = 'Seleccione...';

        foreach ($estudiantes as $value) {
            $array_estudiantes[$value->id] = $value->nombre . ' ' . $value->paterno . ' ' . $value->materno;
        }
        foreach ($paralelos as $value) {
            $array_paralelos[$value->id] = $value->paralelo;
        }

        return view('inscripcions.edit', compact('inscripcion', 'array_estudiantes', 'array_paralelos'));
    }

    public function update(Inscripcion $inscripcion, Request $request)
    {
        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($inscripcion, "inscripcions");
            $inscripcion->update(array_map('mb_strtoupper', $request->all()));
            $datos_nuevo = HistorialAccion::getDetalleRegistro($inscripcion, "inscripcions");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' MODIFICÓ UNA INSCRIPCIÓN',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'INSCRIPCIONES/CANTIDAD ESTUDIANTES',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);
            DB::commit();
            return redirect()->route('inscripcions.index')->with('bien', 'Registro modificado con éxito');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("inscripcions.index")->with("error_swal", $e->getMessage());
        }
    }

    public function show(Inscripcion $inscripcion)
    {
        return 'mostrar cargo';
    }

    public function destroy(Inscripcion $inscripcion)
    {
        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($inscripcion, "inscripcions");
            $inscripcion->status = 0;
            $inscripcion->save();

            $datos_nuevo = HistorialAccion::getDetalleRegistro($inscripcion, "inscripcions");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' ELIMINÓ UNA INSCRIPCIÓN',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'INSCRIPCIONES/CANTIDAD ESTUDIANTES',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);
            DB::commit();

            return redirect()->route('inscripcions.index')->with('bien', 'Registro eliminado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route("inscripcions.index")->with("error_swal", $e->getMessage());
        }
    }

    public function cantidad_estudiantes(Request $request)
    {
        $filtro = $request->filtro;
        $gestion = $request->gestion;
        $nivel = $request->nivel;
        $grado = $request->grado;
        $paralelo = $request->paralelo;
        $turno = $request->turno;

        $inscripcions = Inscripcion::where('status', 1)->get();

        $paralelo = Paralelo::find($paralelo);
        $titulo = 'Total Estudiantes: ' . count($inscripcions);
        if ($filtro != 'todos') {
            if ($gestion != '' && $nivel != '' && $grado != '' && $paralelo != '' && $turno != '') {
                $titulo = 'Total Estudiantes gestión ' . $gestion . ' - ' . $grado . 'º ' . $paralelo->paralelo . ' de ' . $nivel . ' Turno ' . $turno;
                $inscripcions = Inscripcion::where('gestion', $gestion)
                    ->where('nivel', $nivel)
                    ->where('grado', $grado)
                    ->where('paralelo_id', $paralelo->id)
                    ->where('turno', $turno)
                    ->where('status', 1)
                    ->get();
            }
        }

        $data = [
            ['ESTUDIANTES', count($inscripcions)]
        ];
        return response()->JSON([
            'sw' => true,
            'data' => $data,
            'titulo' => $titulo
        ]);
    }

    public function formulario(Inscripcion $inscripcion)
    {
        $pdf = PDF::loadView('inscripcions.formulario', compact('inscripcion'))->setPaper('legal', 'portrait');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('Formulario.pdf');
    }

    public function getEstudianteProfesorMateria(Request $request)
    {
        $materia_profesor = ProfesorMateria::find($request->materia);
        $gestion = $materia_profesor->gestion;
        $nivel = $materia_profesor->nivel;
        $grado = $materia_profesor->grado;
        $paralelo_id = $materia_profesor->paralelo_id;
        $turno = $materia_profesor->turno;
        $materia_id = $materia_profesor->materia_id;

        $inscripcions = Inscripcion::select("inscripcions.*")
            ->join("calificacions", "calificacions.inscripcion_id", "inscripcions.id")
            ->where("inscripcions.gestion", $gestion)
            ->where("inscripcions.nivel", $nivel)
            ->where("inscripcions.grado", $grado)
            ->where("inscripcions.paralelo_id", $paralelo_id)
            ->where("inscripcions.turno", $turno)
            ->where("inscripcions.status", 1)
            ->where("calificacions.materia_id", $materia_id)
            ->distinct()
            ->get();

        $lista_options = '<option value="">Seleccione...</option>';
        foreach ($inscripcions as $value) {
            $lista_options .= '<option value="' . $value->id . '">' . $value->estudiante->full_name . '</option>';
        }

        return response()->JSON([
            "inscripcions" => $inscripcions,
            "lista_options" => $lista_options,
            "materia_id" => $materia_id,
        ]);
    }
}
