<div class="modal fade" id="modal_nueva_actividad">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="txtTituloActividad">Registrar actividad</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formularioActividad">
                    <input type="hidden" name="user_id" value="{{ $profesor->user->id }}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Fecha*:</label>
                                <input type="date" name="fecha" id="fecha" value="{{date("Y-m-d")}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Descripción de la actividad*:</label>
                                <textarea name="descripcion" id="descripcion" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Observación:</label>
                                <textarea name="observacion" id="observacion" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 oculto" id="contenedor_errores">
                            <ul class="bg-danger">

                            </ul>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-outline-success" id="btnRegistraActividad">Registrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
