<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntregaArchivo extends Model
{
    protected $fillable = [
        "entrega_id",
        "link",
    ];

    public function entrega()
    {
        return $this->belongsTo(Entrega::class, 'entrega_id');
    }
}
