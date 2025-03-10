<?php

namespace App\Controllers;

use App\Models\Viajero;
use App\Models\VisaInscripcion;
use Carbon\Carbon;

class VisaInscripcionController extends Controller
{
    public function createVisaInscripcion()
    {
        $data = request()->get([
            'visas_id',
            'fecha_llegada',
            'fecha_salida',
            'correo',
            'viajeros',
        ]);

        // Validaciones básicas
        if (empty($data['viajeros']) || !is_array($data['viajeros']) || empty($data['visas_id']) || empty($data['fecha_llegada']) || empty($data['correo'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Los campos fecha de llegada y correo son obligatorios'
            ], 400);
        }

        $visa = \App\Models\Visa::find($data['visas_id']);

        $visaInscripcion = new VisaInscripcion();
        $visaInscripcion->visas_id = $data['visas_id'];
        $visaInscripcion->fecha_llegada = $data['fecha_llegada'];
        $visaInscripcion->fecha_salida = $data['fecha_salida'];
        $visaInscripcion->correo = $data['correo'];
        $visaInscripcion->pago_hoy = $visa['precio'] * $data['viajeros']->count();
        $visaInscripcion->pago_posterior = $data['pago_posterior'];
        $visaInscripcion->tasa_gobierno_total = $visa['tasa_gobierno'] * $data['viajeros']->count();
        $visaInscripcion->save();

        foreach ($data["viajeros"] as $viajero) {
            Viajero::create([
                "visa_inscripcion_id" => $visaInscripcion->id,
                "nombres_pasaporte" => $viajero['nombres_pasaporte'],
                "apellidos_pasaporte" => $viajero['apellidos_pasaporte'],
                "fecha_nacimiento" => Carbon::parse($viajero['fecha_nacimiento'])->format('d-m-Y'),
                "nacionalidad_pasaporte" => $viajero['nacionalidad_pasaporte'],
                "numero_pasaporte" => intval($viajero['numero_pasaporte']),
                "fecha_caducidad_pasaporte" => isset($viajero['fecha_caducidad_pasaporte']) ? Carbon::parse($viajero['fecha_caducidad_pasaporte'])->format('d-m-Y') : null,
                "pais_nacimiento" => $viajero['pais_nacimiento'],
                "nivel_estudios" => $viajero['nivel_estudios'],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Visa Inscripcion creada exitosamente con sus viajeros',
            'product' => $visaInscripcion
        ], 201);
    }
}