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
                        <li class="breadcrumb-item active">Tareas</li>
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
                                {{-- <h3 class="card-title"></h3> --}}
                                <a href="{{ route('tareas.create') }}" class="btn btn-info"><i class="fa fa-plus"></i>
                                    Nuevo</a>
                            </div>
                        @endif
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table data-table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Materia</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Fecha de Asignación</th>
                                        <th>Fecha Límite de Entrega</th>
                                        <th>Estado</th>
                                        <th>Fecha de Registro</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cont = 1;
                                    @endphp
                                    @foreach ($tareas as $tarea)
                                        <tr>
                                            <td>{{ $tarea->id }}</td>
                                            <td>{{ $tarea->materia->nombre }}</td>
                                            <td>{{ $tarea->nombre }}</td>
                                            <td>{!! $tarea->descripcion !!}</td>
                                            <td>{{ $tarea->fecha_asignacion }}</td>
                                            <td>{{ $tarea->fecha_limite }}</td>
                                            <td><span
                                                    class="text-xs badge {{ $tarea->estado == 'SIN ENTREGAR' ? 'badge-danger' : 'badge-success' }}">{{ $tarea->estado }}</span>
                                            </td>
                                            <td>{{ $tarea->fecha_registro }}</td>
                                            <td class="btns-opciones">
                                                <a href="{{ route('tareas.show', $tarea->id) }}" class="ir-evaluacion"><i
                                                        class="fa fa-eye" data-toggle="tooltip" data-placement="left"
                                                        title="Ver Tarea"></i></a>
                                                @if (Auth::user()->tipo == 'PROFESOR')
                                                    <a href="{{ route('tareas.edit', $tarea->id) }}" class="modificar"><i
                                                            class="fa fa-edit" data-toggle="tooltip" data-placement="left"
                                                            title="Modificar"></i></a>

                                                    <a href="#" data-url="{{ route('tareas.destroy', $tarea->id) }}"
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
            let tarea = $(this).parents('tr').children('td').eq(2).text();
            $('#mensajeEliminar').html(`¿Está seguro(a) de eliminar el registro <b>${tarea}</b>?`);
            let url = $(this).attr('data-url');
            console.log($(this).attr('data-url'));
            $('#formEliminar').prop('action', url);
        });

        $('#btnEliminar').click(function() {
            $('#formEliminar').submit();
        });
    </script>
@endsection
