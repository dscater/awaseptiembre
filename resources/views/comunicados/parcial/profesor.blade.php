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
