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
    @if (Auth::user()->tipo == 'PROFESOR')
        @include('comunicados.parcial.profesor')
    @else
        @include('comunicados.parcial.normal')
    @endif
    <div class="col-md-2">
        <div class="form-group">
            <label>Fecha Inicio*</label>
            {{ Form::date('fecha_inicio', isset($comunicado) ? $comunicado->fecha_inicio : date('Y-m-d'), ['class' => 'form-control', 'required']) }}
            @if ($errors->has('fecha_inicio'))
                <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block" role="alert">
                    <strong>{{ $errors->first('fecha_inicio') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Fecha Final*</label>
            {{ Form::date('fecha_fin', isset($comunicado) ? $comunicado->fecha_fin : date('Y-m-d'), ['class' => 'form-control', 'required']) }}
            @if ($errors->has('fecha_fin'))
                <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block" role="alert">
                    <strong>{{ $errors->first('fecha_fin') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>Descripción de Comunicado*</label>
            {{ Form::textarea('descripcion', null, ['class' => 'form-control', 'required', 'rows' => '1']) }}
            @if ($errors->has('descripcion'))
                <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block" role="alert">
                    <strong>{{ $errors->first('descripcion') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
