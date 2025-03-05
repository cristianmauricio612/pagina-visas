<?php

namespace App\Models;
class VisaInscripcion extends Model
{
    protected $table = 'visa_inscripcion';
    protected $fillable = ['visas_id', 'fecha_llegada', 'fecha_salida', 'correo', 'pago_hoy', 'pago_posterior', 'tasa_gobierno_total'];
}