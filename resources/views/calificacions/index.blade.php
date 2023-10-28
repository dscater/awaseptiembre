@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/calificacions/index.css') }}">
@endsection

@section('sidebar-collapse')
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Administrar Calificaciones</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-white">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Administrar Calificaciones</li>
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
                        @if (Auth::user()->tipo == 'PROFESOR')
                            <div class="card-header">
                                <a href="{{ route('calificacions.create') }}" class="btn btn-info"><i
                                        class="fa fa-plus"></i>
                                    Nuevo</a>
                            </div>
                        @endif
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table data-table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Gestión</th>
                                        <th>Estudiante</th>
                                        <th>Materia</th>
                                        <th>Ponderación</th>
                                        <th>Descripción</th>
                                        <th>Fecha de Registro</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cont = 1;
                                    @endphp
                                    @foreach ($calificacions as $calificacion)
                                        <tr>
                                            <td>{{ $calificacion->gestion }}</td>
                                            <td>{{ $calificacion->estudiante->full_name }}</td>
                                            <td>{{ $calificacion->materia->nombre }}</td>
                                            <td>{{ $calificacion->ponderacion }}</td>
                                            <td>{!! $calificacion->descripcion !!}</td>
                                            <td>{{ $calificacion->fecha_registro }}</td>
                                            <td class="btns-opciones">
                                                <a href="{{ route('calificacions.show', $calificacion->id) }}"
                                                    class="evaluar"><i class="fa fa-eye" data-toggle="tooltip"
                                                        data-placement="left" title="Ver"></i></a>
                                                @if (Auth::user()->tipo == 'ADMINISTRADOR' || Auth::user()->tipo == 'PROFESOR')
                                                    <a href="{{ route('calificacions.edit', $calificacion->id) }}"
                                                        class="modificar"><i class="fa fa-edit" data-toggle="tooltip"
                                                            data-placement="left" title="Modificar"></i></a>

                                                    <a href="#"
                                                        data-url="{{ route('calificacions.destroy', $calificacion->id) }}"
                                                        data-toggle="modal" data-target="#modal-eliminar"
                                                        class="eliminar"><i class="fa fa-trash" data-toggle="tooltip"
                                                            data-placement="left" title="Eliminar"></i></a>
                                                @endif
                                            </td>
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
@endsection

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
            columns: [{
                    width: "5%"
                },
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


        // ELIMINAR
        $(document).on('click', 'table tbody tr td.btns-opciones a.eliminar', function(e) {
            e.preventDefault();
            let gestion = $(this).parents('tr').children('td').eq(0).text();
            let estudiante = $(this).parents('tr').children('td').eq(1).text();
            let ponderacion = $(this).parents('tr').children('td').eq(3).text();
            $('#mensajeEliminar').html(
                `¿Está seguro(a) de eliminar la calificación con ponderación <b>${ponderacion}</b>, gestión <b>${gestion}</b> del estudiante: <b>${estudiante}</b>?`
            );

            let url = $(this).attr('data-url');
            console.log($(this).attr('data-url'));
            $('#formEliminar').prop('action', url);
        });

        $('#btnEliminar').click(function() {
            $('#formEliminar').submit();
        });
    </script>
@endsection
