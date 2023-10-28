<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $fillable = [
        "user_id",
        "materia_id",
        "profesor_materia_id",
        "gestion",
        "nombre",
        "descripcion",
        "fecha_asignacion",
        "fecha_limite",
        "estado",
        "fecha_registro",
    ];

    public function tarea_archivos()
    {
        return $this->hasMany(TareaArchivo::class, 'tarea_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
}
