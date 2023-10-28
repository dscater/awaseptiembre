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
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 input-group mb-3">
                                    <span class="input-group-prepend"> <span class="input-group-text"
                                            id="basic-addon1">Gestión:</span> </span>
                                    {{ Form::select('gestion', $array_gestiones, date('Y'), ['class' => 'form-control', 'id' => 'gestion_entregas']) }}
                                </div>
                            </div>
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
                                        <th>Entregado</th>
                                        <th>Fecha de Registro</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody id="contenedor_tareas_estudiante">

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
    <input type="hidden" value="{{ route('tareas.tareas_estudiante') }}" id="urlTareasEstudiante">
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

        $(document).ready(function() {
            getTareas();
            $("#gestion_entregas").change(getTareas);
        });

        function getTareas() {
            // Destruir la instancia DataTable actual
            if ($.fn.DataTable.isDataTable('table.data-table')) {
                $('table.data-table').DataTable().destroy();
            }
            $.ajax({
                type: "GET",
                url: $("#urlTareasEstudiante").val(),
                data: {
                    gestion: $("#gestion_entregas").val(),
                },
                dataType: "json",
                success: function(response) {
                    $("#contenedor_tareas_estudiante").html(response);

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
                            {
                                width: "10%"
                            },
                        ],
                        scrollCollapse: true,
                        language: lenguaje,
                        pageLength: 25
                    });
                }
            });
        }
    </script>
@endsection
