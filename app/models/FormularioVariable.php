<?php

namespace App\Models;
class FormularioVariable extends Model
{
    protected $table = 'formulario_variables';
    protected $fillable = ['formulario_id', 'variable_id', 'orden', 'meses_espera'];

}