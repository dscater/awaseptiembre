@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Entregas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('entregas.index') }}">Entregas</a></li>
                        <li class="breadcrumb-item active">Administrar Entrega</li>
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
                            <h3 class="card-title">Administrar Entrega</h3>
                        </div>
                        <!-- /.card-header -->
                        {{ Form::model($entrega, ['route' => ['entregas.registra_calificacion', $entrega->id], 'method' => 'put']) }}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p><strong>Materia: </strong>{{ $entrega->materia->nombre }}</p>
                                    <p><strong>Tarea: </strong>{{ $entrega->tarea->nombre }}</p>
                                    <p><strong>Estudiante: </strong>{{ $entrega->inscripcion->estudiante->full_name }}</p>
                                    <p><strong>Observaciones: </strong><br>{!! $entrega->observaciones !!}</p>
                                    <p><strong>Fecha Entrega: </strong>{{ $entrega->fecha_entrega }}
                                    </p>
                                    <hr>
                                    <div class="col-md-12 mb-5">
                                        <label>Links de Archivos:</label>
                                        @foreach ($entrega->entrega_archivos as $ta)
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <a href="{{ $ta->link }}" target="_blank">{{ $ta->link }}</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <p><strong>Calificación:
                                        </strong><span
                                            class="text-xs badge {{ $entrega->calificacion ? 'badge-info' : 'badge-dark' }}">
                                            {{ $entrega->calificacion ? $entrega->calificacion : 'PENDIENTE' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            @if (Auth::user()->tipo == 'PROFESOR')
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label>Calificación*:</label>
                                        {{ Form::number('calificacion', null, ['class' => 'form-control', 'required']) }}
                                    </div>
                                </div>
                                <button class="btn btn-info"><i class="fa fa-clipboard-check"></i> REGISTRAR
                                    CALIFICACIÓN</button>
                            @endif
                            <a href="{{ route('entregas.index') }}" class="btn btn-default"><i
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
    <script src="{{ asset('js/entregas/create.js') }}"></script>
@endsection
