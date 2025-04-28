<?php

namespace App\Models;
class ViajeroVariable extends Model
{
    protected $table = 'viajero_variables';
    protected $fillable = ['viajero_id', 'variable_id', 'valor'];
}