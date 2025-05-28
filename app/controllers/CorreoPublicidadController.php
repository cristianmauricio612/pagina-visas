<?php

namespace App\Controllers;

use App\Models\CorreoPublicidad;
use Leaf\Controller;

class CorreoPublicidadController extends Controller
{
    public function guardarCorreo()
    {
        // Siempre validar CSRF, pero manejar errores adecuadamente
        try {
            csrf()->validate();
        } catch (\Exception $e) {
            // Si falla la validación CSRF, enviar respuesta de error
            return response()->json([
                'status' => 'error',
                'message' => 'Token de seguridad inválido o no encontrado'
            ], 403);
        }

        $data = request()->body();

        // Validar datos
        if (empty($data['correo'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'El correo es obligatorio'
            ], 400);
        }

        // Guardar correo
        $resultado = CorreoPublicidad::guardarCorreo(
            $data['correo'],
            $data['pagina_origen'] ?? request()->referer()
        );

        if ($resultado) {
            return response()->json([
                'status' => 'success',
                'message' => 'Correo guardado correctamente'
            ]);
        } else {
            return response()->json([
                'status' => 'info',
                'message' => 'No se pudo guardar el correo o ya existe'
            ]);
        }
    }
}
