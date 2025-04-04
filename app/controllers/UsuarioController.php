<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Visa;
use App\Models\VisaInscripcion;

class UsuarioController extends Controller
{
    public function register()
    {
        csrf()->validate();

        $data = request()->get(['nombre', 'apellidos', 'email', 'contraseña', 'contraseña-confirm']);

        // Validación de campos vacíos
        foreach ($data as $key => $value) {
            if (empty($value)) {
                return response()->json(['status' => 'error', 'message' => "El campo $key es obligatorio"], 400);
            }
        }

        // Validación del email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return response()->json(['status' => 'error', 'message' => 'El email no es válido'], 400);
        }

        // Validación de la contraseña
        if (strlen($data['contraseña']) < 8) {
            return response()->json(['status' => 'error', 'message' => 'La contraseña debe tener al menos 8 caracteres'], 400);
        }

        // Verificar coincidencia de contraseñas
        if ($data['contraseña'] !== $data['contraseña-confirm']) {
            return response()->json(['status' => 'error', 'message' => 'Las contraseñas no coinciden'], 400);
        }

        // Verificar si el email ya está registrado
        if (User::where('email', $data['email'])->exists()) {
            return response()->json(['status' => 'error', 'message' => 'El email ya está en uso'], 400);
        }

        // Verificar si el usuario admin ya está registrado
        if (strtolower($data['nombre']) === 'admin') {
            if (User::whereRaw('LOWER(nombre) = ?', [strtolower($data['nombre'])])->exists()) {
                return response()->json(['status' => 'error', 'message' => 'El nombre "admin" no está permitido'], 402);
            }
        }

        // Guardar el usuario en la base de datos
        $user = new User();
        $user->nombre = $data['nombre'];
        $user->apellido = $data['apellidos'];
        $user->email = $data['email'];
        $user->contraseña = password_hash($data['contraseña'], PASSWORD_BCRYPT); // Cifrar la contraseña
        $user->save();

        return response()->json(['status' => 'success', 'message' => 'Usuario registrado', 'user' => $user], 201);
    }

    public function updateUserEmail($id)
    {
        csrf()->validate();

        $user = User::find($id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Usuario no encontrado'], 404);
        }

        $data = request()->get(['email']);

        if (!$data['email']) {
            return response()->json(['status' => 'error', 'message' => 'El email es obligatorio'], 400);
        }

        // Validación del email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return response()->json(['status' => 'error', 'message' => 'El email no es válido'], 400);
        }

        // Verificar si el email ya está registrado
        if (User::where('email', $data['email'])->exists()) {
            return response()->json(['status' => 'error', 'message' => 'El email ya está en uso'], 400);
        }

        $user->email = $data['email'];
        $user->save();

        session()->set('usuario', [
            'id' => $user->id,
            'nombre' => $user->nombre,
            'email' => $user->email
        ]);

        return response()->json(['status' => 'success', 'message' => 'Usuario actualizado', 'user' => $user],200);
    }

    public function updateUserPassword($id)
    {
        csrf()->validate();

        $user = User::find($id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Usuario no encontrado'], 404);
        }

        $data = request()->get(['contraseña', 'contraseña-repeat']);

        if (!$data['contraseña'] || !$data['contraseña-repeat']) {
            return response()->json(['status' => 'error', 'message' => 'Las contraseñas son obligatorias'], 400);
        }

        // Validación de la contraseña
        if (strlen($data['contraseña']) < 8) {
            return response()->json(['status' => 'error', 'message' => 'La contraseña debe tener al menos 8 caracteres'], 400);
        }

        // Verificar coincidencia de contraseñas
        if ($data['contraseña'] !== $data['contraseña-repeat']) {
            return response()->json(['status' => 'error', 'message' => 'Las contraseñas no coinciden'], 400);
        }

        $user->contraseña = password_hash($data['contraseña'], PASSWORD_BCRYPT); // Cifrar la contraseña
        $user->save();

        return response()->json(['status' => 'success', 'message' => 'Usuario actualizado', 'user' => $user],200);
    }

    public function login_check(){
        csrf()->validate(); // Validar el token CSRF automáticamente

        $data = request()->get(['email']);

        // Validación del email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return response()->json(['status' => 'error', 'message' => 'El email no es válido'], 400);
        }

        $user = User::where('email', $data['email'])->first();

        // Verificar si el usuario existe
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Correo incorrecto'], 401);
        }

        return response()->json(['status' => 'success', 'message' => 'Correo Valido'], 200);
    }

    public function order_check()
    {
        csrf()->validate(); // Validar el token CSRF automáticamente

        $data = request()->get(['email']);
        $input = $data['email']; // Puede ser un número

        // Buscar el pedido en la base de datos
        $pedido_visa = VisaInscripcion::where('numero_pedido', $input)->first();

        if (!$pedido_visa) {
            return response()->json(['status' => 'error', 'message' => 'Número de pedido incorrecto'], 402);
        }

        // Buscar la visa asociada
        $visa = Visa::find($pedido_visa->visas_id);

        // Guardar en sesión
        session()->set('pedido_visa', [
            'id' => $pedido_visa->id
        ]);
        session()->set('visa', [
            'id' => $visa->id
        ]);

        // Enviar respuesta con la URL de redirección
        return response()->json([
            'status' => 'success',
            'redirect' => '/pedido'
        ], 200);
    }

    public function close_order()
    {
        csrf()->validate(); 

        session()->delete(['pedido_visa', 'visa']);
        return response()->json(['status' => 'success', 'message' => 'Sesiones cerradas']);
    }

    public function login(){
        csrf()->validate(); // Validar el token CSRF automáticamente

        $data = request()->get(['email', 'contraseña']);

        $user = User::where('email', $data['email'])->first();

        // Verificar si el usuario existe
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Correo incorrecto'], 400);
        }

        // Verificar si la contraseña es correcta
        if (!password_verify($data['contraseña'], $user->contraseña)) {
            return response()->json(['status' => 'error', 'message' => 'Contraseña incorrecta'], 401);
        }

        // Guardar el usuario en sesión
        session()->set('usuario', [
            'id' => $user->id,
            'nombre' => $user->nombre,
            'email' => $user->email
        ]);

        return response()->json(['status' => 'success', 'message' => 'Sesion Iniciada'],200);
    }
    
    public function logout()
    {
        csrf()->validate(); 

        session()->delete('usuario'); // Eliminar solo la sesión del admin
        return response()->json(['status' => 'success', 'message' => 'Sesión cerrada']);
    }
}
    