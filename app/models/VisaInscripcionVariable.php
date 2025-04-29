<?php

namespace App\Models;

class VisaInscripcionVariable extends Model
{
    protected $table = 'visa_inscripcion_variables';
    protected $fillable = ['visa_inscripcion_id', 'variable_id', 'valor'];

    public function variable()
    {
        return $this->belongsTo(Variable::class, 'variable_id');
    }
}