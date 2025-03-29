@extends('layouts.public')
@section('title', 'Visa')

@push('resources')
    <link href="{{ assets('css/login.css') }}" rel="stylesheet">
@endpush

@section('content')
    @php
        if (session()->has('pedido_visa')) {
            redirect('/pedido');
        }
    @endphp
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
                    <label for="password">Contraseña</label>
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
                <div class="alert invalid-email">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Invalid email address</span>
                </div>
                <div class="alert error-email">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>There is no account associated with that email address</span>
                </div>
                <div class="alert invalid-number">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>There is no account associated with that order number</span>
                </div>
                <p class="register-text">¿No tienes una cuenta? <br class="salto"> <a
                        href="{{route('registrarse')}}">Regístrate gratis</a></p>
            </form>
        </div>
    </div>
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <div class="modal-icon">
                <img src="https://cdn-icons-png.flaticon.com/512/564/564619.png" alt="Error Icon">
            </div>
            <h2>Error</h2>
            <p class="msg-error">Email address is valid but your password is wrong. We have sent you an automatic login link
                to your email</p>
            <button class="close-btn" onclick="closeModal('errorModal')">Cerrar</button>
        </div>
    </div>
    <div id="invalidModal" class="modal">
        <div class="modal-content">
            <div class="modal-icon">
                <img src="https://cdn-icons-png.flaticon.com/512/564/564619.png" alt="Error Icon">
            </div>
            <h2>Error</h2>
            <p class="msg-error">There is no account associated with that email address</p>
            <button class="close-btn" onclick="closeModal('invalidModal')">Cerrar</button>
        </div>
    </div>

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
            const error_email = document.querySelector(".error-email");
            const invalid_email = document.querySelector(".invalid-email");
            const invalid_number = document.querySelector(".invalid-number");

            // Verificar si es una cadena de números
            const isEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

            if (!isEmail) {
                console.log("✅ Entrada detectada como número válido:", email);
                fetch("order-check", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: JSON.stringify({ email: email })
                })
                    .then(response => response.json().then(data => ({ status: response.status, body: data })))
                    .then(result => {
                        if (result.status === 200 && result.body.redirect) {
                            window.location.href = result.body.redirect; // Redirigir a la nueva vista
                        } else if (result.status === 402) {
                            console.error("❌ ", result.body.message);
                            invalid_number.style.display = "flex";
                            error_email.style.display = "none";
                            invalid_email.style.display = "none";
                        } else {
                            console.error("❌ Error desconocido:", result.body);
                            alert("❌ Error inesperado, intenta nuevamente.");
                        }
                    })
                    .catch(error => {
                        console.error("❌ Error inesperado:", error);
                        alert("❌ Ocurrió un error inesperado.");
                    });
            } else {
                fetch("login-check", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: JSON.stringify({ email: email })
                })
                    .then(response => response.json().then(data => ({ status: response.status, body: data }))) // Convertir en JSON y capturar el código de estado
                    .then(result => {
                        if (result.status === 200) {
                            console.log("✅ Correo validado:", result.body.message);
                            passwordContainer.style.display = "block";
                            continuarBtn.style.display = "none";
                            invalid_email.style.display = "none";
                            error_email.style.display = "none";
                            invalid_number.style.display = "none";
                        } else if (result.status === 400) {
                            console.error("❌ ", result.body.message);
                            invalid_email.style.display = "flex";
                            error_email.style.display = "none";
                            invalid_number.style.display = "none";
                        } else if (result.status === 401) {
                            console.error("❌ ", result.body.message);
                            error_email.style.display = "flex";
                            invalid_email.style.display = "none";
                            invalid_number.style.display = "none";
                        } else {
                            console.error("❌ Error desconocido:", result.body);
                            alert("❌ Error inesperado, intenta nuevamente.");
                        }
                    })
                    .catch(error => {
                        console.error("❌ Error inesperado:", error);
                        alert("❌ Ocurrió un error inesperado. Revisa la consola para más detalles.");
                    });
            }
        }

        document.getElementById("loginForm").addEventListener("submit", function (event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const data = Object.fromEntries(formData.entries());
            const email = document.getElementById('email').value;
            const isEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

            if (isEmail) {
                fetch("/login", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data)
                })
                    .then(response => response.json().then(data => ({ status: response.status, body: data }))) // Convertir en JSON y capturar el código de estado
                    .then(result => {
                        if (result.status === 200) {
                            console.log("✅ Sesión iniciada correctamente");
                            window.location.href = "/account";
                        } else if (result.status === 400) {
                            //alert("❌ Error: " + result.body.message);
                            document.getElementById("invalidModal").style.display = "flex";
                        } else if (result.status === 401) {
                            //alert("❌ Error: " + result.body.message);
                            document.getElementById("errorModal").style.display = "flex";
                        } else {
                            console.error("❌ Error desconocido:", result.body);
                            alert("❌ Error inesperado, intenta nuevamente.");
                        }
                    })
                    .catch(error => {
                        console.error("❌ Error inesperado: ", error);
                        alert("❌ Ocurrió un error inesperado. Revisa la consola para más detalles.");
                    });
            }
        });

        function closeModal(modal) {
            document.getElementById(modal).style.display = "none";
        }

    </script>
@endsection