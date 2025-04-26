@extends('layouts.admin')
@section('title', 'Editar Variable')

@section('content')
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Editar Variable</h1>

        <form id="editVariableForm">
            @csrf

            <input type="hidden" name="id" value="{{ $variable->id }}">

            <div class="mb-4">
                <label class="block font-medium">Nombre</label>
                <input type="text" name="nombre" value="{{ $variable->nombre }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Tipo de Elemento</label>
                <select name="tipo_elemento" class="w-full border rounded px-3 py-2" required disabled>
                    <option value="INPUT_TEXT" {{ $variable->tipo_elemento === 'INPUT_TEXT' ? 'selected' : '' }}>INPUT_TEXT</option>
                    <option value="INPUT_NUMBER" {{ $variable->tipo_elemento === 'INPUT_NUMBER' ? 'selected' : '' }}>INPUT_NUMBER</option>
                    <option value="DATE_PICKER" {{ $variable->tipo_elemento === 'DATE_PICKER' ? 'selected' : '' }}>DATE_PICKER</option>
                    <option value="SELECT" {{ $variable->tipo_elemento === 'SELECT' ? 'selected' : '' }}>SELECT</option>
                    <option value="SELECT_BUTTONS" {{ $variable->tipo_elemento === 'SELECT_BUTTONS' ? 'selected' : '' }}>SELECT_BUTTONS</option>
                    <option value="CHECKBOX_RESTRICTIVE" {{ $variable->tipo_elemento === 'CHECKBOX_RESTRICTIVE' ? 'selected' : '' }}>CHECKBOX_RESTRICTIVE</option>
                    <option value="CHECKBOX_INFORMATIVE" {{ $variable->tipo_elemento === 'CHECKBOX_INFORMATIVE' ? 'selected' : '' }}>CHECKBOX_INFORMATIVE</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Tipo de Variable</label>
                <select name="tipo_variable" class="w-full border rounded px-3 py-2" required>
                    <option value="VISA" {{ $variable->tipo_variable === 'VISA' ? 'selected' : '' }}>VISA</option>
                    <option value="VIAJERO" {{ $variable->tipo_variable === 'VIAJERO' ? 'selected' : '' }}>VIAJERO</option>
                    <option value="PASAPORTE" {{ $variable->tipo_variable === 'PASAPORTE' ? 'selected' : '' }}>PASAPORTE</option>
                </select>
            </div>

            {{-- Resto de campos --}}
            <div class="mb-4">
                <label class="block font-medium">Placeholder</label>
                <input type="text" name="placeholder" value="{{ $variable->placeholder }}" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Encabezado</label>
                <input type="text" name="encabezado" value="{{ $variable->encabezado }}" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Advertencia</label>
                <input type="text" name="advertencia" value="{{ $variable->advertencia }}" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="obligatoriedad" {{ $variable->obligatoriedad ? 'checked' : '' }}>
                    <span class="ml-2">Obligatorio</span>
                </label>
            </div>

            @if(in_array($variable->tipo_elemento, ['SELECT', 'SELECT_BUTTONS']))
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="isPais" {{ $variable->isPais ? 'checked' : '' }}>
                        <span class="ml-2">Esta relacionado a Paises</span>
                    </label>
                </div>
            @endif

            {{-- Opciones si es SELECT o SELECT_BUTTONS --}}
            @if(in_array($variable->tipo_elemento, ['SELECT', 'SELECT_BUTTONS']))
                @if ($variable->isPais)
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Sin Opciones</label>
                    </div>
                @else
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Opciones:</label>
                        <div id="opcionesContainer">
                            @foreach ($variable->opciones as $index => $opcion)
                                <div class="border rounded p-3 mb-2 bg-gray-50">
                                    <input type="hidden" name="opciones[{{ $index }}][id]" value="{{ $opcion->id }}">
                                    <label>Contenido:</label>
                                    <input type="text" name="opciones[{{ $index }}][contenido]" value="{{ $opcion->contenido }}" class="w-full mb-2">
                                    <label>Valor (opcional):</label>
                                    <input type="text" name="opciones[{{ $index }}][valor]" value="{{ $opcion->valor }}" class="w-full mb-2">
                                    <label>Imagen (base64):</label>
                                    <textarea name="opciones[{{ $index }}][imagen]" class="w-full mb-2">{{ $opcion->imagen }}</textarea>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="opciones[{{ $index }}][global]" {{ $opcion->global ? 'checked' : '' }}>
                                        <span class="ml-2">Global</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            {{-- Restricciones si es CHECKBOX_RESTRICTIVE --}}
            @if($variable->tipo_elemento === 'CHECKBOX_RESTRICTIVE')
                <div class="mb-4">
                    <label class="block font-bold mb-2">Restringe a:</label>
                    @php
                        $todasLasVariables = \App\Models\Variable::where('id', '!=', $variable->id)->get();
                        $restricciones = $variable->restricciones->pluck('variable_restringida_id')->toArray();
                    @endphp
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach ($todasLasVariables as $v)
                            <label class="flex items-center">
                                <input type="checkbox" name="restricciones[]" value="{{ $v->id }}" {{ in_array($v->id, $restricciones) ? 'checked' : '' }}>
                                <span class="ml-2">{{ $v->nombre }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Guardar Cambios
            </button>
        </form>
    </div>

    <script>
        document.getElementById("editVariableForm").addEventListener("submit", function (event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);

            const data = Object.fromEntries(formData.entries());
            data.obligatoriedad = formData.has("obligatoriedad");
            data.restricciones = formData.getAll("restricciones[]");

            // Opciones
            const opciones = [];
            const opcionesInputs = form.querySelectorAll("[name^='opciones']");
            const grouped = {};

            opcionesInputs.forEach((input) => {
                const match = input.name.match(/opciones\[(\d+)\]\[(.*?)\]/);
                if (match) {
                    const index = match[1];
                    const key = match[2];
                    grouped[index] = grouped[index] || {};
                    grouped[index][key] = input.type === "checkbox" ? input.checked : input.value;
                }
            });

            for (const index in grouped) {
                opciones.push(grouped[index]);
            }

            data.opciones = opciones;

            fetch(`/admin/variables/actualizar/{{ $variable->id }}`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            }).then(res => res.json()).then(result => {
                if (result.status === "success") {
                    alert("✅ Variable actualizada correctamente");
                    window.location.href = '/admin/variables';
                } else {
                    alert("❌ Error: " + result.message);
                }
            });
        });
    </script>
@endsection
