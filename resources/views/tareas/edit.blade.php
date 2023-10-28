@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Tareas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('tareas.index') }}">Tareas</a></li>
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
                            <h3 class="card-title">Modificar Tarea</h3>
                        </div>
                        <!-- /.card-header -->
                        {{ Form::model($tarea, ['route' => ['tareas.update', $tarea->id], 'method' => 'put']) }}
                        <div class="card-body">
                            @include('tareas.form.form')
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
@endsection

@section('scripts')
    <script src="{{ asset('js/tareas/create.js') }}"></script>
    <script>
        setTimeout(() => {
            $("#select_materia").val("{{ $tarea->profesor_materia_id }}");
        }, 300);
    </script>
@endsection
