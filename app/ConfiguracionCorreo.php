<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionCorreo extends Model
{
    protected $fillable = [
        "host",
        "puerto",
        "encriptado",
        "correo",
        "nombre",
        "password",
        "driver",
    ];
}
