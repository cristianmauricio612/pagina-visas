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
            $purchaseNumber = time() . rand(1000, 9999);
            $exists = VisaInscripcion::where('numero_pedido', $purchaseNumber)->exists();
        } while ($exists);

        return $purchaseNumber;
    }

    private function getSessionToken()
    {
        $apiKey = "TU_API_KEY";
        $url = "https://apitestenv.vnforappstest.com/api.security/v1/security";
        $client = new Client();

        try {
            $response = $client->request('POST', $url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => $apiKey
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            return $data['sessionKey'] ?? null;
        } catch (\Exception $e) {
            return null;
        }
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

        // Datos para Niubiz
        $payload = [
            'merchantId'    => '123456789',
            'sessionToken'  => $this->getSessionToken(), // Obtener token desde función
            'amount'        => number_format($visaInscripcion->pago_total, 2, '.', ''), // Aquí puedes calcular el total de la compra
            'purchaseNumber'=> $purchaseNumber,
            'currency'      => 'USD',
            'responseUrl'   => 'https://tu-sitio.com/api/niubiz/response'
        ];

        return response()->json($payload);
    }

    public function processPayment()
    {
        csrf()->validate();
        $data = request()->get(null);

        // Validar que la respuesta de Niubiz contenga los datos necesarios
        if (!isset($data['actionCode'], $data['orderNumber'])) {
            return redirect('/pago-fallido')->with('error', 'Respuesta inválida de Niubiz');
        }

        // Buscar la inscripción en la base de datos
        $visaInscripcion = VisaInscripcion::where('numero_pedido', $data['orderNumber'])->first();

        if (!$visaInscripcion) {
            return redirect('/pago-fallido')->with('error', 'No se encontró la inscripción');
        }

        // Si la transacción es exitosa (actionCode = 000)
        if ($data['actionCode'] == "000") {
            $visaInscripcion->status_pago = "pagado";
            $visaInscripcion->save();

            return redirect('/pago-exitoso')->with('success', 'Pago confirmado');
        }

        // 🔴 Si el pago falló o fue rechazado, eliminar la inscripción y los viajeros asociados
        Viajero::where('visa_inscripcion_id', $visaInscripcion->id)->delete();
        $visaInscripcion->delete();

        return redirect('/pago-fallido')->with('error', 'El pago no fue exitoso y la inscripción fue eliminada.');
    }

    public function getVisaInscripcion($id){
        $pedido_visa = VisaInscripcion::find($id);
        $visa = Visa::find($pedido_visa->visas_id);

        render('session.show-order', compact('pedido_visa','visa'));
    }
}