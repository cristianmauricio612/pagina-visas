@extends('layouts.admin')
@section('title', 'Admin | Agregar variable')

@section('content')
    @php
        $variables = App\Models\Variable::all();
    @endphp
    <button id="openSidebar"
        class="fixed top-4 left-4 bg-gray-900 text-white w-10 h-10 flex items-center justify-center rounded-md text-lg lg:hidden shadow-md">
        <i class="fas fa-bars"></i>
    </button>

    <div class="py-6 max-w-2xl mx-auto">
        <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4 text-center md:text-left">
            Agregar Variable
        </h1>

        <form id="variableForm" class="bg-white p-6 rounded-lg shadow-md">
            @csrf

            {{-- Nombre --}}
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 font-medium">Nombre</label>
                <input type="text" id="nombre" name="nombre"
                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            {{-- Tipo de Elemento --}}
            <div class="mb-4">
                <label for="tipo_elemento" class="block text-gray-700 font-medium">Tipo de Elemento</label>
                <select id="tipo_elemento" name="tipo_elemento"
                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Seleccione una opción</option>
                    <option value="INPUT_TEXT">INPUT_TEXT</option>
                    <option value="INPUT_NUMBER">INPUT_NUMBER</option>
                    <option value="DATE_PICKER">DATE_PICKER</option>
                    <option value="SELECT">SELECT</option>
                    <option value="CHECKBOX_RESTRICTIVE">CHECKBOX_RESTRICTIVE</option>
                    <option value="CHECKBOX_INFORMATIVE">CHECKBOX_INFORMATIVE</option>
                    <option value="SELECT_BUTTONS">SELECT_BUTTONS</option>
                </select>
            </div>

            {{-- Tipo de Variable --}}
            <div class="mb-4">
                <label for="tipo_variable" class="block text-gray-700 font-medium">Tipo de Variable</label>
                <select id="tipo_variable" name="tipo_variable"
                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Seleccione una opción</option>
                    <option value="VISA">VISA</option>
                    <option value="VIAJERO">VIAJERO</option>
                    <option value="PASAPORTE">PASAPORTE</option>
                </select>
            </div>

            {{-- Obligatorio --}}
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" id="obligatoriedad" name="obligatoriedad"
                        class="form-checkbox h-5 w-5 text-blue-600">
                    <span class="ml-2 text-gray-700">¿Es obligatorio?</span>
                </label>
            </div>

            {{-- Es pais --}}
            <div id="isPaisContainer" class="mb-4 hidden">
                <label class="inline-flex items-center">
                    <input type="checkbox" id="isPais" name="isPais"
                        class="form-checkbox h-5 w-5 text-blue-600">
                    <span class="ml-2 text-gray-700">¿Esta relacionado a Paises?</span>
                </label>
            </div>

            {{-- Placeholder --}}
            <div class="mb-4">
                <label for="placeholder" class="block text-gray-700 font-medium">Placeholder (Opcional)</label>
                <input type="text" id="placeholder" name="placeholder"
                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Encabezado --}}
            <div class="mb-4">
                <label for="encabezado" class="block text-gray-700 font-medium">Encabezado</label>
                <input type="text" id="encabezado" name="encabezado"
                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Advertencia --}}
            <div class="mb-4">
                <label for="advertencia" class="block text-gray-700 font-medium">Advertencia (Opcional)</label>
                <input type="text" id="advertencia" name="advertencia"
                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Valor --}}
            <div class="mb-4">
                <label for="valor" class="block text-gray-700 font-medium">Valor (Opcional)</label>
                <input type="text" id="valor" name="valor"
                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Opciones para SELECT o SELECT_BUTTONS --}}
            <div id="opcionesSelect" class="mb-4 hidden">
                <label class="block text-gray-700 font-medium mb-2">Opciones</label>
                <div id="contenedorOpciones"></div>

                <button type="button" id="agregarOpcion"
                    class="mt-2 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    + Agregar opción
                </button>
            </div>

            {{-- Variables para bloquear --}}
            <div id="variablesBloqueo" class="mb-4 hidden">
                <label class="block text-gray-700 font-medium mb-2">Seleccionar variables a bloquear</label>
                <div class="grid grid-cols-1 gap-2">
                    @foreach ($variables as $variable)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="bloqueos[]" value="{{ $variable->id }}"
                                class="form-checkbox text-blue-500">
                            <span>{{ $variable->nombre }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('admin.variables.listView') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Guardar
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('openSidebar').addEventListener('click', function () {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            this.classList.add('hidden');
        });

        const tipoElemento = document.getElementById('tipo_elemento');
        const opcionesSelect = document.getElementById('opcionesSelect');
        const variablesBloqueo = document.getElementById('variablesBloqueo');
        const isPaisContainer = document.getElementById('isPaisContainer');
        const isPais = document.getElementById('isPais');

        tipoElemento.addEventListener('change', function () {
            const selected = this.value;

            const mostrarOpciones = selected === 'SELECT' || selected === 'SELECT_BUTTONS';

            // Mostrar u ocultar opcionesSelect solo si isPais no está activado
            if (mostrarOpciones && !isPais.checked) {
                opcionesSelect.classList.remove('hidden');
            } else {
                opcionesSelect.classList.add('hidden');
            }

            isPaisContainer.classList.toggle('hidden', !mostrarOpciones);
            variablesBloqueo.classList.toggle('hidden', selected !== 'CHECKBOX_RESTRICTIVE');
        });

        // Cuando el checkbox isPais cambia
        isPais.addEventListener('change', function () {
            // Si se marca, ocultar opcionesSelect
            if (this.checked) {
                opcionesSelect.classList.add('hidden');
            } else if (
                tipoElemento.value === 'SELECT' || tipoElemento.value === 'SELECT_BUTTONS'
            ) {
                // Solo mostrar si el tipo es válido
                opcionesSelect.classList.remove('hidden');
            }
        });

        document.getElementById("variableForm").addEventListener("submit", function (event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);

            // Ajustar campo de obligatoriedad (checkbox)
            formData.set('obligatoriedad', form.querySelector('[name="obligatoriedad"]').checked ? '1' : '0');

            // Ajustar bloqueos[] si existen
            const bloqueos = Array.from(form.querySelectorAll('[name="bloqueos[]"]:checked')).map(el => el.value);
            formData.delete('bloqueos[]');
            bloqueos.forEach(id => formData.append('bloqueos[]', id));

            fetch("/admin/variables/crear", {
                method: "POST",
                body: formData // No colocamos headers, el navegador lo hace automáticamente
            })
                .then(response => response.json().then(json => ({ status: response.status, body: json })))
                .then(result => {
                    if (result.status === 201) {
                        alert("✅ Variable registrada exitosamente");
                        location.reload();
                    } else {
                        alert(`❌ Error: ${result.body.message}`);
                    }
                })
                .catch(error => {
                    console.error("❌ Error inesperado:", error);
                    alert("❌ Ocurrió un error inesperado. Revisa la consola.");
                });
        });


        //LOGICA PARA AGREGAR LAS OPCIONES
        const contenedorOpciones = document.getElementById('contenedorOpciones');
        const btnAgregarOpcion = document.getElementById('agregarOpcion');

        btnAgregarOpcion.addEventListener('click', () => {
            const index = document.querySelectorAll('.opcion-item').length;

            const div = document.createElement('div');
            div.classList.add('opcion-item', 'mb-4', 'p-4', 'border', 'rounded', 'bg-gray-100');
            div.innerHTML = `
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700">Valor (opcional)</label>
                        <input type="text" name="opciones[${index}][valor]"
                            class="w-full p-2 border rounded" placeholder="Ej. valor123">
                    </div>
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700">Imagen</label>
                        <input type="file" name="opciones[${index}][imagen]" accept="image/*"
                            class="w-full p-2 border rounded">
                    </div>
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700">Contenido</label>
                        <input type="text" name="opciones[${index}][contenido]"
                            class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="opciones[${index}][global]" value="1"
                                class="form-checkbox h-5 w-5 text-blue-600">
                            <span class="ml-2 text-gray-700">¿Opción global?</span>
                        </label>
                    </div>
                `;

            contenedorOpciones.appendChild(div);
        });
    </script>
@endsection