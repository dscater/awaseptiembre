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
                            <h3 class="card-title">Modificar Área</h3>
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
@endsection

@section('scripts')
    <script src="{{ asset('js/tareas/create.js') }}"></script>
@endsection
