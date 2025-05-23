@extends('layouts.admin')
@section('title', 'Admin | Ver reclamación')

@section('content')
    @php
        $reclamacion = \App\Models\LibroReclamacion::find($id);
        if (!$reclamacion) {
            header('Location: /admin/reclamaciones');
            exit();
        }

        $fechaIncidente = \Carbon\Carbon::parse($reclamacion->fecha_incidente);
        $fechaRegistro = \Carbon\Carbon::parse($reclamacion->created_at);
        $fechaLimite = $fechaRegistro->copy()->addDays(30);
        $diasRestantes = \Carbon\Carbon::now()->diffInDays($fechaLimite, false);
        $urgente = $diasRestantes <= 5 && in_array($reclamacion->estado, ['Pendiente', 'En proceso']);
        $vencido = $diasRestantes < 0 && in_array($reclamacion->estado, ['Pendiente', 'En proceso']);
    @endphp

    {{-- Botón para abrir el Sidebar --}}
    <button id="openSidebar"
        class="fixed top-4 left-4 bg-gray-900 text-white w-10 h-10 flex items-center justify-center rounded-md text-lg lg:hidden shadow-md">
        <i class="fas fa-bars"></i>
    </button>

    <div class="py-6 max-w-6xl mx-auto">
        {{-- Header con navegación --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div class="mb-4 md:mb-0">
                <div class="flex items-center mb-2">
                    <a href="{{route('admin.reclamaciones.listView')}}"
                       class="text-blue-600 hover:text-blue-800 mr-3">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                        Reclamación #{{ str_pad($reclamacion->id, 4, '0', STR_PAD_LEFT) }}
                    </h1>
                </div>
                @if($urgente || $vencido)
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $vencido ? 'bg-red-200 text-red-800' : 'bg-orange-200 text-orange-800' }}">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        {{ $vencido ? 'VENCIDA' : 'URGENTE' }} -
                        {{ $vencido ? 'Venció hace ' . abs($diasRestantes) . ' días' : $diasRestantes . ' días restantes' }}
                    </div>
                @endif
            </div>

            {{-- Estados rápidos --}}
            <div class="flex flex-wrap gap-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @switch($reclamacion->estado)
                        @case('Pendiente') bg-yellow-100 text-yellow-800 @break
                        @case('En proceso') bg-blue-100 text-blue-800 @break
                        @case('Resuelto') bg-green-100 text-green-800 @break
                        @case('Rechazado') bg-red-100 text-red-800 @break
                    @endswitch">
                    @switch($reclamacion->estado)
                        @case('Pendiente') 🟡 @break
                        @case('En proceso') 🔵 @break
                        @case('Resuelto') 🟢 @break
                        @case('Rechazado') 🔴 @break
                    @endswitch
                    {{ $reclamacion->estado }}
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    {{ $reclamacion->tipo_incidente === 'Reclamo' ? 'bg-orange-100 text-orange-800' : 'bg-purple-100 text-purple-800' }}">
                    {{ $reclamacion->tipo_incidente === 'Reclamo' ? '📋' : '💬' }} {{ $reclamacion->tipo_incidente }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Columna principal: Detalles de la reclamación --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Información del consumidor --}}
                <div class="bg-white rounded-lg shadow-md border p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user mr-2 text-blue-600"></i>
                        Información del Consumidor
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombres y Apellidos</label>
                            <p class="text-gray-900 font-semibold">{{ $reclamacion->nombres_apellidos }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Documento</label>
                            <p class="text-gray-900">{{ $reclamacion->tipo_documento }}: {{ $reclamacion->numero_documento }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                            <p class="text-gray-900">
                                <a href="mailto:{{ $reclamacion->correo }}" class="text-blue-600 hover:underline">
                                    {{ $reclamacion->correo }}
                                </a>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <p class="text-gray-900">
                                @if($reclamacion->telefono)
                                    <a href="tel:{{ $reclamacion->telefono }}" class="text-blue-600 hover:underline">
                                        {{ $reclamacion->telefono }}
                                    </a>
                                @else
                                    <span class="text-gray-400">No proporcionado</span>
                                @endif
                            </p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Dirección</label>
                            <p class="text-gray-900">{{ $reclamacion->direccion }}</p>
                        </div>
                        @if($reclamacion->menor_edad)
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Apoderado (Menor de edad)</label>
                                <p class="text-gray-900 bg-yellow-50 p-2 rounded border">
                                    <i class="fas fa-child mr-2 text-yellow-600"></i>
                                    {{ $reclamacion->apoderado }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Detalles del incidente --}}
                <div class="bg-white rounded-lg shadow-md border p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-clipboard-list mr-2 text-orange-600"></i>
                        Detalles del Incidente
                    </h2>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fecha del Incidente</label>
                                <p class="text-gray-900">{{ $fechaIncidente->format('d/m/Y') }} <span class="text-gray-500 text-sm">({{ $fechaIncidente->diffForHumans() }})</span></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Bien Contratado</label>
                                <p class="text-gray-900">{{ $reclamacion->bien_contratado }}</p>
                            </div>
                            @if($reclamacion->monto)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Monto</label>
                                    <p class="text-gray-900 font-semibold">${{ number_format($reclamacion->monto, 2) }}</p>
                                </div>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descripción del Bien/Servicio</label>
                            <div class="bg-gray-50 p-3 rounded border">
                                <p class="text-gray-900">{{ $reclamacion->descripcion_bien }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Detalle de lo Ocurrido</label>
                            <div class="bg-gray-50 p-3 rounded border">
                                <p class="text-gray-900 whitespace-pre-wrap">{{ $reclamacion->detalle }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pedido del Consumidor</label>
                            <div class="bg-blue-50 p-3 rounded border border-blue-200">
                                <p class="text-gray-900 whitespace-pre-wrap">{{ $reclamacion->pedido_consumidor }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Respuesta existente (si la hay) --}}
                @if($reclamacion->respuesta)
                    <div class="bg-white rounded-lg shadow-md border p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-reply mr-2 text-green-600"></i>
                            Respuesta Enviada
                        </h2>
                        <div class="bg-green-50 p-4 rounded border border-green-200">
                            <div class="mb-2">
                                <span class="text-sm text-green-700">
                                    Respondido el {{ \Carbon\Carbon::parse($reclamacion->fecha_respuesta)->format('d/m/Y H:i') }}
                                </span>
                            </div>
                            <p class="text-gray-900 whitespace-pre-wrap">{{ $reclamacion->respuesta }}</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Columna lateral: Acciones y timeline --}}
            <div class="space-y-6">
                {{-- Información rápida --}}
                <div class="bg-white rounded-lg shadow-md border p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Información Rápida</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Registrado:</span>
                            <span class="font-medium">{{ $fechaRegistro->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tiempo transcurrido:</span>
                            <span class="font-medium">{{ $fechaRegistro->diffForHumans() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Fecha límite:</span>
                            <span class="font-medium {{ $vencido ? 'text-red-600' : ($urgente ? 'text-orange-600' : '') }}">
                                {{ $fechaLimite->format('d/m/Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Días restantes:</span>
                            <span class="font-bold {{ $vencido ? 'text-red-600' : ($urgente ? 'text-orange-600' : 'text-green-600') }}">
                                {{ $diasRestantes > 0 ? $diasRestantes : 'Vencido hace ' . abs($diasRestantes) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Formulario de respuesta --}}
                @if(in_array($reclamacion->estado, ['Pendiente']))
                    <div id="responder" class="bg-white rounded-lg shadow-md border p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-reply mr-2 text-blue-600"></i>
                            Responder Reclamación
                        </h3>
                        <form id="respuestaForm" class="space-y-4">
                            <div>
                                <label for="nuevoEstado" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nuevo Estado <span class="text-red-500">*</span>
                                </label>
                                <select id="nuevoEstado" name="estado" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                                    <option value="Resuelto" {{ $reclamacion->estado === 'Resuelto' ? 'selected' : '' }}>🟢 Resuelto</option>
                                    <option value="Rechazado">🔴 Rechazado</option>
                                </select>
                            </div>

                            <div>
                                <label for="respuesta" class="block text-sm font-medium text-gray-700 mb-2">
                                    Respuesta <span class="text-red-500">*</span>
                                </label>
                                <textarea id="respuesta" name="respuesta" rows="6"
                                          class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                                          placeholder="Escriba aquí la respuesta detallada a la reclamación..." required>{{ $reclamacion->respuesta }}</textarea>
                                <div class="text-sm text-gray-500 mt-1">
                                    Mínimo 50 caracteres. Sea claro y profesional en su respuesta.
                                </div>
                            </div>

                            <div class="flex space-x-3">
                                <button type="submit"
                                        class="flex-1 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                    <i class="fas fa-paper-plane mr-2"></i>Enviar Respuesta
                                </button>
                                <button type="button" onclick="previewResponse()"
                                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                                    <i class="fas fa-eye mr-2"></i>Vista Previa
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                {{-- Acciones adicionales --}}
                <div class="bg-white rounded-lg shadow-md border p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Acciones</h3>
                    <div class="space-y-3">
                        <button onclick="enviarRecordatorio()"
                                class="w-full bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
                            <i class="fas fa-bell mr-2"></i>Enviar Recordatorio
                        </button>
                        <button onclick="exportarPDF()"
                                class="w-full bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                            <i class="fas fa-file-pdf mr-2"></i>Exportar PDF
                        </button>
                        <button onclick="deleteReclamacion({{ $reclamacion->id }})"
                                class="w-full bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                            <i class="fas fa-trash mr-2"></i>Eliminar
                        </button>
                    </div>
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
        const reclamacionId = {{ $reclamacion->id }};

        // Manejar envío de respuesta
        document.getElementById('respuestaForm')?.addEventListener('submit', function(e) {
            e.preventDefault();

            const estado = document.getElementById('nuevoEstado').value;
            const respuesta = document.getElementById('respuesta').value;

            if (respuesta.length < 50) {
                alert('La respuesta debe tener al menos 50 caracteres.');
                return;
            }

            if (!confirm('¿Está seguro de enviar esta respuesta? Se notificará al cliente por correo electrónico.')) {
                return;
            }

            // Deshabilitar el botón para evitar envíos duplicados
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Enviando...';

            fetch(`/admin/reclamaciones/responder/${reclamacionId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    estado: estado,
                    respuesta: respuesta
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('✅ Respuesta enviada exitosamente. El cliente será notificado por correo.');
                    location.reload();
                } else {
                    alert('❌ Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Ocurrió un error al enviar la respuesta.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });

        function previewResponse() {
            const respuesta = document.getElementById('respuesta').value;
            if (!respuesta.trim()) {
                alert('Escriba una respuesta primero.');
                return;
            }

            // Crear modal de vista previa
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50';
            modal.innerHTML = `
                <div class="bg-white rounded-lg p-6 max-w-2xl max-h-96 overflow-y-auto">
                    <h3 class="text-lg font-bold mb-4">Vista Previa de la Respuesta</h3>
                    <div class="bg-gray-50 p-4 rounded border">
                        <p class="whitespace-pre-wrap">${respuesta}</p>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button onclick="this.closest('.fixed').remove()"
                                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            Cerrar
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }

        function enviarRecordatorio() {
            alert('🚧 Funcionalidad de recordatorio en desarrollo');
        }

        function exportarPDF() {
            alert('🚧 Funcionalidad de exportación PDF en desarrollo');
        }

        function deleteReclamacion(id) {
            if (!confirm('¿Está seguro de eliminar esta reclamación? Esta acción no se puede deshacer.')) {
                return;
            }

            fetch(`/admin/reclamaciones/eliminar/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('✅ Reclamación eliminada correctamente');
                    window.location.href = '/admin/reclamaciones';
                } else {
                    alert('❌ Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Ocurrió un error al eliminar la reclamación.');
            });
        }
    </script>
@endsection
