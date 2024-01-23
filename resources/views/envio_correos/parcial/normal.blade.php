<div class="row">
    <div class="col-md-4">
        <label>Tipo de envío</label>
        <select name="tipo" id="select_tipo" class="form-control">
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
        {{ Form::select('estudiante_id', $array_estudiantes, null, ['class' => 'form-control select2', 'id' => 'select_estudiante', 'required']) }}
    </div>
    <div class="col-12" id="info_estudiante">
    </div>
</div>
{{-- GRUPAL --}}
<div class="row" id="contenedor_grupal">
    <div class="col-md-2 col-sm-12">
        <div class="form-group">
            <label>Gestión*:</label>
            {{ Form::select('gestion', $array_gestiones, date('Y'), ['class' => 'form-control', 'required', 'id' => 'select_gestion']) }}
            @if ($errors->has('gestion'))
                <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block" role="alert">
                    <strong>{{ $errors->first('gestion') }}</strong>
                </span>
            @endif
        </div>
    </div>
    @include('comunicados.parcial.normal')
</div>
