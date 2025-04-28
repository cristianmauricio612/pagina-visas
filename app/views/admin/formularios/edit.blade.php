@extends('layouts.admin')
@section('title', 'Editar Formulario')

@section('content')
    @php
        $variableIdsSeleccionadas = $formulario->variables->pluck('id')->toArray();
        $ordenesGuardadas = $formulario->variables->pluck('pivot.orden', 'id')->toArray();
        $mesesGuardados = $formulario->variables->pluck('pivot.meses_espera', 'id')->toArray();
    @endphp

    <div class="py-6 max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Editar Formulario</h1>

        <form id="formularioForm" class="bg-white p-6 rounded shadow-md">
            @csrf
            <input type="hidden" name="id" value="{{ $formulario->id }}">

            {{-- Visa asociada --}}
            <div class="mb-4">
                <label for="visa_id" class="block font-semibold mb-1">Seleccionar Visa:</label>
                <select id="visa_id" name="visa_id" class="w-full p-2 border rounded" required>
                    <option value="">-- Selecciona una visa --</option>
                    @foreach ($visas as $visa)
                        <option value="{{ $visa->id }}" {{ $formulario->visa_id == $visa->id ? 'selected' : '' }}>
                            {{ $visa->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Variables asociadas --}}
            <div class="mb-6">
                <label class="block font-semibold mb-2">Seleccionar Variables:</label>
                <div class="max-h-96 overflow-y-auto border p-3 rounded space-y-4">
                    @foreach (['VISA' => '🛂 Variables de Visa', 'VIAJERO' => '🧍 Variables de Viajero', 'PASAPORTE' => '📘 Variables de Pasaporte'] as $tipo => $titulo)
                        @if ($variables->has($tipo))
                            <div>
                                <h3 class="text-lg font-bold mb-2">{{ $titulo }}</h3>
                                @foreach ($variables[$tipo] as $variable)
                                    <div class="flex items-center justify-between mb-2 gap-4">
                                        <label class="inline-flex items-center space-x-2">
                                            <input type="checkbox" name="variables[]" value="{{ $variable->id }}"
                                                {{ in_array($variable->id, $variableIdsSeleccionadas) ? 'checked' : '' }}>
                                            <span>{{ $variable->nombre_campo }} ({{ $variable->tipo_elemento }})</span>
                                        </label>

                                        <div class="flex items-center gap-2">
                                            {{-- Meses de espera (editable) --}}
                                            @if ($variable->tipo_elemento === 'DATE_PICKER')
                                                <input type="number"
                                                name="meses_espera[{{ $variable->id }}]"
                                                min="0"
                                                placeholder="Meses"
                                                class="w-24 border rounded px-2 py-1 text-sm"
                                                value="{{ $mesesGuardados[$variable->id] ?? ''}}">
                                            @endif

                                            {{-- Orden personalizado --}}
                                            <input type="number"
                                                name="ordenes[{{ $variable->id }}]"
                                                min="1"
                                                placeholder="Orden"
                                                class="w-20 border rounded px-2 py-1 text-sm"
                                                value="{{ $ordenesGuardadas[$variable->id] ?? '' }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.formularios.listView') }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById("formularioForm").addEventListener("submit", function (event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);

            const selectedVariables = [];
            const ordenes = {};
            const mesesEspera = {};

            // Recolectamos variables seleccionadas y sus órdenes
            form.querySelectorAll('input[name="variables[]"]:checked').forEach(checkbox => {
                const variableId = checkbox.value;
                selectedVariables.push(variableId);

                // Obtener el orden
                const ordenInput = form.querySelector(`input[name="ordenes[${variableId}]"]`);
                if (ordenInput) {
                    ordenes[variableId] = ordenInput.value;
                }

                // Obtener meses de espera si existe
                const mesesInput = form.querySelector(`input[name="meses_espera[${variableId}]"]`);
                if (mesesInput) {
                    mesesEspera[variableId] = mesesInput.value;
                }
            });

            const data = {
                id: formData.get('id'),
                visa_id: formData.get('visa_id'),
                variables: selectedVariables,
                ordenes: ordenes,
                meses_espera: mesesEspera
            };

            fetch(`/admin/formularios/actualizar/${data.id}`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf()->token() }}"
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json().then(json => ({ status: res.status, body: json })))
            .then(result => {
                if (result.status === 200) {
                    alert("✅ Formulario actualizado exitosamente.");
                    window.location.href = "{{ route('admin.formularios.listView') }}";
                } else {
                    alert("❌ Error al actualizar: " + result.body.message);
                }
            })
            .catch(error => {
                console.error("❌ Error inesperado:", error);
                alert("❌ Error al actualizar el formulario.");
            });
        });
    </script>
@endsection
