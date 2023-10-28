<div class="row">

    <div class="col-md-12">
        <label><strong>Materia: </strong></label>
        <p>{{ $entrega->tarea->materia->nombre }}</p>
    </div>
    <div class="col-md-12">
        <label><strong>Tarea: </strong></label>
        <p>{{ $entrega->tarea->nombre }}</p>
    </div>
</div>
<div class="row">

    <div class="col-md-12 mb-3">
        <label>Cargar Links de Archivos <button type="button"
                class="btn btn-xs btn-outline-success btn-flat btn-inline-block" id="btnAgregarLink"><i
                    class="fa fa-plus"></i> Agregar
                link</button></label>
        <div class="row" id="contenedor_links">
            @if (isset($entrega))
                @foreach ($entrega->entrega_archivos as $ea)
                    <div class="input-group col-12 mb-1 link existe" data-id="{{ $ea->id }}">
                        <input type="text" name="modificados[]" placeholder="Ingresar Link"
                            value="{{ $ea->link }}" class="form-control" required>
                        <input type="hidden" name="id_modificados[]" value="{{ $ea->id }}" class="form-control"
                            required>
                        <span class="input-group-append"><button class="btn btn-danger" type="button"><i
                                    class="fa fa-times"></i></button></span>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <hr>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>Observaciones*</label>
            {{ Form::textarea('observaciones', null, ['class' => 'form-control', 'rows' => '1']) }}
            @if ($errors->has('observaciones'))
                <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block" role="alert">
                    <strong>{{ $errors->first('observaciones') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

<div id="contenedor_eliminados"></div>
