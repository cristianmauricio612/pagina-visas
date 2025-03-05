@extends('layouts.public')
@section('title', 'Visa')

@section('content')

    <div class="main-container">
        <div class="login-container">
            <div class="login-image">
                <img data-src="https://d1bfs3rtmjstvi.cloudfront.net/img/login-lady-airport.webp" alt="Iniciar sesión"
                    class="image entered loaded" data-ll-status="loaded"
                    src="https://d1bfs3rtmjstvi.cloudfront.net/img/login-lady-airport.webp">
            </div>
            <form class="login-form">
                <h4>Bienvenido nuevamente</h4>
                <p>Comprueba el estado de tu pedido o inicia sesión</p>
                <label for="email">Número de pedido o correo electrónico</label>
                <input type="text" name="email" placeholder="1234567 o tú@email.com">
                <button class="apply-now-btn" type="submit">Continuar</button>
                <p class="register-text">¿No tienes una cuenta? <br class="salto"> <a href="{{route('register')}}">Regístrate gratis</a></p>
            </form>
        </div>
    </div>
    <link href="{{ assets('css/login.css') }}" rel="stylesheet">
@endsection