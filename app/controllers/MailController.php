<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailController
{
    public static function sendEmail($to, $subject, $body)
    {
        $mail = new PHPMailer(true);

        try {
            // Configurar UTF-8
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host       = getenv('MAIL_HOST');
            $mail->SMTPAuth   = true;
            $mail->Username   = getenv('MAIL_USERNAME');
            $mail->Password   = getenv('MAIL_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Usa TLS
            $mail->Port       = getenv('MAIL_PORT');
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ];
            $mail->setFrom(getenv('MAIL_SENDER_EMAIL'), getenv('MAIL_SENDER_NAME'));
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            
            $mail->send();
            error_log("✅ Correo enviado a: " . $to);
            return true;
        } catch (Exception $e) {
            error_log("❌ Error enviando correo: " . $mail->ErrorInfo);
            return false;
        }
    }

    public function contactEmail()
    {
        csrf()->validate();

        // Capturar datos JSON
        $data = request()->body();

        // Validaciones manuales
        $errores = [];

        if (empty($data['nombre']) || strlen($data['nombre']) > 100) {
            $errores[] = "El nombre es obligatorio y debe tener máximo 100 caracteres.";
        }

        if (!empty($data['apellidos']) && strlen($data['apellidos']) > 100) {
            $errores[] = "Los apellidos deben tener máximo 100 caracteres.";
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El correo electrónico no es válido.";
        }

        if (empty($data['telefono']) || strlen($data['telefono']) < 9 || strlen($data['telefono']) > 20) {
            $errores[] = "El teléfono debe tener entre 9 y 20 caracteres.";
        }

        if (empty($data['nacionalidad'])) {
            $errores[] = "La nacionalidad es obligatoria.";
        }

        if (empty($data['dobleNacionalidad'])) {
            $errores[] = "Debe indicar si tiene doble nacionalidad.";
        }

        if (empty($data['paisDestino'])) {
            $errores[] = "Debe seleccionar un país de destino.";
        }

        if (empty($data['motivoViaje'])) {
            $errores[] = "Debe seleccionar un motivo de viaje.";
        }

        if (empty($data['detalleConsulta']) || strlen($data['detalleConsulta']) < 10) {
            $errores[] = "El detalle de la consulta es obligatorio y debe tener al menos 10 caracteres.";
        }

        if (!isset($data['consentimiento'])) {
            $errores[] = "Debe aceptar la política de privacidad.";
        }

        // Si hay errores, devolverlos en JSON
        if (!empty($errores)) {
            echo json_encode([
                "success" => false,
                "errors" => $errores
            ]);
            return;
        }

        $adminEmail = getenv('MAIL_SENDER_EMAIL'); // Tu correo

        // Construcción del correo
        $body = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9; text-align: left;'>
                <h2 style='color: #4C56AF; text-align: center;'>📩 Nuevo Contacto</h2>
                
                <div style='background-color: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 15px;'>
                    <p style='font-size: 16px; color: #333;'><strong>👤 Nombre:</strong> {$data['nombre']} {$data['apellidos']}</p>
                    <p style='font-size: 16px; color: #333;'><strong>📧 Correo:</strong> <a href='mailto:{$data['email']}' style='color: #4C56AF; text-decoration: none;'>{$data['email']}</a></p>
                    <p style='font-size: 16px; color: #333;'><strong>📞 Teléfono:</strong> {$data['telefono']}</p>
                </div>

                <div style='background-color: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 15px;'>
                    <p style='font-size: 16px; color: #333;'><strong>🌍 Nacionalidad:</strong> {$data['nacionalidad']}</p>
                    <p style='font-size: 16px; color: #333;'><strong>🛂 Doble Nacionalidad:</strong> {$data['dobleNacionalidad']}</p>
                    <p style='font-size: 16px; color: #333;'><strong>✈️ País de Destino:</strong> {$data['paisDestino']}</p>
                    <p style='font-size: 16px; color: #333;'><strong>🎯 Motivo de Viaje:</strong> {$data['motivoViaje']}</p>
                </div>

                <div style='background-color: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 15px;'>
                    <p style='font-size: 16px; color: #333;'><strong>📝 Consulta:</strong></p>
                    <p style='font-size: 16px; color: #555; background-color: #f5f5f5; padding: 10px; border-radius: 5px;'>{$data['detalleConsulta']}</p>
                </div>

                <p style='font-size: 16px; color: #333; text-align: center;'>
                    <strong>✅ Consentimiento:</strong> " . ($data['consentimiento'] ? "<span style='color: green;'>Aceptado</span>" : "<span style='color: red;'>No aceptado</span>") . "
                </p>

                <p style='margin-top: 20px; font-size: 14px; color: #888; text-align: center;'>© " . date('Y') . " AV Visa Asesores. Todos los derechos reservados.</p>
            </div>
        ";

        // Enviar correo
        $enviado = $this->sendEmail($adminEmail, "Nuevo Formulario de Contacto", $body);

        if ($enviado) {
            echo json_encode(["success" => true, "message" => "Formulario enviado con éxito."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al enviar el correo."]);
        }
    }
}