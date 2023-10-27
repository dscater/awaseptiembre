<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>FormularioEstudiante</title>
    <style type="text/css">
        * {
            font-family: sans-serif;
        }

        @page {
            margin-top: 1cm;
            margin-bottom: 1cm;
            margin-left: 2cm;
            margin-right: 0.3cm;
            border: 5px solid blue;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px 0px;
            table-layout: fixed;
            margin-top: 20px;
            page-break-before: avoid;
        }

        table thead tr {
            page-break-before: avoid;
        }

        table thead tr th,
        tbody tr td {
            font-size: 0.63em;
        }

        .encabezado {
            width: 100%;
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

        table thead {
            background: rgb(236, 236, 236)
        }

        table thead tr th {
            padding: 3px;
            font-size: 0.7em;
        }

        table tbody tr td {
            font-size: 0.75em;
            vertical-align: middle;
            height: 17px;
        }

        .centreado {
            padding-left: 0px;
            text-align: center;
        }

        .datos {
            margin-left: 15px;
            border-top: solid 1px;
            border-collapse: collapse;
            width: 250px;
        }

        .txt_center {
            font-weight: bold;
            text-align: center;
        }

        .cumplimiento {
            position: absolute;
            width: 150px;
            right: 0px;
            top: 86px;
        }

        .p_cump {
            color: red;
            font-size: 1.2em;
        }

        .b_top {
            border-top: solid 1px black;
        }

        .gray {
            background: rgb(202, 202, 202);
        }

        .txt_rojo {}

        .img_celda img {
            width: 45px;
        }

        td.foto {
            padding: 0px;
        }

        td.foto img {
            height: 140px;
        }

        .border_top {
            border-top: solid 0.5px;
        }

        .border_bottom {
            border-bottom: solid 0.5px;
        }

        .border_left {
            border-left: solid 0.5px;
        }

        .border_right {
            border-right: solid 0.5px;
        }

        .pb-5 {
            padding-bottom: 5px;
        }

        .pb-15 {
            padding-bottom: 15px;
        }

        .pt-5 {
            padding-top: 5px;
        }

        .pl-5 {
            padding-left: 5px;
        }

        .pr-5 {
            padding-right: 5px;
        }

        .bold {
            font-weight: bold;
        }

        .p-4 {
            padding: 4px;
        }

        .p-10 {
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="encabezado">
        <div class="logo">
            <img src="{{ asset('imgs/' . App\RazonSocial::first()->logo) }}">
        </div>
        <h2 class="titulo">
            {{ App\RazonSocial::first()->nombre }}
        </h2>
        <h4 class="texto">FORMULARIO DE REGISTRO</h4>
        <h4 class="fecha">Expedido: {{ date('Y-m-d') }}</h4>
    </div>

    <h4>1. DATOS DE LA O EL ESTUDIANTE</h4>
    <table>
        <tbody>
            <tr>
                <td class="centreado border_bottom">{{ $estudiante->paterno }}</td>
                <td class="centreado border_bottom">{{ $estudiante->materno }}</td>
                <td class="centreado border_bottom">{{ $estudiante->nombre }}</td>
                <td rowspan="6" class="centreado foto">
                    <img src="{{ asset('imgs/users/' . $estudiante->foto) }}" alt="Foto">
                </td>
            </tr>
            <tr>
                <td class="centreado bold">Paterno</td>
                <td class="centreado bold">Materno</td>
                <td class="centreado bold">Nombre</td>
            </tr>
            <tr>
                <td class="centreado border_bottom">{{ $estudiante->nro_doc }}</td>
                <td class="centreado border_bottom">{{ $estudiante->ci_exp }}</td>
                <td class="centreado border_bottom">{{ $estudiante->fecha_nac }}</td>
            </tr>
            <tr>
                <td class="centreado bold">C.I.</td>
                <td class="centreado bold">Expedido</td>
                <td class="centreado bold">Fecha de nacimiento</td>
            </tr>
            <tr>
                <td class="centreado">{{ $estudiante->sexo }}</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="centreado border_top bold">Sexo</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4" class="bold">Lugar de nacimiento:</td>
            </tr>
            <tr>
                <td class="centreado border_bottom">{{ $estudiante->pais_nac }}</td>
                <td class="centreado border_bottom">{{ $estudiante->dpto_nac }}</td>
                <td class="centreado border_bottom">{{ $estudiante->provincia_nac }}</td>
                <td class="centreado border_bottom">{{ $estudiante->localidad_nac }}</td>
            </tr>
            <tr>
                <td class="centreado bold">País</td>
                <td class="centreado bold">Departamento</td>
                <td class="centreado bold">Provincia</td>
                <td class="centreado bold">Localidad</td>
            </tr>
            <tr>
                <td colspan="4" class="bold">Certificado de nacimiento:</td>
            </tr>
            <tr>
                <td class="centreado border_bottom">{{ $estudiante->oficialia }}</td>
                <td class="centreado border_bottom">{{ $estudiante->libro }}</td>
                <td class="centreado border_bottom">{{ $estudiante->partida }}</td>
                <td class="centreado border_bottom">{{ $estudiante->folio }}</td>
            </tr>
            <tr>
                <td class="centreado bold">Oficialia</td>
                <td class="centreado bold">Libro</td>
                <td class="centreado bold">Partida</td>
                <td class="centreado bold">Folio</td>
            </tr>
            <tr>
                <td colspan="4" class="bold">Dirección actual:</td>
            </tr>
            <tr>
                <td class="centreado border_bottom">{{ $estudiante->provincia_dir }}</td>
                <td class="centreado border_bottom">{{ $estudiante->zona_dir }}</td>
                <td class="centreado border_bottom">{{ $estudiante->municipio_dir }}</td>
                <td class="centreado border_bottom">{{ $estudiante->avenida_dir }}</td>
            </tr>
            <tr>
                <td class="centreado border_top bold">Provincia</td>
                <td class="centreado border_top bold">Zona</td>
                <td class="centreado border_top bold">Municipio</td>
                <td class="centreado border_top bold">Avenida</td>
            </tr>
            <tr>
                <td class="centreado">{{ $estudiante->localidad_dir }}</td>
                <td class="centreado">{{ $estudiante->fono_dir }}</td>
                <td class="centreado">{{ $estudiante->nro_dir }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="centreado border_top bold">Localidad</td>
                <td class="centreado border_top bold">Teléfono</td>
                <td class="centreado border_top bold">Nro.</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4" class="bold">Unidad Educativa de Procedencia:</td>
            </tr>
            <tr>
                <td class="centreado">{{ $estudiante->codigo_sie_ue }}</td>
                <td class="centreado" colspan="3">{{ $estudiante->ue_procedencia }}</td>
            </tr>
            <tr>
                <td class="centreado border_top bold">Código SIE de la U.E.</td>
                <td class="centreado border_top bold" colspan="3">Nombre de la Unidad Educativa</td>
            </tr>
        </tbody>
    </table>
    <h4>2. ASPECTOS SOCIALES</h4>
    <table>
        <tbody>
            <tr>
                <td class="bold">¿Cuál es el idioma que aprendio a hablar en su niñez la o el estudiante?</td>
                <td class="bold">¿Qué idiomas habla frecuentemente la o el estudiante?</td>
            </tr>
            <tr>
                <td class="p-10">{{ $estudiante->idioma_niniez }}</td>
                <td class="p-10">{{ $estudiante->idiomas_estudiante }}</td>
            </tr>
            <tr>
                <td class="bold">¿Pertenece a alguna nación, pueblo indígena originario campesino o afroboliviano?
                </td>
                <td class="bold">¿Existe Centro de Salud / Posta / Hospital en su comunidad?</td>
            </tr>
            <tr>
                <td class="p-10">{{ $estudiante->pueblo_nacion }}<br>{{ $estudiante->pueblo_nacion_otro }}</td>
                <td class="p-10">{{ $estudiante->centro_salud }}</td>
            </tr>
            <tr>
                <td class="bold">¿Cuantas veces fue la o el estudiante al centro de salud el año pasado?</td>
                <td></td>
            </tr>
            <tr>
                <td class="p-10">{{ $estudiante->veces_centro_salud }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="bold">Presenta la o el estudiante alguna discapacidad</td>
                <td class="bold">Su discapacidad es</td>
            </tr>
            <tr>
                <td class="p-10">{{ $estudiante->discapacidad }}<br>{{ $estudiante->discapacidad_otro }}</td>
                <td class="p-10">{{ $estudiante->desc_discapacidad }}</td>
            </tr>
            <tr>
                <td class="bold">El agua de su casa proviene de</td>
                <td class="bold">¿La o el estudiante tiene energía eléctrica en su vivienda?</td>
            </tr>
            <tr>
                <td class="p-10">{{ $estudiante->agua }}</td>
                <td class="p-10">{{ $estudiante->energia_electrica }}</td>
            </tr>
            <tr>
                <td class="bold">El baño, water o letrina de su casa tiene desague a</td>
                <td class="bold">¿Realizó la o el estudiante en los últimos 3 meses alguna de las siguientes
                    actividades?</td>
            </tr>
            <tr>
                <td class="p-10">{{ $estudiante->banio }}</td>
                <td class="p-10">{{ $estudiante->actividad }}</td>
            </tr>
            <tr>
                <td class="bold">La semana pasada ¿Cuántos días trabajó o ayudó a la familia la o el estudiante</td>
                <td class="bold">¿Recibió algún pago por el trabajo realizado?</td>
            </tr>
            <tr>
                <td class="p-10">{{ $estudiante->dias_trabajo }}</td>
                <td class="p-10">{{ $estudiante->recibio_pago }}</td>
            </tr>
            <tr>
                <td class="bold">La o el estudiante accede a internet en</td>
                <td class="bold">¿Con qué frecuencia la o el estudiante accede a internet</td>
            </tr>
            <tr>
                <td class="p-10">{{ $estudiante->internet }}</td>
                <td class="p-10">{{ $estudiante->frecuencia_internet }}</td>
            </tr>
            <tr>
                <td class="bold">¿Cómo llega la o el estudiante a la Unidad Educativa?</td>
                <td class="bold">En el medio de transporte señalado ¿Cuál es el tiempo máximo que demora en llegar de
                    su casa a la
                    Unidad Educativa o viceversa?</td>
            </tr>
            <tr>
                <td class="p-10">{{ $estudiante->llega }}<br>{{ $estudiante->llega_otro }}</td>
                <td class="p-10">{{ $estudiante->desc_llega }}</td>
            </tr>
        </tbody>
    </table>
    <h4>3. DATOS DEL PADRE, MADRE O TUTOR(A) DE LA O EL ESTUDIANTE</h4>
    <table>
        <tbody>
            <tr>
                <td colspan="4" class="bold">Datos del padre o tutor(a):</td>
            </tr>
            <tr>
                <td class="centreado">{{ $estudiante->ci_padre_tutor }}</td>
                <td class="centreado">{{ $estudiante->app_padre_tutor }}</td>
                <td class="centreado">{{ $estudiante->apm_padre_tutor }}</td>
                <td class="centreado">{{ $estudiante->nom_padre_tutor }}</td>
            </tr>
            <tr>
                <td class="centreado border_top bold">C.I.</td>
                <td class="centreado border_top bold">Ap. paterno</td>
                <td class="centreado border_top bold">Ap. materno</td>
                <td class="centreado border_top bold">Nombre(s)</td>
            </tr>
            <tr>
                <td class="centreado">{{ $estudiante->idioma_padre_tutor }}</td>
                <td class="centreado">{{ $estudiante->ocupacion_padre_tutor }}</td>
                <td class="centreado">{{ $estudiante->grado_padre_tutor }}</td>
                <td class="centreado">{{ $estudiante->parentezco_padre_tutor }}</td>
            </tr>
            <tr>
                <td class="centreado border_top bold pb-5">Idioma que habla frecuentemente</td>
                <td class="centreado border_top bold pb-5">Ocupación laboral actual</td>
                <td class="centreado border_top bold pb-5">Mayor grado de instrucción alcanzado</td>
                <td class="centreado border_top bold pb-5">En caso de tutor(a) ¿Cuál es el parentezco</td>
            </tr>
            <tr>
                <td colspan="4" class="bold">Datos de la madre:</td>
            </tr>
            <tr>
                <td class="centreado">{{ $estudiante->ci_madre }}</td>
                <td class="centreado">{{ $estudiante->app_madre }}</td>
                <td class="centreado">{{ $estudiante->apm_madre }}</td>
                <td class="centreado">{{ $estudiante->nom_madre }}</td>
            </tr>
            <tr>
                <td class="centreado border_top bold pb-5">C.I.</td>
                <td class="centreado border_top bold pb-5">Ap. paterno</td>
                <td class="centreado border_top bold pb-5">Ap. materno</td>
                <td class="centreado border_top bold pb-5">Nombre(s)</td>
            </tr>
            <tr>
                <td class="centreado">{{ $estudiante->idioma_madre }}</td>
                <td class="centreado">{{ $estudiante->ocupacion_madre }}</td>
                <td class="centreado">{{ $estudiante->grado_madre }}</td>
                <td class="centreado">{{ $estudiante->parentezco_madre }}</td>
            </tr>
            <tr>
                <td class="centreado border_top bold pb-5">Idioma que habla frecuentemente</td>
                <td class="centreado border_top bold pb-5">Ocupación laboral actual</td>
                <td class="centreado border_top bold pb-5">Mayor grado de instrucción alcanzado</td>
                <td class="centreado border_top bold pb-5">En caso de tutor(a) ¿Cuál es el parentezco</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
