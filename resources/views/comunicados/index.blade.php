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
                        <li class="breadcrumb-item active">Comunicados</li>
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
                        @if (Auth::user()->tipo != 'ESTUDIANTE')
                            <div class="card-header">
                                {{-- <h3 class="card-title"></h3> --}}
                                <a href="{{ route('comunicados.create') }}" class="btn btn-info"><i class="fa fa-plus"></i>
                                    Nuevo</a>
                            </div>
                        @endif
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table data-table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nivel</th>
                                        <th>Grado</th>
                                        <th>Materia</th>
                                        <th>Paralelo</th>
                                        <th>Turno</th>
                                        <th>Descripción del Comunicado</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Final</th>
                                        <th>Estado</th>
                                        <th>Fecha de Registro</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cont = 1;
                                    @endphp
                                    @foreach ($comunicados as $comunicado)
                                        <tr>
                                            <td>{{ $comunicado->id }}</td>
                                            <td>{{ $comunicado->nivel }}</td>
                                            <td>{{ $comunicado->grado }}</td>
                                            <td>{{ $comunicado->materia->nombre }}</td>
                                            <td>{{ $comunicado->paralelo->paralelo }}</td>
                                            <td>{{ $comunicado->turno }}</td>
                                            <td>{!! $comunicado->descripcion !!}</td>
                                            <td>{{ $comunicado->fecha_inicio }}</td>
                                            <td>{{ $comunicado->fecha_fin }}</td>
                                            <td>{{ $comunicado->estado }}</td>
                                            <td>{{ $comunicado->fecha_registro }}</td>
                                            <td class="btns-opciones">
                                                <a href="{{ route('comunicados.show', $comunicado->id) }}"
                                                    class="evaluar"><i class="fa fa-eye" data-toggle="tooltip"
                                                        data-placement="left" title="Ver"></i></a>
                                                @if (Auth::user()->tipo == 'ADMINISTRADOR' || Auth::user()->tipo == 'PROFESOR')
                                                    <a href="{{ route('comunicados.edit', $comunicado->id) }}"
                                                        class="modificar"><i class="fa fa-edit" data-toggle="tooltip"
                                                            data-placement="left" title="Modificar"></i></a>

                                                    <a href="#"
                                                        data-url="{{ route('comunicados.destroy', $comunicado->id) }}"
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
            let comunicado = $(this).parents('tr').children('td').eq(0).text();
            $('#mensajeEliminar').html(
                `¿Está seguro(a) de eliminar el registro con código: <b class="text-lg">${comunicado}</b>?`);
            let url = $(this).attr('data-url');
            console.log($(this).attr('data-url'));
            $('#formEliminar').prop('action', url);
        });

        $('#btnEliminar').click(function() {
            $('#formEliminar').submit();
        });
    </script>
@endsection
