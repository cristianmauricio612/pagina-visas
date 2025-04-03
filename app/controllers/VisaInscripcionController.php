<?php

namespace App\Controllers;

use App\Models\Viajero;
use App\Models\VisaInscripcion;
use App\Models\Visa;
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

    private  function generatePurchaseNumber()
    {
        do {
            $purchaseNumber = substr(md5(time()), -6);
            $exists = VisaInscripcion::where('numero_pedido', $purchaseNumber)->exists();
        } while ($exists);

        return $purchaseNumber;
    }

    private function getSignature($params,$key)
    {
        $signature_content = "";

        ksort($params);
        foreach($params as $name=>$value){
            //Recovery of vads_ fields
            if(substr($name,0,5)=='vads_'){
                //Concatenation with "+"
                $signature_content .= $value."+";
             }
        }

        $signature_content .= $key;

        //Encoding base64 encoded chain with SHA-256 algorithm
        $signature = base64_encode(hash_hmac('sha256',$signature_content, $key, true));

        return $signature;
    }

    public function checkout(){
        csrf()->validate();

        $data = request()->body();

        // Validar que se recibieron los datos necesarios
        if (empty($data['viajeros']) || !is_array($data['viajeros']) || empty($data['visas_id']) || empty($data['fecha_llegada']) || empty($data['correo']) || empty($data['telefono'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Los campos fecha de llegada, correo y telefono son obligatorios'
            ], 400);
        }

        $purchaseNumber = $this->generatePurchaseNumber();
        $data['purchase_number'] = $purchaseNumber;

        // (Opcional) Guardar en sesión si es necesario
        Session::set('data', $data);

        $visa = Visa::find($data['visas_id']);
        if (!$visa) {
            return response()->json(["status" => "error", "message" => "Visa no encontrada"], 404);
        }

        $pago_total = ($visa['precio'] + $visa['tasa_gobierno']) * count($data['viajeros']);
        $correo = $data['correo'];

        // Datos para Izipay
        $payload = [
            'vads_action_mode' => "INTERACTIVE",
            'vads_amount'        => intval(number_format($pago_total, 2, '.', '') * 100),
            'vads_ctx_mode' => "TEST",
            'vads_currency'      => '840',
            'vads_cust_email' => $correo,
            'vads_page_action' => "PAYMENT",
            'vads_payment_config' => "SINGLE",
            "vads_redirect_success_timeout" => 5,
            'vads_return_mode' => "GET",
            'vads_site_id' => 94909545,
            'vads_trans_date' => gmdate("YmdHis"),
            'vads_trans_id' => $purchaseNumber,
            'vads_url_return' => 'http://localhost:5500/api/izipay/response',
            'vads_version' => "V2",
        ];

        $clave_secreta = env('TOKEN_SECRET');

        // Generar firma
        $payload['signature'] = $this->getSignature($payload, $clave_secreta);

        return response()->json($payload);
    }

    public function processPayment()
    {
        $dataResult = $_GET;

        error_log("Datos recibidos: " . json_encode($dataResult));

        if (empty($dataResult)) {
            return redirect('/pago-fallido')->with('error', 'El Post estaba vacío.');
        }

        if (!isset($dataResult['signature'])) {
            return redirect('/pago-fallido')->with('error', 'Faltó el signatue.');
        }

        $clave_secreta = _env('TOKEN_SECRET');
        $firma_calculada = $this->getSignature($dataResult, $clave_secreta);

        if ($firma_calculada !== $dataResult['signature']) {
            return redirect('/pago-fallido')->with('error', 'Signature inválido.');
        }

        $estado_pago = $dataResult['vads_trans_status'] ?? 'UNKNOWN';

        // Recuperar toda la data guardada en la sesión
        $data = Session::get('data');

        if ($estado_pago === 'AUTHORISED') {
            $visa = Visa::find($data['visas_id']);

            // Crear la inscripción en la base de datos
            $visaInscripcion = new VisaInscripcion();
            $visaInscripcion->visas_id = $data['visas_id'];
            $visaInscripcion->numero_pedido = $data['purchase_number'];
            $visaInscripcion->fecha_llegada = Carbon::createFromFormat('d/m/Y', $data['fecha_llegada']);
            $visaInscripcion->fecha_salida = isset($data['fecha_salida']) ? Carbon::parse($data['fecha_salida']) : null;
            $visaInscripcion->correo = $data['correo'];
            $visaInscripcion->pago_hoy = $visa['precio'] * count($data['viajeros']);
            $visaInscripcion->pago_total = ($visa['precio'] + $visa['tasa_gobierno']) * count($data['viajeros']);
            $visaInscripcion->tasa_gobierno_total = $visa['tasa_gobierno'] * count($data['viajeros']);
            $visaInscripcion->status_pago = "pagado";
            $visaInscripcion->save();

            // Guardar los viajeros asociados
            foreach ($data["viajeros"] as $viajero) {
                Viajero::create([
                    "visa_inscripcion_id" => $visaInscripcion->id,
                    "nombres_pasaporte" => $viajero['nombres'],
                    "apellidos_pasaporte" => $viajero['apellidos'],
                    "fecha_nacimiento" => Carbon::parse($viajero['fecha_nacimiento']),
                    "nacionalidad_pasaporte_id" => $viajero['nacionalidad_pasaporte'],
                    "numero_pasaporte" => $viajero['numero_pasaporte'],
                    "fecha_caducidad_pasaporte" => isset($viajero['fecha_caducidad_pasaporte']) ? Carbon::parse($viajero['fecha_caducidad_pasaporte']) : null,
                    "pais_nacimiento_id" => $viajero['pais_nacimiento'],
                    "nivel_estudios" => $viajero['nivel_estudios'],
                ]);
            }

            // ENVIAR CORREOS //

            $usuarioEmail = $data['correo']; // Correo del usuario
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
                            <span style='word-wrap: break-word; display: block;'>{$visaInscripcion->correo}</span>
                        </p>
                        <p style='font-size: 16px; color: #555;'><strong>Número de Contacto:</strong> {$data['telefono']}</p>
                        <p style='font-size: 16px; color: #555;'><strong>Precio Total:</strong> $ {$visaInscripcion->pago_total}</p>
                        <p style='font-size: 16px; color: #555;'><strong>Estatus del Pago:</strong> 
                            <span style='color: green; font-weight: bold;'>{$visaInscripcion->status_pago}</span>
                        </p>
                    </div>

                    <p style='font-size: 16px; color: #333;'>Si tienes alguna pregunta, no dudes en contactarnos.</p>
                    <p style='font-size: 16px; color: #333;'>Gracias por confiar en nosotros.</p>

                    <a href='https://tu-sitio.com' style='display: inline-block; padding: 14px 24px; margin-top: 15px; font-size: 16px; color: #fff; background-color: rgb(54, 55, 143); text-decoration: none; border-radius: 5px;'>Ir a la página</a>

                    <p style='margin-top: 20px; font-size: 14px; color: #888;'>© " . date('Y') . " AV Visa Asesores. Todos los derechos reservados.</p>
                </div>
            ";

            // Enviar correo al usuario
            MailController::sendEmail($usuarioEmail, $asunto, $mensaje);

            // Enviar correo a tu cuenta
            MailController::sendEmail($adminEmail, "Nuevo pago recibido", $mensaje);

            Session::delete('data');

            return render('pagos.exito', compact('visaInscripcion'));
        } else {
            Session::delete('data');
            return redirect('/pago-fallido')->with('error', 'Pago no autorizado.');
        }
    }

    public function getVisaInscripcion($id){
        $pedido_visa = VisaInscripcion::find($id);
        $visa = Visa::find($pedido_visa->visas_id);

        render('session.show-order', compact('pedido_visa','visa'));
    }
}