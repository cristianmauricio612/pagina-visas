<?php

namespace App\Controllers;

use App\Models\LibroReclamacion;
use Carbon\Carbon;
use Exception;

class LibroReclamacionController extends Controller
{
    /**
     * Mostrar el formulario del libro de reclamaciones
     */
    public function index()
    {
        render('reclamaciones.index');
    }

    /**
     * Registrar una nueva reclamación
     */
    public function registrarReclamacion()
    {
        csrf()->validate();

        $data = request()->body();

        // Validaciones básicas
        $errores = $this->validarDatosReclamacion($data);

        if (!empty($errores)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Errores de validación',
                'errors' => $errores
            ], 400);
        }

        try {
            // Convertir fecha de DD/MM/YYYY a YYYY-MM-DD
            if (isset($data['fecha_incidente'])) {
                $fecha = Carbon::createFromFormat('d/m/Y', $data['fecha_incidente']);
                $data['fecha_incidente'] = $fecha->format('Y-m-d');
            }

            // Crear la reclamación
            $reclamacion = LibroReclamacion::crearReclamacion($data);

            // Enviar correos
            $this->enviarCorreosNuevaReclamacion($reclamacion, $data);

            return response()->json([
                'status' => 'success',
                'message' => 'Reclamación registrada exitosamente',
                'id' => $reclamacion->id
            ], 201);

        } catch (Exception $e) {
            error_log("Error al crear reclamación: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error interno del servidor. Por favor, inténtelo más tarde.'
            ], 500);
        }
    }

    /**
     * Validar los datos de la reclamación
     */
    private function validarDatosReclamacion($data)
    {
        $errores = [];

        // Campos requeridos
        $camposRequeridos = [
            'tipo_documento' => 'El tipo de documento es obligatorio',
            'numero_documento' => 'El número de documento es obligatorio',
            'nombres_apellidos' => 'Los nombres y apellidos son obligatorios',
            'direccion' => 'La dirección es obligatoria',
            'correo' => 'El correo electrónico es obligatorio',
            'fecha_incidente' => 'La fecha del incidente es obligatoria',
            'bien_contratado' => 'Debe especificar si fue producto o servicio',
            'descripcion_bien' => 'La descripción del bien es obligatoria',
            'tipo_incidente' => 'Debe especificar si es reclamo o queja',
            'detalle' => 'El detalle del incidente es obligatorio',
            'pedido_consumidor' => 'El pedido del consumidor es obligatorio'
        ];

        foreach ($camposRequeridos as $campo => $mensaje) {
            if (empty($data[$campo])) {
                $errores[] = $mensaje;
            }
        }

        // Validar email
        if (!empty($data['correo']) && !filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'El formato del correo electrónico no es válido';
        }

        // Validar fecha
        if (!empty($data['fecha_incidente'])) {
            try {
                $fecha = Carbon::createFromFormat('d/m/Y', $data['fecha_incidente']);
                if ($fecha->isFuture()) {
                    $errores[] = 'La fecha del incidente no puede ser futura';
                }
            } catch (Exception $e) {
                $errores[] = 'El formato de fecha debe ser DD/MM/AAAA';
            }
        }

        // Validar apoderado si es menor de edad
        if (isset($data['menor_edad']) && $data['menor_edad'] && empty($data['apoderado'])) {
            $errores[] = 'Si es menor de edad, debe proporcionar el nombre del apoderado';
        }

        // Validar monto si se proporciona
        if (!empty($data['monto']) && (!is_numeric($data['monto']) || $data['monto'] < 0)) {
            $errores[] = 'El monto debe ser un número válido mayor o igual a cero';
        }

        return $errores;
    }

    /**
     * Enviar correos para nueva reclamación
     */
    private function enviarCorreosNuevaReclamacion($reclamacion, $data)
    {
        $usuarioEmail = $data['correo'];
        $adminEmail = getenv('MAIL_SENDER_EMAIL');

        // Generar número de reclamación
        $numeroReclamacion = str_pad($reclamacion->id, 6, '0', STR_PAD_LEFT);

        // Correo para el usuario
        $asuntoUsuario = "Confirmación de Reclamación #{$numeroReclamacion} - Visas Travel";
        $mensajeUsuario = $this->generarCorreoUsuarioNuevaReclamacion($reclamacion, $numeroReclamacion);

        // Correo para el administrador
        $asuntoAdmin = "Nueva Reclamación Recibida #{$numeroReclamacion}";
        $mensajeAdmin = $this->generarCorreoAdminNuevaReclamacion($reclamacion, $numeroReclamacion);

        // Enviar correos
        MailController::sendEmail($usuarioEmail, $asuntoUsuario, $mensajeUsuario);
        MailController::sendEmail($adminEmail, $asuntoAdmin, $mensajeAdmin);
    }

    /**
     * Generar correo para el usuario - nueva reclamación
     */
    private function generarCorreoUsuarioNuevaReclamacion($reclamacion, $numeroReclamacion)
    {
        $fechaIncidente = Carbon::parse($reclamacion->fecha_incidente)->format('d/m/Y');

        return "
            <div style='font-family: Arial, sans-serif; max-width: 600px; width: 100%; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9; text-align: center; box-sizing: border-box;'>
                <h2 style='color: #0066b2; font-size: 24px;'>📋 Reclamación Recibida</h2>
                <p style='font-size: 16px; color: #333;'>Estimado(a) <strong>{$reclamacion->nombres_apellidos}</strong>,</p>
                <p style='font-size: 16px; color: #333;'>Hemos recibido su " . strtolower($reclamacion->tipo_incidente) . " y será atendida en breve.</p>

                <div style='background-color: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin: 20px 0; text-align: left;'>
                    <p style='font-size: 16px; color: #555;'><strong>Número de Reclamación:</strong>
                        <span style='font-size: 18px; color: #0066b2; font-weight: bold;'>#{$numeroReclamacion}</span>
                    </p>
                    <p style='font-size: 16px; color: #555;'><strong>Tipo:</strong> {$reclamacion->tipo_incidente}</p>
                    <p style='font-size: 16px; color: #555;'><strong>Fecha del Incidente:</strong> {$fechaIncidente}</p>
                    <p style='font-size: 16px; color: #555;'><strong>Estado:</strong>
                        <span style='color: #ffa500; font-weight: bold;'>{$reclamacion->estado}</span>
                    </p>
                    <p style='font-size: 16px; color: #555;'><strong>Detalle:</strong> {$reclamacion->detalle}</p>
                </div>

                <p style='font-size: 16px; color: #333;'>Le responderemos en un plazo máximo de <strong>30 días calendario</strong>.</p>
                <p style='font-size: 16px; color: #333;'>Si tiene alguna consulta adicional, no dude en contactarnos.</p>

                <a href='https://visastraveltours.com' style='display: inline-block; padding: 14px 24px; margin-top: 15px; font-size: 16px; color: #fff; background-color: #0066b2; text-decoration: none; border-radius: 5px;'>Ir a la página</a>

                <p style='margin-top: 20px; font-size: 14px; color: #888;'>© " . date('Y') . " Visas Travel. Todos los derechos reservados.</p>
            </div>
        ";
    }

    /**
     * Generar correo para el administrador - nueva reclamación
     */
    private function generarCorreoAdminNuevaReclamacion($reclamacion, $numeroReclamacion)
    {
        $fechaIncidente = Carbon::parse($reclamacion->fecha_incidente)->format('d/m/Y');
        $fechaRegistro = Carbon::parse($reclamacion->created_at)->format('d/m/Y H:i');

        return "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9; text-align: left;'>
                <h2 style='color: #dc3545; text-align: center;'>🚨 Nueva Reclamación Recibida</h2>

                <div style='background-color: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 15px;'>
                    <p style='font-size: 16px; color: #333;'><strong>🔢 Número:</strong> #{$numeroReclamacion}</p>
                    <p style='font-size: 16px; color: #333;'><strong>📅 Fecha de Registro:</strong> {$fechaRegistro}</p>
                    <p style='font-size: 16px; color: #333;'><strong>🆔 Tipo de Incidente:</strong> {$reclamacion->tipo_incidente}</p>
                    <p style='font-size: 16px; color: #333;'><strong>📦 Bien Contratado:</strong> {$reclamacion->bien_contratado}</p>
                </div>

                <div style='background-color: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 15px;'>
                    <p style='font-size: 16px; color: #333;'><strong>👤 Cliente:</strong> {$reclamacion->nombres_apellidos}</p>
                    <p style='font-size: 16px; color: #333;'><strong>📧 Correo:</strong> <a href='mailto:{$reclamacion->correo}' style='color: #0066b2;'>{$reclamacion->correo}</a></p>
                    <p style='font-size: 16px; color: #333;'><strong>📞 Teléfono:</strong> " . ($reclamacion->telefono ?: 'No proporcionado') . "</p>
                    <p style='font-size: 16px; color: #333;'><strong>🏠 Dirección:</strong> {$reclamacion->direccion}</p>
                </div>

                <div style='background-color: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 15px;'>
                    <p style='font-size: 16px; color: #333;'><strong>📅 Fecha del Incidente:</strong> {$fechaIncidente}</p>
                    <p style='font-size: 16px; color: #333;'><strong>📝 Descripción del Bien:</strong> {$reclamacion->descripcion_bien}</p>
                    " . ($reclamacion->monto ? "<p style='font-size: 16px; color: #333;'><strong>💰 Monto:</strong> $" . number_format($reclamacion->monto, 2) . "</p>" : "") . "
                </div>

                <div style='background-color: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 15px;'>
                    <p style='font-size: 16px; color: #333;'><strong>📋 Detalle del Incidente:</strong></p>
                    <p style='font-size: 16px; color: #555; background-color: #f5f5f5; padding: 10px; border-radius: 5px;'>{$reclamacion->detalle}</p>

                    <p style='font-size: 16px; color: #333;'><strong>🎯 Pedido del Consumidor:</strong></p>
                    <p style='font-size: 16px; color: #555; background-color: #f5f5f5; padding: 10px; border-radius: 5px;'>{$reclamacion->pedido_consumidor}</p>
                </div>

                <p style='font-size: 16px; color: #333; text-align: center; background-color: #fff3cd; padding: 10px; border-radius: 5px; border-left: 4px solid #ffc107;'>
                    ⏰ <strong>Recordatorio:</strong> Debe responder en un plazo máximo de 30 días calendario.
                </p>

                <p style='margin-top: 20px; font-size: 14px; color: #888; text-align: center;'>© " . date('Y') . " Visas Travel. Sistema de Libro de Reclamaciones.</p>
            </div>
        ";
    }

    /**
     * Obtener todas las reclamaciones (para el admin)
     */
    public function listarReclamaciones()
    {
        try {
            $reclamaciones = LibroReclamacion::obtenerTodas();

            return response()->json([
                'status' => 'success',
                'reclamaciones' => $reclamaciones
            ]);
        } catch (Exception $e) {
            error_log("Error al listar reclamaciones: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener las reclamaciones'
            ], 500);
        }
    }

    /**
     * Obtener una reclamación específica
     */
    public function getReclamacion($id)
    {
        try {
            $reclamacion = LibroReclamacion::find($id);

            if (!$reclamacion) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Reclamación no encontrada'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'reclamacion' => $reclamacion
            ]);
        } catch (Exception $e) {
            error_log("Error al obtener reclamación: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    /**
     * Responder a una reclamación
     */
    public function responderReclamacion($id)
    {
        csrf()->validate();

        $data = request()->body();

        // Validaciones
        if (empty($data['respuesta'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'La respuesta es obligatoria'
            ], 400);
        }

        if (empty($data['estado'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'El estado es obligatorio'
            ], 400);
        }

        $estadosValidos = ['Pendiente', 'En proceso', 'Resuelto', 'Rechazado'];
        if (!in_array($data['estado'], $estadosValidos)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Estado no válido'
            ], 400);
        }

        try {
            $reclamacion = LibroReclamacion::find($id);

            if (!$reclamacion) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Reclamación no encontrada'
                ], 404);
            }

            // Actualizar la reclamación
            $reclamacion->responder($data['respuesta'], $data['estado']);

            // Enviar correos de respuesta
            $this->enviarCorreosRespuestaReclamacion($reclamacion);

            return response()->json([
                'status' => 'success',
                'message' => 'Reclamación actualizada exitosamente'
            ]);

        } catch (Exception $e) {
            error_log("Error al responder reclamación: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    /**
     * Enviar correos cuando se responde a una reclamación
     */
    private function enviarCorreosRespuestaReclamacion($reclamacion)
    {
        $usuarioEmail = $reclamacion->correo;
        $adminEmail = getenv('MAIL_SENDER_EMAIL');
        $numeroReclamacion = str_pad($reclamacion->id, 6, '0', STR_PAD_LEFT);

        // Correo para el usuario
        $asuntoUsuario = "Respuesta a su Reclamación #{$numeroReclamacion} - Visas Travel";
        $mensajeUsuario = $this->generarCorreoUsuarioRespuesta($reclamacion, $numeroReclamacion);

        // Correo para el administrador (notificación)
        $asuntoAdmin = "Reclamación #{$numeroReclamacion} Actualizada";
        $mensajeAdmin = $this->generarCorreoAdminRespuesta($reclamacion, $numeroReclamacion);

        // Enviar correos
        MailController::sendEmail($usuarioEmail, $asuntoUsuario, $mensajeUsuario);
        MailController::sendEmail($adminEmail, $asuntoAdmin, $mensajeAdmin);
    }

    /**
     * Generar correo para el usuario - respuesta
     */
    private function generarCorreoUsuarioRespuesta($reclamacion, $numeroReclamacion)
    {
        $fechaRespuesta = Carbon::parse($reclamacion->fecha_respuesta)->format('d/m/Y H:i');
        $colorEstado = $this->getColorEstado($reclamacion->estado);

        return "
            <div style='font-family: Arial, sans-serif; max-width: 600px; width: 100%; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9; text-align: center; box-sizing: border-box;'>
                <h2 style='color: #0066b2; font-size: 24px;'>📨 Respuesta a su Reclamación</h2>
                <p style='font-size: 16px; color: #333;'>Estimado(a) <strong>{$reclamacion->nombres_apellidos}</strong>,</p>
                <p style='font-size: 16px; color: #333;'>Hemos evaluado su reclamación y a continuación le presentamos nuestra respuesta:</p>

                <div style='background-color: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin: 20px 0; text-align: left;'>
                    <p style='font-size: 16px; color: #555;'><strong>Número de Reclamación:</strong>
                        <span style='font-size: 18px; color: #0066b2; font-weight: bold;'>#{$numeroReclamacion}</span>
                    </p>
                    <p style='font-size: 16px; color: #555;'><strong>Estado Actual:</strong>
                        <span style='color: {$colorEstado}; font-weight: bold;'>{$reclamacion->estado}</span>
                    </p>
                    <p style='font-size: 16px; color: #555;'><strong>Fecha de Respuesta:</strong> {$fechaRespuesta}</p>
                </div>

                <div style='background-color: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin: 20px 0; text-align: left;'>
                    <p style='font-size: 16px; color: #333;'><strong>📝 Nuestra Respuesta:</strong></p>
                    <p style='font-size: 16px; color: #555; background-color: #f5f5f5; padding: 15px; border-radius: 5px; line-height: 1.5;'>{$reclamacion->respuesta}</p>
                </div>

                <p style='font-size: 16px; color: #333;'>Si tiene alguna consulta adicional sobre esta respuesta, no dude en contactarnos.</p>
                <p style='font-size: 16px; color: #333;'>Gracias por su confianza en nuestros servicios.</p>

                <a href='https://visastraveltours.com/contact' style='display: inline-block; padding: 14px 24px; margin-top: 15px; font-size: 16px; color: #fff; background-color: #0066b2; text-decoration: none; border-radius: 5px;'>Contactarnos</a>

                <p style='margin-top: 20px; font-size: 14px; color: #888;'>© " . date('Y') . " Visas Travel. Todos los derechos reservados.</p>
            </div>
        ";
    }

    /**
     * Generar correo para el administrador - respuesta
     */
    private function generarCorreoAdminRespuesta($reclamacion, $numeroReclamacion)
    {
        $fechaRespuesta = Carbon::parse($reclamacion->fecha_respuesta)->format('d/m/Y H:i');

        return "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9; text-align: left;'>
                <h2 style='color: #28a745; text-align: center;'>✅ Reclamación Respondida</h2>

                <div style='background-color: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 15px;'>
                    <p style='font-size: 16px; color: #333;'><strong>🔢 Número:</strong> #{$numeroReclamacion}</p>
                    <p style='font-size: 16px; color: #333;'><strong>👤 Cliente:</strong> {$reclamacion->nombres_apellidos}</p>
                    <p style='font-size: 16px; color: #333;'><strong>📧 Correo:</strong> {$reclamacion->correo}</p>
                    <p style='font-size: 16px; color: #333;'><strong>📅 Fecha de Respuesta:</strong> {$fechaRespuesta}</p>
                    <p style='font-size: 16px; color: #333;'><strong>🔄 Nuevo Estado:</strong> {$reclamacion->estado}</p>
                </div>

                <div style='background-color: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 15px;'>
                    <p style='font-size: 16px; color: #333;'><strong>📝 Respuesta Enviada:</strong></p>
                    <p style='font-size: 16px; color: #555; background-color: #f5f5f5; padding: 10px; border-radius: 5px;'>{$reclamacion->respuesta}</p>
                </div>

                <p style='font-size: 16px; color: #333; text-align: center; background-color: #d4edda; padding: 10px; border-radius: 5px; border-left: 4px solid #28a745;'>
                    ✅ <strong>El cliente ha sido notificado por correo electrónico.</strong>
                </p>

                <p style='margin-top: 20px; font-size: 14px; color: #888; text-align: center;'>© " . date('Y') . " Visas Travel. Sistema de Libro de Reclamaciones.</p>
            </div>
        ";
    }

    /**
     * Obtener color para el estado
     */
    private function getColorEstado($estado)
    {
        switch ($estado) {
            case 'Pendiente':
                return '#ffa500';
            case 'En proceso':
                return '#17a2b8';
            case 'Resuelto':
                return '#28a745';
            case 'Rechazado':
                return '#dc3545';
            default:
                return '#6c757d';
        }
    }

    /**
     * Página de éxito tras registrar reclamación
     */
    public function reclamacionExitosa()
    {
        render('reclamaciones.exitoso');
    }

    /**
     * Eliminar una reclamación (solo admin)
     */
    public function eliminarReclamacion($id)
    {
        csrf()->validate();

        try {
            $reclamacion = LibroReclamacion::find($id);
            
            if (!$reclamacion) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Reclamación no encontrada'
                ], 404);
            }

            $reclamacion->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Reclamación eliminada exitosamente'
            ]);

        } catch (Exception $e) {
            error_log("Error al eliminar reclamación: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }
}
