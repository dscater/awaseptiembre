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
                        <li class="breadcrumb-item active">Entregas</li>
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
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table data-table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Estudiante</th>
                                        <th>Materia</th>
                                        <th>Tarea</th>
                                        <th>Observaciones</th>
                                        <th>Fecha de entrega</th>
                                        <th>Calificacion</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cont = 1;
                                    @endphp
                                    @foreach ($entregas as $entrega)
                                        <tr>
                                            <td>{{ $entrega->inscripcion->estudiante->full_name }}</td>
                                            <td>{{ $entrega->materia->nombre }}</td>
                                            <td>{{ $entrega->tarea->nombre }}</td>
                                            <td>{!! $entrega->observaciones !!}</td>
                                            <td>{{ $entrega->fecha_entrega }}</td>
                                            <td>
                                                <span
                                                    class="text-xs badge {{ $entrega->calificacion ? 'badge-info' : 'badge-dark' }}">
                                                    {{ $entrega->calificacion ? $entrega->calificacion : 'PENDIENTE' }}
                                                </span>
                                            </td>
                                            <td><span
                                                    class="text-xs badge {{ $entrega->estado == 'SIN ENTREGAR' ? 'badge-danger' : 'badge-success' }}">{{ $entrega->estado }}
                                            </td>
                                            <td class="btns-opciones">
                                                <a href="{{ route('entregas.show', $entrega->id) }}" class="evaluar"><i
                                                        class="fa fa-eye" data-toggle="tooltip" data-placement="left"
                                                        title="Ver"></i></a>
                                                @if (Auth::user()->tipo == 'ESTUDIANTE' && $entrega->tarea->estado == 'VIGENTE')
                                                    <a href="{{ route('entregas.edit', $entrega->id) }}"
                                                        class="modificar"><i class="fa fa-edit" data-toggle="tooltip"
                                                            data-placement="left" title="Modificar"></i></a>

                                                    <a href="#"
                                                        data-url="{{ route('entregas.destroy', $entrega->id) }}"
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
            // order: [
            //     [0, "desc"]
            // ],
            columns: [{
                    width: "5%"
                },
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
            let entrega = $(this).parents('tr').children('td').eq(2).text();
            $('#mensajeEliminar').html(`¿Está seguro(a) de eliminar el registro <b>${entrega}</b>?`);
            let url = $(this).attr('data-url');
            console.log($(this).attr('data-url'));
            $('#formEliminar').prop('action', url);
        });

        $('#btnEliminar').click(function() {
            $('#formEliminar').submit();
        });
    </script>
@endsection
