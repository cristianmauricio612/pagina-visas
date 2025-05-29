<?php

namespace App\Models;

class BlogAutor extends Model
{
    protected $table = 'blog_autores';

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'bio',
        'imagen',
        'puesto',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    public $timestamps = true;

    /**
     * Relación con artículos del blog
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'autor_id');
    }

    /**
     * Obtener solo autores activos
     */
    public static function activos()
    {
        return self::where('activo', true);
    }

    /**
     * Obtener nombre completo del autor
     */
    public function nombreCompleto()
    {
        return $this->nombre . ($this->apellido ? ' ' . $this->apellido : '');
    }

    /**
     * Subir imagen del autor
     */
    public function subirImagen($archivo)
    {
        if ($archivo && $archivo['size'] > 0) {
            $imagenData = file_get_contents($archivo['tmp_name']);
            $base64 = base64_encode($imagenData);
            $this->imagen = "data:image/jpeg;base64," . $base64;
            $this->save();
            return true;
        }
        return false;
    }

    /**
     * Verificar si el autor tiene imagen
     */
    public function tieneImagen()
    {
        return !empty($this->imagen);
    }

    /**
     * Obtener URL para avatar del autor
     */
    public function avatarUrl()
    {
        if ($this->tieneImagen()) {
            return $this->imagen;
        }
        // Usar avatar predeterminado basado en el ID
        return "https://randomuser.me/api/portraits/men/" . ($this->id % 80) . ".jpg";
    }

    /**
     * Verificar si el autor está activo
     */
    public function estaActivo()
    {
        return $this->activo === true;
    }

    /**
     * Crear un nuevo autor
     */
    public static function crearAutor($datos, $archivoImagen = null)
    {
        $imagenBase64 = null;
        if ($archivoImagen && $archivoImagen['size'] > 0) {
            $imagenData = file_get_contents($archivoImagen['tmp_name']);
            $base64 = base64_encode($imagenData);
            $imagenBase64 = "data:image/jpeg;base64," . $base64;
        }

        return self::create([
            'nombre' => $datos['nombre'],
            'apellido' => $datos['apellido'] ?? null,
            'correo' => $datos['correo'] ?? null,
            'bio' => $datos['bio'] ?? null,
            'imagen' => $imagenBase64,
            'puesto' => $datos['puesto'] ?? null,
            'activo' => isset($datos['activo']) ? (bool) $datos['activo'] : true
        ]);
    }

    /**
     * Obtener la cantidad de artículos de este autor
     */
    public function cantidadArticulos()
    {
        return $this->blogs()->where('estado', 'publicado')->count();
    }

    /**
     * Obtener los artículos más populares de este autor
     */
    public function articulosPopulares($limit = 5)
    {
        return $this->blogs()
            ->where('estado', 'publicado')
            ->whereNotNull('fecha_publicacion')
            ->where('fecha_publicacion', '<=', date('Y-m-d H:i:s'))
            ->orderBy('vistas', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Obtener la URL de la página del autor (si implementas páginas de autor)
     */
    public function url()
    {
        return "/blog/autor/" . urlencode($this->nombre . ($this->apellido ? '-' . $this->apellido : ''));
    }
}
