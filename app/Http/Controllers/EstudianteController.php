<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estudiante;
use App\Http\Controllers\UserController;
use App\Http\Requests\EstudianteStoreRequest;
use App\Http\Requests\EstudianteUpdateRequest;

use Illuminate\Support\Facades\Hash;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;

class EstudianteController extends Controller
{
    public function index()
    {
        $usuarios = Estudiante::select('estudiantes.*')
            ->where('estudiantes.estado', 1)
            ->get();
        return view('estudiantes.index', compact('usuarios'));
    }

    public function create()
    {
        return view('estudiantes.create');
    }

    public function store(EstudianteStoreRequest $request)
    {
        $request['fecha_registro'] = date('Y-m-d');
        $estudiante = new Estudiante(array_map('mb_strtoupper', $request->except('foto')));
        $estudiante->foto = 'user_default.png';
        $estudiante->tipo_doc .= 'CI';
        $estudiante->estado = 1;
        $nombre_estudiante = UserController::nombreUsuario($request->nombre, $request->paterno, $request->materno);
        $nro_codigo = UserController::getCodigoUsuario("ESTUDIANTE");
        $nombre_estudiante = $nombre_estudiante . $nro_codigo;

        // usuario estudiante
        $nuevo_usuario = new User();
        $nuevo_usuario->name = $nombre_estudiante;
        $nuevo_usuario->password = Hash::make($request->nro_doc);
        $nuevo_usuario->tipo = 'ESTUDIANTE';
        $nuevo_usuario->foto = 'user_default.png';
        $nuevo_usuario->codigo = $nro_codigo;
        $nuevo_usuario->estado = 1;
        if ($request->hasFile('foto')) {
            //obtener el archivo
            $file_foto = $request->file('foto');
            $extension = "." . $file_foto->getClientOriginalExtension();
            $nom_foto = $estudiante->nombre . time() . $extension;
            $file_foto->move(public_path() . "/imgs/users/", $nom_foto);
            $nuevo_usuario->foto = $nom_foto;
            $estudiante->foto = $nom_foto;
        }
        $nuevo_usuario->save();
        // asignar usuario al estudiante
        $estudiante->user_id = $nuevo_usuario->id;
        $estudiante->save();

        return redirect()->route('estudiantes.index')->with('bien', 'Registro realizado con éxito');
    }

    public function edit(Estudiante $usuario)
    {
        return view('estudiantes.edit', compact('usuario'));
    }

    public function update(Estudiante $usuario, EstudianteUpdateRequest $request)
    {
        $usuario->update(array_map('mb_strtoupper', $request->except('foto')));

        if ($request->hasFile('foto')) {
            // antiguo
            $antiguo = $usuario->foto;
            if ($antiguo != 'user_default.png') {
                \File::delete(public_path() . '/imgs/users/' . $antiguo);
            }
            //obtener el archivo
            $file_foto = $request->file('foto');
            $extension = "." . $file_foto->getClientOriginalExtension();
            $nom_foto = $usuario->nombre . time() . $extension;
            $file_foto->move(public_path() . "/imgs/users/", $nom_foto);
            $usuario->user->foto = $usuario->foto;
            $usuario->foto = $nom_foto;
        }

        $usuario->user->save();
        return redirect()->route('estudiantes.index')->with('bien', 'Usuario modificado con éxito');
    }

    public function show(Estudiante $usuario)
    {
        return 'mostrar usuario';
    }

    public function info_tutor(Estudiante $estudiante)
    {
        return view('estudiantes.info_tutor', compact("estudiante"));
    }

    public function formulario(Estudiante $estudiante)
    {
        $pdf = PDF::loadView('estudiantes.formulario', compact('estudiante'))->setPaper('legal', 'portrait');
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Pág. {PAGE_NUM}/{PAGE_COUNT}", null, 8, array(0, 0, 0));

        return $pdf->stream('FormularioEstudiante.pdf');
    }

    public function destroy(Estudiante $usuario)
    {
        $usuario->estado = 0;
        $usuario->save();
        return redirect()->route('estudiantes.index')->with('bien', 'Registro eliminado correctamente');
    }

    public function getInfoPadreTutor(Request $request)
    {
        $estudiante_id = $request->estudiante_id;
        $estudiante = Estudiante::find($estudiante_id);

        $tipo_factura = $request->tipo_factura;

        $nombre = '';
        $nit = '';
        if ($tipo_factura == 'PADRE/TUTOR') {
            $nombre = $estudiante->ap_padre_tutor . ' ' . $estudiante->nom_padre_tutor;
            $nit = $estudiante->ci_padre_tutor;
        } elseif ($tipo_factura == 'MADRE') {
            $nombre = $estudiante->ap_madre . ' ' . $estudiante->nom_madre;
            $nit = $estudiante->ci_madre;
        } elseif ($tipo_factura == 'ESTUDIANTE') {
            $nombre = $estudiante->paterno . ' ' . $estudiante->materno . ' ' . $estudiante->nombre;
            $nit = $estudiante->nro_doc;
        }
        return response()->JSON([
            'sw' => true,
            'nombre' => $nombre,
            'nit' => $nit,
        ]);
    }
}
