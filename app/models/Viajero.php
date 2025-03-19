<?php

namespace App\Models;
class Viajero extends Model
{
    protected $table = 'viajero';
    protected $fillable = ['visa_inscripcion_id', 'nombres_pasaporte', 'apellidos_pasaporte', 'fecha_nacimiento', 'nacionalidad_pasaporte_id', 'numero_pasaporte', 'fecha_caducidad_pasaporte', 'pais_nacimiento_id', 'nivel_estudios'];
}