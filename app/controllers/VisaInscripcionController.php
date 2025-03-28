<?php

namespace App\Controllers;

use App\Models\Viajero;
use App\Models\VisaInscripcion;
use App\Models\Visa;
use Carbon\Carbon;
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
        if (empty($data['viajeros']) || !is_array($data['viajeros']) || empty($data['visas_id']) || empty($data['fecha_llegada']) || empty($data['correo'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Los campos fecha de llegada y correo son obligatorios'
            ], 400);
        }

        $purchaseNumber = $this->generatePurchaseNumber();

        $visa = Visa::find($data['visas_id']);
        if (!$visa) {
            return response()->json(["status" => "error", "message" => "Visa no encontrada"], 404);
        }

         // Crear la inscripción en la base de datos
        $visaInscripcion = new VisaInscripcion();
        $visaInscripcion->visas_id = $data['visas_id'];
        $visaInscripcion->numero_pedido = $purchaseNumber;
        $visaInscripcion->fecha_llegada = Carbon::createFromFormat('d/m/Y', $data['fecha_llegada']);
        $visaInscripcion->fecha_salida = isset($data['fecha_salida']) ? Carbon::parse($data['fecha_salida']) : null;
        $visaInscripcion->correo = $data['correo'];
        $visaInscripcion->pago_hoy = $visa['precio'] * count($data['viajeros']);
        $visaInscripcion->pago_total = ($visa['precio'] + $visa['tasa_gobierno']) * count($data['viajeros']);
        $visaInscripcion->tasa_gobierno_total = $visa['tasa_gobierno'] * count($data['viajeros']);
        $visaInscripcion->status_pago = "pendiente"; // Aún no confirmado
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

        // Datos para Izipay
        $payload = [
            'vads_action_mode' => "INTERACTIVE",
            'vads_amount'        => intval(number_format($visaInscripcion->pago_total, 2, '.', '') * 100),
            'vads_ctx_mode' => "TEST",
            'vads_currency'      => '840',
            'vads_cust_email' => $visaInscripcion->correo,
            'vads_page_action' => "PAYMENT",
            'vads_payment_config' => "SINGLE",
            'vads_site_id' => 94909545,
            'vads_trans_date' => gmdate("YmdHis"),
            'vads_trans_id' => $purchaseNumber,
            'vads_version' => "V2",
            'vads_url_return' => 'http://localhost:5500/api/izipay/response'
        ];

        $clave_secreta = env('TOKEN_SECRET');

        // Generar firma
        $payload['signature'] = $this->getSignature($payload, $clave_secreta);

        return response()->json($payload);
    }

    public function processPayment()
    {
        $data = $_POST;

        if (empty($data)) {
            return redirect('/pago-fallido')->with('error', 'El Post estaba vacío.');
        }

        if (!isset($data['vads_hash'])) {
            return redirect('/pago-fallido')->with('error', 'Faltó el vads_hash.');
        }

        $clave_secreta = _env('TOKEN_SECRET');

        $firma_calculada = $this->getSignature($data, $clave_secreta);

        if ($firma_calculada !== $data['vads_hash']) {
            return redirect('/pago-fallido')->with('error', 'Signature inválido.');
        }

        $estado_pago = $data['vads_trans_status'] ?? 'UNKNOWN';

        if ($estado_pago === 'AUTHORISED') {
            return redirect('/pago-exitoso')->with('success', 'El pago fue exitoso.');
        } else {
            return redirect('/pago-fallido')->with('error', 'Pago no autorizado.');
        }
    }

    public function getVisaInscripcion($id){
        $pedido_visa = VisaInscripcion::find($id);
        $visa = Visa::find($pedido_visa->visas_id);

        render('session.show-order', compact('pedido_visa','visa'));
    }
}