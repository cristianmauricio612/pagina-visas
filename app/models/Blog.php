<?php

namespace App\Models;
use Carbon\Carbon;

class Blog extends Model
{
    protected $table = 'blogs';

    protected $fillable = [
        'titulo',
        'slug',
        'categoria_id',
        'contenido',
        'resumen',
        'imagen',
        'autor',
        'tiempo_lectura',
        'estado',
        'vistas',
        'fecha_publicacion',
        'meta_description',
        'meta_keywords'
    ];

    protected $casts = [
        'fecha_publicacion' => 'datetime',
        'tiempo_lectura' => 'integer',
        'vistas' => 'integer',
        'categoria_id' => 'integer'
    ];

    public $timestamps = true;

    public static function crearBlog($datos, $archivoImagen = null)
    {
        // Generar slug único automáticamente
        $slug = self::generarSlug($datos['titulo']);

        // Procesar fecha de publicación según el estado
        $fechaPublicacion = null;
        if (isset($datos['estado']) && $datos['estado'] === 'publicado') {
            $fechaPublicacion = $datos['fecha_publicacion'] ?? date('Y-m-d H:i:s');
        } elseif (isset($datos['fecha_publicacion']) && !empty($datos['fecha_publicacion'])) {
            $fechaPublicacion = $datos['fecha_publicacion'];
        }

        // Calcular tiempo de lectura si no se proporciona
        $tiempoLectura = $datos['tiempo_lectura'] ?? self::calcularTiempoLectura($datos['contenido']);

        $imagenBase64 = null;
        if ($archivoImagen && $archivoImagen['size'] > 0) {
            $imagenData = file_get_contents($archivoImagen['tmp_name']);
            $base64 = base64_encode($imagenData);
            $imagenBase64 = "data:image/jpeg;base64," . $base64;
        }

        return self::create([
            'titulo' => $datos['titulo'],
            'slug' => $slug,
            'categoria_id' => $datos['categoria_id'],
            'contenido' => $datos['contenido'],
            'resumen' => !empty($datos['resumen']) ? $datos['resumen'] : null,
            'imagen' => $imagenBase64,
            'autor' => $datos['autor'] ?? 'Visas Travel',
            'tiempo_lectura' => $tiempoLectura,
            'estado' => $datos['estado'] ?? 'borrador',
            'vistas' => 0,
            'fecha_publicacion' => $fechaPublicacion,
            'meta_description' => !empty($datos['meta_description']) ? $datos['meta_description'] : null,
            'meta_keywords' => !empty($datos['meta_keywords']) ? $datos['meta_keywords'] : null
        ]);
    }

    private static function calcularTiempoLectura($contenido)
    {
        $palabras = str_word_count(strip_tags($contenido));
        $palabrasPorMinuto = 200; // Promedio de lectura en español
        $minutos = ceil($palabras / $palabrasPorMinuto);

        return max(1, $minutos); // Mínimo 1 minuto
    }

    // RELACIONES
    public function categoria()
    {
        return $this->belongsTo(BlogCategoria::class, 'categoria_id');
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_tags_relaciones', 'blog_id', 'tag_id');
    }

    // SCOPES (métodos estáticos como en tu LibroReclamacion)
    public static function publicados()
    {
        return self::where('estado', 'publicado')
                   ->whereNotNull('fecha_publicacion')
                   ->where('fecha_publicacion', '<=', date('Y-m-d H:i:s'))
                   ->orderBy('fecha_publicacion', 'desc');
    }

    public static function porCategoria($categoriaId)
    {
        return self::publicados()->where('categoria_id', $categoriaId);
    }

    public static function buscar($termino)
    {
        return self::publicados()
                   ->where(function($query) use ($termino) {
                       $query->where('titulo', 'LIKE', "%{$termino}%")
                             ->orWhere('contenido', 'LIKE', "%{$termino}%");
                   });
    }

    // MÉTODOS PERSONALIZADOS (como en tu LibroReclamacion)
    public function incrementarVistas()
    {
        $this->vistas = ($this->vistas ?? 0) + 1;
        $this->save();
    }

    public function estaPublicado()
    {
        return $this->estado === 'publicado' &&
               $this->fecha_publicacion &&
               $this->fecha_publicacion <= Carbon::now();
    }

    public function url()
    {
        return "/blog/{$this->slug}";
    }

    public function extracto($longitud = 150)
    {
        if ($this->resumen) {
            return $this->resumen;
        }

        $contenido = strip_tags($this->contenido);
        return strlen($contenido) > $longitud
            ? substr($contenido, 0, $longitud) . '...'
            : $contenido;
    }

    public function fechaFormateada()
    {
        return $this->fecha_publicacion
            ? date('d M, Y', strtotime($this->fecha_publicacion))
            : 'No publicado';
    }

    public function subirImagen($archivo)
    {
        if ($archivo && $archivo['size'] > 0) {
            $imagenData = file_get_contents($archivo['tmp_name']);
            $base64 = base64_encode($imagenData);
            $this->imagen = $base64;
            $this->save();
            return true;
        }
        return false;
    }

    public function tieneImagen()
    {
        return !empty($this->imagen);
    }

    // MÉTODO PARA GENERAR SLUG ÚNICO
    public static function generarSlug($titulo)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $titulo)));
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');

        $contador = 1;
        $slugOriginal = $slug;
        while (self::where('slug', $slug)->exists()) {
            $slug = $slugOriginal . '-' . $contador;
            $contador++;
        }

        return $slug;
    }
}
