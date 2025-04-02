<?php

use App\Models\VisaInscripcion;

app()->get('/', function () {
    /**
     * `render(view, [])` is the same as `echo view(view, [])`
     */
    render('index');
});

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

/*app()->post('/api/izipay/response', ['name' => 'izipay-response', 'VisaInscripcionController@processPayment']);*/
app()->get('/api/izipay/response', 'VisaInscripcionController@processPayment');
app()->post('/api/izipay/response', 'VisaInscripcionController@processPayment');

app()->get('/pago-exitoso', ['name' => 'pago-exitoso', function () {render('pagos.exito');}]);

app()->get('/pago-fallido', ['name' => 'pago-fallido', function () {render('pagos.error');}]);

app()->get('/limpiar-pedidos', function () {
    VisaInscripcion::limpiarPedidosPendientes(); 
    return response()->json(["message" => "Pedidos pendientes eliminados"]);
});

app()->post('/contact-mail', 'MailController@contactEmail');

//VISTAS ADMIN

app()->get('/admin/home', ['name' => 'admin.homeView', function () {render('admin.home');}]);

app()->get('/admin/paises', ['name' => 'admin.paises.listView', function () {render('admin.paises.list');}]);

app()->get('/admin/paises/agregar', ['name' => 'admin.paises.addView', function () {render('admin.paises.add');}]);

app()->get('/admin/pedidos', ['name' => 'admin.pedidos.listView', function () {render('admin.pedidos.list');}]);

app()->get('/admin/pedidos/agregar', ['name' => 'admin.pedidos.addView', function () {render('admin.pedidos.add');}]);

app()->get('/admin/usuarios', ['name' => 'admin.usuarios.listView', function () {render('admin.usuarios.list');}]);

app()->get('/admin/usuarios/agregar', ['name' => 'admin.usuarios.addView', function () {render('admin.usuarios.add');}]);

app()->get('/admin/usuarios/editar/{id}', ['name' => 'admin.usuarios.editView', 'AdminController@editUser']);

app()->get('/admin/visas', ['name' => 'admin.visas.listView', function () {render('admin.visas.list');}]);

app()->get('/admin/visas/agregar', ['name' => 'admin.visas.addView', function () {render('admin.visas.add');}]);

app()->get('/admin/visas/editar/{id}', ['name' => 'admin.visas.editView', 'AdminController@editVisa']);

/* RUTAS DEL ADMINISTRADOR */

//USUARIOS

app()->put('/admin/usuarios/actualizar/{id}', ['name' => 'admin.usuarios.update', 'AdminController@updateUser']);

app()->delete('/admin/usuarios/eliminar/{id}', ['name' => 'admin.usuarios.delete', 'AdminController@deleteUser']);

app()->get('/admin/usuarios/buscar', ['name' => 'admin.usuarios.search', 'AdminController@searchUsers']);

//PAISES

app()->post('/admin/paises/crear', ['name' => 'admin.paises.create', 'AdminController@createCountry']);

app()->delete('/admin/paises/eliminar/{id}', ['name' => 'admin.paises.delete', 'AdminController@deleteCountry']);

app()->get('/admin/paises/buscar', ['name' => 'admin.paises.search', 'AdminController@searchCountries']);

//VISAS

app()->post('/admin/visas/crear', ['name' => 'admin.visas.create', 'AdminController@createVisa']);

app()->put('/admin/visas/actualizar/{id}', ['name' => 'admin.visas.update', 'AdminController@updateVisa']);

app()->delete('/admin/visas/eliminar/{id}', ['name' => 'admin.visas.delete', 'AdminController@deleteVisa']);

app()->get('/admin/visas/buscar', ['name' => 'admin.visas.search', 'AdminController@searchVisas']);
