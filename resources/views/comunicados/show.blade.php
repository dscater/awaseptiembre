@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Comunicados</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('comunicados.index') }}">Comunicados</a></li>
                        <li class="breadcrumb-item active">Ver Comunicado</li>
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
                            <h3 class="card-title">Ver Comunicado</h3>
                        </div>
                        <!-- /.card-header -->
                        {{ Form::model($comunicado, ['route' => ['comunicados.update', $comunicado->id], 'method' => 'put']) }}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p><strong>Gestión: </strong>{{ $comunicado->gestion }}</p>
                                </div>
                                <div class="col-md-12">
                                    <p><strong>Nivel: </strong>{{ $comunicado->nivel }}</p>
                                </div>
                                <div class="col-md-12">
                                    <p><strong>Grado: </strong>{{ $comunicado->grado }}</p>
                                </div>
                                <div class="col-md-12">
                                    <p><strong>Paralelo: </strong>{{ $comunicado->paralelo->paralelo }}</p>
                                </div>
                                <div class="col-md-12">
                                    <p><strong>Turno: </strong>{{ $comunicado->turno }}</p>
                                </div>
                                <div class="col-md-12">
                                    <label class="text-dark">Descripción del comunicado: </label>
                                    <p>{!! $comunicado->descripcion !!}</p>
                                </div>
                                <div class="col-md-12">
                                    <p><strong>Fecha Inicio: </strong>{{ $comunicado->fecha_inicio }}</p>
                                </div>
                                <div class="col-md-12">
                                    <p><strong>Fecha Final: </strong>{{ $comunicado->fecha_fin }}</p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <p><strong>Estado: </strong>{{ $comunicado->estado }}</p>
                                </div>
                            </div>
                            <a href="{{ route('comunicados.index') }}" class="btn btn-default"><i
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
