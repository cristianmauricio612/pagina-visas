<?php

namespace App\Models;
use Carbon\Carbon;

class Blog extends Model
{
    protected $table = 'blog';

    protected $fillable = [
        'titulo',
        'slug',
        'categoria_id',
        'contenido',
        'resumen',
        'imagen',
        'autor_id',
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
        'categoria_id' => 'integer',
        'autor_id' => 'integer'
    ];

    public $timestamps = true;

    public function autorObj()
    {
        return $this->belongsTo(BlogAutor::class, 'autor_id');
    }

    public static function crearBlog($datos, $archivoImagen = null)
    {
        // Generar slug único automáticamente
        $slug = self::generarSlug($datos['titulo']);

        // Procesar fecha de publicación según el estado
        $fechaPublicacion = null;
        if (isset($datos['estado']) && $datos['estado'] === 'publicado') {
            $fechaPublicacion = $datos['fecha_publicacion'] ?? date('Y-m-d H:i:s');
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
            'autor_id' => $datos['autor_id'] ?? null,
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
            ->where(function ($query) use ($termino) {
                $query->where('titulo', 'LIKE', "%{$termino}%")
                    ->orWhere('contenido', 'LIKE', "%{$termino}%");
            });
    }

    // MÉTODOS PERSONALIZADOS
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
        return "/{$this->slug}";
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

    public function nombreAutor()
    {
        if ($this->autorObj) {
            return $this->autorObj->nombreCompleto();
        }
        return 'Anónimo'; // O cualquier valor predeterminado
    }

    // MÉTODO PARA GENERAR SLUG ÚNICO
    public static function generarSlug($titulo)
    {
        // PASO 1: Convertir caracteres acentuados a sus equivalentes sin acento
        $caracteres = [
            'á' => 'a',
            'à' => 'a',
            'ä' => 'a',
            'â' => 'a',
            'ā' => 'a',
            'ã' => 'a',
            'é' => 'e',
            'è' => 'e',
            'ë' => 'e',
            'ê' => 'e',
            'ē' => 'e',
            'í' => 'i',
            'ì' => 'i',
            'ï' => 'i',
            'î' => 'i',
            'ī' => 'i',
            'ó' => 'o',
            'ò' => 'o',
            'ö' => 'o',
            'ô' => 'o',
            'ō' => 'o',
            'õ' => 'o',
            'ú' => 'u',
            'ù' => 'u',
            'ü' => 'u',
            'û' => 'u',
            'ū' => 'u',
            'ñ' => 'n',
            'ç' => 'c',
            // Mayúsculas
            'Á' => 'A',
            'À' => 'A',
            'Ä' => 'A',
            'Â' => 'A',
            'Ā' => 'A',
            'Ã' => 'A',
            'É' => 'E',
            'È' => 'E',
            'Ë' => 'E',
            'Ê' => 'E',
            'Ē' => 'E',
            'Í' => 'I',
            'Ì' => 'I',
            'Ï' => 'I',
            'Î' => 'I',
            'Ī' => 'I',
            'Ó' => 'O',
            'Ò' => 'O',
            'Ö' => 'O',
            'Ô' => 'O',
            'Ō' => 'O',
            'Õ' => 'O',
            'Ú' => 'U',
            'Ù' => 'U',
            'Ü' => 'U',
            'Û' => 'U',
            'Ū' => 'U',
            'Ñ' => 'N',
            'Ç' => 'C'
        ];

        // Reemplazar caracteres acentuados
        $titulo = strtr($titulo, $caracteres);

        // PASO 2: Convertir a minúsculas
        $slug = strtolower($titulo);

        // PASO 3: Reemplazar espacios y caracteres especiales con guiones
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);

        // PASO 4: Eliminar guiones múltiples
        $slug = preg_replace('/-+/', '-', $slug);

        // PASO 5: Eliminar guiones al inicio y final
        $slug = trim($slug, '-');

        // PASO 6: Asegurar que el slug no esté vacío
        if (empty($slug)) {
            $slug = 'articulo';
        }

        // PASO 7: Verificar unicidad y agregar número si es necesario
        $contador = 1;
        $slugOriginal = $slug;
        while (self::where('slug', $slug)->exists()) {
            $slug = $slugOriginal . '-' . $contador;
            $contador++;
        }

        return $slug;
    }
}
