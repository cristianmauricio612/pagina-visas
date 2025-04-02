@extends('layouts.admin')
@section('title', 'Admin | Editar Visa')

@section('content')
    {{-- Botón para abrir el Sidebar (Solo en esta vista) --}}
    <button id="openSidebar" class="fixed top-4 left-4 bg-gray-900 text-white w-10 h-10 flex items-center justify-center rounded-md text-lg lg:hidden shadow-md">
        <i class="fas fa-bars"></i>
    </button>

    <div class="py-6">
        {{-- Título --}}
        <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4 text-center md:text-left">
            Editar Visa
        </h1>

        {{-- Formulario --}}
        <div class="bg-white p-6 rounded-lg shadow-md border max-w-3xl mx-auto">
            <form id="updateVisaForm">
                @csrf
                
                {{-- País 1 --}}
                <div class="mb-4">
                    <label for="pais1_id" class="block text-gray-700 font-semibold mb-2">País 1</label>
                    <select name="pais1_id" id="pais1_id" class="p-2 border rounded w-full" required>
                        <option value="">Selecciona un pais</option>
                        @foreach(\App\Models\Pais::all() as $pais)
                            <option value="{{ $pais->id }}" @selected($visa->pais1_id == $pais->id)>{{ $pais->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- País 2 --}}
                <div class="mb-4">
                    <label for="pais2_id" class="block text-gray-700 font-semibold mb-2">País 2</label>
                    <select name="pais2_id" id="pais2_id" class="p-2 border rounded w-full" required>
                        <option value="">Selecciona un pais</option>
                        @foreach(\App\Models\Pais::all() as $pais)
                            <option value="{{ $pais->id }}" @selected($visa->pais2_id == $pais->id)>{{ $pais->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Nombre de la visa --}}
                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700 font-semibold mb-2">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="p-2 border rounded w-full" value="{{$visa->nombre}}" required>
                </div>

                {{-- Tiempo de Validez --}}
                <div class="mb-4">
                    <label for="tiempo_validez" class="block text-gray-700 font-semibold mb-2">Tiempo de Validez</label>
                    <input type="text" name="tiempo_validez" id="tiempo_validez" class="p-2 border rounded w-full" value="{{$visa->tiempo_validez}}" placeholder="Ejemplo: 2 dias - meses - años" required>
                </div>

                {{-- Número de Entradas --}}
                <div class="mb-4">
                    <label for="numero_entradas" class="block text-gray-700 font-semibold mb-2">Número de Entradas</label>
                    <input type="text" name="numero_entradas" id="numero_entradas" class="p-2 border rounded w-full" value="{{$visa->numero_entradas}}" placeholder="Ejemplo: Entrada multiple" required>
                </div>

                {{-- Estancia Máxima --}}
                <div class="mb-4">
                    <label for="estancia_maxima" class="block text-gray-700 font-semibold mb-2">Estancia Máxima</label>
                    <input type="text" name="estancia_maxima" id="estancia_maxima" class="p-2 border rounded w-full" value="{{$visa->estancia_maxima}}" placeholder="Ejemplo: 2 dias - meses - años" required>
                </div>

                {{-- Necesita Visa --}}
                <div class="mb-4">
                    <label for="necesita_visa" class="block text-gray-700 font-semibold mb-2">¿Necesita Visa?</label>
                    <select name="necesita_visa" id="necesita_visa" class="p-2 border rounded w-full" required>
                        <option value="">Selecciona una opción</option>
                        <option value="1" @selected($visa->necesita_visa == "1")>Sí</option>
                        <option value="0" @selected($visa->necesita_visa == "0")>No</option>
                    </select>
                </div>

                {{-- Precio --}}
                <div class="mb-4">
                    <label for="precio" class="block text-gray-700 font-semibold mb-2">Precio (MXN)</label>
                    <input type="number" step="0.01" name="precio" id="precio" class="p-2 border rounded w-full" value="{{$visa->precio}}" placeholder="00.00" required>
                </div>

                {{-- Tasa de Gobierno --}}
                <div class="mb-4">
                    <label for="tasa_gobierno" class="block text-gray-700 font-semibold mb-2">Tasa de Gobierno (MXN)</label>
                    <input type="number" step="0.01" name="tasa_gobierno" id="tasa_gobierno" class="p-2 border rounded w-full" value="{{$visa->tasa_gobierno}}" placeholder="00.00" required>
                </div>

                {{-- Botón de envío --}}
                <div class="flex justify-between">
                    <a href="{{ route('admin.visas.listView') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 button-update" data-id="{{$visa->id}}">
                        Actualizar Visa
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script para abrir el Sidebar --}}
    <script>
        document.getElementById('openSidebar').addEventListener('click', function () {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            this.classList.add('hidden'); // Oculta el botón de abrir
        });

        document.getElementById("updateVisaForm").addEventListener("submit", function (event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const data = Object.fromEntries(formData.entries());
            let id = $(".button-update").data("id");

            fetch("/admin/visas/actualizar/" + id, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json().then(json => ({ status: response.status, body: json })))
                .then(result => {
                    if (result.status === 200) {
                        console.log("✅ Visa actualizada:", result.body);
                        alert("✅ Visa actualizada exitosamente");
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else {
                        console.error("❌ Error al actualizar visa:", result.body);
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