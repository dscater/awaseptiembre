@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Envío de correos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Envío de correos</li>
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
                            {{-- <h3 class="card-title"></h3> --}}
                            <a href="{{ route('envio_correos.create') }}" class="btn btn-info"><i class="fa fa-plus"></i>
                                Nuevo</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table data-table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Envíado por</th>
                                        <th>Tipo</th>
                                        <th>Gestión</th>
                                        <th>Estudiante</th>
                                        <th>Nivel</th>
                                        <th>Grado</th>
                                        <th>Paralelo</th>
                                        <th>Materia</th>
                                        <th>Turno</th>
                                        <th>Mensaje</th>
                                        <th>Archivo</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($envio_correos as $value)
                                        <tr>
                                            <td>{{ $value->user->name }}</td>
                                            <td>{{ $value->tipo }}</td>
                                            <td>{{ $value->gestion }}</td>
                                            <td>{{ $value->estudiante ? $value->estudiante->full_name : '' }}</td>
                                            <td>{{ $value->nivel }}</td>
                                            <td>{{ $value->grado }}</td>
                                            <td>{{ $value->paralelo->paralelo }}</td>
                                            <td>{{ $value->materia ? $value->materia->nombre : '' }}</td>
                                            <td>{{ $value->turno }}</td>
                                            <td>{!! $value->texto !!}</td>
                                            <td>
                                                @if ($value->archivo)
                                                    <a href="{{ asset('files/' . $value->archivo) }}"
                                                        target="_blank">Archivo</a>
                                                @endif
                                            </td>
                                            <td>{{ date('d/m/Y', strtotime($value->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

    @include('modal.eliminar')

@section('scripts')
    <script>
        @if (session('bien'))
            mensajeNotificacion('{{ session('bien') }}', 'success');
        @endif

        @if (session('info'))
            mensajeNotificacion('{{ session('info') }}', 'info');
        @endif

        @if (session('error'))
            mensajeNotificacion('{{ session('error') }}', 'error');
        @endif

        $('table.data-table').DataTable({
            order: [
                [0, "desc"]
            ],
            columns: [
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                {
                    width: "10%"
                },
            ],
            scrollCollapse: true,
            language: lenguaje,
            pageLength: 25
        });
    </script>
@endsection
@endsection
