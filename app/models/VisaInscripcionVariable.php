<?php

namespace App\Models;
use Carbon\Carbon;
class VisaInscripcionVariable extends Model
{
    protected $table = 'visa_inscripcion_variables';
    protected $fillable = ['visa_inscripcion_id', 'variable_id', 'valor'];


    /*
    public static function limpiarPedidosPendientes()
    {
        $tiempoExpiracion = Carbon::now()->subMinutes(30);

        // Obtener todas las inscripciones que serán eliminadas
        $inscripciones = self::where('status_pago', 'pendiente')
            ->where('created_at', '<', $tiempoExpiracion)
            ->get();

        foreach ($inscripciones as $inscripcion) {
            // Eliminar todos los viajeros asociados a la inscripción
            Viajero::where('visa_inscripcion_id', $inscripcion->id)->delete();
            
            // Eliminar la inscripción
            $inscripcion->delete();
        }
    }*/
}