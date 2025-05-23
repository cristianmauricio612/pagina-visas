@extends('layouts.public')

@section('title', 'Libro de Reclamaciones - Visas Travel')
@section('description', 'Libro de Reclamaciones de Visas Travel. Registre sus reclamos o quejas relacionados con nuestros servicios.')
@section('keyword', 'libro de reclamaciones, reclamos, quejas, visas travel, atención al cliente')

@push('resources')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js">
@endpush

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Navegación de migas de pan -->
    <div class="text-sm text-gray-500 mb-6">
        <a href="/" class="hover:text-blue-600">Inicio</a>
        <span class="mx-2">></span>
        <span class="font-bold">Libro de Reclamaciones</span>
    </div>

    <!-- Información importante -->
    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-8 rounded-md">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">HOJA DE RECLAMACIÓN</h3>
                <p class="mt-1 text-sm text-blue-700">
                    Si tiene algún reclamo o queja sobre nuestros servicios, por favor complete este formulario. Nos comprometemos a responder en un plazo máximo de <strong>30 días calendario</strong>.
                </p>
            </div>
        </div>
    </div>

    <!-- Formulario principal -->
    <form id="reclamacionForm" class="space-y-8">
        <!-- Sección 1: Identificación del Consumidor -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
            <h2 class="text-xl font-bold text-blue-800 mb-6 pb-2 border-b-2 border-blue-800">
                1. IDENTIFICACIÓN DEL CONSUMIDOR
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tipo de documento y número -->
                <div>
                    <label for="tipoDocumento" class="block text-sm font-medium text-gray-700 mb-2">
                        Tipo de Documento <span class="text-red-500">*</span>
                    </label>
                    <select id="tipoDocumento" name="tipo_documento" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="" disabled selected>Seleccione...</option>
                        <option value="DNI">DNI</option>
                        <option value="CE">Carné de Extranjería</option>
                        <option value="PASAPORTE">Pasaporte</option>
                    </select>
                    <div class="invalid-feedback text-red-500 text-sm mt-1 hidden">Este campo es requerido.</div>
                </div>

                <div>
                    <label for="numeroDocumento" class="block text-sm font-medium text-gray-700 mb-2">
                        N° de Documento <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="numeroDocumento" name="numero_documento"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Número de Documento" required>
                    <div class="invalid-feedback text-red-500 text-sm mt-1 hidden">Este campo es requerido.</div>
                </div>
            </div>

            <!-- Nombres y apellidos -->
            <div class="mt-6">
                <label for="nombresApellidos" class="block text-sm font-medium text-gray-700 mb-2">
                    Nombres y Apellidos <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nombresApellidos" name="nombres_apellidos"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Nombres y Apellidos completos" required>
                <div class="invalid-feedback text-red-500 text-sm mt-1 hidden">Este campo es requerido.</div>
            </div>

            <!-- Menor de edad y apoderado -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Menor de Edad</label>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="menor_edad" value="1" class="text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">SÍ</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="menor_edad" value="0" class="text-blue-600 focus:ring-blue-500" checked>
                            <span class="ml-2 text-sm text-gray-700">NO</span>
                        </label>
                    </div>
                </div>

                <div id="apoderadoContainer" class="hidden">
                    <label for="apoderado" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombres del Apoderado <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="apoderado" name="apoderado"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Nombres del Apoderado">
                    <div class="invalid-feedback text-red-500 text-sm mt-1 hidden">Este campo es requerido para menores de edad.</div>
                </div>
            </div>

            <!-- Dirección -->
            <div class="mt-6">
                <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">
                    Dirección / Localización <span class="text-red-500">*</span>
                </label>
                <input type="text" id="direccion" name="direccion"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Dirección completa" required>
                <div class="invalid-feedback text-red-500 text-sm mt-1 hidden">Este campo es requerido.</div>
            </div>

            <!-- Correo y teléfono -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="correo" class="block text-sm font-medium text-gray-700 mb-2">
                        Correo Electrónico <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="correo" name="correo"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="correo@ejemplo.com" required>
                    <div class="invalid-feedback text-red-500 text-sm mt-1 hidden">Por favor, ingrese un correo electrónico válido.</div>
                </div>

                <div>
                    <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                    <input type="tel" id="telefono" name="telefono"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Celular/Teléfono">
                </div>
            </div>
        </div>

        <!-- Sección 2: Identificación de la Queja o Reclamo -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
            <h2 class="text-xl font-bold text-blue-800 mb-6 pb-2 border-b-2 border-blue-800">
                2. IDENTIFICACIÓN DE LA QUEJA O RECLAMO
            </h2>

            <!-- Fecha del incidente y bien contratado -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="fechaIncidente" class="block text-sm font-medium text-gray-700 mb-2">
                        Fecha del incidente <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="fechaIncidente" name="fecha_incidente"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="dd/mm/aaaa" required>
                    <div class="invalid-feedback text-red-500 text-sm mt-1 hidden">Este campo es requerido.</div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Bien contratado <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="bien_contratado" value="Producto" class="text-blue-600 focus:ring-blue-500" checked>
                            <span class="ml-2 text-sm text-gray-700">Producto</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="bien_contratado" value="Servicio" class="text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Servicio</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Descripción del producto/servicio -->
            <div class="mt-6">
                <label for="descripcionBien" class="block text-sm font-medium text-gray-700 mb-2">
                    Identificación del producto o servicio adquirido <span class="text-red-500">*</span>
                </label>
                <textarea id="descripcionBien" name="descripcion_bien" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Descripción detallada del producto o servicio adquirido" required></textarea>
                <div class="invalid-feedback text-red-500 text-sm mt-1 hidden">Este campo es requerido.</div>
            </div>

            <!-- Tipo de incidente y monto -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tipo de incidente <span class="text-red-500">*</span>
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="tipo_incidente" value="Reclamo" class="text-blue-600 focus:ring-blue-500" checked>
                            <span class="ml-2 text-sm text-gray-700">Reclamo</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="tipo_incidente" value="Queja" class="text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Queja</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label for="monto" class="block text-sm font-medium text-gray-700 mb-2">Monto</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-500">$</span>
                        <input type="number" id="monto" name="monto" step="0.01" min="0"
                               class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="0.00">
                    </div>
                </div>
            </div>

            <!-- Información sobre tipos de incidente -->
            <div class="bg-cyan-50 border border-cyan-200 rounded-lg p-4 mt-6">
                <div class="text-sm text-cyan-800">
                    <p class="mb-2"><strong>Reclamo:</strong> Disconformidad relacionada a los productos o servicios.</p>
                    <p><strong>Queja:</strong> Disconformidad no relacionada a los productos, servicios o descontento respecto a la atención al público.</p>
                </div>
            </div>

            <!-- Detalle de lo ocurrido -->
            <div class="mt-6">
                <label for="detalle" class="block text-sm font-medium text-gray-700 mb-2">
                    Detalle de lo ocurrido <span class="text-red-500">*</span>
                </label>
                <textarea id="detalle" name="detalle" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Describa detalladamente lo ocurrido" required></textarea>
                <div class="invalid-feedback text-red-500 text-sm mt-1 hidden">Este campo es requerido.</div>
            </div>

            <!-- Pedido del consumidor -->
            <div class="mt-6">
                <label for="pedidoConsumidor" class="block text-sm font-medium text-gray-700 mb-2">
                    Pedido del consumidor <span class="text-red-500">*</span>
                </label>
                <textarea id="pedidoConsumidor" name="pedido_consumidor" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Describa qué espera como solución o respuesta" required></textarea>
                <div class="invalid-feedback text-red-500 text-sm mt-1 hidden">Este campo es requerido.</div>
            </div>
        </div>

        <!-- CAPTCHA -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
            <h2 class="text-xl font-bold text-blue-800 mb-6 pb-2 border-b-2 border-blue-800">
                3. VERIFICACIÓN DE SEGURIDAD
            </h2>

            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-4">Por favor, complete la verificación de seguridad para enviar su reclamación.</p>

                <!-- CAPTCHA Simple Matemático -->
                <div class="bg-gray-50 p-4 rounded-md border border-gray-300">
                    <label for="captcha" class="block text-sm font-medium text-gray-700 mb-2">
                        Resuelva la siguiente operación: <span id="captchaQuestion" class="font-bold text-lg"></span> <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="captcha" name="captcha"
                           class="w-32 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="?" required>
                    <input type="hidden" id="captchaAnswer" name="captcha_answer">
                    <div class="invalid-feedback text-red-500 text-sm mt-1 hidden">Por favor, ingrese la respuesta correcta.</div>

                    <button type="button" id="refreshCaptcha" class="mt-2 text-blue-600 hover:text-blue-800 text-sm flex items-center focus:outline-none border-0">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Generar nueva pregunta
                    </button>
                </div>
            </div>

            <!-- Alternativa: Google reCAPTCHA (comentado) -->
            <!-- Para usar Google reCAPTCHA, descomente el siguiente código y agregue su clave del sitio -->
            <!-- <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY"></div> -->
        </div>

        <!-- Botón de envío -->
        <div class="text-center">
            <button type="submit" id="btnEnviar"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg text-lg transition duration-300 shadow-lg hover:shadow-xl border-0">
                <span id="btnTexto">ENVIAR RECLAMACIÓN</span>
                <svg id="btnSpinner" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        </div>
    </form>
</div>

<!-- Modal de confirmación -->
<div id="modalConfirmacion" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
    <div class="relative mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">¡Reclamación Enviada!</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Su reclamación ha sido registrada exitosamente. Le responderemos en un plazo máximo de 30 días calendario.
                </p>
            </div>
            <div class="items-center px-4 py-3 border-0">
                <button id="btnCerrarModal"
                        class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar datepicker
    flatpickr("#fechaIncidente", {
        dateFormat: "d/m/Y",
        locale: "es",
        maxDate: "today",
        allowInput: true,
        placeholder: "dd/mm/aaaa"
    });

    // CAPTCHA Simple
    let captchaAnswer = 0;

    function generateCaptcha() {
        const num1 = Math.floor(Math.random() * 10) + 1;
        const num2 = Math.floor(Math.random() * 10) + 1;
        const operations = ['+', '-', '*'];
        const operation = operations[Math.floor(Math.random() * operations.length)];

        let question = '';

        switch(operation) {
            case '+':
                captchaAnswer = num1 + num2;
                question = `${num1} + ${num2} = `;
                break;
            case '-':
                // Asegurar que el resultado no sea negativo
                const max = Math.max(num1, num2);
                const min = Math.min(num1, num2);
                captchaAnswer = max - min;
                question = `${max} - ${min} = `;
                break;
            case '*':
                captchaAnswer = num1 * num2;
                question = `${num1} × ${num2} = `;
                break;
        }

        document.getElementById('captchaQuestion').textContent = question;
        document.getElementById('captchaAnswer').value = captchaAnswer;
        document.getElementById('captcha').value = '';
    }

    // Generar CAPTCHA inicial
    generateCaptcha();

    // Botón para refrescar CAPTCHA
    document.getElementById('refreshCaptcha').addEventListener('click', function() {
        generateCaptcha();
        const captchaInput = document.getElementById('captcha');
        captchaInput.classList.remove('border-red-500');
        const errorElement = captchaInput.parentNode.querySelector('.invalid-feedback');
        if (errorElement) {
            errorElement.classList.add('hidden');
        }
    });

    // Manejar menor de edad
    const menorEdadRadios = document.querySelectorAll('input[name="menor_edad"]');
    const apoderadoContainer = document.getElementById('apoderadoContainer');
    const apoderadoInput = document.getElementById('apoderado');

    function toggleApoderado() {
        const esMenor = document.querySelector('input[name="menor_edad"]:checked').value === '1';
        if (esMenor) {
            apoderadoContainer.classList.remove('hidden');
            apoderadoInput.setAttribute('required', '');
        } else {
            apoderadoContainer.classList.add('hidden');
            apoderadoInput.removeAttribute('required');
            apoderadoInput.value = '';
        }
    }

    menorEdadRadios.forEach(radio => {
        radio.addEventListener('change', toggleApoderado);
    });

    // Validación del formulario
    const form = document.getElementById('reclamacionForm');
    const btnEnviar = document.getElementById('btnEnviar');
    const btnTexto = document.getElementById('btnTexto');
    const btnSpinner = document.getElementById('btnSpinner');
    const modal = document.getElementById('modalConfirmacion');
    const btnCerrarModal = document.getElementById('btnCerrarModal');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        if (!validateForm()) {
            return false;
        }

        // Mostrar spinner
        btnTexto.textContent = 'Enviando...';
        btnSpinner.classList.remove('hidden');
        btnEnviar.disabled = true;

        // Recoger datos del formulario
        const formData = new FormData(form);
        const jsonData = {};

        formData.forEach((value, key) => {
            jsonData[key] = value;
        });

        // Convertir menor_edad a boolean
        jsonData.menor_edad = jsonData.menor_edad === "1";

        // Enviar datos
        fetch('{{ route("registrar-reclamacion") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf()->token() }}'
            },
            body: JSON.stringify(jsonData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Mostrar modal de confirmación
                modal.classList.remove('hidden');
                form.reset();
                // Ocultar apoderado si se reinicia el form
                apoderadoContainer.classList.add('hidden');
                apoderadoInput.removeAttribute('required');
            } else {
                alert('Error: ' + (data.message || 'Ocurrió un error inesperado'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ocurrió un error al procesar la solicitud. Por favor, inténtelo nuevamente.');
        })
        .finally(() => {
            // Restaurar botón
            btnTexto.textContent = 'ENVIAR RECLAMACIÓN';
            btnSpinner.classList.add('hidden');
            btnEnviar.disabled = false;
        });
    });

    // Cerrar modal
    btnCerrarModal.addEventListener('click', function() {
        modal.classList.add('hidden');
        window.location.href = '{{ route("reclamacion-exitosa") }}';
    });

    // Cerrar modal al hacer clic fuera
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });

    function validateForm() {
        let isValid = true;

        // Limpiar errores previos
        document.querySelectorAll('.invalid-feedback').forEach(error => {
            error.classList.add('hidden');
        });
        document.querySelectorAll('.border-red-500').forEach(field => {
            field.classList.remove('border-red-500');
        });

        // Validar campos requeridos
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                showError(field, 'Este campo es requerido.');
                isValid = false;
            }
        });

        // Validar email
        const emailField = document.getElementById('correo');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailField.value && !emailRegex.test(emailField.value)) {
            showError(emailField, 'Por favor, ingrese un correo electrónico válido.');
            isValid = false;
        }

        // Validar fecha
        const fechaField = document.getElementById('fechaIncidente');
        const fechaRegex = /^\d{1,2}\/\d{1,2}\/\d{4}$/;
        if (fechaField.value && !fechaRegex.test(fechaField.value)) {
            showError(fechaField, 'El formato de fecha debe ser dd/mm/aaaa.');
            isValid = false;
        }

        // Validar apoderado si es menor de edad
        const esMenor = document.querySelector('input[name="menor_edad"]:checked').value === '1';
        if (esMenor && !apoderadoInput.value.trim()) {
            showError(apoderadoInput, 'Este campo es requerido para menores de edad.');
            isValid = false;
        }

        // Validar CAPTCHA
        const captchaInput = document.getElementById('captcha');
        const captchaUserAnswer = parseInt(captchaInput.value);
        const captchaCorrectAnswer = parseInt(document.getElementById('captchaAnswer').value);

        if (!captchaInput.value.trim()) {
            showError(captchaInput, 'Por favor, resuelva la operación matemática.');
            isValid = false;
        } else if (captchaUserAnswer !== captchaCorrectAnswer) {
            showError(captchaInput, 'La respuesta es incorrecta. Por favor, inténtelo nuevamente.');
            isValid = false;
            // Generar nuevo CAPTCHA si falla
            setTimeout(() => {
                generateCaptcha();
            }, 1000);
        }

        return isValid;
    }

    function showError(field, message) {
        field.classList.add('border-red-500');
        const errorElement = field.parentNode.querySelector('.invalid-feedback');
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
        }
    }
});
</script>
@endpush
