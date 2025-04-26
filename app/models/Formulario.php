<?php

namespace App\Models;
class Formulario extends Model
{
    protected $table = 'formulario';
    protected $fillable = ['visa_id'];

    public function variables()
    {
        return $this->belongsToMany(Variable::class, 'formulario_variables')
            ->withPivot('orden', 'meses_espera') // <-- Agregamos 'meses_espera'
            ->withTimestamps()
            ->orderBy('formulario_variables.orden');
    }

    public function visa()
    {
        return $this->belongsTo(Visa::class);
    }
}