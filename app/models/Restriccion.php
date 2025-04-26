<?php

namespace App\Models;
class Restriccion extends Model
{
    protected $table = 'restriccion';
    protected $fillable = ['variable_id', 'variable_restringida_id'];

    public function variable()
    {
        return $this->belongsTo(Variable::class, 'variable_id');
    }

    public function variableRestringida()
    {
        return $this->belongsTo(Variable::class, 'variable_restringida_id');
    }
}