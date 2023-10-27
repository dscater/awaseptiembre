<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Desempeño</title>
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

        .foto {
            padding: 0px;
            vertical-align: middle;
            text-align: center;
        }

        .foto img {
            /* height: 80px; */
            width: 120px;
        }


        .logo img {
            position: absolute;
            width: 200px;
            height: 90px;
            top: -20px;
            left: -20px;
        }

        h2.titulo {
            width: 450px;
            margin: auto;
            margin-top: 15px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14pt;
        }

        .texto {
            width: 250px;
            text-align: center;
            margin: auto;
            margin-top: 15px;
            font-weight: bold;
            font-size: 1.1em;
        }

        .fecha {
            width: 250px;
            text-align: center;
            margin: auto;
            margin-top: 15px;
            font-weight: normal;
            font-size: 0.85em;
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
        $count_inscripcions = 0;
        $array_dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
        $array_meses = ['01' => 'enero', '02' => 'febrero', '03' => 'marzo', '04' => 'abril', '05' => 'mayo', '06' => 'junio', '07' => 'julio', '08' => 'agosto', '09' => 'septiembre', '10' => 'octubre', '11' => 'noviembre', '12' => 'diciembre'];
    @endphp

    @foreach ($inscripcions as $inscripcion)
        <div class="encabezado">
            <div class="logo">
                <img src="{{ asset('imgs/' . App\RazonSocial::first()->logo) }}">
            </div>
            <h2 class="titulo">
                {{ App\RazonSocial::first()->nombre }}
            </h2>
            <h4 class="texto">KARDEX DE DESEMPEÑO ACADÉMICO</h4>
            <h4 class="fecha">Expedido: {{ date('Y-m-d') }}</h4>
        </div>

        <table border="1">
            <tbody>
                <tr>
                    <td class="bold" width="10%">Estudiante: </td>
                    <td width="70%">{{ $inscripcion->estudiante->full_name }}</td>
                    <td rowspan="4" class="foto"><img
                            src="{{ asset('imgs/users/' . $inscripcion->estudiante->foto) }}" alt=""></td>
                </tr>
                <tr>
                    <td class="bold">C.I.: </td>
                    <td>{{ $inscripcion->estudiante->nro_doc }} {{ $inscripcion->estudiante->ci_exp }}</td>
                </tr>
                <tr>
                    <td class="bold">Grado: </td>
                    <td>{{ $inscripcion->grado }}° {{ $inscripcion->paralelo->paralelo }} de {{$inscripcion->nivel}}</td>
                </tr>
                <tr>
                    <td class="bold">Gestión: </td>
                    <td>{{ $gestion }}</td>
                </tr>
            </tbody>
        </table>
        <h4 style="width:100%;text-align:center;">Desempeño académico</h4>
        <table border="1" style="margin-top:15px;">
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>Desempeño</th>
                    <th>Valoración</th>
                    <th>Fecha</th>
                    <th>Observación</th>
                    <th>Profesor</th>
                    <th>Fecha de registro</th>
                </tr>
            </thead>
            <tbody>
                @if (count($desempeno_materia[$inscripcion->id]) > 0)
                    @foreach ($desempeno_materia[$inscripcion->id] as $desempeno)
                        <tr>
                            <td>{{ $desempeno->materia->nombre }}</td>
                            <td>{{ $desempeno->desempeno }}</td>
                            <td>{{ $desempeno->valoracion }}</td>
                            <td>{{ date('d/m/Y', strtotime($desempeno->fecha)) }}</td>
                            <td>{{ $desempeno->observacion }}</td>
                            <td>{{ $desempeno->user->profesor->full_name }}</td>
                            <td>{{ date('d/m/Y', strtotime($desempeno->fecha_registro)) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="centreado">SIN REGISTROS</td>
                    </tr>
                @endif
            </tbody>
        </table>
        @php
            $count_inscripcions++;
        @endphp
        @if ($count_inscripcions < count($inscripcions))
            <div class="nueva_pagina"></div>
        @endif
    @endforeach
</body>

</html>
