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
                        {{ Form::model($entrega, ['route' => ['entregas.update', $entrega->id], 'method' => 'put']) }}
                        <div class="card-body">
                            @include('entregas.form.form')
                            @if ($entrega->estado == 'ENTREGADO')
                                <button class="btn btn-info"><i class="fa fa-sync"></i> ACTUALIZAR TAREA</button>
                            @else
                                <button class="btn btn-info"><i class="fa fa-paper-plane"></i> ENVIAR TAREA</button>
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
    <script src="{{ asset('js/entregas/create.js') }}"></script>
@endsection
