<?php

namespace App\Models;
class Viajero extends Model
{
    protected $table = 'viajero';
    protected $fillable = ['visa_inscripcion_id', 'nombres_pasaporte', 'apellidos_pasaporte', 'fecha_nacimiento', 'nacionalidad_pasaporte', 'numero_pasaporte', 'fecha_caducidad_pasaporte', 'pais_nacimiento', 'nivel_estudios'];
}