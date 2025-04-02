<?php

namespace App\Models;
class Visa extends Model
{
    protected $table = 'visas';
    protected $fillable = ['pais1_id', 'pais2_id', 'nombre', 'tiempo_validez', 'numero_entradas', 'estancia_maxima', 'necesita_visa', 'precio', 'tasa_gobierno'];

    public function pais1()
    {
        return $this->belongsTo(Pais::class, 'pais1_id');
    }

    public function pais2()
    {
        return $this->belongsTo(Pais::class, 'pais2_id');
    }
}