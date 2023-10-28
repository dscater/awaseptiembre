<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comunicado extends Model
{
    protected $fillable = [
        "user_id",
        "gestion",
        "nivel",
        "grado",
        "profesor_materia_id",
        "materia_id",
        "paralelo_id",
        "turno",
        "descripcion",
        "fecha_inicio",
        "fecha_fin",
        "estado",
        "fecha_registro",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function paralelo()
    {
        return $this->belongsTo(Paralelo::class, 'paralelo_id');
    }
}
