@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Comunicados</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('comunicados.index') }}">Comunicados</a></li>
                        <li class="breadcrumb-item active">Modificar</li>
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
                            <h3 class="card-title">Modificar Comunicado</h3>
                        </div>
                        <!-- /.card-header -->
                        {{ Form::model($comunicado, ['route' => ['comunicados.update', $comunicado->id], 'method' => 'put']) }}
                        <div class="card-body">
                            @include('comunicados.form.form')
                            <button class="btn btn-info"><i class="fa fa-update"></i> ACTUALIZAR</button>
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
    <script src="{{ asset('js/comunicados/create.js') }}"></script>
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
                setTimeout(() => {
                    $("#select_grado").val("{{ $comunicado->grado }}");
                    getMateriasNivelGrado();
                    setTimeout(() => {
                        $("#materia_id").val("{{ $comunicado->materia_id }}");
                    }, 300);

                }, 300);
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
