<?php

namespace App\Models;
class VisaInscripcion extends Model
{
    protected $table = 'visa_inscripcion';
    protected $fillable = ['visas_id', 'numero_pedido', 'fecha_llegada', 'fecha_salida', 'correo', 'pago_hoy', 'pago_total', 'tasa_gobierno_total'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($visa_inscripcion) {
            // Si no se ha definido un número de pedido, generar uno aleatorio de 7 dígitos
            $visa_inscripcion->numero_pedido = $visa_inscripcion->numero_pedido ?? str_pad(mt_rand(0, 9999999), 7, '0', STR_PAD_LEFT);
        });
    }
}