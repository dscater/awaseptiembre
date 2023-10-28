<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TareaArchivo extends Model
{
    protected $fillable = [
        "tarea_id",
        "link",
    ];

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'tarea_id');
    }
}
