<?php

namespace App\Models;
class Pais extends Model
{
    protected $table = 'paises';
    protected $fillable = ['nombre', 'imagen'];
}