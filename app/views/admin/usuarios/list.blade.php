@extends('layouts.admin')
@section('title', 'Admin | Listar usuarios')

@section('content')
    @php
        $usuarios = \App\Models\User::all(); // Obtener todos los usuarios
    @endphp

    {{-- Botón para abrir el Sidebar (Solo en esta vista) --}}
    <button id="openSidebar" class="fixed top-4 left-4 bg-gray-900 text-white w-10 h-10 flex items-center justify-center rounded-md text-lg lg:hidden shadow-md">
        <i class="fas fa-bars"></i>
    </button>

    <div class="py-6">
        {{-- Título --}}
        <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4 text-center md:text-left">
            Gestión de Usuarios
        </h1>

        {{-- Buscador y Botón Agregar --}}
        <div class="flex flex-col md:flex-row justify-between mb-6 gap-4">
            <input type="text" id="search" placeholder="Buscar usuario..." class="p-2 border rounded w-full md:w-1/3">
            <a href="{{ route('admin.usuarios.addView') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Agregar Usuario
            </a>
        </div>

        {{-- Contenedor con scroll horizontal y vertical --}}
        <div class="w-full max-w-[100%] max-h-[600px] overflow-y-auto overflow-x-auto border rounded-lg">
            <table class="w-full md:min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left w-12">ID</th>
                        <th class="py-2 px-4 text-left w-48">Nombre</th>
                        <th class="py-2 px-4 text-left w-48">Apellido</th>
                        <th class="py-2 px-4 text-left w-48">Correo</th>
                        <th class="py-2 px-4 text-left w-32">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($usuarios as $usuario)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-2 px-4">{{ $usuario->id }}</td>
                            <td class="py-2 px-4">{{ $usuario->nombre }}</td>
                            <td class="py-2 px-4">{{ $usuario->apellido }}</td>
                            <td class="py-2 px-4">{{ $usuario->email }}</td>
                            <td class="py-2 px-4 flex space-x-2">
                                <a href="" class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-2 px-4 text-center text-gray-500">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('openSidebar').addEventListener('click', function () {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            this.classList.add('hidden'); // Oculta el botón de abrir
        });
    </script>
@endsection