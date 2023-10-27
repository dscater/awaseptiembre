@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Estudiantes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('estudiantes.index') }}">Estudiantes</a></li>
                        <li class="breadcrumb-item active">Información tutor</li>
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
                            <h3 class="card-title">Información tutor</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Estudiante</h4>
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td><strong>Nombre: </strong>{{ $estudiante->full_name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Nro. documento: </strong>{{ $estudiante->nro_doc }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tipo documento: </strong>{{ $estudiante->tipo_doc }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @if ($estudiante->user_tutor)
                                <div class="col-md-12">
                                    <h4>Tutor</h4>
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td><strong>Usuario: </strong>{{ $estudiante->user_tutor->name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Nombre: </strong>{{ $estudiante->full_name_tutor }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>C.I.: </strong>{{ $estudiante->ci_padre_tutor }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                                @if ($estudiante->user_madre)
                                    <div class="col-md-12">
                                        <h4>Madre</h4>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Usuario: </strong>{{ $estudiante->user_madre->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Nombre: </strong>{{ $estudiante->full_name_madre }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>C.I.: </strong>{{ $estudiante->ci_madre }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{route("estudiantes.index")}}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Estudiantes</a>
                                </div>
                            </div>
                        </div>
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
