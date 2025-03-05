<?php

namespace App\Controllers;

use App\Models\Pais;

class PaisController extends Controller
{
    public function getPaisById($id) {
        $pais = Pais::find($id);

        if (!$pais) {
            return view('errors.404');
        }

        render('index', compact('pais'));
    }
}