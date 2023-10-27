<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'password', 'tipo', 'foto', 'codigo', 'estado',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function administrativo()
    {
        return $this->hasOne('App\Administrativo', 'user_id', 'id');
    }

    public function profesor()
    {
        return $this->hasOne('App\Profesor', 'user_id', 'id');
    }

    public function estudiante()
    {
        return $this->hasOne(Estudiante::class, 'user_id');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'user_id');
    }

    public function actividad_profesors()
    {
        return $this->hasMany(ActividadProfesor::class, 'user_id');
    }

    public function desempeno_notificacions()
    {
        return $this->hasMany(DesempenoNotificacion::class, 'user_id');
    }

    public function user_tutor()
    {
        return $this->hasOne(Estudiante::class, 'user_tutor_id');
    }

    public function user_madre()
    {
        return $this->hasOne(Estudiante::class, 'user_madre_id');
    }
}
