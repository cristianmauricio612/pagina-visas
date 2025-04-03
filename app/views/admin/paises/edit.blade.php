@extends('layouts.admin')
@section('title', 'Admin | Agregar pais')

@section('content')
    {{-- Botón para abrir el Sidebar (Solo en esta vista) --}}
    <button id="openSidebar" class="fixed top-4 left-4 bg-gray-900 text-white w-10 h-10 flex items-center justify-center rounded-md text-lg lg:hidden shadow-md">
        <i class="fas fa-bars"></i>
    </button>

    <div class="py-6 max-w-lg mx-auto">
        {{-- Título --}}
        <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4 text-center md:text-left">
            Editar País
        </h1>

        {{-- Formulario --}}
        <form id="updatePaisForm" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            @csrf

            {{-- Nombre del país --}}
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 font-medium">Nombre del país</label>
                <input type="text" id="nombre" name="nombre" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{$pais->nombre}}" required>
            </div>

            {{-- Imagen --}}
            <div class="mb-4">
                <label for="imagen" class="block text-gray-700 font-medium">Imagen</label>
                <input type="file" id="floatingFile" accept="image/*" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="hidden" id="imageBase64" name="imagen">
            </div>

            {{-- Botones --}}
            <div class="flex justify-between">
                <a href="{{ route('admin.paises.listView') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 button-update" data-id="{{$pais->id}}">
                    Guardar
                </button>
            </div>
        </form>
    </div>

    {{-- Script para abrir el Sidebar --}}
    <script>
        document.getElementById('openSidebar').addEventListener('click', function () {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            this.classList.add('hidden');
        });

        document.getElementById("floatingFile").addEventListener("change", function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Guardar la imagen en base64 en un campo oculto
                    document.getElementById("imageBase64").value = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById("updatePaisForm").addEventListener("submit", function (event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const data = Object.fromEntries(formData.entries());
            let id = $(".button-update").data("id");

            fetch("/admin/paises/actualizar/" + id, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json().then(json => ({ status: response.status, body: json })))
                .then(result => {
                    if (result.status === 200) {
                        console.log("✅ País actualizado:", result.body);
                        alert("✅ País actualizado exitosamente");
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else {
                        console.error("❌ Error al actualizar pais:", result.body);
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