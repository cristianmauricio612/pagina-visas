<?php

namespace App\Models;

class BlogCategoria extends Model
{
    protected $table = 'blog_categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
        'color',
        'icono',
        'activa'
    ];

    protected $casts = [
        'activa' => 'boolean'
    ];

    public $timestamps = true;

    // RELACIONES
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'categoria_id');
    }

    // SCOPES
    public static function activas()
    {
        return self::where('activa', true)->orderBy('nombre');
    }

    // MÉTODOS PERSONALIZADOS
    public function cantidadArticulos()
    {
        return $this->blogs()->where('estado', 'publicado')->count();
    }

    public function estaActiva()
    {
        return $this->activa === true;
    }

    public function url()
    {
        return "/blog/categoria/" . urlencode($this->nombre);
    }
}
