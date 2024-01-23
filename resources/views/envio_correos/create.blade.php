@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Envío de correos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('envio_correos.index') }}">Envío de correos</a></li>
                        <li class="breadcrumb-item active">Nuevo</li>
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
                            <h3 class="card-title">Nuevo correo</h3>
                        </div>
                        <!-- /.card-header -->
                        {{ Form::open(['route' => 'envio_correos.store', 'method' => 'post', 'files' => true]) }}
                        <div class="card-body">
                            @if (Auth::user()->tipo == 'PROFESOR')
                                @include('envio_correos.parcial.profesor')
                            @else
                                @include('envio_correos.parcial.normal')
                            @endif
                            <div class="row">
                                <div class="col-12">
                                    <hr class="mt-0">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Mensaje*:</label>
                                        {{ Form::textarea('texto', null, ['class' => 'form-control', 'required', 'rows' => '1']) }}
                                        @if ($errors->has('texto'))
                                            <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block"
                                                role="alert">
                                                <strong>{{ $errors->first('texto') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Archivo adjunto:</label>
                                        <input type="file" name="archivo" id="archivo" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-info"><i class="fa fa-save"></i> GUARDAR</button>
                        </div>
                        {{ Form::close() }}
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </section>
    <input type="hidden" id="prof" value="{{ $profesor ? $profesor->id : '' }}">
    <input type="hidden" id="urlMaterias" value="{{ route('materias.materiasCalificacions') }}">
    <input type="hidden" value="{{ route('materias.getMateriasNivelGrado') }}" id="urlGetMateriasNivelGrado">
    <input type="hidden" value="{{ route('estudiantes.info_tutor_correo') }}" id="info_tutor_correo">
    <input type="hidden" value="{{ route('inscripcions.getEstudianteProfesorMateria') }}" id="estudiantes_materias">
@endsection

@section('scripts')
    <script src="{{ asset('js/envio_correos/create.js') }}"></script>
    @if (Auth::user()->tipo == 'PROFESOR')
        <script>
            $(document).ready(function() {
                $("#select_estudiante").html("");
                obtieneMaterias();
                $("#select_gestion").change(obtieneMaterias);

                $("#select_materia").change(function() {
                    obtieneInscripcions();
                })
            });

            function obtieneMaterias() {
                if ($("#select_gestion").val() != "") {
                    $.ajax({
                        type: "GET",
                        url: $("#urlMaterias").val(),
                        data: {
                            profesor: $("#prof").val(),
                            gestion: $("#select_gestion").val(),
                        },
                        dataType: "json",
                        success: function(response) {
                            $("#select_materia").html(response);
                        },
                    });
                } else {
                    $("#select_materia").html("");
                }
            }

            function obtieneInscripcions() {
                if ($("#select_materia").val() != '') {
                    $.ajax({
                        type: "GET",
                        url: $("#estudiantes_materias").val(),
                        data: {
                            materia: $("#select_materia").val()
                        },
                        dataType: "json",
                        success: function(response) {
                            let options = `<option value="">- Seleccionar Estudiante -</option>`;
                            response.inscripcions.forEach(elem => {
                                options +=
                                    `<option value="${elem.estudiante_id}">${elem.estudiante.full_name}</option>`;
                            })

                            $("#select_estudiante").html(options);
                        }
                    });
                } else {
                    $("#select_estudiante").html("");
                }
            }
        </script>
    @else
        <script>
            $(document).ready(function() {
                getMateriasNivelGrado();
                $("#select_nivel").change(getMateriasNivelGrado);
                $("#select_grado").change(getMateriasNivelGrado);
                $("#paralelo_id").change(getMateriasNivelGrado);
            });

            function getMateriasNivelGrado() {
                if ($("#select_nivel").val() != '' && $("#select_grado").val() != '' && $("#paralelo_id").val() != '') {
                    $.ajax({
                        type: "GET",
                        url: $("#urlGetMateriasNivelGrado").val(),
                        data: {
                            nivel: $("#select_nivel").val(),
                            grado: $("#select_grado").val(),
                        },
                        dataType: "json",
                        success: function(response) {
                            $("#materia_id").html(response)
                        }
                    });
                } else {
                    $("#materia_id").html("")
                }
            }
        </script>
    @endif
    <script>
        let select_tipo = $("#select_tipo");
        let select_estudiante = $("#select_estudiante");
        let select_turno = $("#select_turno");
        let info_estudiante = $("#info_estudiante");
        let contenedor_individual = $("#contenedor_individual");
        let contenedor_grupal = $("#contenedor_grupal");
        let materia_id = $("#materia_id");
        let select_materia = $("#select_materia");
        let paralelo_id = $("#paralelo_id");
        let select_gestion = $("#select_gestion");
        $(document).ready(function() {
            watchTipoEnvio();
            watchInfoEstudiante();
            select_estudiante.change(function() {
                watchInfoEstudiante();
                getEstudianteTutor();
            })
            select_tipo.change(watchTipoEnvio);
        });

        function getEstudianteTutor() {
            if (select_estudiante.val() != '') {
                $.ajax({
                    type: "GET",
                    url: $("#info_tutor_correo").val(),
                    data: {
                        id: select_estudiante.val()
                    },
                    dataType: "json",
                    success: function(response) {
                        info_estudiante.html(response);
                    }
                });
            } else {
                info_estudiante.html("");
            }
        }

        function watchInfoEstudiante() {
            info_estudiante.show();
            if (select_tipo.val() == 'GRUPAL') {
                select_estudiante.val("");
            }
            if (select_estudiante.val() == '') {
                info_estudiante.html("");
                info_estudiante.hide();
            }
        }

        function watchTipoEnvio() {
            contenedor_grupal.addClass("oculto");
            contenedor_individual.addClass("oculto");

            if (select_tipo.val() == 'INDIVIDUAL') {
                select_estudiante.prop("required", true);
                if (select_gestion) {
                    select_gestion.removeAttr("required")
                }
                if (select_grado) {
                    select_grado.removeAttr("required")
                }
                if (select_turno) {
                    select_turno.removeAttr("required")
                }
                if (materia_id) {
                    materia_id.removeAttr("required")
                }
                if (paralelo_id) {
                    paralelo_id.removeAttr("required")
                }
                if (select_materia) {
                    select_materia.removeAttr("required")
                }
                contenedor_individual.removeClass("oculto");
            } else {
                select_estudiante.removeAttr("required");
                if (select_grado) {
                    select_grado.prop("required", true)
                }
                if (select_turno) {
                    select_turno.prop("required", true)
                }
                if (paralelo_id) {
                    paralelo_id.prop("required", true)
                }
                if (materia_id) {
                    materia_id.prop("required", true)
                }
                if (select_materia) {
                    select_materia.prop("required", true)
                }
                contenedor_grupal.removeClass("oculto");
            }
        }
    </script>
@endsection
