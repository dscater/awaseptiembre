<div class="modal fade" id="m_comunicados">
    <div class="modal-dialog">
        <div class="modal-content  bg-sucess">
            <div class="modal-header">
                <h4 class="modal-title">Comunicados</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open([
                    'route' => 'reportes.comunicados',
                    'method' => 'get',
                    'target' => '_blank',
                    'id' => 'formcomunicados',
                ]) !!}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Seleccione:</label>
                            {{ Form::select('filtro', ['todos' => 'Todos', 'estado' => 'Estado'], null, ['class' => 'form-control', 'id' => 'filtro', 'required']) }}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Estado:</label>
                            {{ Form::select('estado', ['todos' => 'TODOS', 'VIGENTE' => 'VIGENTE', 'VENCIDO' => 'VENCIDO'], null, ['class' => 'form-control', 'id' => 'estado', 'required']) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-info" id="btncomunicados">Generar reporte</button>
                {!! Form::close() !!}
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
