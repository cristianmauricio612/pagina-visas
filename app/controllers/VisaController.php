<?php

namespace App\Controllers;

use App\Models\Visa;
use App\Models\Pais;

class VisaController extends Controller
{
    public function getVisasByPaises($pais1_id, $pais2_id) {
        // Buscar visas donde pais1_id y pais2_id coincidan con los parámetros
        $visas = Visa::where('pais1_id', $pais1_id)
                     ->where('pais2_id', $pais2_id)
                     ->get();
        
        $pais1 = Pais::find($pais1_id);
        $pais2 = Pais::find($pais2_id);

        // Renderizar la vista con los resultados
        render('visas', compact('visas', 'pais1', 'pais2'));
    }

    public function getVisaById($id) {
        // Buscar visas donde pais1_id y pais2_id coincidan con los parámetros
        $visa = Visa::where('id', $id)->get();

        // Renderizar la vista con los resultados
        render('visa-inscripcion', compact('visa'));
    }
}