<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActividadProfesor extends Model
{
    protected $fillable = [
        "user_id",
        "fecha",
        "descripcion",
        "observacion",
        "fecha_registro",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
