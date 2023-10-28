<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $fillable = [
        "registro_id",
        "modulo",
        "descripcion",
    ];

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'registro_id');
    }

    public function entrega()
    {
        return $this->belongsTo(Entrega::class, 'registro_id');
    }

    public function comunicado()
    {
        return $this->belongsTo(Comunicado::class, 'registro_id');
    }
}
