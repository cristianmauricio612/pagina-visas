<?php

namespace App\Controllers;

use App\Models\Pais;
use App\Models\Blog;

class PaisController extends Controller
{
    /**
     * Renderiza la página principal con artículos en tendencia
     */
    public function index()
    {
        // Obtener países para el selector de visas
        $paises = Pais::all();

        // Obtener artículos populares (por vistas)
        $articulosPopulares = Blog::with('autorObj')
            ->where('estado', 'publicado')
            ->whereNotNull('fecha_publicacion')
            ->where('fecha_publicacion', '<=', date('Y-m-d H:i:s'))
            ->orderBy('vistas', 'desc')
            ->limit(3)
            ->get();

        return render('index', compact('paises', 'articulosPopulares'));
    }

    public function getPaisById($id) {
        $pais = Pais::find($id);

        if (!$pais) {
            return view('errors.404');
        }

        render('index', compact('pais'));
    }
}
