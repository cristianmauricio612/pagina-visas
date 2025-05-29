<?php

namespace App\Controllers;

use App\Models\Blog;
use App\Models\BlogCategoria;
use App\Models\BlogTag;
use App\Models\BlogTagRelacion;

class BlogController extends Controller
{
    /**
     * Mostrar la página principal del blog con listado de artículos
     */
    public function index()
    {
        $page = request()->get('page', 1);
        $categoria = request()->get('categoria');
        $busqueda = request()->get('q');
        $perPage = 9;

        // Obtener artículo destacado (el más reciente)
        $articuloDestacado = Blog::publicados()->with('autorObj')->first();

        // Obtener categorías disponibles
        $categorias = BlogCategoria::activas()->get();

        // Obtener artículos populares (por vistas)
        $articulosPopulares = Blog::with('autorObj')->where('estado', 'publicado')
            ->whereNotNull('fecha_publicacion')
            ->where('fecha_publicacion', '<=', date('Y-m-d H:i:s'))
            ->orderBy('vistas', 'desc')
            ->limit(5)
            ->get();

        // Query base para artículos
        $query = Blog::publicados();

        // Filtrar por categoría si se especifica
        if ($categoria) {
            $categoriaObj = BlogCategoria::where('nombre', $categoria)->first();
            if ($categoriaObj) {
                $query = $query->where('categoria_id', $categoriaObj->id);
            }
        }

        // Filtrar por búsqueda si se especifica
        if ($busqueda) {
            $query = Blog::buscar($busqueda);
        }

        // Obtener total para paginación
        $total = $query->count();
        $totalPages = ceil($total / $perPage);

        // Obtener artículos de la página actual
        $offset = ($page - 1) * $perPage;
        $articulos = $query->limit($perPage)->offset($offset)->get();

        return render('blog.index', compact(
            'articulos',
            'articuloDestacado',
            'categorias',
            'articulosPopulares',
            'categoria',
            'busqueda',
            'page',
            'totalPages',
            'total'
        ));
    }

    /**
     * Mostrar un artículo específico
     */
    public function show($slug)
    {
        $articulo = Blog::publicados()->with('autorObj')->where('slug', $slug)->first();

        if (!$articulo) {
            return render('errors.404');
        }

        // Incrementar contador de vistas
        $articulo->incrementarVistas();

        // Obtener artículos relacionados de la misma categoría
        $articulosRelacionados = Blog::porCategoria($articulo->categoria_id)->with('autorObj')
            ->where('id', '!=', $articulo->id)
            ->limit(3)
            ->get();

        // Obtener artículo anterior y siguiente
        $articuloAnterior = Blog::publicados()
            ->where('fecha_publicacion', '<', $articulo->fecha_publicacion)
            ->orderBy('fecha_publicacion', 'desc')
            ->first();

        // Obtener artículos populares (por vistas)
        $articulosPopulares = Blog::with('autorObj')->where('estado', 'publicado')
            ->whereNotNull('fecha_publicacion')
            ->where('fecha_publicacion', '<=', date('Y-m-d H:i:s'))
            ->orderBy('vistas', 'desc')
            ->limit(5)
            ->get();

        $articuloSiguiente = Blog::publicados()
            ->where('fecha_publicacion', '>', $articulo->fecha_publicacion)
            ->orderBy('fecha_publicacion', 'asc')
            ->first();

        // Obtener categorías para el sidebar
        $categorias = BlogCategoria::activas()->get();

        // Obtener todas las etiquetas para la barra lateral
        $tags = BlogTag::orderBy('uso_contador', 'desc')->get();

        // Cargar la relación de tags del artículo
        $articulo->load('tags');

        return render('blog.show', compact(
            'articulo',
            'articulosRelacionados',
            'articuloAnterior',
            'articuloSiguiente',
            'articulosPopulares',
            'categorias',
            'tags'
        ));
    }

    /**
     * Filtrar por categoría
     */
    public function categoria($categoria)
    {
        // Decodificar el nombre de la categoría de la URL
        $categoria = urldecode(str_replace('+', ' ', $categoria));

        $page = request()->get('page', 1);
        $perPage = 9;

        $categoriaObj = BlogCategoria::where('nombre', $categoria)->first();

        if (!$categoriaObj || !$categoriaObj->estaActiva()) {
            return render('errors.404');
        }

        $query = Blog::porCategoria($categoriaObj->id);

        $total = $query->count();
        $totalPages = ceil($total / $perPage);

        $offset = ($page - 1) * $perPage;
        $articulos = $query->with('autorObj')->limit($perPage)->offset($offset)->get();

        // Obtener todas las categorías para la barra lateral
        $categorias = BlogCategoria::activas()->get();

        // Obtener artículos populares para la barra lateral
        $articulosPopulares = Blog::publicados()->with('autorObj')
            ->orderBy('vistas', 'desc')
            ->limit(5)
            ->get();

        return render('blog.categoria', compact(
            'articulos',
            'categoria',
            'categorias',
            'categoriaObj',
            'page',
            'totalPages',
            'total',
            'articulosPopulares'
        ));
    }

    /**
     * Buscar artículos
     */
    public function buscar()
    {
        $termino = request()->get('q');
        $page = request()->get('page', 1);
        $perPage = 9;

        if (!$termino) {
            return response()->redirect('/blog');
        }

        $query = Blog::buscar($termino);

        $total = $query->count();
        $totalPages = ceil($total / $perPage);

        $offset = ($page - 1) * $perPage;
        $articulos = $query->limit($perPage)->offset($offset)->get();

        return render('blog.buscar', compact(
            'articulos',
            'termino',
            'page',
            'totalPages',
            'total'
        ));
    }

    /**
     * API para obtener artículos (AJAX)
     */
    public function obtenerArticulos()
    {
        $page = request()->get('page', 1);
        $categoria = request()->get('categoria');
        $busqueda = request()->get('q');
        $perPage = 6;

        $query = Blog::publicados();

        if ($categoria) {
            $categoriaObj = BlogCategoria::where('nombre', $categoria)->first();
            if ($categoriaObj) {
                $query = $query->where('categoria_id', $categoriaObj->id);
            }
        }

        if ($busqueda) {
            $query = Blog::buscar($busqueda);
        }

        $offset = ($page - 1) * $perPage;
        $articulos = $query->with('autorObj')->limit($perPage)->offset($offset)->get();

        $total = $query->count();
        $hasMore = ($page * $perPage) < $total;

        return response()->json([
            'status' => 'success',
            'articulos' => $articulos,
            'hasMore' => $hasMore,
            'page' => $page + 1
        ]);
    }

    /**
     * Filtrar artículos por etiqueta
     */
    public function tag($tag)
    {
        // Decodificar el nombre de la categoría de la URL
        $tag = urldecode(str_replace('+', ' ', $tag));

        $page = request()->get('page', 1);
        $perPage = 9;

        $tagObj = BlogTag::where('nombre', $tag)->first();

        if (!$tagObj) {
            return render('errors.404');
        }

        // Obtener los IDs de artículos relacionados con este tag
        $blogIds = BlogTagRelacion::where('tag_id', $tagObj->id)->pluck('blog_id')->toArray();

        // Consultar artículos publicados con esos IDs
        $query = Blog::publicados()->whereIn('id', $blogIds);

        $total = $query->count();
        $totalPages = ceil($total / $perPage);

        $offset = ($page - 1) * $perPage;
        $articulos = $query->with('autorObj')->limit($perPage)->offset($offset)->get();

        // Obtener todas las categorías para la barra lateral
        $categorias = BlogCategoria::activas()->get();

        // Obtener todos los tags para la barra lateral
        $tags = BlogTag::orderBy('uso_contador', 'desc')->get();

        return render('blog.tag', compact(
            'articulos',
            'tag',
            'tagObj',
            'tags',
            'categorias',
            'page',
            'totalPages',
            'total'
        ));
    }
}
