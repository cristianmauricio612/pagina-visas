@extends('layouts.admin')
@section('title', 'Admin | Listar Variables')

@section('content')
    @php
        $variables = \App\Models\Variable::with(['restricciones', 'opciones'])->get();
    @endphp

    <div class="py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Gestión de Variables</h1>

        <div class="flex justify-end mb-4">
            <a href="{{ route('admin.variables.addView') }}"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Agregar Variable
            </a>
        </div>

        <div class="overflow-x-auto border rounded-lg">
            <table class="min-w-full bg-white border">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4">ID</th>
                        <th class="py-2 px-4">Nombre del Campo</th>
                        <th class="py-2 px-4">Nombre del Elemento</th>
                        <th class="py-2 px-4">Tipo Elemento</th>
                        <th class="py-2 px-4">Tipo Variable</th>
                        <th class="py-2 px-4">Obligatoriedad</th>
                        <th class="py-2 px-4">Es Pais</th>
                        <th class="py-2 px-4">Opciones / Restricciones</th>
                        <th class="py-2 px-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($variables as $variable)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-2 px-4">{{ $variable->id }}</td>
                            <td class="py-2 px-4">{{ $variable->nombre_campo }}</td>
                            <td class="py-2 px-4">{{ $variable->nombre }}</td>
                            <td class="py-2 px-4">{{ $variable->tipo_elemento }}</td>
                            <td class="py-2 px-4">{{ $variable->tipo_variable }}</td>
                            <td class="py-2 px-4">
                                {{ $variable->obligatoriedad ? 'Sí' : 'No' }}
                            </td>
                            <td class="py-2 px-4">
                                {{ $variable->isPais ? 'Sí' : 'No' }}
                            </td>
                            <td class="py-2 px-4">
                                @if (in_array($variable->tipo_elemento, ['SELECT', 'SELECT_BUTTONS']) && $variable->opciones)
                                    <strong>Opciones:</strong>
                                    <ul class="list-disc ml-5">
                                        @foreach ($variable->opciones as $opcion)
                                            <li>
                                                {{ $opcion->contenido }}
                                                @if ($opcion->valor) (Valor: {{ $opcion->valor }}) @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @elseif ($variable->tipo_elemento === 'CHECKBOX_RESTRICTIVE' && $variable->restricciones)
                                    <strong>Restringe a:</strong>
                                    <ul class="list-disc ml-5">
                                        @foreach ($variable->restricciones as $restriccion)
                                            <li>Variable ID: {{ $restriccion->variable_restringida_id }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-gray-400 italic">Ninguna</span>
                                @endif
                            </td>
                            <td class="py-2 px-4">
                                <a href="{{ route('admin.variables.editView', $variable->id) }}"
                                    class="text-blue-500 hover:text-blue-700 mr-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="deleteVariable({{ $variable->id }})"
                                    class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 px-4 text-center text-gray-500">
                                No se han registrado variables aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function deleteVariable(id) {
            if (!confirm("¿Estás seguro de eliminar esta variable?")) return;

            fetch(`/admin/variables/eliminar/${id}`, {
                method: 'DELETE',
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf()->token() }}"
                }
            })
            .then(response => {
                if (response.ok) {
                    alert("✅ Variable eliminada exitosamente.");
                    location.reload();
                } else {
                    alert("❌ Error al eliminar la variable.");
                }
            });
        }
    </script>
@endsection
