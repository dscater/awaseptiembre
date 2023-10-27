@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profesors/profesor_materias.css') }}">
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Actividades de Profesores</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-white">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('profesors.index') }}">Profesores</a></li>
                        <li class="breadcrumb-item active">Actividades de Profesores</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- /.card -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mt-2">
                                    <table id="example2" class="table data-table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Descripción de la actividad</th>
                                                <th>Observación</th>
                                                <th>Fecha de registro</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $cont = 1;
                                            @endphp
                                            @foreach ($actividad_profesors as $value)
                                                <tr>
                                                    <td>{{ $value->fecha }}</td>
                                                    <td>{{ $value->descripcion }}</td>
                                                    <td>{{ $value->observacion }}</td>
                                                    <td>{{ $value->fecha_registro }}</td>
                                                    {{-- <td class="btns-opciones">
                                                        <a href="{{ route('actividad_profesors.update', $value->id) }}"
                                                            data-fecha="{{ $value->fecha }}"
                                                            data-descripcion="{{ $value->descripcion }}"
                                                            data-observacion="{{ $value->observacion }}"
                                                            class="modificar"><i class="fa fa-edit" data-toggle="tooltip"
                                                                data-placement="left" title="Modificar"></i></a>
                                                        <a href="#"
                                                            data-url="{{ route('actividad_profesors.destroy', $value->id) }}"
                                                            data-toggle="modal" data-target="#modal-eliminar"
                                                            class="eliminar"><i class="fa fa-trash" data-toggle="tooltip"
                                                                data-placement="left" title="Eliminar"></i></a>
                                                    </td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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
            columns: [
                null,
                null,
                null,
                null,
            ],
            scrollCollapse: true,
            language: lenguaje,
            pageLength: 25
        });


        // ELIMINAR
        $(document).on('click', 'table tbody tr td.btns-opciones a.eliminar', function(e) {
            e.preventDefault();
            let usuario = $(this).parents('tr').children('td').eq(2).text();
            $('#mensajeEliminar').html(`¿Está seguro(a) de eliminar al usuario <b>${usuario}</b>?`);
            let url = $(this).attr('data-url');
            console.log($(this).attr('data-url'));
            $('#formEliminar').prop('action', url);
        });

        $('#btnEliminar').click(function() {
            $('#formEliminar').submit();
        });
    </script>
@endsection
