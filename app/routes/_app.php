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

app()->get('/kenia/p/e-visa', ['name' => 'kenia-e-visa', function () {render('articles.kenia-e-visa');}]);

//SESSION

app()->get('/iniciar-sesion', ['name' => 'login', function () {render('session.login');}]);

app()->get('/registrarse', ['name' => 'register', function () {render('session.register');}]);

