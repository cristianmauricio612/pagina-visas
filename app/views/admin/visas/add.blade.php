@extends('layouts.admin')
@section('title', 'Admin | Agregar Visa')

@section('content')
    {{-- Botón para abrir el Sidebar (Solo en esta vista) --}}
    <button id="openSidebar" class="fixed top-4 left-4 bg-gray-900 text-white w-10 h-10 flex items-center justify-center rounded-md text-lg lg:hidden shadow-md">
        <i class="fas fa-bars"></i>
    </button>

    <div class="py-6">
        {{-- Título --}}
        <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4 text-center md:text-left">
            Agregar Nueva Visa
        </h1>

        {{-- Formulario --}}
        <div class="bg-white p-6 rounded-lg shadow-md border max-w-3xl mx-auto">
            <form action="" method="POST">
                @csrf
                
                {{-- País 1 --}}
                <div class="mb-4">
                    <label for="pais1_id" class="block text-gray-700 font-semibold mb-2">País 1</label>
                    <select name="pais1_id" id="pais1_id" class="p-2 border rounded w-full">
                        @foreach(\App\Models\Pais::all() as $pais)
                            <option value="{{ $pais->id }}">{{ $pais->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- País 2 --}}
                <div class="mb-4">
                    <label for="pais2_id" class="block text-gray-700 font-semibold mb-2">País 2</label>
                    <select name="pais2_id" id="pais2_id" class="p-2 border rounded w-full">
                        @foreach(\App\Models\Pais::all() as $pais)
                            <option value="{{ $pais->id }}">{{ $pais->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Nombre de la visa --}}
                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700 font-semibold mb-2">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="p-2 border rounded w-full" required>
                </div>

                {{-- Tiempo de Validez --}}
                <div class="mb-4">
                    <label for="tiempo_validez" class="block text-gray-700 font-semibold mb-2">Tiempo de Validez</label>
                    <input type="text" name="tiempo_validez" id="tiempo_validez" class="p-2 border rounded w-full" required>
                </div>

                {{-- Número de Entradas --}}
                <div class="mb-4">
                    <label for="numero_entradas" class="block text-gray-700 font-semibold mb-2">Número de Entradas</label>
                    <input type="number" name="numero_entradas" id="numero_entradas" class="p-2 border rounded w-full" required>
                </div>

                {{-- Estancia Máxima --}}
                <div class="mb-4">
                    <label for="estancia_maxima" class="block text-gray-700 font-semibold mb-2">Estancia Máxima</label>
                    <input type="text" name="estancia_maxima" id="estancia_maxima" class="p-2 border rounded w-full" required>
                </div>

                {{-- Necesita Visa --}}
                <div class="mb-4">
                    <label for="necesita_visa" class="block text-gray-700 font-semibold mb-2">¿Necesita Visa?</label>
                    <select name="necesita_visa" id="necesita_visa" class="p-2 border rounded w-full">
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </select>
                </div>

                {{-- Precio --}}
                <div class="mb-4">
                    <label for="precio" class="block text-gray-700 font-semibold mb-2">Precio (MXN)</label>
                    <input type="number" step="0.01" name="precio" id="precio" class="p-2 border rounded w-full" required>
                </div>

                {{-- Tasa de Gobierno --}}
                <div class="mb-4">
                    <label for="tasa_gobierno" class="block text-gray-700 font-semibold mb-2">Tasa de Gobierno (MXN)</label>
                    <input type="number" step="0.01" name="tasa_gobierno" id="tasa_gobierno" class="p-2 border rounded w-full" required>
                </div>

                {{-- Botón de envío --}}
                <div class="flex justify-between">
                    <a href="{{ route('admin.visas.listView') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        Guardar Visa
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
    </script>
@endsection