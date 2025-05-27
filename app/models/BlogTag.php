<?php

namespace App\Models;

class BlogTag extends Model
{
    protected $table = 'blog_tags';

    protected $fillable = [
        'nombre',
        'descripcion',
        'uso_contador'
    ];

    protected $casts = [
        'uso_contador' => 'integer'
    ];

    public $timestamps = true;

    // RELACIONES
    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_tags_relaciones', 'tag_id', 'blog_id');
    }

    // SCOPES
    public static function populares($limite = 10)
    {
        return self::orderBy('uso_contador', 'desc')->limit($limite);
    }

    public static function porNombre($nombre)
    {
        return self::where('nombre', $nombre)->first();
    }

    // MÉTODOS PERSONALIZADOS
    public function incrementarUso()
    {
        $this->uso_contador = ($this->uso_contador ?? 0) + 1;
        $this->save();
    }

    public function decrementarUso()
    {
        $this->uso_contador = max(0, ($this->uso_contador ?? 0) - 1);
        $this->save();
    }

    public function url()
    {
        return "/blog/tag/" . urlencode($this->nombre);
    }
}
