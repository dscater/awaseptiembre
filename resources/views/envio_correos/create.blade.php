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
                        {{ Form::open(['route' => 'envio_correos.store', 'method' => 'post']) }}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Tipo de envío</label>
                                    <select name="tipo" id="tipo" class="form-control">
                                        <option value="INDIVIDUAL">INDIVIDUAL</option>
                                        <option value="GRUPAL">GRUPAL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <hr>
                                </div>
                            </div>
                            {{-- INDIVIDUAL --}}
                            <div class="row" id="contenedor_individual">
                                <div class="col-md-12 form-group">
                                    {{ Form::select('inscripcion_id', $array_estudiantes, null, ['class' => 'form-control select2', 'id' => 'select_inscripcion', 'required']) }}
                                </div>
                                <div class="col-12" id="info_estudiante">

                                </div>
                            </div>
                            {{-- GRUPAL --}}
                            <div class="row" id="contenedor_grupal">
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>Gestión*</label>
                                        {{ Form::select('gestion', $array_gestiones, date('Y'), ['class' => 'form-control', 'required', 'id' => 'select_gestion']) }}
                                        @if ($errors->has('gestion'))
                                            <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block"
                                                role="alert">
                                                <strong>{{ $errors->first('gestion') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @if (Auth::user()->tipo == 'PROFESOR')
                                    @include('comunicados.parcial.profesor')
                                @else
                                    @include('comunicados.parcial.normal')
                                @endif
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Descripción de Comunicado*</label>
                                        {{ Form::textarea('descripcion', null, ['class' => 'form-control', 'required', 'rows' => '1']) }}
                                        @if ($errors->has('descripcion'))
                                            <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block"
                                                role="alert">
                                                <strong>{{ $errors->first('descripcion') }}</strong>
                                            </span>
                                        @endif
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
@endsection

@section('scripts')
    <script src="{{ asset('js/envio_correos/create.js') }}"></script>
    @if (Auth::user()->tipo == 'PROFESOR')
        <script>
            $(document).ready(function() {
                obtieneMaterias();
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
@endsection
