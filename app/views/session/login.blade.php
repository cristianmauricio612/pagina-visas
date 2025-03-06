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
            <form class="login-form" id="loginForm">
                {{ csrf()->form() }}
                <h4>Bienvenido nuevamente</h4>
                <p>Comprueba el estado de tu pedido o inicia sesión</p>
                <label for="email">Número de pedido o correo electrónico</label>
                <input type="text" id="email" name="email" placeholder="1234567 o tú@email.com" required>
                <div class="password-container">
                    <label for="contraseña">Contraseña</label>
                    <div class="password-wrapper">
                        <input class="txt-contraseña" type="password" id="password" name="contraseña" required>
                        <span class="toggle-password">
                            <i class="fa-solid fa-eye" alt="Mostrar contraseña" id="eye-icon"></i>
                        </span>
                    </div>
                    <div class="forgetpassword-link">
                        <a href="{{route('registrarse')}}">¿Has olvidado la contraseña?</a>
                    </div>
                    <div class="forgetpassword-link">
                        <a href="{{route('registrarse')}}">Consigue un enlace de acceso sin contraseña</a>
                    </div>

                    <button class="iniciar-sesion-btn" type="submit">Iniciar Sesion</button>
                </div>
                <button class="continuar-btn" onclick="checkLogin()">Continuar</button>
                <p class="register-text">¿No tienes una cuenta? <br class="salto"> <a
                        href="{{route('registrarse')}}">Regístrate gratis</a></p>
            </form>
        </div>
    </div>
    <link href="{{ assets('css/login.css') }}" rel="stylesheet">
    <script>
        const csrfToken = "{{ csrf()->token() }}";
        document.addEventListener("DOMContentLoaded", function () {
            const passwordInput = document.getElementById("password");
            const eyeIcon = document.getElementById("eye-icon");

            eyeIcon.addEventListener("click", function () {
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    eyeIcon.className = "fa-solid fa-eye-slash"; // Cambia el ícono al de "ocultar"
                } else {
                    passwordInput.type = "password";
                    eyeIcon.className = "fa-solid fa-eye"; // Vuelve al ícono de "mostrar"
                }
            });
        });

        function checkLogin() {
            const email = document.getElementById('email').value;
            const continuarBtn = document.querySelector(".continuar-btn");
            const passwordContainer = document.querySelector(".password-container");

            fetch("login-check", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    console.log("✅ Correo validado:", data.message);
                    // Mostrar el contenedor de contraseña
                    passwordContainer.style.display = "block";

                    // Ocultar el botón de continuar
                    continuarBtn.style.display = "none";

                } else {
                    console.error("❌ Error al validar correo:", data.message);
                    alert(`❌ Error: ${data.message}`);
                }
            })
            .catch(error => {
                console.error("❌ Error inesperado:", error);
                alert("❌ Ocurrió un error inesperado. Revisa la consola para más detalles.");
            });
        }

        document.getElementById("loginForm").addEventListener("submit", function (event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const data = Object.fromEntries(formData.entries());

            fetch("/login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(result => {
                    if (result.status === "success") {
                        alert("✅ Sesión iniciada correctamente");
                        window.location.href = "/account"; 
                    } else {
                        alert("❌ Error: " + result.message);
                    }
                })
                .catch(error => {
                    console.error("❌ Error inesperado: ", error);
                    alert("❌ Ocurrió un error inesperado. Revisa la consola para más detalles.");
                });
        });
    </script>
@endsection