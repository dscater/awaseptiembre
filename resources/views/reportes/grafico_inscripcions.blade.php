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
                        <li class="breadcrumb-item active">Reportes - Gráfico de inscripciones</li>
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
                        <h3>Reportes - Gráfico de inscripciones</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 ml-auto mr-auto">
                                <div class="form-group">
                                    <label>Seleccione:</label>
                                    {{ Form::select('filtro', ['todos' => 'Todos', 'nivel' => 'Nivel', 'grado' => 'Grado', 'paralelo' => 'Paralelo', 'turno' => 'Turno', 'gestion' => 'Gestión'], null, ['class' => 'form-control', 'id' => 'filtro', 'required']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6 ml-auto mr-auto">
                                <div class="form-group">
                                    <label for="">Nivel:</label>
                                    {{ Form::select(
                                        'filtro',
                                        [
                                            'SECUNDARIA' => 'SECUNDARIA',
                                        ],
                                        'SECUNDARIA',
                                        ['class' => 'form-control', 'id' => 'nivel', 'required'],
                                    ) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 ml-auto mr-auto">
                                <div class="form-group">
                                    <label for="">Grado:</label>
                                    {{ Form::select('grado', ['todos' => 'Todos', '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6], null, ['class' => 'form-control', 'id' => 'grado', 'required']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 ml-auto mr-auto">
                                <div class="form-group">
                                    <label for="">Paralelo:</label>
                                    {{ Form::select('paralelo', $array_paralelos, null, ['class' => 'form-control', 'id' => 'paralelo', 'required']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 ml-auto mr-auto">
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
                        </div>
                        <div class="row">
                            <div class="col-md-6 ml-auto mr-auto">
                                <div class="form-group">
                                    <label for="">Gestión:</label>
                                    {{ Form::select('gestion', $array_gestiones_insc, null, ['class' => 'form-control', 'id' => 'gestion', 'required']) }}
                                </div>
                            </div>
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

    <input type="hidden" value="{{ route('reportes.grafico_inscripcions_datos') }}" id="urlGraficoInscripcionDatos">
@endsection

@section('scripts')
    <script>
        let filtro = $("#filtro");
        let nivel = $("#nivel");
        let grado = $("#grado");
        let paralelo = $("#paralelo");
        let turno = $("#turno");
        let gestion = $("#gestion");
        $(document).ready(function() {
            nivel.parents(".form-group").hide();
            grado.parents(".form-group").hide();
            paralelo.parents(".form-group").hide();
            turno.parents(".form-group").hide();
            gestion.parents(".form-group").hide();

            getDatos();
            nivel.change(getDatos);
            grado.change(getDatos);
            paralelo.change(getDatos);
            turno.change(getDatos);
            gestion.change(getDatos);

            filtro.change(function() {
                getDatos();
                switch ($(this).val()) {
                    case "todos":
                        nivel.parents(".form-group").hide();
                        grado.parents(".form-group").hide();
                        paralelo.parents(".form-group").hide();
                        turno.parents(".form-group").hide();
                        gestion.parents(".form-group").hide();
                        break;
                    case "nivel":
                        nivel.parents(".form-group").show();
                        grado.parents(".form-group").hide();
                        paralelo.parents(".form-group").hide();
                        turno.parents(".form-group").hide();
                        gestion.parents(".form-group").hide();
                        break;
                    case "grado":
                        grado.parents(".form-group").show();
                        nivel.parents(".form-group").hide();
                        paralelo.parents(".form-group").hide();
                        turno.parents(".form-group").hide();
                        gestion.parents(".form-group").hide();
                        break;
                    case "paralelo":
                        paralelo.parents(".form-group").show();
                        nivel.parents(".form-group").hide();
                        grado.parents(".form-group").hide();
                        turno.parents(".form-group").hide();
                        gestion.parents(".form-group").hide();
                        break;
                    case "turno":
                        turno.parents(".form-group").show();
                        nivel.parents(".form-group").hide();
                        grado.parents(".form-group").hide();
                        paralelo.parents(".form-group").hide();
                        gestion.parents(".form-group").hide();
                        break;
                    case "gestion":
                        gestion.parents(".form-group").show();
                        nivel.parents(".form-group").hide();
                        grado.parents(".form-group").hide();
                        paralelo.parents(".form-group").hide();
                        turno.parents(".form-group").hide();
                        break;
                }
            });
        });

        function getDatos() {
            $.ajax({
                type: "GET",
                url: $("#urlGraficoInscripcionDatos").val(),
                data: {
                    filtro: filtro.val(),
                    nivel: nivel.val(),
                    grado: grado.val(),
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
                            text: 'INSCRIPCIÓN DE ESTUDIANTES'
                        },
                        subtitle: {},
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
                                text: 'Total inscritos'
                            }
                        },
                        legend: {
                            enabled: false
                        },
                        tooltip: {
                            pointFormat: '<b>{point.y:.0f} Estudiantes</b>'
                        },
                        series: [{
                            name: 'Population',
                            colorByPoint: true,
                            data: response,
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
