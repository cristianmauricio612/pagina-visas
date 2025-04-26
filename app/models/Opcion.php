<?php

namespace App\Models;
class Opcion extends Model
{
    protected $table = 'opcion';
    protected $fillable = ['variable_id', 'valor', 'imagen', 'global', 'contenido'];
}