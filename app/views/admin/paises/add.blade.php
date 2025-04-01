@extends('layouts.admin')
@section('title', 'Admin | Agregar pais')

@section('content')
    {{-- Botón para abrir el Sidebar (Solo en esta vista) --}}
    <button id="openSidebar" class="fixed top-4 left-4 bg-gray-900 text-white w-10 h-10 flex items-center justify-center rounded-md text-lg lg:hidden shadow-md">
        <i class="fas fa-bars"></i>
    </button>

    <div class="p-6 max-w-lg mx-auto">
        {{-- Título --}}
        <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4 text-center md:text-left">
            Agregar País
        </h1>

        {{-- Formulario --}}
        <form action="" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            @csrf

            {{-- Nombre del país --}}
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 font-medium">Nombre del país</label>
                <input type="text" id="nombre" name="nombre" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            {{-- Imagen --}}
            <div class="mb-4">
                <label for="imagen" class="block text-gray-700 font-medium">Imagen</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Botones --}}
            <div class="flex justify-between">
                <a href="{{ route('admin.paises.listView') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
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
    </script>
@endsection