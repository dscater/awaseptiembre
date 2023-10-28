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
                        <li class="breadcrumb-item active">Ver</li>
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
                            <h3 class="card-title">Ver Tarea</h3>
                        </div>
                        <!-- /.card-header -->
                        {{ Form::model($tarea, ['route' => ['tareas.update', $tarea->id], 'method' => 'put']) }}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>{{ $tarea->nombre }}</h4>
                                </div>
                                <div class="col-md-12">
                                    <label><strong>Materia: </strong></label>
                                    <p>{{ $tarea->materia->nombre }}</p>
                                </div>
                                <div class="col-md-12">
                                    <label>Descripción:</label>
                                    <p>{!! $tarea->descripcion !!}</p>
                                </div>
                                <div class="col-md-12">
                                    <label>Fecha de asignación:</label>
                                    <p>{{ $tarea->fecha_asignacion }}</p>
                                </div>
                                <div class="col-md-12">
                                    <label>Fecha Límite de Entrega:</label>
                                    <p>{{ $tarea->fecha_limite }}</p>
                                </div>
                                <div class="col-md-12">
                                    <label>Estado:</label>
                                    <p>{{ $tarea->estado }}</p>
                                </div>
                                <hr>

                                <div class="col-md-12 mb-5">
                                    <label>Links de Archivos:</label>
                                    @foreach ($tarea->tarea_archivos as $ta)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="{{ $ta->link }}" target="_blank">{{ $ta->link }}</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @if (Auth::user()->tipo == 'ESTUDIANTE')
                                <a href="{{ route('tareas.tareas_estudiante') }}" class="btn btn-default"><i
                                        class="fa fa-arrow-left"></i> VOLVER</a>
                            @else
                                <a href="{{ route('tareas.index') }}" class="btn btn-default"><i
                                        class="fa fa-arrow-left"></i> VOLVER</a>
                            @endif
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
@endsection

@section('scripts')
    </script>
@endsection
