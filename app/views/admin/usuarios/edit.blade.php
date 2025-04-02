@extends('layouts.admin')
@section('title', 'Admin | Editar usuario')

@section('content')
    {{-- Botón para abrir el Sidebar (Solo en esta vista) --}}
    <button id="openSidebar"
        class="fixed top-4 left-4 bg-gray-900 text-white w-10 h-10 flex items-center justify-center rounded-md text-lg lg:hidden shadow-md">
        <i class="fas fa-bars"></i>
    </button>

    <div class="py-6 max-w-lg mx-auto">
        {{-- Título --}}
        <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4 text-center md:text-left">
            Editar Usuario
        </h1>

        {{-- Formulario --}}
        <form id="updateUserForm" class="bg-white p-6 rounded-lg shadow-md">
            @csrf

            {{-- Nombre --}}
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 font-medium">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{$user->nombre}}"
                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            {{-- Apellido --}}
            <div class="mb-4">
                <label for="apellidos" class="block text-gray-700 font-medium">Apellido</label>
                <input type="text" id="apellidos" name="apellidos" value="{{$user->apellido}}"
                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            {{-- Correo --}}
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium">Correo</label>
                <input type="email" id="email" name="email" value="{{$user->email}}"
                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            {{-- Contraseña --}}
            <div class="mb-4">
                <label for="contraseña" class="block text-gray-700 font-medium">Contraseña</label>
                <input type="password" id="contraseña" name="contraseña" value=""
                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="contraseña-confirm" class="block text-gray-700 font-medium">Confirmar Contraseña</label>
                <input type="password" id="contraseña-confirm" name="contraseña-confirm" value=""
                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Botones --}}
            <div class="flex justify-between">
                <a href="{{ route('admin.usuarios.listView') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 button-update" data-id="{{$user->id}}">
                    Actualizar
                </button>
            </div>
        </form>
    </div>

    {{-- Script para abrir el Sidebar --}}
    <script>
        document.getElementById('openSidebar').addEventListener('click', function () {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            this.classList.add('hidden'); // Oculta el botón de abrir
        });

        document.getElementById("updateUserForm").addEventListener("submit", function (event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const data = Object.fromEntries(formData.entries());
            let id = $(".button-update").data("id");

            fetch("/admin/usuarios/actualizar/" + id, {
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
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
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