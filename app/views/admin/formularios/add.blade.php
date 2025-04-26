@extends('layouts.admin')
@section('title', 'Crear Formulario')

@section('content')
    @php
        use App\Models\Visa;
        use App\Models\Variable;

        $visas = Visa::all();
        $variables = Variable::all()->groupBy('tipo_variable');
    @endphp

    <div class="py-6 max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Crear nuevo Formulario</h1>

        <form id="formularioForm" class="bg-white p-6 rounded shadow-md">
            {{-- Visa asociada --}}
            <div class="mb-4">
                <label for="visa_id" class="block font-semibold mb-1">Seleccionar Visa:</label>
                <select id="visa_id" name="visa_id" class="w-full p-2 border rounded" required>
                    <option value="">-- Selecciona una visa --</option>
                    @foreach ($visas as $visa)
                        <option value="{{ $visa->id }}">{{ $visa->nombre }}</option>
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
                                    <div class="flex items-center justify-between mb-2 space-x-4">
                                        <label class="inline-flex items-center space-x-2 flex-grow">
                                            <input type="checkbox" name="variables[]" value="{{ $variable->id }}">
                                            <span>{{ $variable->nombre }} ({{ $variable->tipo_elemento }})</span>
                                        </label>

                                        @if ($variable->tipo_elemento === 'DATE_PICKER')
                                            <input type="number" name="meses_espera[{{ $variable->id }}]" min="0" placeholder="Meses"
                                                class="w-24 border rounded px-2 py-1 text-sm" title="Meses de espera">
                                        @endif

                                        <input type="number" name="ordenes[{{ $variable->id }}]" min="1" placeholder="Orden"
                                            class="w-20 border rounded px-2 py-1 text-sm">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Botón --}}
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Guardar Formulario
            </button>
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
    
            // Recorremos todos los checkboxes marcados
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
                visa_id: formData.get('visa_id'),
                variables: selectedVariables,
                ordenes: ordenes,
                meses_espera: mesesEspera
            };
    
            fetch("/admin/formularios/crear", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf()->token() }}"
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json().then(json => ({ status: res.status, body: json })))
            .then(result => {
                if (result.status === 201) {
                    alert("✅ Formulario creado exitosamente");
                    location.href = "/admin/formularios";
                } else {
                    alert(`❌ Error: ${result.body.message}`);
                }
            })
            .catch(error => {
                console.error("❌ Error inesperado:", error);
                alert("❌ Error al crear el formulario.");
            });
        });
    </script>
    
@endsection