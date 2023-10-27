@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profesors/profesor_materias.css') }}">
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profesores</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-white">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('profesors.index') }}">Profesores</a></li>
                        <li class="breadcrumb-item active">Profesores actividades</li>
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
                        <div class="card-header">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr class="bg-dark">
                                        <td width="80px">Nombre: </td>
                                        <td>{{ $profesor->nombre }} {{ $profesor->paterno }} {{ $profesor->materno }}</td>
                                        <td class="foto_profesor" with="80px" rowspan="2">
                                            <img src="{{ asset('imgs/users/' . $profesor->foto) }}" alt="Foto">
                                        </td>
                                    </tr>
                                    <tr class="bg-dark">
                                        <td>C.I.:</td>
                                        <td>{{ $profesor->ci }} {{ $profesor->ci_exp }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mr-auto ml-auto">
                                    <div class="form-group">
                                        <label>Seleccione Gestión*</label>
                                        {{ Form::select('gestion', $array_gestiones, date('Y'), ['class' => 'form-control', 'required', 'id' => 'select_gestion']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <button class="btn btn-info btn-block" id="btnNuevaActividad"><i class="fa fa-plus"></i>
                                        Nuevo</button>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div id="contenedor_actividades">

                                    </div>
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

    @include('actividad_profesors.nuevo')
    @include('modal.eliminar')

    <input type="hidden" id="prof" value="{{ $profesor->id }}">
    <input type="hidden" id="urlActividadesProfesor"
        value="{{ route('actividad_profesors.getActividadesProfesor', $profesor->id) }}">
    <input type="hidden" id="urlStoreActividad" value="{{ route('actividad_profesors.store', $profesor->id) }}">
    <input type="hidden" id="fecha_actual" value="{{ date('Y-m-d') }}">
@endsection

@section('scripts')
    <script>
        @if (session('bien'))
            mensajeNotificacion('{{ session('bien') }}', 'success');
        @endif

        let accion = "nuevo";
        let btnNuevaActividad = $("#btnNuevaActividad");
        let fecha_actual = $("#fecha_actual");
        let errors = null;

        let contenedor_actividades = $("#contenedor_actividades");
        let select_gestion = $("#select_gestion");
        let modal_nueva_actividad = $("#modal_nueva_actividad");

        let formularioActividad = $("#formularioActividad");
        let fecha = $("#fecha");
        let descripcion = $("#descripcion");
        let observacion = $("#observacion");
        let btnRegistraActividad = $("#btnRegistraActividad");

        let contenedor_errores = $("#contenedor_errores");
        $(document).ready(function() {
            getActividadesProfesor();
            select_gestion.change(getActividadesProfesor);

            btnNuevaActividad.click(function() {
                limpiaErrores();
                limpiaFormulario();
                accion = "nuevo";
                btnRegistraActividad.text("Registrar");
                $("#txtTituloActividad").html("Registrar actividad");
                modal_nueva_actividad.modal("show");
            });

            btnRegistraActividad.click(function() {
                btnRegistraActividad.prop("disabled", true);
                valida();
                if (!errors || errors.length == 0) {
                    limpiaErrores();
                    registraActividad();
                } else {
                    let li = "";
                    if (errors.length > 0) {
                        errors.forEach(function(el) {
                            li += `<li>${el}</li>`;
                        });
                        contenedor_errores.removeClass("oculto");
                        contenedor_errores.children("ul").html(li);;
                    } else {
                        limpiaErrores();
                    }
                    btnRegistraActividad.removeAttr("disabled");
                }
            });

            // editar
            contenedor_actividades.on("click", "table tbody tr td.btns-opciones a.modificar", function(e) {
                e.preventDefault();
                limpiaErrores();
                accion = "edit";
                formularioActividad.prop("action", $(this).attr("href"));
                fecha.val($(this).attr("data-fecha"));
                descripcion.val($(this).attr("data-descripcion"));
                observacion.val($(this).attr("data-observacion"));

                btnRegistraActividad.text("Actualizar");
                $("#txtTituloActividad").html("Modificar actividad");
                modal_nueva_actividad.modal("show");
            });

            // eliminar
            contenedor_actividades.on("click", "table tbody tr td.btns-opciones a.eliminar", function(e) {
                e.preventDefault();
                let actividad_fecha = $(this).parents('tr').children('td').eq(0).text();
                let descripcion = $(this).parents('tr').children('td').eq(1).text();
                $('#mensajeEliminar').html(
                    `¿Está seguro(a) de eliminar este registro?<br>Fecha: <b>${actividad_fecha}</b><br>Descripción: <b>${descripcion}</b>?`
                );
                let url = $(this).attr('data-url');
                console.log($(this).attr('data-url'));
                $('#formEliminar').prop('action', url);
            });

            $('#btnEliminar').click(function() {
                $('#formEliminar').submit();
            });

        });

        function getActividadesProfesor() {
            $.ajax({
                type: "GET",
                url: $("#urlActividadesProfesor").val(),
                data: {
                    gestion: select_gestion.val(),
                },
                dataType: "json",
                success: function(response) {
                    contenedor_actividades.html(response);
                }
            });
        }

        function registraActividad() {
            let url = $("#urlStoreActividad").val();
            let type_ajax = "POST";
            let data = formularioActividad.serialize();
            if (accion == "edit") {
                type_ajax = "PUT";
                url = formularioActividad.attr("action");
            }
            $.ajax({
                headers: {
                    'x-csrf-token': $('#token').val()
                },
                type: type_ajax,
                url: url,
                data: data,
                dataType: "json",
                success: function(response) {
                    console.log("AA");
                    modal_nueva_actividad.modal('hide');
                    getActividadesProfesor();
                    limpiaFormulario();
                    btnRegistraActividad.removeAttr("disabled");
                    mensajeNotificacion(response.msg, 'success');
                    console.log("BB");
                }
            });
        }

        function valida() {
            let _errors = []
            if (fecha.val() == "" || fecha.val() == null) {
                _errors.push("Debes indicar una fecha");
            }
            if (descripcion.val() == "" || descripcion.val() == null) {
                _errors.push("Debes indicar una descripción");
            }
            errors = _errors;
        }

        function limpiaErrores() {
            contenedor_errores.addClass("oculto");
            contenedor_errores.children("ul").html("");;
        }

        function limpiaFormulario() {
            fecha.val(fecha_actual.val());
            descripcion.val("");
            observacion.val("");
        }
    </script>
@endsection
