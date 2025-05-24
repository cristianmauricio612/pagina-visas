@extends('layouts.admin')
@section('title', 'Admin | Listar reclamaciones')

@section('content')
    @php
        $reclamaciones = \App\Models\LibroReclamacion::orderBy('created_at', 'desc')->get();
    @endphp

    {{-- Botón para abrir el Sidebar (Solo en esta vista) --}}
    <button id="openSidebar"
        class="fixed top-4 left-4 bg-gray-900 text-white w-10 h-10 flex items-center justify-center rounded-md text-lg lg:hidden shadow-md">
        <i class="fas fa-bars"></i>
    </button>

    <div class="py-6">
        {{-- Título --}}
        <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4 text-center md:text-left">
            Gestión de Reclamaciones
        </h1>

        {{-- Estadísticas rápidas --}}
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
            @php
                $pendientes = $reclamaciones->where('estado', 'Pendiente')->count();
                $resueltas = $reclamaciones->where('estado', 'Resuelto')->count();
                $rechazadas = $reclamaciones->where('estado', 'Rechazado')->count();
            @endphp

            <div class="bg-yellow-100 border-l-4 border-yellow-500 p-3 rounded">
                <div class="text-sm text-yellow-700">Pendientes</div>
                <div class="text-2xl font-bold text-yellow-800">{{ $pendientes }}</div>
            </div>
            <div class="bg-green-100 border-l-4 border-green-500 p-3 rounded">
                <div class="text-sm text-green-700">Resueltas</div>
                <div class="text-2xl font-bold text-green-800">{{ $resueltas }}</div>
            </div>
            <div class="bg-red-100 border-l-4 border-red-500 p-3 rounded">
                <div class="text-sm text-red-700">Rechazadas</div>
                <div class="text-2xl font-bold text-red-800">{{ $rechazadas }}</div>
            </div>
        </div>

        {{-- Filtros y Buscador --}}
        <div class="flex flex-col md:flex-row justify-between mb-6 gap-4">
            <div class="flex flex-col md:flex-row gap-2 md:gap-4">
                <input type="text" id="search-input" placeholder="Buscar por cliente o documento..."
                       class="p-2 border rounded w-full md:w-64 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <select id="filter-estado" class="p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Todos los estados</option>
                    <option value="Pendiente">🟡 Pendiente</option>
                    <option value="Resuelto">🟢 Resuelto</option>
                    <option value="Rechazado">🔴 Rechazado</option>
                </select>
                <select id="filter-tipo" class="p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Todos los tipos</option>
                    <option value="Reclamo">📋 Reclamo</option>
                    <option value="Queja">💬 Queja</option>
                </select>
            </div>
            <button onclick="exportarReclamaciones()"
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                <i class="fas fa-download mr-2"></i>Exportar
            </button>
        </div>

        {{-- Contenedor con scroll horizontal y vertical --}}
        <div class="w-full max-w-[100%] max-h-[600px] overflow-y-auto overflow-x-auto border rounded-lg">
            <table class="w-full md:min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left w-16">ID</th>
                        <th class="py-2 px-4 text-left w-48">Cliente</th>
                        <th class="py-2 px-4 text-left w-32">Documento</th>
                        <th class="py-2 px-4 text-left w-32">Tipo</th>
                        <th class="py-2 px-4 text-left w-32">Fecha</th>
                        <th class="py-2 px-4 text-left w-32">Estado</th>
                        <th class="py-2 px-4 text-left w-32">Días Rest.</th>
                        <th class="py-2 px-4 text-left w-32">Acciones</th>
                    </tr>
                </thead>
                <tbody id="reclamaciones-table-body">
                    @forelse ($reclamaciones as $reclamacion)
                        @php
                            $fechaIncidente = \Carbon\Carbon::parse($reclamacion->created_at);
                            $fechaLimite = $fechaIncidente->addDays(30);
                            $diasRestantes = \Carbon\Carbon::now()->diffInDays($fechaLimite, false);
                            $urgente = $diasRestantes <= 5 && $reclamacion->estado === 'Pendiente';
                        @endphp
                        <tr class="border-b hover:bg-gray-100 {{ $urgente ? 'bg-red-50 border-red-200' : '' }}"
                            data-cliente="{{ strtolower($reclamacion->nombres_apellidos) }}"
                            data-documento="{{ $reclamacion->numero_documento }}"
                            data-estado="{{ $reclamacion->estado }}"
                            data-tipo="{{ $reclamacion->tipo_incidente }}">
                            <td class="py-2 px-4">
                                <span class="font-mono text-sm">#{{ str_pad($reclamacion->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="py-2 px-4">
                                <div class="font-semibold">{{ $reclamacion->nombres_apellidos }}</div>
                                <div class="text-sm text-gray-600">{{ $reclamacion->correo }}</div>
                            </td>
                            <td class="py-2 px-4">
                                <div class="text-sm">{{ $reclamacion->tipo_documento }}</div>
                                <div class="font-mono text-xs">{{ $reclamacion->numero_documento }}</div>
                            </td>
                            <td class="py-2 px-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $reclamacion->tipo_incidente === 'Reclamo' ? 'bg-orange-100 text-orange-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ $reclamacion->tipo_incidente === 'Reclamo' ? '📋' : '💬' }} {{ $reclamacion->tipo_incidente }}
                                </span>
                            </td>
                            <td class="py-2 px-4">
                                <div class="text-sm">{{ $fechaIncidente->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $fechaIncidente->locale('es')->diffForHumans() }}</div>
                            </td>
                            <td class="py-2 px-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @switch($reclamacion->estado)
                                        @case('Pendiente') bg-yellow-100 text-yellow-800 @break
                                        @case('Resuelto') bg-green-100 text-green-800 @break
                                        @case('Rechazado') bg-red-100 text-red-800 @break
                                    @endswitch">
                                    @switch($reclamacion->estado)
                                        @case('Pendiente') 🟡 @break
                                        @case('Resuelto') 🟢 @break
                                        @case('Rechazado') 🔴 @break
                                    @endswitch
                                    {{ $reclamacion->estado }}
                                </span>
                            </td>
                            <td class="py-2 px-4">
                                @if($reclamacion->estado === 'Pendiente')
                                    <div class="text-sm {{ $diasRestantes <= 5 ? 'text-red-600 font-bold' : ($diasRestantes <= 10 ? 'text-orange-600' : 'text-gray-600') }}">
                                        {{ $diasRestantes > 0 ? $diasRestantes . ' días' : 'Vencido' }}
                                    </div>
                                    @if($urgente)
                                        <div class="text-xs text-red-500">¡URGENTE!</div>
                                    @endif
                                @else
                                    <span class="text-xs text-gray-400">Finalizado</span>
                                @endif
                            </td>
                            <td class="py-2 px-4 flex space-x-2">
                                <a href="{{route('admin.reclamaciones.viewView', $reclamacion->id)}}"
                                    class="text-blue-500 hover:text-blue-700 p-1 rounded transition"
                                    title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($reclamacion->estado === 'Pendiente')
                                    <a href="{{route('admin.reclamaciones.viewView', $reclamacion->id)}}#responder"
                                        class="text-green-500 hover:text-green-700 p-1 rounded transition"
                                        title="Responder">
                                        <i class="fas fa-reply"></i>
                                    </a>
                                @endif
                                <button type="button" class="text-red-500 hover:text-red-700 p-1 rounded transition"
                                        data-id="{{ $reclamacion->id }}" onclick="deleteReclamacion(this)"
                                        title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 px-4 text-center text-gray-500">
                                <div class="text-4xl mb-2">📋</div>
                                <div>No hay reclamaciones registradas.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Información adicional --}}
        <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-400 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <strong>Recordatorio:</strong> Las reclamaciones deben ser respondidas en un plazo máximo de 30 días calendario según la normativa.
                        Las marcadas en rojo tienen 5 días o menos para ser respondidas.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('openSidebar').addEventListener('click', function () {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            this.classList.add('hidden');
        });

        const csrfToken = "{{ csrf()->token() }}";

        // Búsqueda y filtros
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById('search-input');
            const filterEstado = document.getElementById('filter-estado');
            const filterTipo = document.getElementById('filter-tipo');

            // Eventos para filtros
            searchInput.addEventListener('keyup', filtrarReclamaciones);
            filterEstado.addEventListener('change', filtrarReclamaciones);
            filterTipo.addEventListener('change', filtrarReclamaciones);
        });

        function filtrarReclamaciones() {
            const searchTerm = document.getElementById('search-input').value.toLowerCase();
            const estadoFilter = document.getElementById('filter-estado').value;
            const tipoFilter = document.getElementById('filter-tipo').value;
            const rows = document.querySelectorAll('#reclamaciones-table-body tr[data-cliente]');

            rows.forEach(row => {
                const cliente = row.getAttribute('data-cliente');
                const documento = row.getAttribute('data-documento');
                const estado = row.getAttribute('data-estado');
                const tipo = row.getAttribute('data-tipo');

                const matchSearch = searchTerm === '' ||
                                  cliente.includes(searchTerm) ||
                                  documento.includes(searchTerm);
                const matchEstado = estadoFilter === '' || estado === estadoFilter;
                const matchTipo = tipoFilter === '' || tipo === tipoFilter;

                if (matchSearch && matchEstado && matchTipo) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function deleteReclamacion(button) {
            const id = button.getAttribute('data-id');

            if (!id) {
                alert("Error: ID de la reclamación no encontrado.");
                return;
            }

            if (!confirm("¿Estás seguro de eliminar esta reclamación?")) {
                return;
            }

            fetch(`/admin/reclamaciones/eliminar/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert("✅ Reclamación eliminada correctamente");
                    location.reload();
                } else {
                    alert("❌ Error al eliminar: " + data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("❌ Ocurrió un error inesperado.");
            });
        }

        function exportarReclamaciones() {
            alert("🚧 Funcionalidad de exportación en desarrollo");
        }

        // Actualizar cada minuto los contadores de días
        setInterval(() => {
            location.reload();
        }, 60000);
    </script>
@endsection
