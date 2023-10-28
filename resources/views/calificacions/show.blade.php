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
                            <h3 class="card-title">Ver Registro</h3>
                        </div>
                        <!-- /.card-header -->
                        {{ Form::model($calificacion, ['route' => ['calificacions.update', $calificacion->id], 'method' => 'put']) }}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p><strong>Gestión: </strong>{{ $calificacion->gestion }}</p>
                                    <p><strong>Estudiante: </strong>{{ $calificacion->inscripcion->estudiante->full_name }}
                                    </p>
                                    <p><strong>Materia: </strong>{{ $calificacion->materia->nombre }}</p>
                                    <p><strong>Ponderación: </strong>{{ $calificacion->ponderacion }}</p>
                                    <p><strong>Descripción: </strong>{{ $calificacion->descripcion }}</p>
                                    <p><strong>Fecha Registro: </strong>{{ $calificacion->fecha_registro }}</p>
                                </div>
                            </div>
                            <a href="{{ route('calificacions.index') }}" class="btn btn-default"><i
                                    class="fa fa-arrow-left"></i>
                                VOLVER</a>
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
@endsection
