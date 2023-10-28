@extends('layouts.app')

@section('css')
    <style>
        .boton_reporte {
            width: 100% !important;
            margin-left: auto;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .boton_reporte a {
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reportes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-white">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reportes.index') }}">Reportes</a></li>
                        <li class="breadcrumb-item active">Reportes - Gráfico de Tareas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content" id="contenedorReportes">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Reportes - Gráfico de Tareas</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nivel:</label>
                                    {{ Form::select(
                                        'nivel',
                                        [
                                            'SECUNDARIA' => 'SECUNDARIA',
                                        ],
                                        'SECUNDARIA',
                                        ['class' => 'form-control', 'id' => 'nivel', 'required'],
                                    ) }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Grado:</label>
                                    {{ Form::select('grado', [], null, ['class' => 'form-control', 'id' => 'grado', 'required']) }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Materia:</label>
                                    {{ Form::select('materia', [], null, ['class' => 'form-control', 'id' => 'materia', 'required']) }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Paralelo:</label>
                                    {{ Form::select('paralelo', $array_paralelos, null, ['class' => 'form-control', 'id' => 'paralelo', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Turno:</label>
                                    {{ Form::select(
                                        'turno',
                                        [
                                            'MAÑANA' => 'MAÑANA',
                                            'TARDE' => 'TARDE',
                                            'NOCHE' => 'NOCHE',
                                        ],
                                        null,
                                        ['class' => 'form-control', 'id' => 'turno', 'required'],
                                    ) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Gestión:</label>
                                    {{ Form::select('gestion', $array_gestiones_insc, null, ['class' => 'form-control', 'id' => 'gestion', 'required']) }}
                                </div>
                            </div>
                            @if (Auth::user()->tipo == 'ESTUDIANTE')
                                <input type="hidden" value="{{ Auth::user()->estudiante->id }}" id="estudiante">
                            @else
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Estudiante:</label>
                                        {{ Form::select('estudiante', $array_estudiantes, null, ['class' => 'form-control select2', 'id' => 'estudiante', 'required']) }}

                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="contendor_grafico"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <input type="hidden" value="{{ route('materias.getMateriasFiltro') }}" id="getMateriasFiltro">
    <input type="hidden" value="{{ route('reportes.grafico_tareas_datos') }}" id="urlGraficoInscripcionDatos">
@endsection

@section('scripts')
    <script>
        var grados = `<option value="">Seleccione...</option>
<option value="1">1º</option>
<option value="2">2º</option>
<option value="3">3º</option>
<option value="4">4º</option>
<option value="5">5º</option>
<option value="6">6º</option>`;

        var grados_inicial = `<option value="">Seleccione...</option>
<option value="1">1º</option>
<option value="2">2º</option>`;
        var estudiante = $("#estudiante");
        var nivel = $("#nivel");
        var grado = $("#grado");
        var materia = $("#materia");
        var paralelo = $("#paralelo");
        var turno = $("#turno");
        var gestion = $("#gestion");
        $(document).ready(function() {
            getDatos();
            var nivel = $('#nivel').parents('.form-group');
            var grado = $('#grado').parents('.form-group');

            let valor = nivel.find('select').val();
            if (valor != 'NIVEL INICIAL') {
                grado.find('select').html(grados);
            } else {
                grado.find('select').html(grados_inicial);
            }
            estudiante.change(getDatos);
            nivel.change(getDatos);
            grado.change(getDatos);
            materia.change(getDatos);
            paralelo.change(getDatos);
            turno.change(getDatos);
            gestion.change(getDatos);
            $('select#grado').change(function() {
                if ($('#grado').val() != "") {
                    $.ajax({
                        type: "GET",
                        url: $("#getMateriasFiltro").val(),
                        data: {
                            grado: $('#grado').val(),
                        },
                        dataType: "json",
                        success: function(response) {
                            $('select#materia').html(response)
                        }
                    });
                } else {
                    $("select#materia").html("");
                }
            });
        });

        function getDatos() {
            $.ajax({
                type: "GET",
                url: $("#urlGraficoInscripcionDatos").val(),
                data: {
                    estudiante: estudiante.val(),
                    nivel: nivel.val(),
                    grado: grado.val(),
                    materia: materia.val(),
                    paralelo: paralelo.val(),
                    turno: turno.val(),
                    gestion: gestion.val(),
                },
                dataType: "json",
                success: function(response) {
                    Highcharts.chart('contendor_grafico', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'TAREAS ' + response.estudiante.full_name
                        },
                        subtitle: {
                            text: 'Gestión: ' + gestion.val(),
                        },
                        xAxis: {
                            type: 'category',
                            labels: {
                                style: {
                                    fontSize: '13px',
                                    fontFamily: 'Verdana, sans-serif'
                                }
                            }
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Total Tareas'
                            }
                        },
                        legend: {
                            enabled: false
                        },
                        tooltip: {
                            pointFormat: '<b>{point.y:.0f} Tareas</b>'
                        },
                        series: [{
                            name: 'Population',
                            colorByPoint: true,
                            data: response.datos,
                            dataLabels: {
                                enabled: true,
                                rotation: -90,
                                color: '#FFFFFF',
                                align: 'right',
                                format: '{point.y:.0f}', // one decimal
                                y: 10, // 10 pixels down from the top
                                style: {
                                    fontSize: '13px',
                                    fontFamily: 'Verdana, sans-serif'
                                }
                            }
                        }]
                    });
                }
            });
        }
    </script>
@endsection
