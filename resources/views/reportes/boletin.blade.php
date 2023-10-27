<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>BoletinCalificaciones</title>
    <style type="text/css">
        * {
            font-family: sans-serif;
        }

        @page {
            margin-top: 1cm;
            margin-bottom: 1cm;
            margin-left: 1.5cm;
            margin-right: 1cm;
            border: 5px solid blue;
        }

        table {
            margin: auto;
            border-collapse: collapse;
            width: 100%;
        }

        table thead tr th {
            font-size: 9pt;
            padding: 8px;
        }

        table tr td {
            font-size: 9pt;
            padding: 8px;
        }

        .foto img {
            height: 80px;
            width: 80px;
        }

        .logo img {
            height: 90px;
            width: 120px;
        }

        .nueva_pagina {
            page-break-after: always;
        }

        .titulo {
            font-size: 14pt;
            font-weight: bold;
        }

        body {
            writing-mode: rl;
        }

        .bold {
            font-weight: bold;
        }

        .black {
            background: black;
            color: white;
        }

        .gray {
            background: rgb(235, 235, 235);
        }

        .centreado {
            text-align: center;
        }

        .text_lg {
            font-size: 1em;
        }

        .border_left {
            border-left: solid 1px black;
        }

        .border_right {
            border-right: solid 1px black;
        }

        .border_top {
            border-top: solid 1px black;
        }

        .border_bottom {
            border-bottom: solid 1px black;
        }

        .tabla_final {
            width: 70%;
            margin-top: 15px;
            margin-right: auto;
            margin-left: 0;
        }

        .tabla_final tbody tr td {
            font-size: 0.6em;
            padding: 2px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/reportes/boleta_calificaciones.css') }}">
</head>

<body>
    @php
        $empresa = App\RazonSocial::first();
        $contador_materias = 0;
        $array_dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
        $array_meses = ['01' => 'enero', '02' => 'febrero', '03' => 'marzo', '04' => 'abril', '05' => 'mayo', '06' => 'junio', '07' => 'julio', '08' => 'agosto', '09' => 'septiembre', '10' => 'octubre', '11' => 'noviembre', '12' => 'diciembre'];
    @endphp

    @foreach ($materias as $materia)
        <table border="1" style="margin-bottom: 15px;">
            <tr>
                <td class="bold centreado text_lg" rowspan="2" colspan="2">{{ $empresa->nombre }}</td>
                <td class="bold black centreado text_lg" colspan="2">BOLETIN DE ASIGNATURA {{ $gestion }}</td>
            </tr>
            <tr>

                <td class="gray bold">PROFESOR:</td>
                <td>{{ isset($profesors[$materia->id]) ? $profesors[$materia->id] : '' }}</td>
            </tr>
            <tr>
                <td class="gray bold" rowspan="2">CURSO:</td>
                <td class="black bold centreado" rowspan="2">{{ $grado }}{{ $paralelo }}</td>
                <td class="gray bold">MATERIA:</td>
                <td>{{ $materia->nombre }}</td>
            </tr>
            <tr>
                <td class="gray bold">COD. MATERIA:</td>
                <td>{{ $materia->codigo }}</td>
            </tr>
        </table>

        <table border="1">
            <thead>
                <tr>
                    <th class="gray" rowspan="2">N°</th>
                    <th class="gray" rowspan="2">APELLIDOS Y NOMBRES</th>
                    <th class="gray" colspan="4">EVALUACIÓN CUANTITATIVA</th>
                    <th class="gray" rowspan="2">OBSERVACIONES</th>
                </tr>
                <tr>
                    <th class="gray">1er Trim.</th>
                    <th class="gray">2do Trim.</th>
                    <th class="gray">3er Trim.</th>
                    <th class="gray">P.A.</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $cont = 1;
                    $aprobados1 = 0;
                    $aprobados2 = 0;
                    $aprobados3 = 0;
                    $reprobados1 = 0;
                    $reprobados2 = 0;
                    $reprobados3 = 0;
                    $total = isset($datos[$materia->id]) ? count($datos[$materia->id]) : 0;
                @endphp
                @if (isset($datos[$materia->id]))
                    @foreach ($datos[$materia->id] as $dato)
                        <tr>
                            <td>{{ $cont++ }}</td>
                            <td>{{ $dato['nombre'] }}</td>
                            <td>{{ $dato['1'] }}</td>
                            <td>{{ $dato['2'] }}</td>
                            <td>{{ $dato['3'] }}</td>
                            <td>{{ $dato['final'] }}</td>
                            <td>{{ $dato['obs'] }}</td>
                        </tr>
                        @if ($dato['obs1'] == 'APROBADO')
                            @php
                                $aprobados1++;
                            @endphp
                        @else
                            @php
                                $reprobados1++;
                            @endphp
                        @endif
                        @if ($dato['obs2'] == 'APROBADO')
                            @php
                                $aprobados2++;
                            @endphp
                        @else
                            @php
                                $reprobados2++;
                            @endphp
                        @endif
                        @if ($dato['obs3'] == 'APROBADO')
                            @php
                                $aprobados3++;
                            @endphp
                        @else
                            @php
                                $reprobados3++;
                            @endphp
                        @endif
                    @endforeach
                @else
                <tr>
                    <td colspan="7" class="centreado">SIN REGISTROS</td>
                </tr>
                @endif
            </tbody>
        </table>

        @if ($total > 0)
            <table class="tabla_final">
                <tbody>
                    <tr>
                        <td class="bold centreado border_left border_top border_bottom border_right bold gray"
                            rowspan="2">ALUMNOS INSCRITOS</td>
                        <td class="border_top border_right">ESTADISTICAS</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="border_right border_top border_bottom gray bold" colspan="2">NUM DE ALUMNOS</td>
                        <td class="centreado bold gray border_right border_bottom border_top">1er Trim.</td>
                        <td class="centreado bold gray border_right border_bottom border_top">2do Trim.</td>
                        <td class="centreado bold gray border_right border_bottom border_top">3er Trim.</td>
                        <td class="centreado bold gray border_right border_bottom border_top">PROM. FINAL</td>
                    </tr>
                    <tr>
                        <td class="centreado border_left border_bottom border_right">{{ $total }}</td>
                        <td class="border_right border_bottom" colspan="2">APROBADOS</td>
                        <td class="centreado border_left border_right border_bottom">{{ $aprobados1 }}</td>
                        <td class="centreado border_left border_right border_bottom">{{ $aprobados2 }}</td>
                        <td class="centreado border_left border_right border_bottom">{{ $aprobados3 }}</td>
                        <td class="centreado border_left border_right border_bottom">
                            {{ (int) (($aprobados1 + $aprobados2 + $aprobados3) / 3) }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="border_left border_bottom" colspan="2">REPROBADOS</td>
                        <td class="centreado border_left border_right border_bottom">{{ $reprobados1 }}</td>
                        <td class="centreado border_left border_right border_bottom">{{ $reprobados2 }}</td>
                        <td class="centreado border_left border_right border_bottom">{{ $reprobados3 }}</td>
                        <td class="centreado border_left border_right border_bottom">
                            {{ (int) (($reprobados1 + $reprobados2 + $reprobados3) / 3) }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="border_left border_bottom" colspan="2">RETIRADOS</td>
                        <td class="centreado border_left border_right border_bottom">0</td>
                        <td class="centreado border_left border_right border_bottom">0</td>
                        <td class="centreado border_left border_right border_bottom">0</td>
                        <td class="centreado border_left border_right border_bottom">0</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="border_left border_right border_bottom gray" colspan="6">PORCENTAJE DE ALUMNOS
                            EFECTIVOS</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="border_left border_bottom" colspan="2">APROBADOS</td>
                        @php
                            $porcentaje1 = number_format(($aprobados1 / $total) * 100, 2, '.', '');
                            $porcentaje2 = number_format(($aprobados2 / $total) * 100, 2, '.', '');
                            $porcentaje3 = number_format(($aprobados3 / $total) * 100, 2, '.', '');
                            $promedio = number_format(($porcentaje1 + $porcentaje2 + $porcentaje3) / 3, 2, '.', '');
                        @endphp
                        <td class="centreado border_left border_right border_bottom">{{ $porcentaje1 }}</td>
                        <td class="centreado border_left border_right border_bottom">{{ $porcentaje2 }}</td>
                        <td class="centreado border_left border_right border_bottom">{{ $porcentaje3 }}</td>
                        <td class="centreado border_left border_right border_bottom">
                            {{ $promedio }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="border_left border_bottom" colspan="2">REPROBADOS</td>
                        @php
                            $porcentaje1 = number_format(($reprobados1 / $total) * 100, 2, '.', '');
                            $porcentaje2 = number_format(($reprobados2 / $total) * 100, 2, '.', '');
                            $porcentaje3 = number_format(($reprobados3 / $total) * 100, 2, '.', '');
                            $promedio = number_format(($porcentaje1 + $porcentaje2 + $porcentaje3) / 3, 2, '.', '');
                        @endphp
                        <td class="centreado border_left border_right border_bottom">{{ $porcentaje1 }}</td>
                        <td class="centreado border_left border_right border_bottom">{{ $porcentaje2 }}</td>
                        <td class="centreado border_left border_right border_bottom">{{ $porcentaje3 }}</td>
                        <td class="centreado border_left border_right border_bottom">
                            {{ $promedio }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="" colspan="6"> FECHA: LA PAZ, {{ $array_dias[date('w')] }},
                            {{ date('d') }} de {{ $array_meses[date('m')] }} de
                            {{ $gestion }}</td>
                    </tr>
                </tbody>
            </table>
        @endif
        @php
            $contador_materias++;
        @endphp
        @if ($contador_materias < count($materias))
            <div class="nueva_pagina"></div>
        @endif
    @endforeach
</body>

</html>
