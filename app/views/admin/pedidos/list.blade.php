@extends('layouts.admin')
@section('title', 'Admin | Listar pedidos')

@section('content')
    @php
        $inscripciones = \App\Models\VisaInscripcion::all();
    @endphp

    {{-- Botón para abrir el Sidebar --}}
    <button id="openSidebar" class="fixed top-4 left-4 bg-gray-900 text-white w-10 h-10 flex items-center justify-center rounded-md text-lg lg:hidden shadow-md">
        <i class="fas fa-bars"></i>
    </button>

    <div class="py-6 px-4 md:px-10">
        {{-- Título --}}
        <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4 text-center md:text-left">
            Gestión de Pedidos de Visas
        </h1>

        {{-- Buscador --}}
        <div class="mb-6 flex justify-center md:justify-start">
            <input type="text" id="search" placeholder="Buscar pedido..." class="p-2 border rounded w-full md:w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        {{-- Contenedor de Pedidos --}}
        <div class="space-y-4">
            @forelse ($inscripciones->reverse() as $inscripcion)
                @php
                    $visa = \App\Models\Visa::find($inscripcion->visas_id);
                    $viajeros = \App\Models\Viajero::where('visa_inscripcion_id', $inscripcion->id)->get();
                @endphp

                <div class="bg-white p-4 rounded-lg shadow-md border">
                    {{-- Encabezado del Pedido --}}
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-2 md:space-y-0">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">{{ $inscripcion->numero_pedido }}</h2>
                            <p class="text-gray-600 text-sm">Visa: {{ $visa->nombre }}</p>
                            <p class="text-gray-600 text-sm">Correo: {{ $inscripcion->correo }}</p>
                            <p class="text-gray-600 text-sm">Fecha de llegada: {{ $inscripcion->fecha_llegada }}</p>
                            <p class="text-gray-600 text-sm font-bold">Pago Total: MXN {{ number_format($inscripcion->pago_total, 2) }}</p>
                        </div>

                        {{-- Estado del Pedido --}}
                        <div class="flex items-center space-x-2">
                            <label for="status_{{ $inscripcion->id }}" class="text-sm font-semibold">Estado:</label>
                            <select id="status_{{ $inscripcion->id }}" class="p-1 border rounded-md text-black font-semibold"
                                onchange="updateStatusColor(this)">
                                <option value="pendiente" {{ $inscripcion->status_pago == 'pendiente' ? 'selected' : '' }}>🟡 Pendiente</option>
                                <option value="pagado" {{ $inscripcion->status_pago == 'pagado' ? 'selected' : '' }}>🟢 Pagado</option>
                                <option value="en proceso" {{ $inscripcion->status_pago == 'en proceso' ? 'selected' : '' }}>🔵 En proceso</option>
                                <option value="terminado" {{ $inscripcion->status_pago == 'terminado' ? 'selected' : '' }}>⚪ Terminado</option>
                            </select>
                        </div>

                        {{-- Botón para Eliminar Pedido --}}
                        <form action="" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este pedido?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-lg">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>

                    {{-- Botón para Mostrar/Ocultar Viajeros --}}
                    <button onclick="toggleViajeros({{ $inscripcion->id }})" class="mt-4 text-blue-600 hover:text-blue-800 font-semibold transition">
                        Ver Viajeros ({{ count($viajeros) }})
                    </button>

                    {{-- Lista de Viajeros --}}
                    <div id="viajeros_{{ $inscripcion->id }}" class="hidden mt-2 border-t pt-2 space-y-2">
                        @foreach ($viajeros as $viajero)
                            @php
                                $nacionalidad_pasaporte = \App\Models\Pais::find($viajero->nacionalidad_pasaporte_id)->nombre;
                                $pais_nacimiento = \App\Models\Pais::find($viajero->pais_nacimiento_id)->nombre;
                            @endphp
                            <div class="p-2 bg-gray-100 rounded-lg">
                                <p class="font-semibold">{{ $viajero->nombres_pasaporte }} {{ $viajero->apellidos_pasaporte }}</p>
                                <button onclick="toggleViajero({{ $viajero->id }})" class="text-blue-600 hover:text-blue-800 text-sm font-semibold transition">
                                    Ver Detalles
                                </button>

                                {{-- Detalles del Viajero --}}
                                <div id="viajero_{{ $viajero->id }}" class="hidden mt-2 p-3 border rounded bg-white shadow-sm">
                                    <p><strong>Fecha de Nacimiento:</strong> {{ $viajero->fecha_nacimiento }}</p>
                                    <p><strong>Nacionalidad:</strong> {{ $nacionalidad_pasaporte }}</p>
                                    <p><strong>Número de Pasaporte:</strong> {{ $viajero->numero_pasaporte }}</p>
                                    <p><strong>País de Nacimiento:</strong> {{ $pais_nacimiento }}</p>
                                    <p><strong>Nivel de Estudios:</strong> {{ $viajero->nivel_estudios }}</p>
                                    <p><strong>Fecha de Caducidad del Pasaporte:</strong> {{ $viajero->fecha_caducidad_pasaporte }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center">No hay pedidos registrados.</p>
            @endforelse
        </div>
    </div>

    {{-- Script para Mostrar/Ocultar Viajeros y sus Detalles --}}
    <script>
        function toggleViajeros(id) {
            let viajerosDiv = document.getElementById('viajeros_' + id);
            viajerosDiv.classList.toggle('hidden');
        }

        function toggleViajero(id) {
            let viajeroDiv = document.getElementById('viajero_' + id);
            viajeroDiv.classList.toggle('hidden');
        }

        function updateStatusColor(select) {
            let colors = {
                "pendiente": "#fef9c3",   // Amarillo muy claro
                "pagado": "#d1fae5",      // Verde muy claro
                "en proceso": "#dbeafe",  // Azul muy claro
                "terminado": "#e5e7eb"    // Gris muy claro
            };

            select.style.backgroundColor = colors[select.value]; 
            select.style.color = "#374151"; // Texto oscuro para mejor visibilidad
            select.style.borderColor = "#9ca3af"; // Borde elegante
        }

        document.getElementById('openSidebar').addEventListener('click', function () {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            this.classList.add('hidden');
        });

        // Aplicar color correcto a los select al cargar
        document.querySelectorAll('select').forEach(select => updateStatusColor(select));
    </script>
@endsection

