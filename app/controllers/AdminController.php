<?php

namespace App\Controllers;

use App\Models\Pais;
use App\Models\User;
use App\Models\Visa;
use App\Models\VisaInscripcion;


class AdminController extends Controller
{
    //USUARIOS

    public function updateUser($id)
    {
        csrf()->validate();
        // Buscar el usuario por ID
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        // Obtener datos desde el request
        $data = request()->get([
            'nombre',
            'apellidos',
            'email',
            'contraseña',
            'contraseña-confirm'
        ]);

        // Validaciones
        if (empty($data['nombre'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'El nombre es obligatorio'
            ], 400);
        }

        if (empty($data['apellidos'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'El nombre es obligatorio'
            ], 400);
        }

        if (!$data['email']) {
            return response()->json(['status' => 'error', 'message' => 'El email es obligatorio'], 400);
        }

        // Validación del email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return response()->json(['status' => 'error', 'message' => 'El email no es válido'], 400);
        }

        // Verificar si el email ya está registrado
        if (User::where('email', $data['email'])->exists()) {
            if (User::where('email', $data['email'])->first()->email != $user->email) {
                return response()->json(['status' => 'error', 'message' => 'El email ya está en uso'], 400);
            }
        }

        // Verificar si el usuario admin ya está registrado
        if (strtolower($data['nombre']) === 'admin') {
            if (User::whereRaw('LOWER(nombre) = ?', [strtolower($data['nombre'])])->exists()) {
                return response()->json(['status' => 'error', 'message' => 'El nombre "admin" no está permitido'], 402);
            }
        }

        if (!(empty($data['contraseña']) && empty($data['contraseña-confirm']))) {
            // Validación de la contraseña
            if (strlen($data['contraseña']) < 8) {
                return response()->json(['status' => 'error', 'message' => 'La contraseña debe tener al menos 8 caracteres'], 400);
            }

            // Verificar coincidencia de contraseñas
            if ($data['contraseña'] !== $data['contraseña-confirm']) {
                return response()->json(['status' => 'error', 'message' => 'Las contraseñas no coinciden'], 400);
            }

            $user->contraseña = $data['contraseña'];
        }


        $user->nombre = $data['nombre'];
        $user->apellido = $data['apellidos'];
        $user->email = $data['email'];

        // Guardar cambios en el usuario
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Usuario actualizado exitosamente',
            'user' => $user
        ], 200);
    }

    public function editUser($id)
    {
        // Buscar el producto en la base de datos por ID
        $user = User::find($id);

        // Si no se encuentra el producto, mostrar error 404
        if (!$user) {
            return view('errors.404');
        }

        // Retornar la vista 'admin/usuario/edit' pasando el usuario
        render('admin.usuarios.edit', compact('user'));
    }

    public function deleteUser($id)
    {
        csrf()->validate();
        $user = User::find($id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Usuario no encontrado'], 404);
        }

        // Luego eliminar el usuario
        $user->delete();

        return response()->json(['status' => 'success', 'message' => 'Usuario eliminado correctamente']);
    }

    public function searchUsers()
    {
        $descripcion = trim(request()->get('descripcion', '')); // Obtener descripción correctamente

        if ($descripcion === '') {
            $users = User::all(); // Devolver todos los productos si la descripción está vacía
        } else {
            // Filtrar productos por resumen o precio según si están en oferta o no
            $users = User::where('nombre', 'LIKE', "%{$descripcion}%")
                ->orWhere('apellido', 'LIKE', "%{$descripcion}%")
                ->orWhere('email', 'LIKE', "%{$descripcion}%")
                ->get();
        }

        if ($users->isEmpty()) {
            return response()->json(['message' => 'No se encontraron usuarios'], 404);
        }

        return response()->json($users);
    }

    //PAISES

    public function createCountry()
    {
        csrf()->validate();

        $data = request()->get(['nombre', 'imagen']);

        // Validar datos obligatorios
        if (!$data['nombre'] || !$data['imagen']) {
            return response()->json([
                'status' => 'error',
                'message' => 'El nombre del pais y la imagen son obligatorios'
            ], 400);
        }

        // Verificar si el pais existe
        if (Pais::where('nombre', $data['nombre'])->exists()) {
            return response()->json(['status' => 'error', 'message' => 'El pais ya existe'], 404);
        }

        // Validar que la imagen sea Base64 válida
        if (!$this->isValidBase64Image($data['imagen'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'La imagen no es un formato base64 válido'
            ], 400);
        }

        // Guardar la imagen en la base de datos
        $pais = new Pais();
        $pais->nombre = $data['nombre'];
        $pais->imagen = $data['imagen'];
        $pais->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Pais creado exitosamente',
            'pais' => $pais
        ], 201);
    }

    private function isValidBase64Image($base64)
    {
        // Extraer solo los datos base64, eliminando el encabezado
        if (preg_match('/^data:image\/(\w+);base64,/', $base64, $matches)) {
            $base64 = substr($base64, strpos($base64, ',') + 1);
        }

        // Reemplazar caracteres no válidos y verificar si es realmente base64
        $base64 = str_replace(['-', '_'], ['+', '/'], $base64);
        if (base64_decode($base64, true) === false) {
            return false;
        }

        // Intentar crear una imagen desde la cadena decodificada
        $imageData = base64_decode($base64);
        return @imagecreatefromstring($imageData) !== false;
    }

    public function updateCountry($id)
    {
        csrf()->validate();
        // Buscar el usuario por ID
        $pais = Pais::find($id);

        $data = request()->get(['nombre', 'imagen']);

        // Validar datos obligatorios
        if (!$data['nombre']) {
            return response()->json([
                'status' => 'error',
                'message' => 'El nombre del pais es obligatorio'
            ], 400);
        }

        // Verificar si la visa existe
        if (Pais::where('nombre', $data['nombre'])->exists()) {
            if (Pais::where('nombre', $data['nombre'])->first()->nombre != $pais->nombre) {
                return response()->json(['status' => 'error', 'message' => 'El pais ya existe'], 404);
            }
        }

        if (!empty($data['imagen'])) {
            // Validar que la imagen sea Base64 válida
            if (!$this->isValidBase64Image($data['imagen'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'La imagen no es un formato base64 válido'
                ], 400);
            }
        }

        $pais->nombre = $data['nombre'];
        $pais->imagen = $data['imagen'];

        // Guardar cambios en el usuario
        $pais->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Pais actualizado exitosamente',
            'pais' => $pais
        ], 200);
    }

    public function editCountry($id)
    {
        // Buscar el producto en la base de datos por ID
        $pais = Pais::find($id);

        // Si no se encuentra el producto, mostrar error 404
        if (!$pais) {
            return view('errors.404');
        }

        // Retornar la vista 'admin/usuario/edit' pasando el usuario
        render('admin.paises.edit', compact('pais'));
    }

    public function deleteCountry($id)
    {
        csrf()->validate();
        $pais = Pais::find($id);

        if (!$pais) {
            return response()->json(['status' => 'error', 'message' => 'Pais no encontrado'], 400);
        }

        $visas = Visa::where('pais1_id', $pais->id)->orWhere('pais2_id', $pais->id)->get();

        if (!empty($visas)) {
            return response()->json(['status' => 'error', 'message' => 'El país esta siendo usado, elimine o edite las visas para poder eliminar este pais'], 401);
        }

        // Luego eliminar el usuario
        $pais->delete();

        return response()->json(['status' => 'success', 'message' => 'Pais eliminado correctamente'], 200);
    }

    public function searchCountries()
    {
        $descripcion = trim(request()->get('descripcion', '')); // Obtener descripción correctamente

        if ($descripcion === '') {
            $paises = Pais::all(); // Devolver todos los paises si la descripción está vacía
        } else {
            // Filtrar paises por resumen o precio según si están en oferta o no
            $paises = Pais::where('nombre', 'LIKE', "%{$descripcion}%")->get();
        }

        if ($paises->isEmpty()) {
            return response()->json(['message' => 'No se encontraron paises'], 404);
        }

        return response()->json($paises);
    }

    //VISAS

    public function createVisa()
    {
        csrf()->validate();

        $data = request()->get(['pais1_id', 'pais2_id', 'nombre', 'tiempo_validez', 'numero_entradas', 'estancia_maxima', 'necesita_visa', 'precio', 'tasa_gobierno']);

        // Validar datos obligatorios
        if ($data['pais1_id'] == $data['pais2_id']) {
            return response()->json([
                'status' => 'error',
                'message' => 'Los paises tienen que ser diferentes'
            ], 400);
        }

        // Verificar si la visa existe
        if (Visa::where('nombre', $data['nombre'])->exists()) {
            return response()->json(['status' => 'error', 'message' => 'El nombre de la visa ya existe'], 404);
        }

        if (!is_numeric($data['precio'])) {
            return response()->json(['status' => 'error', 'message' => 'El precio debe ser un dato numerico'], 404);
        }

        if (!is_numeric($data['tasa_gobierno'])) {
            return response()->json(['status' => 'error', 'message' => 'La tasa de gobierno debe ser un dato numerico'], 404);
        }

        // Guardar la visa en la base de datos
        $visa = new Visa();
        $visa->pais1_id = $data['pais1_id'];
        $visa->pais2_id = $data['pais2_id'];
        $visa->nombre = $data['nombre'];
        $visa->tiempo_validez = $data['tiempo_validez'];
        $visa->numero_entradas = $data['numero_entradas'];
        $visa->estancia_maxima = $data['estancia_maxima'];
        $visa->necesita_visa = $data['necesita_visa'];
        $visa->precio = $data['precio'];
        $visa->tasa_gobierno = $data['tasa_gobierno'];
        $visa->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Visa creada exitosamente',
            'visa' => $visa
        ], 201);
    }

    public function updateVisa($id)
    {
        csrf()->validate();
        // Buscar el usuario por ID
        $visa = Visa::find($id);

        $data = request()->get(['pais1_id', 'pais2_id', 'nombre', 'tiempo_validez', 'numero_entradas', 'estancia_maxima', 'necesita_visa', 'precio', 'tasa_gobierno']);

        // Validar datos obligatorios
        if ($data['pais1_id'] == $data['pais2_id']) {
            return response()->json([
                'status' => 'error',
                'message' => 'Los paises tienen que ser diferentes'
            ], 400);
        }

        // Verificar si la visa existe
        if (Visa::where('nombre', $data['nombre'])->exists()) {
            if (Visa::where('nombre', $data['nombre'])->first()->nombre != $visa->nombre) {
                return response()->json(['status' => 'error', 'message' => 'El nombre de la visa ya existe'], 404);
            }
        }

        if (!is_numeric($data['precio'])) {
            return response()->json(['status' => 'error', 'message' => 'El precio debe ser un dato numerico'], 404);
        }

        if (!is_numeric($data['tasa_gobierno'])) {
            return response()->json(['status' => 'error', 'message' => 'La tasa de gobierno debe ser un dato numerico'], 404);
        }

        // Actualizar solo los campos enviados
        foreach ($data as $key => $value) {
            if ($value === "") {
                $visa->$key = null; // Convertir valores vacíos a NULL
            } else {
                $visa->$key = $value;
            }
        }

        // Guardar cambios en el usuario
        $visa->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Usuario actualizado exitosamente',
            'visa' => $visa
        ], 200);
    }

    public function editVisa($id)
    {
        // Buscar el producto en la base de datos por ID
        $visa = Visa::find($id);

        // Si no se encuentra el producto, mostrar error 404
        if (!$visa) {
            return view('errors.404');
        }

        // Retornar la vista 'admin/usuario/edit' pasando el usuario
        render('admin.visas.edit', compact('visa'));
    }

    public function deleteVisa($id)
    {
        csrf()->validate();
        $visa = Visa::find($id);

        if (!$visa) {
            return response()->json(['status' => 'error', 'message' => 'Visa no encontrada'], 404);
        }

        // Luego eliminar el usuario
        $visa->delete();

        return response()->json(['status' => 'success', 'message' => 'Visa eliminada correctamente']);
    }

    public function searchVisas()
    {
        $descripcion = trim(request()->get('descripcion', ''));

        // Cargar las relaciones con pais1 y pais2
        $query = Visa::with(['pais1', 'pais2']);

        if ($descripcion !== '') {
            $query->where('nombre', 'LIKE', "%{$descripcion}%")
                ->orWhere('precio', '=', floatval($descripcion)) // Comparación exacta para números
                ->orWhere('tasa_gobierno', '=', floatval($descripcion))
                ->orWhereHas('pais1', function ($q) use ($descripcion) {
                    $q->where('nombre', 'LIKE', "%{$descripcion}%");
                })
                ->orWhereHas('pais2', function ($q) use ($descripcion) {
                    $q->where('nombre', 'LIKE', "%{$descripcion}%");
                });
        }

        $visas = $query->get();

        return response()->json($visas);
    }

    //PEDIDOS

    public function updateOrder($id)
    {
        csrf()->validate();
        // Buscar la categoria en la base de datos por ID
        $order = VisaInscripcion::find($id);

        // Si no se encuentra el pedido, mostrar error 404
        if (!$order) {
            return view('errors.404');
        }

        $data = request()->get(['status']);

        $order->status_pago = $data['status'];
        $order->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Pedido actualizado exitosamente',
            'order' => $order
        ], 200);
    }

    public function deleteOrder($id)
    {
        csrf()->validate();

        $order = VisaInscripcion::find($id);

        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Pedido no encontrado'], 404);
        }

        $order->delete();

        return response()->json(['status' => 'success', 'message' => 'Pedido eliminado']);
    }

    //LOGIN

    public function login()
    {
        csrf()->validate(); // Validar el token CSRF automáticamente

        $data = request()->get(['email', 'contraseña']);

        // Verificar si se enviaron los datos requeridos
        if (empty($data['email']) || empty($data['contraseña'])) {
            return response()->json(['status' => 'error', 'message' => 'Email y contraseña son obligatorios'], 400);
        }

        $user = User::where('email', $data['email'])->first();

        // Verificar si el usuario existe y si la contraseña es correcta
        //if (!$user || !($data['password'] === $user->password)) {
        if (!$user || !password_verify($data['contraseña'], $user->contraseña)) {
            return response()->json(['status' => 'error', 'message' => 'Usuario o contraseña incorrectos'], 401);
        }

        if ($user->nombre === 'admin') {
            // Guardar el admin en sesión
            session()->set('admin', [
                'id' => $user->id,
                'name' => $user->nombre,
                'email' => $user->email
            ]);

            return response()->json(['status' => 'success', 'message' => 'Sesion Iniciada']);
        }

        return response()->json(['status' => 'error', 'message' => 'Acceso denegado'], 404);
    }

    public function logout()
    {
        csrf()->validate();

        session()->delete('admin'); // Eliminar solo la sesión del admin
        return response()->json(['status' => 'success', 'message' => 'Sesión cerrada']);
    }

}