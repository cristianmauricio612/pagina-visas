@extends('layouts.public')
@section('title', 'Visa')

@push('resources')
    <link href="{{ assets('css/security-privacy.css') }}" rel="stylesheet">
@endpush

@section('content')
    @php
        $usuario = session()->get('usuario');
        if(!$usuario){
            redirect('/iniciar-sesion');
        }
    @endphp
    <div class="main-container">
        <div class="info-visa-container">
            <div class="return-page">
                <div class="small-title-page">
                    <a class="inicio-link" href="/">
                        <span>Inicio</span>
                    </a>
                    <span> > </span>
                    <a class="inicio-link" href="/account">
                        <span>Mi cuenta</span>
                    </a>
                    <span> > </span>
                    <b>Seguridad y privacidad</b>
                </div>
            </div>
            <div class="saludo">
                <span>Hola {{$usuario['nombre']}}</span>
            </div>

        </div>

        <div class="editar-container">
            <a href="/account" class="back-link">← Mi cuenta</a>
            <h2>Seguridad y privacidad</h2>
            <hr>
            <form id="updatePasswordForm">
                {{ csrf()->form() }}
                <label for="contraseña">Contraseña</label>
                <div class="password-wrapper">
                    <input class="txt-contraseña password" type="password" name="contraseña" placeholder="Nueva contraseña"
                        required>
                    <span class="toggle-password">
                        <i class="fa-solid fa-eye eye-icon" alt="Mostrar contraseña"></i>
                    </span>
                </div>

                <label for="contraseña-repeat">Repite contraseña</label>
                <div class="password-wrapper">
                    <input class="txt-contraseña password" type="password" name="contraseña-repeat" placeholder="Contraseña"
                        required>
                    <span class="toggle-password">
                        <i class="fa-solid fa-eye eye-icon" alt="Mostrar contraseña"></i>
                    </span>
                </div>

                <div class="btn-container">
                    <button class="btn-guardar" data-id="{{$usuario['id']}}" type="submit">Guardar contraseña</button>
                </div>
            </form>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".password-wrapper").forEach(container => {
                const passwordInput = container.querySelector(".password");
                const eyeIcon = container.querySelector(".eye-icon");

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
        });

        document.getElementById("updatePasswordForm").addEventListener("submit", function (event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const data = Object.fromEntries(formData.entries());
            let id = document.querySelector(".btn-guardar").getAttribute("data-id");

            fetch("/account/seguridad-privacidad/actualizar/" + id, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json().then(json => ({ status: response.status, body: json })))
                .then(result => {
                    if (result.status === 200) {
                        console.log("✅ Usuario actualizado:", result.body);
                        alert("✅ Usuario actualizado exitosamente");
                        window.location.href = "/account";
                    } else {
                        console.error("❌ Error al actualizar usuario:", result.body);
                        alert(`❌ Error: ${result.body.message}`);
                    }
                })
                .catch(error => {
                    console.error("❌ Error inesperado:", error);
                    alert("❌ Ocurrió un error inesperado. Revisa la consola para más detalles.");
                });
        });
    </script>

@endsection