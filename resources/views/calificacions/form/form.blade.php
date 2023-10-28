@if (isset($calificacion))
    <div class="row">
        <div class="col-md-2 col-sm-12">
            <div class="form-group">
                <label>Gestión*</label>
                {{ Form::text('gestion', $calificacion->gestion, ['class' => 'form-control', 'required', 'readonly']) }}
            </div>
        </div>
        <div class="col-md-10 col-sm-12">
            <div class="form-group">
                <label>Materia*</label>
                <input type="hidden" name="profesor_materia_id" value="{{ $calificacion->profesor_materia_id }}">
                {{ Form::text('materia_calificacion', $calificacion->materia->nombre, ['class' => 'form-control', 'required', 'readonly']) }}
            </div>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-md-2 col-sm-12">
            <div class="form-group">
                <label>Seleccione Gestión*</label>
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
    </div>
@endif
<hr>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Estudiante*</label>
            @if (isset($calificacion))
                {{ Form::text('inscripcion_calificacion', $calificacion->estudiante->full_name, ['class' => 'form-control', 'required', 'readonly']) }}
                <input type="hidden" name="inscripcion_id" value="{{ $calificacion->inscripcion_id }}">
            @else
                {{ Form::select('inscripcion_id', [], null, ['class' => 'form-control', 'id' => 'select_inscripcion', 'required']) }}
            @endif
            @if ($errors->has('inscripcion_id'))
                <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block" role="alert">
                    <strong>{{ $errors->first('inscripcion_id') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Ponderación*</label>
            {{ Form::number('ponderacion', null, ['class' => 'form-control', 'required']) }}
            @if ($errors->has('ponderacion'))
                <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block" role="alert">
                    <strong>{{ $errors->first('ponderacion') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label>Descripción</label>
            {{ Form::textarea('descripcion', null, ['class' => 'form-control', 'rows' => '1']) }}
            @if ($errors->has('descripcion'))
                <span class="invalid-feedback" style="color:rgb(185, 7, 7);display:block" role="alert">
                    <strong>{{ $errors->first('descripcion') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
