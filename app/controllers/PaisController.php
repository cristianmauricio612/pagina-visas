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
        // Obtener solo los países usados como país 1 y país 2 en visas
        $visas = \App\Models\Visa::all();
        $paises_origen_ids = $visas->pluck('pais1_id')->unique()->toArray();
        $paises_destino_ids = $visas->pluck('pais2_id')->unique()->toArray();
        $paises_origen = Pais::whereIn('id', $paises_origen_ids)->orderBy('nombre')->get();
        $paises_destino = Pais::whereIn('id', $paises_destino_ids)->orderBy('nombre')->get();

        // Obtener artículos populares (por vistas)
        $articulosPopulares = Blog::with('autorObj')
            ->where('estado', 'publicado')
            ->whereNotNull('fecha_publicacion')
            ->where('fecha_publicacion', '<=', date('Y-m-d H:i:s'))
            ->orderBy('vistas', 'desc')
            ->limit(3)
            ->get();

        return render('index', [
            'paises_origen' => $paises_origen,
            'paises_destino' => $paises_destino,
            'articulosPopulares' => $articulosPopulares
        ]);
    }

    public function getPaisById($id) {
        $pais = Pais::find($id);

        if (!$pais) {
            return view('errors.404');
        }

        render('index', compact('pais'));
    }
}
