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
            <form class="register-form" id="registerForm">
                {{ csrf()->form() }}
                <h4>Regístrate</h4>
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre">
                <label for="apellidos">Apellidos</label>
                <input type="text" name="apellidos">
                <label for="email">E-Mail Address</label>
                <input type="text" name="email">
                <label for="contraseña">Contraseña</label>
                <input type="password" name="contraseña">
                <label for="contraseña-confirm">Confirm Password</label>
                <input type="password" name="contraseña-confirm">
                <button class="apply-now-btn" type="submit">Registrate</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById("registerForm").addEventListener("submit", function(event) {
            event.preventDefault();
    
            const formData = new FormData(event.target);
            const data = Object.fromEntries(formData.entries());
    
            fetch("/register", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json().then(json => ({ status: response.status, body: json }))) 
            .then(result => {
                if (result.status === 201) {
                    console.log("✅ Usuario registrado:", result.body);
                    alert("✅ Usuario registrado exitosamente");
                    window.location.href = "/iniciar-sesion"; 
                } else {
                    console.error("❌ Error al registrarse:", result.body);
                    alert(`❌ Error: ${result.body.message}`);
                }
            })
            .catch(error => {
                console.error("❌ Error inesperado:", error);
                alert("❌ Ocurrió un error inesperado. Revisa la consola para más detalles.");
            });
        });
    </script>

    <link href="{{ assets('css/register.css') }}" rel="stylesheet">
@endsection