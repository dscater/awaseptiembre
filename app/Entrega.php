<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    protected $fillable = [
        "user_id",
        "inscripcion_id",
        "profesor_materia_id",
        "materia_id",
        "tarea_id",
        "observaciones",
        "fecha_entrega",
        "calificacion",
        "estado",
        "enviado",
        "fecha_registro",
        "activo"
    ];

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class, 'inscripcion_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'tarea_id');
    }

    public function entrega_archivos()
    {
        return $this->hasMany(EntregaArchivo::class, 'entrega_id');
    }
}
