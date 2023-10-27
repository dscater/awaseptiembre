<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>ActividadProfesors</title>
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
        $count_profesors = 0;
        $array_dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
        $array_meses = ['01' => 'enero', '02' => 'febrero', '03' => 'marzo', '04' => 'abril', '05' => 'mayo', '06' => 'junio', '07' => 'julio', '08' => 'agosto', '09' => 'septiembre', '10' => 'octubre', '11' => 'noviembre', '12' => 'diciembre'];
    @endphp

    @foreach ($profesors as $profesor)
        <div class="encabezado">
            <div class="logo">
                <img src="{{ asset('imgs/' . App\RazonSocial::first()->logo) }}">
            </div>
            <h2 class="titulo">
                {{ App\RazonSocial::first()->nombre }}
            </h2>
            <h4 class="texto">CRONOGRAMA DE ACTIVIDADES</h4>
            <h4 class="fecha">Expedido: {{ date('Y-m-d') }}</h4>
        </div>

        <table>
            <tbody>
                <tr>
                    <td class="bold" width="10%">Profesor: </td>
                    <td>{{ $profesor->full_name }}</td>
                </tr>
                <tr>
                    <td class="bold">Gestión: </td>
                    <td>{{ $gestion }}</td>
                </tr>
            </tbody>
        </table>

        <table border="1" style="margin-top:15px;">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Observación</th>
                    <th>Fecha de registro</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $cont = 1;
                @endphp
                @foreach ($profesor->user->actividad_profesors()->orderBy('fecha', 'asc')->get() as $actividad)
                    <tr>
                        <td>{{ $cont++ }}</td>
                        <td>{{ date('d/m/Y', strtotime($actividad->fecha)) }}</td>
                        <td>{{ $actividad->descripcion }}</td>
                        <td>{{ $actividad->observacion }}</td>
                        <td>{{ date('d/m/Y', strtotime($actividad->fecha_registro)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @php
            $count_profesors++;
        @endphp
        @if ($count_profesors < count($profesors))
            <div class="nueva_pagina"></div>
        @endif
    @endforeach
</body>

</html>
