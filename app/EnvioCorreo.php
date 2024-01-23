<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnvioCorreo extends Model
{
    protected $fillable = [
        "tipo",
        "estudiante_id",
        "nivel",
        "grado",
        "paralelo_id",
        "materia_id",
        "turno",
        "texto",
        "archivo",
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function paralelo()
    {
        return $this->belongsTo(Paralelo::class, 'paralelo_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
}
