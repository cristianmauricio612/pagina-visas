@extends('layouts.admin')
@section('title', 'Admin | Home')

@section('content')
    @php
        $paisesCount = \App\Models\Pais::count();
        $usuariosCount = \App\Models\User::count();
        $visasCount = \App\Models\Visa::count();
        $pedidosCount = \App\Models\VisaInscripcion::where('status_pago', '!=', 'finalizado')->count();
    @endphp
    {{-- Botón para abrir el Sidebar (Solo en esta vista) --}}
    <button id="openSidebar" class="fixed top-4 left-4 bg-gray-900 text-white w-10 h-10 flex items-center justify-center rounded-md text-lg lg:hidden shadow-md">
        <i class="fas fa-bars"></i>
    </button>

    <div class="p-6">
        {{-- Título de Bienvenida --}}
        <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4 text-center md:text-left">
            ¡Bienvenido al Panel de Administración!
        </h1>

        <p class="text-gray-600 mb-6 text-center md:text-left">
            Desde aquí puedes gestionar usuarios, países, visas y pedidos de manera eficiente.
        </p>

        {{-- Sección de estadísticas (Diseño Responsivo) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Tarjeta de Usuarios --}}
            <div class="bg-white p-5 rounded-lg shadow flex items-center">
                <i class="fas fa-users text-3xl text-blue-500 mr-3"></i>
                <div>
                    <p class="text-gray-600">Total Usuarios</p>
                    <p class="text-xl font-bold">{{ $usuariosCount }}</p>
                </div>
            </div>

            {{-- Tarjeta de Países --}}
            <div class="bg-white p-5 rounded-lg shadow flex items-center">
                <i class="fas fa-globe text-3xl text-green-500 mr-3"></i>
                <div>
                    <p class="text-gray-600">Total Países</p>
                    <p class="text-xl font-bold">{{ $paisesCount }}</p>
                </div>
            </div>

            {{-- Tarjeta de Visas --}}
            <div class="bg-white p-5 rounded-lg shadow flex items-center">
                <i class="fas fa-passport text-3xl text-yellow-500 mr-3"></i>
                <div>
                    <p class="text-gray-600">Tipos de Visas</p>
                    <p class="text-xl font-bold">{{ $visasCount }}</p>
                </div>
            </div>

            {{-- Tarjeta de Pedidos --}}
            <div class="bg-white p-5 rounded-lg shadow flex items-center">
                <i class="fas fa-shopping-cart text-3xl text-red-500 mr-3"></i>
                <div>
                    <p class="text-gray-600">Pedidos Activos</p>
                    <p class="text-xl font-bold">{{ $pedidosCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('openSidebar').addEventListener('click', function () {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            this.classList.add('hidden'); // Oculta el botón de abrir
        });
    </script>
@endsection