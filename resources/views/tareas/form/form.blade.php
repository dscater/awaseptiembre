<div class="row">
    <div class="col-md-2 col-sm-12">
        <div class="form-group">
            <label>Gestión*</label>
            {{ Form::select('gestion', $array_gestiones, date('Y'), ['class' => 'form-control', 'required', 'id' => 'select_gestion']) }}
            @if ($errors->has('gestion'))
                <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block" role="alert">
                    <strong>{{ $errors->first('gestion') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-10 col-sm-12">
        <div class="form-group">
            <label>Seleccione Materia*</label>
            {{ Form::select('profesor_materia_id', [], null, ['class' => 'form-control', 'required', 'id' => 'select_materia']) }}
            @if ($errors->has('profesor_materia_id'))
                <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block" role="alert">
                    <strong>{{ $errors->first('profesor_materia_id') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>Nombre Tarea*</label>
            {{ Form::text('nombre', null, ['class' => 'form-control', 'rows' => '1']) }}
            @if ($errors->has('nombre'))
                <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block" role="alert">
                    <strong>{{ $errors->first('nombre') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>Descripción de Tarea</label>
            {{ Form::textarea('descripcion', null, ['class' => 'form-control', 'rows' => '1']) }}
            @if ($errors->has('descripcion'))
                <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block" role="alert">
                    <strong>{{ $errors->first('descripcion') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Fecha de asignación*</label>
            {{ Form::date('fecha_asignacion', isset($tarea) ? $tarea->fecha_asignacion : date('Y-m-d'), ['class' => 'form-control', 'required']) }}
            @if ($errors->has('fecha_asignacion'))
                <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block" role="alert">
                    <strong>{{ $errors->first('fecha_asignacion') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Fecha Límite de Entrega*</label>
            {{ Form::date('fecha_limite', isset($tarea) ? $tarea->fecha_limite : date('Y-m-d'), ['class' => 'form-control', 'required']) }}
            @if ($errors->has('fecha_limite'))
                <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block" role="alert">
                    <strong>{{ $errors->first('fecha_limite') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <hr>
    </div>
    <div class="col-md-12 mb-3">
        <label>Cargar Links de Archivos <button type="button"
                class="btn btn-xs btn-outline-success btn-flat btn-inline-block" id="btnAgregarLink"><i
                    class="fa fa-plus"></i> Agregar
                link</button></label>
        <div class="row" id="contenedor_links">
            @if (isset($tarea))
                @foreach ($tarea->tarea_archivos as $ta)
                    <div class="input-group col-12 mb-1 link existe" data-id="{{ $ta->id }}">
                        <input type="text" name="modificados[]" placeholder="Ingresar Link"
                            value="{{ $ta->link }}" class="form-control" required>
                        <input type="hidden" name="id_modificados[]" value="{{ $ta->id }}" class="form-control"
                            required>
                        <span class="input-group-append"><button class="btn btn-danger" type="button"><i
                                    class="fa fa-times"></i></button></span>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<div id="contenedor_eliminados"></div>
