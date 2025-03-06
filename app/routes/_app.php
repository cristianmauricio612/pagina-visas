<?php

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

app()->get('/estados-unidos/p/esta', ['name' => 'kenia-e-visa', function () {render('articles.estados-unidos-p-esta');}]);

//SESSION

app()->get('/iniciar-sesion', ['name' => 'login', function () {render('session.login');}]);

app()->get('/registrarse', ['name' => 'register', function () {render('session.register');}]);

app()->get('/visas/{pais1}/{pais2}/{posicion}', ['name' => 'visas', 'VisaController@getVisasByPaises']);

app()->get('/visa-inscripcion/{id}', ['name' => 'visa-inscripcion', 'VisaController@getVisaById']);

app()->get('/pago/{id}', ['name' => 'pago', 'VisaInscripcionController@createVisaInscripcion']);
