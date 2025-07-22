<?php

namespace App\Controllers;

use App\Models\Variable;
use App\Models\Viajero;
use App\Models\ViajeroVariable;
use App\Models\VisaInscripcion;
use App\Models\Visa;
use App\Models\VisaInscripcionVariable;
use Carbon\Carbon;
use Leaf\Http\Session;
use GuzzleHttp\Client;

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

        $visa = Visa::find($data['visas_id']);

        $visaInscripcion = new VisaInscripcion();
        $visaInscripcion->visas_id = $data['visas_id'];
        $visaInscripcion->numero_pedido = $data['numero_pedido'];
        $visaInscripcion->fecha_llegada = $data['fecha_llegada'];
        $visaInscripcion->fecha_salida = $data['fecha_salida'];
        $visaInscripcion->correo = $data['correo'];
        $visaInscripcion->pago_hoy = $visa['precio'] * $data['viajeros']->count();
        $visaInscripcion->pago_total = ($visa['precio'] + $visa['tasa_gobierno']) * $data['viajeros']->count();
        $visaInscripcion->tasa_gobierno_total = $visa['tasa_gobierno'] * $data['viajeros']->count();
        $visaInscripcion->status_pago = "pendiente";
        $visaInscripcion->save();

        foreach ($data["viajeros"] as $viajero) {
            Viajero::create([
                "visa_inscripcion_id" => $visaInscripcion->id,
                "nombres_pasaporte" => $viajero['nombres'],
                "apellidos_pasaporte" => $viajero['apellidos'],
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

    private function generatePurchaseNumber()
    {
        do {
            $purchaseNumber = substr(md5(time()), -6);
            $exists = VisaInscripcion::where('numero_pedido', $purchaseNumber)->exists();
        } while ($exists);

        return $purchaseNumber;
    }

    private function getSignature($params, $key)
    {
        $signature_content = "";

        ksort($params);
        foreach ($params as $name => $value) {
            //Recovery of vads_ fields
            if (substr($name, 0, 5) == 'vads_') {
                //Concatenation with "+"
                $signature_content .= $value . "+";
            }
        }

        $signature_content .= $key;

        //Encoding base64 encoded chain with SHA-256 algorithm
        $signature = base64_encode(hash_hmac('sha256', $signature_content, $key, true));

        return $signature;
    }

    public function checkout()
    {
        csrf()->validate();

        $data = request()->body();

        // Decodificar viajeros y variables_dinamicas si llegan como JSON string
        if (isset($data['viajeros']) && is_string($data['viajeros'])) {
            $data['viajeros'] = json_decode($data['viajeros'], true);
        }

        if (isset($data['variables_dinamicas']) && is_string($data['variables_dinamicas'])) {
            $data['variables_dinamicas'] = json_decode($data['variables_dinamicas'], true);
        }

        // Validar que llegaron los campos básicos
        if (
            empty($data['viajeros']) || !is_array($data['viajeros']) ||
            empty($data['variables_dinamicas']) || !is_array($data['variables_dinamicas']) ||
            empty($data['visas_id'])
        ) {
            return response()->json([
                'status' => 'error',
                'message' => 'Todos los campos son obligatorios'
            ], 400);
        }
        error_log("FormData: " . print_r($data, true));

        $purchaseNumber = $this->generatePurchaseNumber();
        $data['purchase_number'] = $purchaseNumber;

        // (Opcional) Guardar en sesión toda la data, incluyendo variables dinámicas
        Session::set('data', $data);

        // Buscar la visa
        $visa = Visa::find($data['visas_id']);
        if (!$visa) {
            return response()->json([
                "status" => "error",
                "message" => "Visa no encontrada"
            ], 404);
        }

        // Calcular total (por cantidad de viajeros)
        $pago_total = ($visa['precio'] + $visa['tasa_gobierno']) * count($data['viajeros']);
        $correo = $data['variables_dinamicas']['correo'] ?? null;

        // Preparar payload para Izipay
        $payload = [
            'vads_action_mode' => "INTERACTIVE",
            'vads_amount' => intval(number_format($pago_total, 2, '.', '') * 100),
            'vads_ctx_mode' => "TEST",
            'vads_currency' => '840',
            'vads_cust_email' => $correo,
            'vads_page_action' => "PAYMENT",
            'vads_payment_config' => "SINGLE",
            'vads_redirect_success_timeout' => 5,
            'vads_return_mode' => "GET",
            'vads_site_id' => 94909545,
            'vads_trans_date' => gmdate("YmdHis"),
            'vads_trans_id' => $purchaseNumber,
            'vads_url_return' => env('APP_URL') . 'api/izipay/response',
            'vads_version' => "V2",
        ];

        $clave_secreta = env('TOKEN_SECRET_TEST');

        // Generar firma
        $payload['signature'] = $this->getSignature($payload, $clave_secreta);

        return response()->json($payload);
    }

    public function processEmbeddedPayment()
    {
        csrf()->validate();

        $dataResult = request()->body();

        error_log("Datos recibidos del formulario incrustado: " . json_encode($dataResult));

        if (empty($dataResult)) {
            return redirect('/pago-fallido')->with('error', 'No se recibieron datos del pago.');
        }

        // Verificar campos requeridos según documentación paso 5 de Izipay
        if (!isset($dataResult['kr-hash']) || !isset($dataResult['kr-answer'])) {
            return redirect('/pago-fallido')->with('error', 'Respuesta de pago incompleta. Faltan campos obligatorios kr-hash o kr-answer.');
        }

        // Verificar campos adicionales si están presentes
        $krHashAlgorithm = $dataResult['kr-hash-algorithm'] ?? 'sha256_hmac';
        $krAnswerType = $dataResult['kr-answer-type'] ?? 'V4/Payment';

        error_log("Algoritmo de hash: {$krHashAlgorithm}, Tipo de respuesta: {$krAnswerType}");

        // Validar hash según el algoritmo especificado (por defecto sha256_hmac)
        $clave_secreta = env('IZIPAY_PASSWORD');
        $krAnswer = $dataResult['kr-answer'];

        // Validación del hash según documentación de Izipay
        if ($krHashAlgorithm === 'sha256_hmac') {
            $expectedHash = hash_hmac('sha256', $krAnswer, $clave_secreta);
        } else {
            // Fallback a sha256_hmac si el algoritmo no es reconocido
            $expectedHash = hash_hmac('sha256', $krAnswer, $clave_secreta);
            error_log("Algoritmo de hash no reconocido, usando sha256_hmac por defecto");
        }

        if (hash_equals($expectedHash, $dataResult['kr-hash']) === false) {
            error_log("Validación de hash fallida.");
            error_log("Hash esperado: {$expectedHash}");
            error_log("Hash recibido: {$dataResult['kr-hash']}");
            error_log("Algoritmo utilizado: {$krHashAlgorithm}");
            error_log("Clave secreta utilizada: " . substr($clave_secreta, 0, 8) . "...");

            return redirect('/pago-fallido')->with('error', 'La respuesta de pago no pudo ser verificada. Hash inválido.');
        }

        // Decodificar respuesta de pago
        $paymentData = json_decode($krAnswer, true);

        if (!$paymentData) {
            error_log("Error al decodificar kr-answer JSON: " . json_last_error_msg());
            return redirect('/pago-fallido')->with('error', 'Error al procesar la respuesta de pago. JSON inválido.');
        }

        error_log("Datos de pago decodificados correctamente: " . json_encode($paymentData));

        // Verificar estado del pago según estructura de Izipay
        $orderStatus = $paymentData['orderStatus'] ?? 'UNKNOWN';

        // Log detallado del estado
        error_log("Estado del pedido: {$orderStatus}");

        // Recuperar data de la sesión
        $data = Session::get('data');

        if (!$data) {
            error_log("No se encontraron datos de sesión");
            return redirect('/pago-fallido')->with('error', 'Datos de la sesión no encontrados.');
        }

        if ($orderStatus === 'PAID') {
            error_log("Procesando pago exitoso");

            $visa = Visa::find($data['visas_id']);

            // Extraer información del pago de la respuesta de Izipay
            $transactionId = $paymentData['orderDetails']['orderId'] ?? $data['purchase_number'];
            $paidAmount = ($paymentData['orderDetails']['orderTotalAmount'] ?? 0) / 100; // Convertir de centavos

            // Log información de transacción
            error_log("ID de transacción: {$transactionId}");
            error_log("Monto pagado: {$paidAmount}");

            // Crear la inscripción en la base de datos
            $visaInscripcion = new VisaInscripcion();
            $visaInscripcion->visas_id = $data['visas_id'];
            $visaInscripcion->numero_pedido = $transactionId;
            $visaInscripcion->pago_sintasa = $visa['precio'] * count($data['viajeros']);
            $visaInscripcion->pago_total = ($visa['precio'] + $visa['tasa_gobierno']) * count($data['viajeros']);
            $visaInscripcion->tasa_gobierno_total = $visa['tasa_gobierno'] * count($data['viajeros']);
            $visaInscripcion->status_pago = "pagado";
            $visaInscripcion->save();

            error_log("Inscripción de visa creada con ID: {$visaInscripcion->id}");

            // Guardar variables dinámicas
            foreach ($data["variables_dinamicas"] as $nombre => $valor) {
                $variabletemp = Variable::where('nombre', $nombre)->first();
                if ($variabletemp) { // Solo si existe la variable
                    VisaInscripcionVariable::create([
                        "visa_inscripcion_id" => $visaInscripcion->id,
                        "variable_id" => $variabletemp->id,
                        "valor" => $valor
                    ]);
                }
            }

            // Guardar los viajeros asociados
            foreach ($data["viajeros"] as $viajero) {
                $newViajero = Viajero::create([
                    "visa_inscripcion_id" => $visaInscripcion->id,
                ]);

                foreach ($viajero as $nombre => $valor) {
                    $variabletemp = Variable::where('nombre', $nombre)->first();
                    if ($variabletemp) { // Solo si existe la variable
                        ViajeroVariable::create([
                            "viajero_id" => $newViajero->id,
                            "variable_id" => $variabletemp->id,
                            "valor" => $valor
                        ]);
                    }
                }
            }

            // ENVIAR CORREOS //

            $usuarioEmail = $data['variables_dinamicas']['correo'] ?? null; // Correo del usuario
            $usuarioTelfono = $data['variables_dinamicas']['telefono'] ?? null; // Telefono del usuario
            $adminEmail = getenv('MAIL_SENDER_EMAIL'); // Tu correo

            $asunto = "Confirmacion de pago exitoso";
            $mensaje = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; width: 100%; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9; text-align: center; box-sizing: border-box;'>
                    <h2 style='color: rgb(76, 86, 175); font-size: 24px;'>¡Pago recibido con éxito! 🎉</h2>
                    <p style='font-size: 16px; color: #333;'>Hola,</p>
                    <p style='font-size: 16px; color: #333;'>Tu pago ha sido procesado correctamente. A continuación, los detalles de tu transacción:</p>

                    <div style='background-color: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin: 20px 0; text-align: left; word-wrap: break-word;'>
                        <p style='font-size: 16px; color: #555;'><strong>ID de Transacción:</strong>
                            <span style='font-size: 18px; color: rgb(62, 76, 156); font-weight: bold;'>{$visaInscripcion->numero_pedido}</span>
                        </p>
                        <p style='font-size: 16px; color: #555;'><strong>Correo del Cliente:</strong>
                            <span style='word-wrap: break-word; display: block;'>{$usuarioEmail}</span>
                        </p>
                        <p style='font-size: 16px; color: #555;'><strong>Número de Contacto:</strong> {$usuarioTelfono}</p>
                        <p style='font-size: 16px; color: #555;'><strong>Precio Total:</strong> $ {$visaInscripcion->pago_total}</p>
                        <p style='font-size: 16px; color: #555;'><strong>Estatus del Pago:</strong>
                            <span style='color: green; font-weight: bold;'>{$visaInscripcion->status_pago}</span>
                        </p>
                    </div>

                    <p style='font-size: 16px; color: #333;'>Si tienes alguna pregunta, no dudes en contactarnos.</p>
                    <p style='font-size: 16px; color: #333;'>Gracias por confiar en nosotros.</p>

                    <a href='https://evisa.dibujame.com' style='display: inline-block; padding: 14px 24px; margin-top: 15px; font-size: 16px; color: #fff; background-color: rgb(54, 55, 143); text-decoration: none; border-radius: 5px;'>Ir a la página</a>

                    <p style='margin-top: 20px; font-size: 14px; color: #888;'>© " . date('Y') . " AV Visa Asesores. Todos los derechos reservados.</p>
                </div>
            ";

            // Enviar correo al usuario
            MailController::sendEmail($usuarioEmail, $asunto, $mensaje);

            // Enviar correo a tu cuenta
            MailController::sendEmail($adminEmail, "Nuevo pago recibido", $mensaje);

            Session::delete('data');

            error_log("Pago procesado exitosamente, redirigiendo a página de éxito");
            return render('pagos.exito', compact('visaInscripcion'));
        } else {
            error_log("Pago no autorizado con estado: {$orderStatus}");
            Session::delete('data');
            return redirect('/pago-fallido')->with('error', 'Pago no autorizado. Estado: ' . $orderStatus);
        }
    }

    public function getVisaInscripcion($id)
    {
        $pedido_visa = VisaInscripcion::find($id);
        $visa = Visa::find($pedido_visa->visas_id);

        render('session.show-order', compact('pedido_visa', 'visa'));
    }

    public function handleIPN()
    {
        $dataResult = $_POST;

        error_log("Datos recibidos del IPN: " . print_r($dataResult, true));
        if (empty($dataResult['kr-hash']) || empty($dataResult['kr-answer'])) {
            return response()->status(400);
        }

        $krAnswerRaw = $dataResult['kr-answer'];
        $claveIPN = getenv('IZIPAY_PASSWORD'); // .env → contraseña para IPN

        $expectedHash = base64_encode(
            hash_hmac('sha256', $krAnswerRaw, $claveIPN, true)
        );

        if (!hash_equals($expectedHash, $dataResult['kr-hash'])) {
            return response()->status(400);
        }

        $paymentData = json_decode($krAnswerRaw, true);
        if (!$paymentData) {
            return response()->status(400);
        }

        // Aquí puedes actualizar el estado de tu pedido según orderId
        return response()->json(['message' => 'IPN recibida'], 200);
    }

    public function handleReturn()
    {
        $dataResult = $_POST;
        
        error_log("Datos recibidos del retorno: " . print_r($dataResult, true));
        
        if (empty($dataResult['kr-hash']) || empty($dataResult['kr-answer'])) {
            return redirect('/pago-fallido')->with('error', 'Respuesta incompleta');
        }
        
        $krAnswerRaw = $dataResult['kr-answer'];
        
        // ✅ Usar la clave HMAC correcta para retorno (NO la contraseña)
        $claveHMAC = getenv('IZIPAY_HMAC'); // Clave HMAC-SHA 256 del Back Office
        
        // ✅ Algoritmo correcto según documentación de Izipay
        $expectedHash = hash_hmac('sha256', $krAnswerRaw, $claveHMAC);
        
        error_log("Hash recibido: " . $dataResult['kr-hash']);
        error_log("Hash calculado: " . $expectedHash);
        error_log("Clave HMAC usada: " . substr($claveHMAC, 0, 8) . "...");
        
        if (!hash_equals($expectedHash, $dataResult['kr-hash'])) {
            error_log("❌ Hash inválido en retorno");
            return redirect('/pago-fallido')->with('error', 'Hash inválido');
        }
        
        error_log("✅ Hash válido - continuando...");
        
        $paymentData = json_decode($krAnswerRaw, true);
        if (!$paymentData) {
            return redirect('/pago-fallido')->with('error', 'JSON inválido');
        }
        
        $orderStatus = $paymentData['orderStatus'] ?? 'UNKNOWN';
        error_log("Estado del pago: " . $orderStatus);
        
        if ($orderStatus === 'PAID') {
            return $this->procesarPagoExitoso($paymentData);
        } else {
            Session::delete('data');
            return redirect('/pago-fallido')->with('error', 'Pago no autorizado. Estado: ' . $orderStatus);
        }
    }

    private function procesarPagoExitoso(array $paymentData)
    {
        $data = Session::get('data');
        if (!$data) {
            redirect('/pago-fallido')->with('error', 'Datos de sesión perdidos.');
            return;
        }

        $visa = Visa::find($data['visas_id']);
        $transactionId = $paymentData['orderDetails']['orderId'] ?? $data['purchase_number'];
        $paidAmount = ($paymentData['orderDetails']['orderTotalAmount'] ?? 0) / 100;

        $visaInscripcion = new VisaInscripcion();
        $visaInscripcion->visas_id = $data['visas_id'];
        $visaInscripcion->numero_pedido = $transactionId;
        $visaInscripcion->pago_sintasa = $visa['precio'] * count($data['viajeros']);
        $visaInscripcion->pago_total = ($visa['precio'] + $visa['tasa_gobierno']) * count($data['viajeros']);
        $visaInscripcion->tasa_gobierno_total = $visa['tasa_gobierno'] * count($data['viajeros']);
        $visaInscripcion->status_pago = "pagado";
        $visaInscripcion->save();

        foreach ($data["variables_dinamicas"] as $nombre => $valor) {
            $variabletemp = Variable::where('nombre', $nombre)->first();
            if ($variabletemp) {
                VisaInscripcionVariable::create([
                    "visa_inscripcion_id" => $visaInscripcion->id,
                    "variable_id" => $variabletemp->id,
                    "valor" => $valor
                ]);
            }
        }

        foreach ($data["viajeros"] as $viajero) {
            $newViajero = Viajero::create([
                "visa_inscripcion_id" => $visaInscripcion->id,
            ]);

            foreach ($viajero as $nombre => $valor) {
                $variabletemp = Variable::where('nombre', $nombre)->first();
                if ($variabletemp) {
                    ViajeroVariable::create([
                        "viajero_id" => $newViajero->id,
                        "variable_id" => $variabletemp->id,
                        "valor" => $valor
                    ]);
                }
            }
        }
        // ENVIAR CORREOS //

        $usuarioEmail = $data['variables_dinamicas']['correo'] ?? null; // Correo del usuario
        $usuarioTelfono = $data['variables_dinamicas']['telefono'] ?? null; // Telefono del usuario
        $adminEmail = getenv('MAIL_SENDER_EMAIL'); // Tu correo

        $asunto = "Confirmacion de pago exitoso";
        $mensaje = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; width: 100%; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9; text-align: center; box-sizing: border-box;'>
                    <h2 style='color: rgb(76, 86, 175); font-size: 24px;'>¡Pago recibido con éxito! 🎉</h2>
                    <p style='font-size: 16px; color: #333;'>Hola,</p>
                    <p style='font-size: 16px; color: #333;'>Tu pago ha sido procesado correctamente. A continuación, los detalles de tu transacción:</p>

                    <div style='background-color: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin: 20px 0; text-align: left; word-wrap: break-word;'>
                        <p style='font-size: 16px; color: #555;'><strong>ID de Transacción:</strong>
                            <span style='font-size: 18px; color: rgb(62, 76, 156); font-weight: bold;'>{$visaInscripcion->numero_pedido}</span>
                        </p>
                        <p style='font-size: 16px; color: #555;'><strong>Correo del Cliente:</strong>
                            <span style='word-wrap: break-word; display: block;'>{$usuarioEmail}</span>
                        </p>
                        <p style='font-size: 16px; color: #555;'><strong>Número de Contacto:</strong> {$usuarioTelfono}</p>
                        <p style='font-size: 16px; color: #555;'><strong>Precio Total:</strong> $ {$visaInscripcion->pago_total}</p>
                        <p style='font-size: 16px; color: #555;'><strong>Estatus del Pago:</strong>
                            <span style='color: green; font-weight: bold;'>{$visaInscripcion->status_pago}</span>
                        </p>
                    </div>

                    <p style='font-size: 16px; color: #333;'>Si tienes alguna pregunta, no dudes en contactarnos.</p>
                    <p style='font-size: 16px; color: #333;'>Gracias por confiar en nosotros.</p>

                    <a href='https://evisa.dibujame.com' style='display: inline-block; padding: 14px 24px; margin-top: 15px; font-size: 16px; color: #fff; background-color: rgb(54, 55, 143); text-decoration: none; border-radius: 5px;'>Ir a la página</a>

                    <p style='margin-top: 20px; font-size: 14px; color: #888;'>© " . date('Y') . " AV Visa Asesores. Todos los derechos reservados.</p>
                </div>
            ";

        // Enviar correo al usuario
        MailController::sendEmail($usuarioEmail, $asunto, $mensaje);
        // Enviar correo a tu cuenta
        MailController::sendEmail($adminEmail, "Nuevo pago recibido", $mensaje);

        Session::delete('data');

        error_log("Pago procesado exitosamente, redirigiendo a página de éxito");
        return render('pagos.exito', compact('visaInscripcion'));
    }

    public function getFormToken()
    {
        $data = request()->body();

        // Decodificar viajeros y variables_dinamicas si llegan como JSON string
        if (isset($data['viajeros']) && is_string($data['viajeros'])) {
            $data['viajeros'] = json_decode($data['viajeros'], true);
        }

        if (isset($data['variables_dinamicas']) && is_string($data['variables_dinamicas'])) {
            $data['variables_dinamicas'] = json_decode($data['variables_dinamicas'], true);
        }

        // Validar que llegaron los campos básicos
        if (
            empty($data['viajeros']) || !is_array($data['viajeros']) ||
            empty($data['variables_dinamicas']) || !is_array($data['variables_dinamicas']) ||
            empty($data['visas_id'])
        ) {
            return response()->json([
                'error' => 'No se pudo obtener los campos basicos',
                'detalle' => $data
            ], 500);
        }
        error_log("FormData: " . print_r($data, true));

        $purchaseNumber = $this->generatePurchaseNumber();
        $data['purchase_number'] = $purchaseNumber;

        // (Opcional) Guardar en sesión toda la data, incluyendo variables dinámicas
        Session::set('data', $data);

        // Buscar la visa
        $visa = Visa::find($data['visas_id']);
        if (!$visa) {
            return response()->json([
                'error' => 'No se pudo obtener el formToken',
                'detalle' => 'Visa no encontrada: ' . $data['visas_id']
            ], 500);
        }

        // Calcular total (por cantidad de viajeros)
        $pago_total = ($visa['precio'] + $visa['tasa_gobierno']) * count($data['viajeros']);
        $correo = $data['variables_dinamicas']['correo'] ?? null;

        // Ajusta estos valores según tu lógica y tus variables
        $amount = intval(number_format($pago_total, 2, '.', '') * 100); // en centavos, por ejemplo 1000 = S/ 10.00
        $currency = "USD"; // O "USD" si es en dólares
        $orderId = $purchaseNumber; // O usa tu propio identificador único
        $email = $correo;

        // Prepara el payload según la documentación de Izipay
        $payload = [
            "amount" => $amount,
            "currency" => $currency,
            "orderId" => $orderId,
            "customer" => [
                "email" => $email,
            ],
            // Puedes agregar más campos según lo que requiera tu negocio
        ];

        $client = new Client();
        $response = $client->post('https://api.micuentaweb.pe/api-payment/V4/Charge/CreatePayment', [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode(env('IZIPAY_USER') . ':' . env('IZIPAY_PASSWORD')),
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode($payload),
        ]);

        $result = json_decode($response->getBody(), true);

        if (isset($result['answer']['formToken'])) {
            return response()->json([
                'formToken' => $result['answer']['formToken']
            ]);
        } else {
            return response()->json([
                'error' => 'No se pudo obtener el formToken',
                'detalle' => $result
            ], 500);
        }
    }
}
