@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Calificaciones</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('calificacions.index') }}">Calificaciones</a></li>
                        <li class="breadcrumb-item active">Modificar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Modificar Registro</h3>
                        </div>
                        <!-- /.card-header -->
                        {{ Form::model($calificacion, ['route' => ['calificacions.update', $calificacion->id], 'method' => 'put']) }}
                        <div class="card-body">
                            @include('calificacions.form.form')
                            <button class="btn btn-info"><i class="fa fa-update"></i> ACTUALIZAR</button>
                        </div>
                        {{ Form::close() }}
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </section>
    <input type="hidden" id="prof" value="{{ $profesor->id }}">
    <input type="hidden" id="urlMaterias" value="{{ route('materias.materiasCalificacions') }}">
    <input type="hidden" id="urlEstudiantes" value="{{ route('calificacions.getEstudiantesMateria') }}">
    <input type="hidden" id="urlStoreCalificacion" value="{{ route('calificacions.store') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/calificacions/create.js') }}"></script>
    <script>
        setTimeout(() => {
            $("#select_materia").val("{{ $calificacion->profesor_materia_id }}");
            obtieneEstudiantes();
            setTimeout(() => {
                $("#select_inscripcion").val("{{ $calificacion->inscripcion_id }}");
            }, 300);
        }, 300);
    </script>
@endsection
