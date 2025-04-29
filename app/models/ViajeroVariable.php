<?php

namespace App\Models;
class ViajeroVariable extends Model
{
    protected $table = 'viajero_variables';
    protected $fillable = ['viajero_id', 'variable_id', 'valor'];

    public function variable()
    {
        return $this->belongsTo(Variable::class, 'variable_id');
    }
}