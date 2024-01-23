<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $fillable = [
        'nombre', 'paterno', 'materno', 'tipo_doc', 'nro_doc', 'ci_exp',
        'pais_nac', 'dpto_nac', 'provincia_nac', 'localidad_nac', 'fecha_nac',
        'sexo', 'oficialia', 'libro', 'partida', 'folio', 'ue_procedencia',
        'codigo_sie_ue', 'provincia_dir', 'zona_dir', 'municipio_dir',
        'avenida_dir', 'localidad_dir', 'fono_dir', 'nro_dir', 'idioma_niniez',
        'idiomas_estudiante', 'pueblo_nacion', 'pueblo_nacion_otro',
        'centro_salud', 'veces_centro_salud', 'discapacidad', 'discapacidad_otro',
        'desc_discapacidad', 'agua', 'energia_electrica',
        'banio', 'actividad', 'dias_trabajo', 'recibio_pago', 'internet',
        'frecuencia_internet', 'llega', 'llega_otro', 'desc_llega', 'ci_padre_tutor', 'app_padre_tutor',
        'apm_padre_tutor', 'nom_padre_tutor', 'idioma_padre_tutor', 'ocupacion_padre_tutor', 'grado_padre_tutor',
        'parentezco_padre_tutor', 'correo_padre_tutor',
        'ci_madre', 'app_madre', 'apm_madre', 'nom_madre',
        'idioma_madre', 'ocupacion_madre', 'grado_madre', 'correo_madre',
        'lugar', 'foto',
        'fecha_registro', 'user_id', 'estado',
    ];

    protected $appends = ["full_name", "full_name_tutor", "full_name_madre"];

    public function getFullNameAttribute()
    {
        $full_name = $this->nombre . ' ' . $this->paterno;
        if ($this->materno) {
            $full_name .= ' ' . $this->materno;
        }
        return $full_name;
    }

    public function getFullNameTutorAttribute()
    {
        $full_name = $this->nom_padre_tutor . ' ' . $this->app_padre_tutor;
        if ($this->materno) {
            $full_name .= ' ' . $this->apm_padre_tutor;
        }
        return $full_name;
    }

    public function getFullNameMadreAttribute()
    {
        if ($this->nom_madre && $this->app_madre) {
            $full_name = $this->nom_madre . ' ' . $this->app_madre;
            if ($this->materno) {
                $full_name .= ' ' . $this->apm_madre;
            }
            return $full_name;
        }
        return "";
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user_tutor()
    {
        return $this->belongsTo(User::class, 'user_tutor_id');
    }


    public function user_madre()
    {
        return $this->belongsTo(User::class, 'user_madre_id');
    }

    public function inscripcions()
    {
        return $this->hasMany(Inscripcion::class, 'estudiante_id');
    }

    public function pagos()
    {
        return $this->hasMany(PagoEstudiante::class, 'estudiante_id');
    }
}
