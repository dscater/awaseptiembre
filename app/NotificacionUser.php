<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificacionUser extends Model
{
    protected $fillable = [
        "notificacion_id",
        "user_id",
        "visto",
    ];

    public function notificacion()
    {
        return $this->belongsTo(Notificacion::class, 'notificacion_id');
    }


    public function user()
    {
        return $this->belongsTo(NotificacionUser::class, 'user_id');
    }
}
