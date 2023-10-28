<div class="col-md-2">
    <div class="form-group">
        <label>Nivel*</label>
        {{ Form::select('nivel', ['SECUNDARIA' => 'SECUNDARIA'], 'SECUNDARIA', ['class' => 'form-control', 'required', 'id' => 'select_nivel']) }}
        @if ($errors->has('nivel'))
            <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block" role="alert">
                <strong>{{ $errors->first('nivel') }}</strong>
            </span>
        @endif
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label>Grado*</label>
        {{ Form::select('grado', [], null, ['class' => 'form-control', 'required', 'id' => 'select_grado']) }}
        @if ($errors->has('grado'))
            <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block" role="alert">
                <strong>{{ $errors->first('grado') }}</strong>
            </span>
        @endif
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label>Paralelo*</label>
        {{ Form::select('paralelo_id', $array_paralelos, null, ['class' => 'form-control', 'required', 'paralelo_id']) }}
        @if ($errors->has('paralelo_id'))
            <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block" role="alert">
                <strong>{{ $errors->first('paralelo_id') }}</strong>
            </span>
        @endif
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label>Materia*</label>
        {{ Form::select('materia_id', [], null, ['class' => 'form-control', 'required', 'id' => 'materia_id']) }}
        @if ($errors->has('materia_id'))
            <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block" role="alert">
                <strong>{{ $errors->first('materia_id') }}</strong>
            </span>
        @endif
    </div>
</div>
<div class="col-md-2">
    <div class="form-group">
        <label>Turno*</label>
        {{ Form::select('turno', ['' => 'Seleccione...', 'MAÑANA' => 'MAÑANA', 'TARDE' => 'TARDE', 'NOCHE' => 'NOCHE'], null, ['class' => 'form-control', 'required']) }}
        @if ($errors->has('turno'))
            <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block" role="alert">
                <strong>{{ $errors->first('turno') }}</strong>
            </span>
        @endif
    </div>
</div>
