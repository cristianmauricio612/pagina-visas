<?php

use App\Models\VisaInscripcion;

app()->get('/', ['name' => 'home', 'PaisController@index']);

app()->get('/que-es-una-visa', ['name' => 'about-visa', function () {render('articles.what-is-avisa');}]);

app()->get('/electronic-visa', ['name' => 'electronic-visa', function () {render('articles.electronic-visa');}]);

app()->get('/arrived-visa', ['name' => 'arrived-visa', function () {render('articles.arrived-visa');}]);

app()->get('/price-canadience-visa', ['name' => 'price-canadience-visa', function () {render('articles.price-canadience-visa');}]);

app()->get('/visa-validity', ['name' => 'visa-validity', function () {render('articles.visa-validity');}]);

app()->get('/estados-unidos/p/esta', ['name' => 'estados-unidos-p-esta', function () {render('articles.estados-unidos-p-esta');}]);

app()->get('/canada/p/eta', ['name' => 'canada-p-eta', function () {render('articles.canada-p-eta');}]);

app()->get('/india/p/tourist-e-visa', ['name' => 'india-p-tourist-e-visa', function () {render('articles.india-p-tourist-e-visa');}]);

app()->get('/leer-mas', ['name' => 'leer-mas', function () {render('articles.leer-mas');}]);


app()->get('/account', ['name' => 'account', function () {render('session.account');}]);

app()->get('/account/mis-pedidos', ['name' => 'account-mis-pedidos', function () {render('session.myorders');}]);

app()->get('/account/datos-personales', ['name' => 'account-datos-personales', function () {render('session.personal-data');}]);

app()->get('/account/seguridad-privacidad', ['name' => 'account-seguridad-privacidad', function () {render('session.security-privacy');}]);

app()->get('/about-us', ['name' => 'about-us', function () {render('about-us');}]);

app()->get('/contact', ['name' => 'contact', function () {render('contact');}]);

app()->post('/order-check', ['name' => 'order-check', 'UsuarioController@order_check']);

app()->get('/pedido', ['name' => 'order', function () {render('view-order-code');}]);

app()->post('/close-order', 'UsuarioController@close_order');

app()->get('/libro-de-reclamaciones', ['name' => 'libro-reclamaciones', function () {render('reclamaciones.index');}]);

app()->post('/libro-de-reclamaciones/registrar', ['name' => 'registrar-reclamacion', 'LibroReclamacionController@registrarReclamacion']);

app()->get('/libro-de-reclamaciones/exitoso', ['name' => 'reclamacion-exitosa', function () {render('reclamaciones.exitoso');}]);

// RUTAS PÚBLICAS DEL BLOG
app()->get('/blog', ['name' => 'blog.index', 'BlogController@index']);

app()->get('/blog/categoria/{categoria}', ['name' => 'blog.categoria', 'BlogController@categoria']);

app()->get('/blog/buscar', ['name' => 'blog.buscar', 'BlogController@buscar']);

app()->get('/api/blog/articulos', ['name' => 'blog.api.articulos', 'BlogController@obtenerArticulos']);

app()->get('/blog/tag/{tag}', ['name' => 'blog.tag', 'BlogController@tag']);

// RUTA PARA CORREOS DE PUBLICIDAD
app()->post('/api/guardar-correo-marketing', ['name' => 'guardar-correo-marketing', 'CorreoPublicidadController@guardarCorreo']);

//SESSION

app()->get('/iniciar-sesion', ['name' => 'iniciar-sesion', function () {render('session.login');}]);

app()->get('/registrarse', ['name' => 'registrarse', function () {render('session.register');}]);

app()->post('/register', ['name' => 'register', 'UsuarioController@register']);

app()->put('/account/datos-personales/actualizar/{id}', ['name' => 'account-update-email', 'UsuarioController@updateUserEmail']);

app()->put('/account/seguridad-privacidad/actualizar/{id}', ['name' => 'account-update-password', 'UsuarioController@updateUserPassword']);

app()->get('/account/mis-pedidos/show/{id}', ['name' => 'account-show-order', 'VisaInscripcionController@getVisaInscripcion']);

app()->post('/login-check', ['name' => 'login-check', 'UsuarioController@login_check']);

app()->post('/login', ['name' => 'login', 'UsuarioController@login']);

app()->post('/logout', 'UsuarioController@logout');

//FIN SESSION

//VISA INSCRIPCION

app()->get('/visas/{pais1}/{pais2}/{posicion}', ['name' => 'visas', 'VisaController@getVisasByPaises']);

app()->get('/visa-inscripcion/{id}/{posicion}', ['name' => 'visa-inscripcion', 'VisaController@getVisaById']);

app()->get('/pago/{id}', ['name' => 'pago', 'VisaInscripcionController@createVisaInscripcion']);

app()->post('/api/izipay/payload', ['name' => 'izipay-payload', 'VisaInscripcionController@checkout']);

// 1. IPN → Sin sesión, sin redirecciones
app()->post('/api/izipay/ipn', 'VisaInscripcionController@handleIPN');

// 2. Retorno a tienda → Con sesión, redirección a vista
app()->post('/procesar-pago-retorno', 'VisaInscripcionController@handleReturn');

app()->post('/api/izipay/form-token', 'VisaInscripcionController@getFormToken');

app()->get('/pago-exitoso', ['name' => 'pago-exitoso', function () {render('pagos.exito');}]);

app()->get('/pago-fallido', ['name' => 'pago-fallido', function () {render('pagos.error');}]);

app()->post('/saludo', ['name' => 'saludo', function () {
    response()->json(['mensaje' => 'hola']);
}]);


app()->get('/limpiar-pedidos', function () {
    VisaInscripcion::limpiarPedidosPendientes();
    return response()->json(["message" => "Pedidos pendientes eliminados"]);
});

app()->post('/contact-mail', 'MailController@contactEmail');

//VISTAS ADMIN

app()->get('/admin/iniciar-sesion', ['name' => 'admin.loginView', function () {render('admin.login');}]);

app()->get('/admin/home', ['name' => 'admin.homeView', function () {render('admin.home');}]);

app()->get('/admin/paises', ['name' => 'admin.paises.listView', function () {render('admin.paises.list');}]);

app()->get('/admin/paises/agregar', ['name' => 'admin.paises.addView', function () {render('admin.paises.add');}]);

app()->get('/admin/paises/editar/{id}', ['name' => 'admin.paises.editView', 'AdminController@editCountry']);

app()->get('/admin/pedidos', ['name' => 'admin.pedidos.listView', function () {render('admin.pedidos.list');}]);

app()->get('/admin/usuarios', ['name' => 'admin.usuarios.listView', function () {render('admin.usuarios.list');}]);

app()->get('/admin/usuarios/agregar', ['name' => 'admin.usuarios.addView', function () {render('admin.usuarios.add');}]);

app()->get('/admin/usuarios/editar/{id}', ['name' => 'admin.usuarios.editView', 'AdminController@editUser']);

app()->get('/admin/visas', ['name' => 'admin.visas.listView', function () {render('admin.visas.list');}]);

app()->get('/admin/visas/agregar', ['name' => 'admin.visas.addView', function () {render('admin.visas.add');}]);

app()->get('/admin/visas/editar/{id}', ['name' => 'admin.visas.editView', 'AdminController@editVisa']);

app()->get('/admin/formularios', ['name' => 'admin.formularios.listView', function () {render('admin.formularios.list');}]);

app()->get('/admin/formularios/agregar', ['name' => 'admin.formularios.addView', function () {render('admin.formularios.add');}]);

app()->get('/admin/formularios/editar/{id}', ['name' => 'admin.formularios.editView', 'AdminController@editFormulario']);

app()->get('/admin/variables', ['name' => 'admin.variables.listView', function () {render('admin.variables.list');}]);

app()->get('/admin/variables/agregar', ['name' => 'admin.variables.addView', function () {render('admin.variables.add');}]);

app()->get('/admin/variables/editar/{id}', ['name' => 'admin.variables.editView', 'AdminController@editVariable']);

/* RUTAS DEL ADMINISTRADOR */

//USUARIOS

app()->put('/admin/usuarios/actualizar/{id}', ['name' => 'admin.usuarios.update', 'AdminController@updateUser']);

app()->delete('/admin/usuarios/eliminar/{id}', ['name' => 'admin.usuarios.delete', 'AdminController@deleteUser']);

app()->get('/admin/usuarios/buscar', ['name' => 'admin.usuarios.search', 'AdminController@searchUsers']);

//PAISES

app()->post('/admin/paises/crear', ['name' => 'admin.paises.create', 'AdminController@createCountry']);

app()->put('/admin/paises/actualizar/{id}', ['name' => 'admin.paises.update', 'AdminController@updateCountry']);

app()->delete('/admin/paises/eliminar/{id}', ['name' => 'admin.paises.delete', 'AdminController@deleteCountry']);

app()->get('/admin/paises/buscar', ['name' => 'admin.paises.search', 'AdminController@searchCountries']);

//VISAS

app()->post('/admin/visas/crear', ['name' => 'admin.visas.create', 'AdminController@createVisa']);

app()->put('/admin/visas/actualizar/{id}', ['name' => 'admin.visas.update', 'AdminController@updateVisa']);

app()->delete('/admin/visas/eliminar/{id}', ['name' => 'admin.visas.delete', 'AdminController@deleteVisa']);

app()->get('/admin/visas/buscar', ['name' => 'admin.visas.search', 'AdminController@searchVisas']);

//VARIABLES

app()->post('/admin/variables/crear', ['name' => 'admin.variables.create', 'AdminController@createVariable']);

app()->put('/admin/variables/actualizar/{id}', ['name' => 'admin.variables.update', 'AdminController@updateVariable']);

app()->delete('/admin/variables/eliminar/{id}', ['name' => 'admin.variables.delete', 'AdminController@deleteVariable']);

//FORMULARIOS

app()->post('/admin/formularios/crear', ['name' => 'admin.formularios.create', 'AdminController@createFormulario']);

app()->put('/admin/formularios/actualizar/{id}', ['name' => 'admin.formularios.update', 'AdminController@updateFormulario']);

app()->delete('/admin/formularios/eliminar/{id}', ['name' => 'admin.formularios.delete', 'AdminController@deleteFormulario']);

//PEDIDOS

app()->put('/admin/pedidos/actualizar/{id}', ['name' => 'admin.order.update', 'AdminController@updateOrder']);

app()->delete('/admin/pedidos/eliminar/{id}', ['name' => 'admin.order.delete', 'AdminController@deleteOrder']);

//LOGIN - LOGOUT

app()->post('/admin/login', ['name' => 'admin.login', 'AdminController@login']);

app()->post('/admin/logout', 'AdminController@logout');

app()->get('/cargar-viajero/{id}', ['name' => 'ui.Viajero', 'ViajeroController@cargarViajero']);

app()->get('/cargar-pasaporte/{id}', ['name' => 'ui.Pasaporte', 'ViajeroController@cargarPasaporte']);

// LIBRO DE RECLAMACIONES

app()->get('/admin/reclamaciones', ['name' => 'admin.reclamaciones.listView', function () {render('admin.reclamaciones.list');}]);

app()->get('/admin/reclamaciones/ver/{id}', ['name' => 'admin.reclamaciones.viewView', function ($id) {render('admin.reclamaciones.view', compact('id'));}]);

app()->get('/admin/reclamaciones/listar', ['name' => 'admin.reclamaciones.list', 'LibroReclamacionController@listarReclamaciones']);

app()->get('/admin/reclamaciones/obtener/{id}', ['name' => 'admin.reclamaciones.get', 'LibroReclamacionController@getReclamacion']);

app()->put('/admin/reclamaciones/responder/{id}', ['name' => 'admin.reclamaciones.responder', 'LibroReclamacionController@responderReclamacion']);

app()->delete('/admin/reclamaciones/eliminar/{id}', ['name' => 'admin.reclamaciones.delete', 'LibroReclamacionController@eliminarReclamacion']);

app()->get('/admin/reclamaciones/exportar-excel', ['name' => 'admin.reclamaciones.exportExcel', 'LibroReclamacionController@exportarExcel']);

app()->get('/admin/reclamaciones/exportar-pdf/{id}', ['name' => 'admin.reclamaciones.exportPDF', 'LibroReclamacionController@exportarPDF']);

app()->put('/admin/reclamaciones/cambiar-estado/{id}', ['name' => 'admin.reclamaciones.cambiarEstado', 'LibroReclamacionController@cambiarEstado']);

// RUTAS DEL BLOG EN EL ÁREA DE ADMINISTRACIÓN

// VISTAS DEL BLOG
app()->get('/admin/blog', ['name' => 'admin.blog.listView', function () {render('admin.blog.list');}]);

app()->get('/admin/blog/agregar', ['name' => 'admin.blog.addView', function () {render('admin.blog.add');}]);

app()->get('/admin/blog/editar/{id}', ['name' => 'admin.blog.editView', 'AdminController@editBlog']);

app()->get('/admin/blog/categorias', ['name' => 'admin.blog.categorias.listView', function () {render('admin.blog.categorias');}]);

app()->get('/admin/blog/tags', ['name' => 'admin.blog.tags.listView', function () {render('admin.blog.tags');}]);

// ENDPOINTS DEL BLOG
app()->post('/admin/blog/crear', ['name' => 'admin.blog.create', 'AdminController@createBlog']);

app()->put('/admin/blog/actualizar/{id}', ['name' => 'admin.blog.update', 'AdminController@updateBlog']);

app()->delete('/admin/blog/eliminar/{id}', ['name' => 'admin.blog.delete', 'AdminController@deleteBlog']);

app()->get('/admin/blog/buscar', ['name' => 'admin.blog.search', 'AdminController@searchBlogs']);

app()->put('/admin/blog/cambiar-estado/{id}', ['name' => 'admin.blog.cambiarEstado', 'AdminController@cambiarEstado']);

app()->post('/admin/blog/upload-image', ['name' => 'admin.blog.uploadImage', 'AdminController@uploadImage']);

// ENDPOINTS PARA CATEGORÍAS DEL BLOG
app()->get('/admin/blog/categorias/listar', ['name' => 'admin.blog.categorias.listar', function() {
    $categorias = \App\Models\BlogCategoria::withCount('blogs as articulos_count')->get();
    return response()->json([
        'status' => 'success',
        'data' => $categorias
    ]);
}]);

app()->post('/admin/blog/categorias/crear', ['name' => 'admin.blog.categorias.create', function() {
    csrf()->validate();
    $data = request()->body();

    // Validar nombre
    if (empty($data['nombre'])) {
        return response()->json([
            'status' => 'error',
            'message' => 'El nombre es obligatorio'
        ], 400);
    }

    // Verificar si ya existe
    if (\App\Models\BlogCategoria::where('nombre', $data['nombre'])->exists()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Ya existe una categoría con este nombre'
        ], 400);
    }

    $categoria = new \App\Models\BlogCategoria();
    $categoria->nombre = $data['nombre'];
    $categoria->descripcion = $data['descripcion'] ?? null;
    $categoria->color = $data['color'] ?? '#667eea';
    $categoria->icono = $data['icono'] ?? null;
    $categoria->activa = isset($data['activa']) ? $data['activa'] : true;
    $categoria->save();

    return response()->json([
        'status' => 'success',
        'message' => 'Categoría creada exitosamente',
        'data' => $categoria
    ]);
}]);

app()->put('/admin/blog/categorias/actualizar/{id}', ['name' => 'admin.blog.categorias.update', function($id) {
    csrf()->validate();
    $data = request()->body();

    $categoria = \App\Models\BlogCategoria::find($id);
    if (!$categoria) {
        return response()->json([
            'status' => 'error',
            'message' => 'Categoría no encontrada'
        ], 404);
    }

    // Validar nombre
    if (empty($data['nombre'])) {
        return response()->json([
            'status' => 'error',
            'message' => 'El nombre es obligatorio'
        ], 400);
    }

    // Verificar si ya existe otro con ese nombre
    if (\App\Models\BlogCategoria::where('nombre', $data['nombre'])->where('id', '!=', $id)->exists()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Ya existe otra categoría con este nombre'
        ], 400);
    }

    $categoria->nombre = $data['nombre'];
    $categoria->descripcion = $data['descripcion'] ?? $categoria->descripcion;
    $categoria->color = $data['color'] ?? $categoria->color;
    $categoria->icono = $data['icono'] ?? $categoria->icono;
    $categoria->activa = isset($data['activa']) ? $data['activa'] : $categoria->activa;
    $categoria->save();

    return response()->json([
        'status' => 'success',
        'message' => 'Categoría actualizada exitosamente',
        'data' => $categoria
    ]);
}]);

app()->get('/admin/blog/categorias/obtener/{id}', ['name' => 'admin.blog.categorias.get', function($id) {
    $categoria = \App\Models\BlogCategoria::find($id);

    if (!$categoria) {
        return response()->json([
            'status' => 'error',
            'message' => 'Categoría no encontrada'
        ], 404);
    }

    return response()->json([
        'status' => 'success',
        'data' => $categoria
    ]);
}]);

app()->delete('/admin/blog/categorias/eliminar/{id}', ['name' => 'admin.blog.categorias.delete', function($id) {
    csrf()->validate();

    $categoria = \App\Models\BlogCategoria::find($id);

    if (!$categoria) {
        return response()->json([
            'status' => 'error',
            'message' => 'Categoría no encontrada'
        ], 404);
    }

    // Opcionalmente, reasignar artículos a una categoría predeterminada o dejarlos sin categoría

    $categoria->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'Categoría eliminada exitosamente'
    ]);
}]);

// ENDPOINTS PARA TAGS
app()->get('/admin/blog/tags/listar', ['name' => 'admin.blog.tags.listar', function() {
    $tags = \App\Models\BlogTag::withCount('blogs as articulos_count')->get();
    return response()->json([
        'status' => 'success',
        'data' => $tags
    ]);
}]);

app()->get('/admin/blog/tags/obtener/{id}', ['name' => 'admin.blog.tags.obtener', function($id) {
    $tag = \App\Models\BlogTag::find($id);

    if (!$tag) {
        return response()->json([
            'status' => 'error',
            'message' => 'Tag no encontrado'
        ], 404);
    }

    return response()->json([
        'status' => 'success',
        'data' => $tag
    ]);
}]);

app()->post('/admin/blog/tags/crear', ['name' => 'admin.blog.tags.crear', function() {
    csrf()->validate();
    $data = request()->body();

    // Validar nombre
    if (empty($data['nombre'])) {
        return response()->json([
            'status' => 'error',
            'message' => 'El nombre es obligatorio'
        ], 400);
    }

    // Verificar si ya existe
    if (\App\Models\BlogTag::where('nombre', $data['nombre'])->exists()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Ya existe un tag con este nombre'
        ], 400);
    }

    $tag = new \App\Models\BlogTag();
    $tag->nombre = $data['nombre'];
    $tag->descripcion = $data['descripcion'] ?? null;
    $tag->uso_contador = 0;
    $tag->save();

    return response()->json([
        'status' => 'success',
        'message' => 'Tag creado exitosamente',
        'data' => $tag
    ]);
}]);

app()->put('/admin/blog/tags/actualizar/{id}', ['name' => 'admin.blog.tags.actualizar', function($id) {
    csrf()->validate();
    $data = request()->body();

    $tag = \App\Models\BlogTag::find($id);
    if (!$tag) {
        return response()->json([
            'status' => 'error',
            'message' => 'Tag no encontrado'
        ], 404);
    }

    // Validar nombre
    if (empty($data['nombre'])) {
        return response()->json([
            'status' => 'error',
            'message' => 'El nombre es obligatorio'
        ], 400);
    }

    // Verificar si ya existe otro con ese nombre
    if (\App\Models\BlogTag::where('nombre', $data['nombre'])->where('id', '!=', $id)->exists()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Ya existe otro tag con este nombre'
        ], 400);
    }

    $tag->nombre = $data['nombre'];
    $tag->descripcion = $data['descripcion'] ?? $tag->descripcion;
    $tag->save();

    return response()->json([
        'status' => 'success',
        'message' => 'Tag actualizado exitosamente',
        'data' => $tag
    ]);
}]);

app()->delete('/admin/blog/tags/eliminar/{id}', ['name' => 'admin.blog.tags.eliminar', function($id) {
    csrf()->validate();

    $tag = \App\Models\BlogTag::find($id);

    if (!$tag) {
        return response()->json([
            'status' => 'error',
            'message' => 'Tag no encontrado'
        ], 404);
    }

    // Eliminar relaciones en la tabla pivote
    db()->query("DELETE FROM blog_tags_relaciones WHERE tag_id = {$tag->id}");

    $tag->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'Tag eliminado exitosamente'
    ]);
}]);

// CORREOS DE PUBLICIDAD
app()->get('/admin/correos-publicidad', ['name' => 'admin.correos.listView', function () {render('admin.correos.list');}]);

// ENDPOINTS PARA CORREOS DE PUBLICIDAD
app()->get('/admin/correos-publicidad/listar', ['name' => 'admin.correos.listar', 'AdminController@listarCorreosPublicidad']);

app()->delete('/admin/correos-publicidad/eliminar/{id}', ['name' => 'admin.correos.eliminar', 'AdminController@eliminarCorreoPublicidad']);

app()->get('/admin/correos-publicidad/exportar', ['name' => 'admin.correos.exportar', 'AdminController@exportarCorreosPublicidad']);

app()->put('/admin/correos-publicidad/marcar-convertido/{id}', ['name' => 'admin.correos.marcarConvertido', 'CorreoPublicidadController@marcarComoConvertido']);

// VISTA PARA GESTIÓN DE AUTORES
app()->get('/admin/blog/autores', ['name' => 'admin.blog.autores.listView', function () {render('admin.blog.autores');}]);

// ENDPOINTS PARA AUTORES DEL BLOG
app()->get('/admin/blog/autores/listar', ['name' => 'admin.blog.autores.listar', function() {
    $autores = \App\Models\BlogAutor::withCount('blogs as articulos_count')->get();
    return response()->json([
        'status' => 'success',
        'data' => $autores
    ]);
}]);

app()->post('/admin/blog/autores/crear', ['name' => 'admin.blog.autores.crear', function() {
    csrf()->validate();
    $data = request()->body();
    $files = request()->files();

    // Validar nombre
    if (empty($data['nombre'])) {
        return response()->json([
            'status' => 'error',
            'message' => 'El nombre es obligatorio'
        ], 400);
    }

    $autor = new \App\Models\BlogAutor();
    $autor->nombre = $data['nombre'];
    $autor->apellido = $data['apellido'] ?? null;
    $autor->correo = $data['correo'] ?? null;
    $autor->bio = $data['bio'] ?? null;
    $autor->puesto = $data['puesto'] ?? null;
    $autor->activo = isset($data['activo']) ? filter_var($data['activo'], FILTER_VALIDATE_BOOLEAN) : true;
    $autor->save();

    // Procesar imagen si existe
    if (isset($files['imagen']) && $files['imagen']['size'] > 0) {
        $autor->subirImagen($files['imagen']);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Autor creado exitosamente',
        'data' => $autor
    ]);
}]);

app()->post('/admin/blog/autores/actualizar/{id}', ['name' => 'admin.blog.autores.actualizar', function($id) {
    csrf()->validate();
    $data = request()->body();
    $files = request()->files();

    $autor = \App\Models\BlogAutor::find($id);
    if (!$autor) {
        return response()->json([
            'status' => 'error',
            'message' => 'Autor no encontrado'
        ], 404);
    }

    // Validar nombre
    if (empty($data['nombre'])) {
        return response()->json([
            'status' => 'error',
            'message' => 'El nombre es obligatorio'
        ], 400);
    }

    $autor->nombre = $data['nombre'];
    $autor->apellido = $data['apellido'] ?? $autor->apellido;
    $autor->correo = $data['correo'] ?? $autor->correo;
    $autor->bio = $data['bio'] ?? $autor->bio;
    $autor->puesto = $data['puesto'] ?? $autor->puesto;
    $autor->activo = isset($data['activo']) ? filter_var($data['activo'], FILTER_VALIDATE_BOOLEAN) : $autor->activo;
    $autor->save();

    // Procesar imagen si existe
    if (isset($files['imagen']) && $files['imagen']['size'] > 0) {
        $autor->subirImagen($files['imagen']);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Autor actualizado exitosamente',
        'data' => $autor
    ]);
}]);

app()->get('/admin/blog/autores/obtener/{id}', ['name' => 'admin.blog.autores.obtener', function($id) {
    $autor = \App\Models\BlogAutor::find($id);

    if (!$autor) {
        return response()->json([
            'status' => 'error',
            'message' => 'Autor no encontrado'
        ], 404);
    }

    return response()->json([
        'status' => 'success',
        'data' => $autor
    ]);
}]);

app()->delete('/admin/blog/autores/eliminar/{id}', ['name' => 'admin.blog.autores.eliminar', function($id) {
    csrf()->validate();

    $autor = \App\Models\BlogAutor::find($id);
    if (!$autor) {
        return response()->json([
            'status' => 'error',
            'message' => 'Autor no encontrado'
        ], 404);
    }

    // Actualizar artículos de este autor para eliminar la referencia
    $articulos = \App\Models\Blog::where('autor_id', $id)->get();
    foreach ($articulos as $articulo) {
        $articulo->autor_id = null;
        $articulo->save();
    }

    $autor->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'Autor eliminado exitosamente'
    ]);
}]);

app()->get('/{slug}', ['name' => 'blog.show', 'BlogController@show']);
