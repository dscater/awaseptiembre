<div class="modal fade" id="m_est_ap_rep">
    <div class="modal-dialog">
        <div class="modal-content  bg-sucess">
            <div class="modal-header">
                <h4 class="modal-title">Lista de Estudiantes Aprobados y Reprobados</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open([
                    'route' => 'reportes.est_ap_rep',
                    'method' => 'get',
                    'target' => '_blank',
                    'id' => 'formest_ap_rep',
                ]) !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Seleccione:</label>
                            {{ Form::select(
                                'filtro',
                                [
                                    'todos' => 'TODOS',
                                    'APROBADO' => 'APROBADOS',
                                    'REPROBADO' => 'REPROBADOS',
                                ],
                                'todos',
                                ['class' => 'form-control', 'id' => 'filtro', 'required'],
                            ) }}
                        </div>
                    </div>
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
                            <label for="">Paralelo:</label>
                            {{ Form::select('paralelo', $array_paralelos2, 'todos', ['class' => 'form-control', 'id' => 'paralelo', 'required']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Turno:</label>
                            {{ Form::select(
                                'turno',
                                [
                                    'todos' => 'TODOS',
                                    'MAÑANA' => 'MAÑANA',
                                    'TARDE' => 'TARDE',
                                    'NOCHE' => 'NOCHE',
                                ],
                                'todos',
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
                    {{-- @if (Auth::user()->tipo == 'ESTUDIANTE')
                        <input type="hidden" name="estudiante"value="{{ Auth::user()->estudiante->id }}"
                            id="estudiante">
                    @else
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Estudiante:</label>
                                {{ Form::select('estudiante', $array_estudiantes, null, ['class' => 'form-control select2', 'id' => 'estudiante', 'required']) }}

                            </div>
                        </div>
                    @endif --}}
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-info" id="btncalificaciones">Generar reporte</button>
                {!! Form::close() !!}
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
