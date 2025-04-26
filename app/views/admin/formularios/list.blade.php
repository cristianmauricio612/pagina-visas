@extends('layouts.admin')
@section('title', 'Listado de Formularios')

@section('content')
    @php
        $formularios = \App\Models\Formulario::all();
    @endphp
    <div class="py-6 max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Gestión de Formularios</h1>

        {{-- Botón de crear formulario --}}
        <div class="mb-4">
            <a href="{{ route('admin.formularios.addView') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Crear nuevo formulario
            </a>
        </div>

        {{-- Tabla de formularios --}}
        <div class="overflow-x-auto bg-white shadow rounded border">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4">ID</th>
                        <th class="py-3 px-4">Visa</th>
                        <th class="py-3 px-4">Variables</th>
                        <th class="py-3 px-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($formularios as $formulario)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4">{{ $formulario->id }}</td>
                            <td class="py-2 px-4">{{ $formulario->visa->nombre ?? 'N/A' }}</td>
                            <td class="py-2 px-4">{{ $formulario->variables->count() }}</td>
                            <td class="py-2 px-4 flex space-x-2">
                                <a href="{{ route('admin.formularios.editView', $formulario->id) }}" class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="deleteFormulario({{ $formulario->id }})" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 px-4 text-center text-gray-500">No hay formularios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Script para eliminar --}}
    <script>
        function deleteFormulario(id) {
            if (!confirm("¿Estás seguro de eliminar este formulario?")) return;

            fetch(`/admin/formularios/eliminar/${id}`, {
                method: 'DELETE',
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf()->token() }}"
                }
            })
            .then(res => {
                if (res.ok) {
                    alert("✅ Formulario eliminado correctamente.");
                    location.reload();
                } else {
                    alert("❌ Error al eliminar el formulario.");
                }
            });
        }
    </script>
@endsection
