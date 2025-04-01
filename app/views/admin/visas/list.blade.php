@extends('layouts.admin')
@section('title', 'Admin | Listar visas')

@section('content')
    @php
        $visas = \App\Models\Visa::all(); // Obtener todas las visas
    @endphp

    {{-- Botón para abrir el Sidebar (Solo en esta vista) --}}
    <button id="openSidebar" class="fixed top-4 left-4 bg-gray-900 text-white w-10 h-10 flex items-center justify-center rounded-md text-lg lg:hidden shadow-md">
        <i class="fas fa-bars"></i>
    </button>

    <div class="py-6">
        {{-- Título --}}
        <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4 text-center md:text-left">
            Gestión de Visas
        </h1>

        {{-- Buscador y Botón Agregar --}}
        <div class="flex flex-col md:flex-row justify-between mb-6 gap-4">
            <input type="text" id="search" placeholder="Buscar visa..." class="p-2 border rounded w-full md:w-1/3">
            <a href="{{ route('admin.visas.addView') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Agregar Visa
            </a>
        </div>

        {{-- Contenedor con scroll horizontal y vertical --}}
        <div class="w-full max-w-[100%] max-h-[600px] overflow-y-auto overflow-x-auto border rounded-lg">
            <table class="w-full md:min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left w-12 whitespace-nowrap">ID</th>
                        <th class="py-2 px-4 text-left w-48 whitespace-nowrap">País 1</th>
                        <th class="py-2 px-4 text-left w-48 whitespace-nowrap">País 2</th>
                        <th class="py-2 px-4 text-left w-48 whitespace-nowrap">Nombre</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Tiempo Validez</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Entradas</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Estancia Máxima</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Necesita Visa</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Precio</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Tasa Gobierno</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($visas as $visa)
                        @php
                            $pais1 = \App\Models\Pais::find($visa->pais1_id)->nombre;
                            $pais2 = \App\Models\Pais::find($visa->pais2_id)->nombre;
                        @endphp
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-2 px-4 whitespace-nowrap">{{ $visa->id }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $pais1 }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $pais2 }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $visa->nombre }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $visa->tiempo_validez }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $visa->numero_entradas }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $visa->estancia_maxima }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $visa->necesita_visa ? 'Sí' : 'No' }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">MXN {{ number_format($visa->precio, 2) }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">MXN {{ number_format($visa->tasa_gobierno, 2) }}</td>
                            <td class="py-2 px-4 flex space-x-2 whitespace-nowrap">
                                <a href="" class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta visa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="py-2 px-4 text-center text-gray-500">No hay visas registradas.</td>
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
