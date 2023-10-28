<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $fillable = [
        'inscripcion_id', 'estudiante_id', 'gestion', 'profesor_materia_id', 'materia_id', 'ponderacion',
        'estado', 'fecha_registro',
    ];

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class, 'inscripcion_id');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function trimestres()
    {
        return $this->hasMany(CalificacionTrimestre::class, 'calificacion_id');
    }
}
