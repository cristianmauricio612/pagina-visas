<?php

namespace App\Controllers;

use App\Models\Pais;
use App\Models\User;
use App\Models\Visa;
use App\Models\VisaInscripcion;
use App\Models\Variable;
use App\Models\Opcion;
use App\Models\Restriccion;
use App\Models\Formulario;
use App\Models\FormularioVariable;
use App\Models\Blog;
use App\Models\BlogCategoria;
use App\Models\BlogTag;
use App\Models\BlogTagRelacion;
use Exception;

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
                if ($user->nombre != $data['nombre']) {
                    return response()->json(['status' => 'error', 'message' => 'El nombre "admin" no está permitido'], 402);
                }
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

            $user->contraseña = password_hash($data['contraseña'], PASSWORD_BCRYPT); // Cifrar la contraseña;
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
        $descripcion = trim(request()->get('descripcion') ?? ''); // Obtener descripción correctamente

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
        $descripcion = trim(request()->get('descripcion') ?? ''); // Obtener descripción correctamente

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

        $data = request()->get([
            'pais1_id',
            'pais2_id',
            'nombre',
            'tiempo_validez',
            'numero_entradas',
            'estancia_maxima',
            'necesita_visa',
            'precio',
            'tasa_gobierno',
            'meses_espera'
        ]);

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

        if (!is_numeric($data['meses_espera'])) {
            return response()->json(['status' => 'error', 'message' => 'El tiempo de espera debe ser un dato numerico (EN MESES)'], 404);
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
        $visa->meses_espera = $data['meses_espera'];
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

        $data = request()->get(['pais1_id', 'pais2_id', 'nombre', 'tiempo_validez', 'numero_entradas', 'estancia_maxima', 'necesita_visa', 'precio', 'tasa_gobierno', 'meses_espera']);

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

        if (!is_numeric($data['meses_espera'])) {
            return response()->json(['status' => 'error', 'message' => 'El tiempo de espera debe ser un dato numerico (EN MESES)'], 404);
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
            'message' => 'Visa actualizada exitosamente',
            'visa' => $visa
        ], 200);
    }

    public function editVisa($id)
    {
        // Buscar la visa en la base de datos por ID
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
        $descripcion = trim(request()->get('descripcion') ?? '');

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

    //VARIABLES

    public function createVariable()
    {
        csrf()->validate();

        $data = request()->body();

        if (empty($data['nombre']) || empty($data['tipo_elemento']) || empty($data['tipo_variable'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Debe completar todos los campos obligatorios'
            ], 400);
        }

        if (Variable::where('nombre', $data['nombre'])->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ya existe una variable con ese nombre'
            ], 400);
        }

        $variable = new Variable();
        $variable->nombre_campo = $data['nombre_campo'];
        $variable->nombre = $data['nombre'];
        $variable->tipo_elemento = $data['tipo_elemento'];
        $variable->tipo_variable = $data['tipo_variable'];
        $variable->obligatoriedad = $data['obligatoriedad'] ? 1 : 0;
        $variable->placeholder = $data['placeholder'] ?? null;
        $variable->encabezado = $data['encabezado'] ?? null;
        $variable->advertencia = $data['advertencia'] ?? null;
        $variable->valor = $data['valor'] ?? null;
        $variable->isPais = isset($data['isPais']) && $data['isPais'] ? 1 : 0;

        $variable->save();


        // Guardar opciones si el tipo_elemento es SELECT o SELECT_BUTTONS
        if (
            in_array($data['tipo_elemento'], ['SELECT', 'SELECT_BUTTONS']) &&
            isset($_POST['opciones']) && is_array($_POST['opciones'])
        ) {
            // Solo guardar si isPais NO está activado
            if (!$variable->isPais) {
                $opcionesValidas = [];

                // Filtrar opciones con contenido válido
                foreach ($_POST['opciones'] as $index => $opcionData) {
                    $contenido = $opcionData['contenido'] ?? '';
                    if (!empty(trim($contenido))) {
                        $opcionesValidas[] = $index; // Guardamos el índice para usarlo luego
                    }
                }

                // Verificar mínimo 2 opciones válidas
                if (count($opcionesValidas) < 2) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Debe agregar al menos 2 opciones con contenido.'
                    ]);
                }

                // Si pasa la validación, guardar las opciones válidas
                foreach ($opcionesValidas as $index) {
                    $opcionData = $_POST['opciones'][$index];

                    $valor = $opcionData['valor'] ?? null;
                    $contenido = $opcionData['contenido'];

                    // Manejo de imagen (base64)
                    $imagenBase64 = null;
                    if (
                        isset($_FILES['opciones']['tmp_name'][$index]['imagen']) &&
                        is_uploaded_file($_FILES['opciones']['tmp_name'][$index]['imagen'])
                    ) {
                        $tmpName = $_FILES['opciones']['tmp_name'][$index]['imagen'];
                        $imageData = file_get_contents($tmpName);
                        $imagenBase64 = base64_encode($imageData);
                    }

                    Opcion::create([
                        'variable_id' => $variable->id,
                        'valor' => $valor,
                        'imagen' => $imagenBase64,
                        'contenido' => $contenido
                    ]);
                }
            }
        }

        // Guardar restricciones si es CHECKBOX_RESTRICTIVE
        if (
            $data['tipo_elemento'] === 'CHECKBOX_RESTRICTIVE' &&
            !empty($data['bloqueos']) &&
            is_array($data['bloqueos'])
        ) {
            foreach ($data['bloqueos'] as $bloqueo_id) {
                Restriccion::create([
                    'variable_id' => $variable->id,
                    'variable_restringida_id' => $bloqueo_id
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Variable creada exitosamente',
            'variable' => $variable
        ], 201);
    }

    public function editVariable($id)
    {
        // Buscar la variable con sus relaciones necesarias
        $variable = Variable::with(['opciones', 'restricciones'])->find($id);

        // Si no se encuentra el producto, mostrar error 404
        if (!$variable) {
            return view('errors.404');
        }

        // Retornar la vista 'admin/usuario/edit' pasando el usuario
        render('admin.variables.edit', compact('variable'));
    }

    public function updateVariable($id)
    {
        csrf()->validate();

        $data = request()->body();

        $variable = Variable::findOrFail($id);
        $variable->nombre_campo = $data['nombre_campo'];
        $variable->nombre = $data['nombre'];
        $variable->tipo_variable = $data['tipo_variable'] ?? null;
        $variable->placeholder = $data['placeholder'] ?? null;
        $variable->encabezado = $data['encabezado'] ?? null;
        $variable->advertencia = $data['advertencia'] ?? null;
        $variable->obligatoriedad = !empty($data['obligatoriedad']) ? 1 : 0;
        $variable->isPais = !empty($data['isPais']) ? 1 : 0;
        $variable->save();

        // Actualizar opciones si el tipo_elemento es SELECT o SELECT_BUTTONS
        if (in_array($variable->tipo_elemento, ['SELECT', 'SELECT_BUTTONS'])) {
            // Solo actualizamos si isPais NO está activado
            if (!$variable->isPais) {
                if (!empty($data['opciones'])) {
                    // Filtrar opciones válidas
                    $opcionesValidas = array_filter($data['opciones'], function ($op) {
                        return !empty(trim($op['contenido'] ?? ''));
                    });

                    if (count($opcionesValidas) < 2) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Debe agregar al menos 2 opciones con contenido.'
                        ]);
                    }

                    // Actualizar las opciones válidas
                    foreach ($opcionesValidas as $op) {
                        $opcion = Opcion::find($op['id']);
                        if ($opcion) {
                            $opcion->valor = $op['valor'] ?? null;
                            $opcion->imagen = $op['imagen'] ?? null;
                            $opcion->contenido = $op['contenido'];
                            $opcion->save();
                        }
                    }
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Debe agregar al menos 2 opciones.'
                    ]);
                }
            }
        }

        // Actualizar restricciones si es CHECKBOX_RESTRICTIVE
        if ($variable->tipo_elemento === 'CHECKBOX_RESTRICTIVE') {
            Restriccion::where('variable_id', $variable->id)->delete();
            if (!empty($data['restricciones'])) {
                foreach ($data['restricciones'] as $rid) {
                    Restriccion::create([
                        'variable_id' => $variable->id,
                        'variable_restringida_id' => $rid
                    ]);
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Variable actualizada exitosamente'
        ]);
    }


    public function deleteVariable($id)
    {
        // Buscar la variable
        $variable = Variable::find($id);

        if (!$variable) {
            return response()->json([
                'status' => 'error',
                'message' => 'Variable no encontrada'
            ], 404);
        }

        // Eliminar restricciones relacionadas (si las hay)
        Restriccion::where('variable_id', $id)->delete();

        // Eliminar opciones relacionadas (si las hay)
        Opcion::where('variable_id', $id)->delete();

        // Finalmente eliminar la variable
        $variable->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Variable eliminada correctamente'
        ]);
    }

    //FORMULARIOS

    public function createFormulario()
    {
        csrf()->validate();
        $data = request()->body();

        // Validar campos requeridos
        if (empty($data['visa_id']) || empty($data['variables']) || empty($data['ordenes'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Todos los campos son obligatorios, incluyendo el orden de las variables.'
            ], 400);
        }

        // Validar que no exista un formulario para esta visa
        if (Formulario::where('visa_id', $data['visa_id'])->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ya existe un formulario asociado a esta visa.'
            ], 400);
        }

        // Validar que cada variable tenga su orden válido
        foreach ($data['variables'] as $variable_id) {
            if (!isset($data['ordenes'][$variable_id]) || !is_numeric($data['ordenes'][$variable_id])) {
                return response()->json([
                    'status' => 'error',
                    'message' => "El orden de la variable con ID {$variable_id} es inválido o está vacío."
                ], 400);
            }
        }

        // Crear el formulario
        $formulario = new Formulario();
        $formulario->visa_id = $data['visa_id'];
        $formulario->save();

        // Asociar variables con su orden y meses_espera si están disponibles
        foreach ($data['variables'] as $variable_id) {
            $orden = (int) $data['ordenes'][$variable_id];
            $mesesEspera = isset($data['meses_espera'][$variable_id]) && is_numeric($data['meses_espera'][$variable_id])
                ? (int) $data['meses_espera'][$variable_id]
                : null;

            FormularioVariable::create([
                'formulario_id' => $formulario->id,
                'variable_id' => $variable_id,
                'orden' => $orden,
                'meses_espera' => $mesesEspera
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Formulario creado exitosamente',
            'formulario' => $formulario
        ], 201);
    }

    public function editFormulario($id)
    {
        $formulario = Formulario::with('variables')->findOrFail($id);
        $visas = Visa::all();
        $variables = Variable::all()->groupBy('tipo_variable');

        render('admin.formularios.edit', compact('formulario', 'visas', 'variables'));
    }

    public function updateFormulario($id)
    {
        csrf()->validate();
        $data = request()->body();

        // Validar campos requeridos
        if (empty($data['visa_id']) || empty($data['variables']) || empty($data['ordenes'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Todos los campos son obligatorios, incluyendo el orden de las variables.'
            ], 400);
        }

        // Validar que cada variable tenga su orden válido
        foreach ($data['variables'] as $variable_id) {
            if (!isset($data['ordenes'][$variable_id]) || !is_numeric($data['ordenes'][$variable_id])) {
                return response()->json([
                    'status' => 'error',
                    'message' => "El orden de la variable con ID {$variable_id} es inválido o está vacío."
                ], 400);
            }
        }

        // Buscar y actualizar formulario
        $formulario = Formulario::findOrFail($id);
        $formulario->visa_id = $data['visa_id'];
        $formulario->save();

        // Eliminar relaciones anteriores
        FormularioVariable::where('formulario_id', $formulario->id)->delete();

        // Asociar nuevamente las variables con su orden
        foreach ($data['variables'] as $variable_id) {
            $orden = (int) $data['ordenes'][$variable_id];
            $mesesEspera = isset($data['meses_espera'][$variable_id]) && is_numeric($data['meses_espera'][$variable_id])
                ? (int) $data['meses_espera'][$variable_id]
                : null;

            FormularioVariable::create([
                'formulario_id' => $formulario->id,
                'variable_id' => $variable_id,
                'orden' => $orden,
                'meses_espera' => $mesesEspera
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Formulario actualizado exitosamente'
        ]);
    }

    public function deleteFormulario($id)
    {
        csrf()->validate(); // Protege contra CSRF

        $formulario = Formulario::find($id);

        if (!$formulario) {
            return response()->json([
                'status' => 'error',
                'message' => 'Formulario no encontrado.'
            ], 404);
        }

        // También puedes eliminar relaciones si las tienes (como variables asociadas)
        // Por ejemplo:
        $formulario->variables()->detach(); // Si es una relación many-to-many

        $formulario->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Formulario eliminado correctamente.'
        ]);
    }

    //PEDIDOS

    public function updateOrder($id)
    {
        csrf()->validate();
        // Buscar el pedido en la base de datos por ID
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

    //RECLAMACIONES

    /**
     * Ver reclamación específica
     */
    public function viewReclamacion($id)
    {
        $reclamacion = \App\Models\LibroReclamacion::find($id);

        if (!$reclamacion) {
            // Redirigir con error si no existe
            return redirect('/admin/reclamaciones')->with('error', 'Reclamación no encontrada');
        }

        return render('admin.reclamaciones.view', compact('reclamacion'));
    }

    //BLOG

    /**
     * Mostrar la vista de edición de blog
     */
    public function editBlog($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return render('errors.404');
        }

        // 🔥 CARGAR TAGS EXISTENTES usando BlogTagRelacion
        $tagsExistentes = BlogTagRelacion::where('blog_id', $blog->id)
            ->join('blog_tags', 'blog_tags_relaciones.tag_id', '=', 'blog_tags.id')
            ->pluck('blog_tags.id')
            ->toArray();

        $blog->tags_existentes = $tagsExistentes;

        return render('admin.blog.edit', compact('blog'));
    }

    /**
     * Crear nuevo artículo de blog
     */
    public function createBlog()
    {
        csrf()->validate();

        $data = request()->body();

        // Validar datos requeridos
        $errores = $this->validarDatosBlog($data);

        if (!empty($errores)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Errores de validación',
                'errors' => $errores
            ], 400);
        }

        try {
            // Procesar imagen si existe
            $archivoImagen = $_FILES['imagen'] ?? null;

            // Crear el artículo
            $blog = Blog::crearBlog($data, $archivoImagen);

            // Procesar tags si existen
            if (!empty($data['tags'])) {
                $this->procesarTags($blog, $data['tags']);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Artículo creado exitosamente',
                'data' => $blog
            ], 201);

        } catch (Exception $e) {
            error_log("Error al crear artículo: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error al crear el artículo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar artículo existente
     */
    public function updateBlog($id)
    {
        csrf()->validate();

        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json([
                'status' => 'error',
                'message' => 'El artículo no existe'
            ], 404);
        }

        $data = request()->body();

        // Validar datos
        $errores = $this->validarDatosBlog($data, $id);

        if (!empty($errores)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Errores de validación',
                'errors' => $errores
            ], 400);
        }

        try {
            // Actualizar slug si cambió el título
            if (isset($data['titulo']) && $data['titulo'] !== $blog->titulo) {
                $data['slug'] = Blog::generarSlug($data['titulo']);
            }

            // Procesar fecha de publicación
            if (isset($data['estado']) && $data['estado'] === 'publicado' && !$blog->fecha_publicacion) {
                $data['fecha_publicacion'] = date('Y-m-d H:i:s');
            }

            // SOLUCIÓN: Manejar imagen por separado
            $nuevaImagen = null;
            $archivoImagen = $_FILES['imagen'] ?? null;

            if ($archivoImagen && $archivoImagen['size'] > 0) {
                // Se subió una nueva imagen
                $tipoImagen = $archivoImagen['type'];

                $tiposPermitidos = [
                    'image/jpeg' => 'jpeg',
                    'image/jpg' => 'jpeg',
                    'image/png' => 'png',
                    'image/webp' => 'webp'
                ];

                if (isset($tiposPermitidos[$tipoImagen])) {
                    $extensionImagen = $tiposPermitidos[$tipoImagen];
                    $imagenData = file_get_contents($archivoImagen['tmp_name']);
                    $base64 = base64_encode($imagenData);
                    $nuevaImagen = "data:image/{$extensionImagen};base64," . $base64;
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Tipo de imagen no permitido. Solo JPEG, PNG y WebP son aceptados.'
                    ], 400);
                }
            }

            // Lista de campos permitidos (SIN incluir 'imagen')
            $camposPermitidos = [
                'titulo',
                'slug',
                'categoria_id',
                'contenido',
                'resumen',
                'autor',
                'tiempo_lectura',
                'estado',
                'vistas',
                'fecha_publicacion',
                'meta_description',
                'meta_keywords'
            ];

            // Actualizar campos normales (sin imagen)
            foreach ($data as $key => $value) {
                if (in_array($key, $camposPermitidos)) {
                    $blog->$key = $value;
                }
            }

            // SOLO actualizar imagen si se subió una nueva
            if ($nuevaImagen !== null) {
                $blog->imagen = $nuevaImagen;
            }

            $blog->save();

            // Procesar tags si existen
            if (isset($data['tags'])) {
                $this->procesarTags($blog, $data['tags']);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Artículo actualizado exitosamente',
                'data' => $blog
            ]);

        } catch (Exception $e) {
            error_log("Error al actualizar artículo: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error al actualizar el artículo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar artículo
     */
    public function deleteBlog($id)
    {
        csrf()->validate();

        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json([
                'status' => 'error',
                'message' => 'El artículo no existe'
            ], 404);
        }

        try {
            $blog->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Artículo eliminado exitosamente'
            ]);

        } catch (Exception $e) {
            error_log("Error al eliminar artículo: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error al eliminar el artículo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Buscar artículos para el administrador
     */
    public function searchBlogs()
    {
        $termino = request()->get('q') ?? '';
        $estado = request()->get('estado') ?? '';
        $categoria = request()->get('categoria') ?? '';
        $page = request()->get('page', 1);
        $perPage = request()->get('per_page', 10);

        $query = Blog::with('categoria');

        // Aplicar filtros
        if (!empty($termino)) {
            $query->where(function ($q) use ($termino) {
                $q->where('titulo', 'LIKE', "%{$termino}%")
                    ->orWhere('contenido', 'LIKE', "%{$termino}%")
                    ->orWhere('autor', 'LIKE', "%{$termino}%");
            });
        }

        if (!empty($estado)) {
            $query->where('estado', $estado);
        }

        if (!empty($categoria)) {
            $categoriaObj = BlogCategoria::where('nombre', $categoria)->first();
            if ($categoriaObj) {
                $query->where('categoria_id', $categoriaObj->id);
            }
        }

        // Ordenar por fecha de creación descendente
        $query->orderBy('created_at', 'desc');

        // Paginación
        $total = $query->count();
        $offset = ($page - 1) * $perPage;
        $blogs = $query->limit($perPage)->offset($offset)->get();

        return response()->json([
            'status' => 'success',
            'data' => $blogs,
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => ceil($total / $perPage)
        ]);
    }

    /**
     * Cambiar estado de un artículo
     */
    public function cambiarEstado($id)
    {
        csrf()->validate();

        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json([
                'status' => 'error',
                'message' => 'El artículo no existe'
            ], 404);
        }

        $data = request()->body();
        $nuevoEstado = $data['estado'] ?? '';

        if (!in_array($nuevoEstado, ['borrador', 'publicado', 'archivado'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Estado no válido'
            ], 400);
        }

        try {
            $blog->estado = $nuevoEstado;

            // Si se publica por primera vez, establecer fecha de publicación
            if ($nuevoEstado === 'publicado' && !$blog->fecha_publicacion) {
                $blog->fecha_publicacion = date('Y-m-d H:i:s');
            }

            $blog->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Estado cambiado exitosamente',
                'data' => $blog
            ]);

        } catch (Exception $e) {
            error_log("Error al cambiar estado: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error al cambiar el estado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Subir imagen para el blog
     */
    public function uploadImage()
    {
        csrf()->validate();

        $file = $_FILES['image'] ?? null;

        if (!$file || $file['size'] == 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se recibió ninguna imagen'
            ], 400);
        }

        // Validar tipo de archivo
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tipo de archivo no permitido. Solo JPEG, PNG y WebP'
            ], 400);
        }

        // Validar tamaño (máximo 5MB)
        $maxSize = 5 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            return response()->json([
                'status' => 'error',
                'message' => 'El archivo es demasiado grande. Máximo 5MB'
            ], 400);
        }

        try {
            // Convertir a base64
            $imagenData = file_get_contents($file['tmp_name']);
            $base64 = base64_encode($imagenData);
            $dataUrl = "data:{$file['type']};base64," . $base64;

            return response()->json([
                'status' => 'success',
                'message' => 'Imagen subida exitosamente',
                'url' => $dataUrl
            ]);

        } catch (Exception $e) {
            error_log("Error al procesar imagen: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error al procesar la imagen: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validar datos del blog
     */
    private function validarDatosBlog($data, $blogId = null)
    {
        $errores = [];

        // Campos requeridos
        if (empty($data['titulo'])) {
            $errores[] = 'El título es obligatorio';
        }

        if (empty($data['contenido'])) {
            $errores[] = 'El contenido es obligatorio';
        }

        if (empty($data['categoria_id'])) {
            $errores[] = 'La categoría es obligatoria';
        }

        // Validar que la categoría existe
        if (!empty($data['categoria_id'])) {
            $categoria = BlogCategoria::find($data['categoria_id']);
            if (!$categoria) {
                $errores[] = 'La categoría seleccionada no existe';
            }
        }

        // Validar unicidad del título
        if (!empty($data['titulo'])) {
            $query = Blog::where('titulo', $data['titulo']);
            if ($blogId) {
                $query->where('id', '!=', $blogId);
            }
            if ($query->exists()) {
                $errores[] = 'Ya existe un artículo con este título';
            }
        }

        // Validar estado
        if (!empty($data['estado']) && !in_array($data['estado'], ['borrador', 'publicado', 'archivado'])) {
            $errores[] = 'Estado no válido';
        }

        return $errores;
    }

    /**
     * Procesar tags del artículo
     */
    private function procesarTags($blog, $tagsString)
    {
        if (empty($tagsString)) {
            return;
        }

        // Los tags vienen como IDs separados por comas desde el formulario
        $tagIds = array_filter(array_map('trim', explode(',', $tagsString)));

        if (empty($tagIds)) {
            return;
        }

        // Eliminar relaciones anteriores usando el modelo BlogTagRelacion
        BlogTagRelacion::where('blog_id', $blog->id)->delete();

        // Agregar nuevas relaciones e incrementar contador de uso
        foreach ($tagIds as $tagId) {
            if (!empty($tagId) && is_numeric($tagId)) {
                // Crear la relación
                BlogTagRelacion::create([
                    'blog_id' => $blog->id,
                    'tag_id' => $tagId
                ]);

                // Incrementar uso del tag
                $tag = BlogTag::find($tagId);
                if ($tag) {
                    $tag->incrementarUso();
                }
            }
        }
    }

    /**
     * Listar correos de publicidad
     */
    public function listarCorreosPublicidad()
    {
        $correos = \App\Models\CorreoPublicidad::orderBy('fecha_registro', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $correos
        ]);
    }

    /**
     * Eliminar correo de publicidad
     */
    public function eliminarCorreoPublicidad($id)
    {
        csrf()->validate();

        $correo = \App\Models\CorreoPublicidad::find($id);
        if (!$correo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Correo no encontrado'
            ], 404);
        }

        $correo->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Correo eliminado correctamente'
        ]);
    }

    /**
     * Exportar correos de publicidad a CSV
     */
    public function exportarCorreosPublicidad()
    {
        $correos = \App\Models\CorreoPublicidad::orderBy('fecha_registro', 'desc')->get();

        $csvContent = "ID,Correo,Fecha de Registro,Página de Origen,IP,Convertido\n";

        foreach ($correos as $correo) {
            $csvContent .= "{$correo->id},{$correo->correo},{$correo->fecha_registro},{$correo->pagina_origen},{$correo->ip_usuario},{$correo->convertido}\n";
        }

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="correos_publicidad.csv"');

        echo $csvContent;
        exit;
    }
}
