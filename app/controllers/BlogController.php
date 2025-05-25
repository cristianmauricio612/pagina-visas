<?php

namespace App\Controllers;

use App\Models\Blog;
use App\Models\BlogCategoria;
use App\Models\BlogTag;

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
        $articuloDestacado = Blog::publicados()->first();

        // Obtener categorías disponibles
        $categorias = BlogCategoria::activas()->get();

        // Obtener artículos populares (por vistas)
        $articulosPopulares = Blog::publicados()
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
        $articulo = Blog::publicados()->where('slug', $slug)->first();

        if (!$articulo) {
            return render('errors.404');
        }

        // Incrementar contador de vistas
        $articulo->incrementarVistas();

        // Obtener artículos relacionados de la misma categoría
        $articulosRelacionados = Blog::porCategoria($articulo->categoria_id)
                                    ->where('id', '!=', $articulo->id)
                                    ->limit(3)
                                    ->get();

        // Obtener artículo anterior y siguiente
        $articuloAnterior = Blog::publicados()
                               ->where('fecha_publicacion', '<', $articulo->fecha_publicacion)
                               ->orderBy('fecha_publicacion', 'desc')
                               ->first();

        $articuloSiguiente = Blog::publicados()
                                ->where('fecha_publicacion', '>', $articulo->fecha_publicacion)
                                ->orderBy('fecha_publicacion', 'asc')
                                ->first();

        return render('blog.show', compact(
            'articulo',
            'articulosRelacionados',
            'articuloAnterior',
            'articuloSiguiente'
        ));
    }

    /**
     * Filtrar por categoría
     */
    public function categoria($categoria)
    {
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
        $articulos = $query->limit($perPage)->offset($offset)->get();

        // Obtener todas las categorías para el sidebar
        $categorias = BlogCategoria::activas()->get();

        return render('blog.categoria', compact(
            'articulos',
            'categoria',
            'categorias',
            'categoriaObj',
            'page',
            'totalPages',
            'total'
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
        $articulos = $query->limit($perPage)->offset($offset)->get();

        $total = $query->count();
        $hasMore = ($page * $perPage) < $total;

        return response()->json([
            'status' => 'success',
            'articulos' => $articulos,
            'hasMore' => $hasMore,
            'page' => $page + 1
        ]);
    }
}
