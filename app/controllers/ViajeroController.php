<?php

namespace App\Controllers;

use App\Models\Formulario;

class ViajeroController extends Controller
{
    public function cargarViajero($id) {
        $formulario = Formulario::with('variables')->where('id', $id)->first();

        if (!$formulario) {
            return response()->json(['error' => 'Formulario no encontrado'], 404);
        }

        return render('ui.Viajero', ['formulario' => $formulario]);
    }

    public function cargarPasaporte($id) {
        $formulario = Formulario::with('variables')->where('id', $id)->first();

        if (!$formulario) {
            return response()->json(['error' => 'Formulario no encontrado'], 404);
        }

        return render('ui.Pasaporte', ['formulario' => $formulario]);
    }
}