@extends('layouts.public')
@section('title', 'Visa')

@section('content')

    <div class="main-container">
        <div class="register-container">
            <div class="register-image">
                <img data-src="https://d1bfs3rtmjstvi.cloudfront.net/img/login-lady-airport.webp" alt="Iniciar sesión"
                    class="image entered loaded" data-ll-status="loaded"
                    src="https://d1bfs3rtmjstvi.cloudfront.net/img/login-lady-airport.webp">
            </div>
            <form class="register-form">
                <h4>Regístrate</h4>
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre">
                <label for="apellidos">Apellidos</label>
                <input type="text" name="apellidos">
                <label for="email">E-Mail Address</label>
                <input type="text" name="email">
                <label for="contraseña">Contraseña</label>
                <input type="text" name="contraseña">
                <label for="contraseña-confirm">Confirm Password</label>
                <input type="text" name="contraseña-confirm">
                <button class="apply-now-btn" type="submit">Registrate</button>
            </form>
        </div>
    </div>
    <link href="{{ assets('css/register.css') }}" rel="stylesheet">
@endsection