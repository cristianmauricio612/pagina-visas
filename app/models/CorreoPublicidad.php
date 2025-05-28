<?php

namespace App\Models;

use Carbon\Carbon;

class CorreoPublicidad extends Model
{
    protected $table = 'correos_publicidad';
    protected $fillable = ['correo', 'pagina_origen', 'ip_usuario', 'user_agent', 'convertido'];

    /**
     * Guardar un correo para marketing si no existe
     */
    public static function guardarCorreo($correo, $pagina_origen = null)
    {
        // Validar el formato del correo
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // Verificar si el correo ya existe
        $existente = self::where('correo', $correo)->first();
        if ($existente) {
            return false; // Ya existe, no hacemos nada
        }

        // Obtener la IP del usuario
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;

        // Obtener el User Agent
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;

        // Crear nuevo registro
        $nuevoCorreo = new self();
        $nuevoCorreo->correo = $correo;
        $nuevoCorreo->fecha_registro = date('Y-m-d H:i:s');
        $nuevoCorreo->pagina_origen = $pagina_origen;
        $nuevoCorreo->ip_usuario = $ip;
        $nuevoCorreo->user_agent = $userAgent;
        $nuevoCorreo->convertido = 0;

        return $nuevoCorreo->save();
    }

    /**
     * Marcar un correo como convertido (cuando completa una acción)
     */
    public static function marcarConvertido($correo)
    {
        $registro = self::where('correo', $correo)->first();
        if ($registro) {
            $registro->convertido = 1;
            $registro->fecha_conversion = Carbon::now();
            return $registro->save();
        }
        return false;
    }
}
