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
}