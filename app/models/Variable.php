<?php

namespace App\Models;
class Variable extends Model
{
    protected $table = 'variable';
    protected $fillable = ['nombre', 'tipo_elemento', 'tipo_variable', 'tiempo_validez', 'obligatoriedad', 'placeholder', 'encabezado', 'advertencia', 'valor', 'isPais'];

    // En Variable.php
    public function restricciones()
    {
        return $this->hasMany(Restriccion::class, 'variable_id');
    }

    public function opciones()
    {
        return $this->hasMany(Opcion::class, 'variable_id');
    }
}