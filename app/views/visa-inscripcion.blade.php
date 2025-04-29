@extends('layouts.public')

@section('title', 'Visa-Inscripcion')

@push('resources')
    <link rel="stylesheet" href="{{ assets("css/visa-inscripcion.css") }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')
    @php
        $contadorViajero = 1;
        $paises = \App\Models\Pais::all();
        $pais1 = \App\Models\Pais::find($visa->pais1_id);
        $pais2 = \App\Models\Pais::find($visa->pais2_id);

        $viajero1 = new App\Models\Viajero();

        $viajeros = [$viajero1];
        $formulario = \App\Models\Formulario::with('variables')->where('visa_id', $visa->id)->first();
    @endphp
    <div class="visa-inscripcion" id="visa-inscripcion">
        <div class="visa-inscripcion-container">
            <div class="visa-inscripcion-title">
                <h1 class="inscripcion-title-text">
                    <span>{{ $visa->nombre }}</span>
                </h1>
            </div>

            <div>
                <div class="visa-inscripcion-progress">
                    <div class="inscripcion-progress-points">
                        <span id="point1" class="inscripcion-point-container inscripcion-point-active">
                            <span class="inscripcion-point">1</span>
                        </span>
                        <span class="inscripcion-point-text">Detalles del viaje</span>
                    </div>

                    <div id="bar1" class="inscripcion-progress-bar"></div>

                    <div class="inscripcion-progress-points"
                        style="--tw-space-x-reverse: 0; margin-right: calc(32px* var(--tw-space-x-reverse)); margin-left: calc(32px* calc(1 - var(--tw-space-x-reverse)));">
                        <span id="point2" class="inscripcion-point-container">
                            <span class="inscripcion-point">2</span>
                        </span>
                        <span class="inscripcion-point-text">Información personal</span>
                    </div>

                    <div id="bar2" class="inscripcion-progress-bar"></div>

                    <div class="inscripcion-progress-points"
                        style="--tw-space-x-reverse: 0; margin-right: calc(32px* var(--tw-space-x-reverse)); margin-left: calc(32px* calc(1 - var(--tw-space-x-reverse)));">
                        <span id="point3" class="inscripcion-point-container">
                            <span class="inscripcion-point">3</span>
                        </span>
                        <span class="inscripcion-point-text">Pago</span>
                    </div>
                </div>
            </div>

            <div class="tab" id="tab1" style="">
                <div class="tab-form">
                    <div>
                        <div class="tab-form-title">
                            <span class="form-title-text">Detalles de tu viaje</span>
                        </div>

                        <div class="tab-form-box">

                            @foreach ($formulario->variables as $variable)
                                @if ($variable->tipo_variable === 'VISA')
                                    @if ($variable->tipo_elemento === 'DATE_PICKER')
                                        @include('ui.DatePicker')
                                    @endif
                                    @if ($variable->tipo_elemento === 'INPUT_TEXT' || $variable->tipo_elemento === 'INPUT_NUMBER')
                                        @include('ui.Input')
                                    @endif
                                    @if ($variable->tipo_elemento === 'CHECKBOX_RESTRICTIVE')
                                        @include('ui.Checkbox')
                                    @endif
                                    @if ($variable->tipo_elemento === 'SELECT')
                                        @include('ui.Select')
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="tab-information">
                    <div class="tab-information-container">
                        <div class="tab-information-box">
                            <div class="information-box" data-handle="sidebar-summary-breakdown">
                                <div class="information-box-title">
                                    <ul class="information-title-text">
                                        <li>{{ $visa->nombre }}</li>
                                    </ul>
                                </div>

                                <div class="information-pago-hoy" style="display: none;">
                                    <span style="flex: 1 1 0%;">Pago a realizar hoy&nbsp;</span>
                                    <span style="text-wrap: nowrap; width: fit-content;">
                                        $. {{ $visa->precio * $contadorViajero}}
                                    </span>
                                </div>

                                <div class="information-pago-extra">
                                    @for ($i = 0; $i < $contadorViajero; $i++)
                                        <div class="information-pago-tasas">
                                            <span style="flex: 1 1 0%;">Tasas gubernamentales</span>
                                            <span style="text-wrap: nowrap; width: fit-content;">
                                                $. {{ $visa->tasa_gobierno }}
                                            </span>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="information-box-total">
                                <div class="box-total-text">
                                    <span>Total a pagar hoy</span>
                                    <span>Se calculará al momento de pagar</span>
                                </div>
                                <div class="gx zj bk"></div>
                            </div>
                        </div>

                        <div class="tab-information-buttons">
                            <button class="tab-button-continuar" id="btnContinueSidebar">
                                <span class="">Guardar y continuar</span>
                            </button>

                            <div
                                style="--tw-space-y-reverse: 0; margin-top: calc(24px* calc(1 - var(--tw-space-y-reverse))); margin-bottom: calc(24px* var(--tw-space-y-reverse));">
                                <button class="tab-button-retroceder" id="btnPreviousSidebar">
                                    <i class="fa-solid fa-arrow-left-long"></i>
                                    <span>Atrás</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab" id="tab2" style="display: none;">
                <div class="tab-form">
                    <div>
                        <div class="tab-form-title">
                            <span class="form-title-text">Tus datos personales</span>
                        </div>

                        <div>
                            <p class="form-title-warning">Asegúrate de que coincidan exactamente con los datos de tu
                                pasaporte.</p>
                        </div>

                        <div class="tab-viajero-box">
                            <div class="tab-viajero-select">
                                <div class="tab-viajero-text">
                                    <span class="viajero-text">Viajero #1</span>
                                </div>
                                <div class="tab-viajero-icon">
                                    <div class="ge">
                                        <i class="fa-solid fa-chevron-down" style="font-size: 14px;"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-viajero-form hidden">
                                @foreach ($formulario->variables as $variable)
                                    @if ($variable->tipo_variable === 'VIAJERO')
                                        @if ($variable->tipo_elemento === 'DATE_PICKER')
                                            @include('ui.DatePicker')
                                        @endif
                                        @if ($variable->tipo_elemento === 'INPUT_TEXT' || $variable->tipo_elemento === 'INPUT_NUMBER')
                                            @include('ui.Input')
                                        @endif
                                        @if ($variable->tipo_elemento === 'CHECKBOX_RESTRICTIVE')
                                            @include('ui.Checkbox')
                                        @endif
                                        @if ($variable->tipo_elemento === 'SELECT')
                                            @include('ui.Select')
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div id="contenedor-viajeros">
                        <!-- Aquí se agregarán los formularios dinámicamente -->
                    </div>

                    <div class="add-form">
                        <button class="add-form-button" onclick="agregarViajero()">
                            <div style="display: inline; margin-right: 10px; font-size: 16px;">
                                <i class="fa-solid fa-circle-plus"></i>
                            </div>
                            <span>Añadir otro viajero</span>
                        </button>
                    </div>
                </div>

                <div class="tab-information">
                    <div class="tab-information-container">
                        <div class="tab-information-box">
                            <div class="information-box" data-handle="sidebar-summary-breakdown">
                                <div class="information-box-title">
                                    <ul class="information-title-text">
                                        <li>{{ $visa->nombre }}</li>
                                    </ul>
                                </div>

                                <div class="information-pago-hoy" style="display: none;">
                                    <span style="flex: 1 1 0%;">Pago a realizar hoy&nbsp;</span>
                                    <span style="text-wrap: nowrap; width: fit-content;">
                                        $. {{ $visa->precio * $contadorViajero}}
                                    </span>
                                </div>

                                <div class="information-pago-extra">
                                    @for ($i = 0; $i < $contadorViajero; $i++)
                                        <div class="information-pago-tasas">
                                            <span style="flex: 1 1 0%;">Tasas gubernamentales</span>
                                            <span style="text-wrap: nowrap; width: fit-content;">
                                                $. {{ $visa->tasa_gobierno }}
                                            </span>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="information-box-total">
                                <div class="box-total-text">
                                    <span>Total a pagar hoy</span>
                                    <span>Se calculará al momento de pagar</span>
                                </div>
                                <div class="gx zj bk"></div>
                            </div>
                        </div>

                        <div class="tab-information-buttons">
                            <button class="tab-button-continuar" id="btnContinueSidebar">
                                <span class="">Guardar y continuar</span>
                            </button>

                            <div
                                style="--tw-space-y-reverse: 0; margin-top: calc(24px* calc(1 - var(--tw-space-y-reverse))); margin-bottom: calc(24px* var(--tw-space-y-reverse));">
                                <button class="tab-button-retroceder" id="btnPreviousSidebar">
                                    <i class="fa-solid fa-arrow-left-long"></i>
                                    <span>Atrás</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab" id="tab3" style="display: none;">
                <div class="tab-form">
                    <div id="viajeros-info-extra">

                        <div class="tab-form-title">
                            <span class="form-title-text">Tu información del pasaporte</span>
                        </div>

                        @for ($i = 0; $i < $contadorViajero; $i++)
                            <div class="tab-viajero-box">
                                <div class="tab-viajero-select">
                                    <div class="tab-viajero-text">
                                        <span class="viajero-text">Viajero #{{ $i + 1 }}</span>
                                    </div>
                                    <div class="tab-viajero-icon">
                                        <div class="ge">
                                            <i class="fa-solid fa-chevron-down" style="font-size: 14px;"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-viajero-form hidden">
                                    @foreach ($formulario->variables as $variable)
                                        @if ($variable->tipo_variable === 'PASAPORTE')
                                            @if ($variable->tipo_elemento === 'DATE_PICKER')
                                                @include('ui.DatePicker')
                                            @endif
                                            @if ($variable->tipo_elemento === 'INPUT_TEXT' || $variable->tipo_elemento === 'INPUT_NUMBER')
                                                @include('ui.Input')
                                            @endif
                                            @if ($variable->tipo_elemento === 'CHECKBOX_RESTRICTIVE')
                                                @include('ui.Checkbox')
                                            @endif
                                            @if ($variable->tipo_elemento === 'SELECT')
                                                @include('ui.Select')
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="tab-information">
                    <div class="tab-information-container">
                        <div class="tab-information-box">
                            <div class="information-box" data-handle="sidebar-summary-breakdown">
                                <div class="information-box-title">
                                    <ul class="information-title-text">
                                        <li>{{ $visa->nombre }}</li>
                                    </ul>
                                </div>

                                <div class="information-pago-hoy" style="display: none;">
                                    <span style="flex: 1 1 0%;">Pago a realizar hoy&nbsp;</span>
                                    <span style="text-wrap: nowrap; width: fit-content;">
                                        $. {{ $visa->precio * $contadorViajero}}
                                    </span>
                                </div>

                                <div class="information-pago-extra">
                                    @for ($i = 0; $i < $contadorViajero; $i++)
                                        <div class="information-pago-tasas">
                                            <span style="flex: 1 1 0%;">Tasas gubernamentales</span>
                                            <span style="text-wrap: nowrap; width: fit-content;">
                                                $. {{ $visa->tasa_gobierno }}
                                            </span>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="information-box-total">
                                <div class="box-total-text">
                                    <span>Total a pagar hoy</span>
                                    <span>Se calculará al momento de pagar</span>
                                </div>
                                <div class="gx zj bk"></div>
                            </div>
                        </div>

                        <div class="tab-information-buttons">
                            <button class="tab-button-continuar" id="btnContinueSidebar">
                                <span class="">Guardar y continuar</span>
                            </button>

                            <div
                                style="--tw-space-y-reverse: 0; margin-top: calc(24px* calc(1 - var(--tw-space-y-reverse))); margin-bottom: calc(24px* var(--tw-space-y-reverse));">
                                <button class="tab-button-retroceder" id="btnPreviousSidebar">
                                    <i class="fa-solid fa-arrow-left-long"></i>
                                    <span>Atrás</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="revisar-solicitud" id="revisar-solicitud" style="display: none;">
        <div class="revisar-solicitud-container">
            <div class="visa-inscripcion-title" style="margin-top: 18px;">
                <h1 class="inscripcion-title-text">
                    <span class="inscripcion-title-span">Revisa tu solicitud</span>
                </h1>
            </div>

            <div class="tab">
                <div class="tab-form">
                    <div class="informacion-completa">
                        <div class="informacion-general">
                            <div class="informacion-general-box">
                                <div class="informacion-general-nombre">
                                    <h2>{{ $visa->nombre }}</h2>
                                    <img src="{{ $pais2->imagen }}" height="40" width="40">
                                </div>

                                <p class="informacion-general-item">Válido por: <span class="info-general-item-black">2 años
                                        desde la emisión</span></p>
                                <p class="informacion-general-item">Estancia máxima: <span class="info-general-item-black">2
                                        años por entrada</span></p>
                                <p class="informacion-general-item" style="margin: 0;">Número de entradas: <span
                                        class="info-general-item-black">Entrada múltiple</span></p>
                            </div>
                        </div>
                        <div class="viajeros-box">
                            <h5 class="viajeros-box-title">Viajeros</h5>
                            @foreach ($viajeros as $viajero)
                                <div class="viajeros-box-item">
                                    <div style="display: inline;">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <p style="word-break: break-word; margin-bottom: 0;">{{ $viajero->nombres_pasaporte }}
                                        {{ $viajero->apellidos_pasaporte }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="tab-information">
                    <div class="tab-information-container">
                        <div class="information-box-final" data-handle="sidebar-summary-breakdown">
                            <div class="information-box-title">
                                <ul class="information-title-text">
                                    <li>{{ $visa->nombre }}</li>
                                </ul>
                            </div>

                            <div class="information-pago-hoy">
                                <span style="flex: 1 1 0%;">Servicio de trámite y asesoría&nbsp;</span>
                                <span style="text-wrap: nowrap; width: fit-content;">
                                    $. {{ $visa->precio * $contadorViajero}}
                                </span>
                            </div>

                            <div class="information-pago-extra">
                                @for ($i = 0; $i < $contadorViajero; $i++)
                                    <div class="information-pago-tasas">
                                        <span style="flex: 1 1 0%;">Tasas gubernamentales</span>
                                        <span style="text-wrap: nowrap; width: fit-content;">
                                            $. {{ $visa->tasa_gobierno }}
                                        </span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <div class="information-box-total">
                            <div id="precioTotal" class="box-total-text">
                                <span>Total a pagar hoy</span>
                                <span>USD $. {{ ($visa->precio + $visa->tasa_gobierno) * $contadorViajero }}</span>
                            </div>
                        </div>

                        <div class="tab-information-buttons">
                            <button class="tab-button-continuar" id="btnContinuePay">
                                <span class="">Continuar con el pago</span>
                            </button>

                            <div
                                style="--tw-space-y-reverse: 0; margin-top: calc(24px* calc(1 - var(--tw-space-y-reverse))); margin-bottom: calc(24px* var(--tw-space-y-reverse));">
                                <button class="tab-button-retroceder" id="btnPreviousSidebar">
                                    <i class="fa-solid fa-arrow-left-long"></i>
                                    <span>Atrás</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        function inicializarDatePickers(context = document) {
            const inputs = context.querySelectorAll('.date-picker');

            inputs.forEach(input => {
                if (input._flatpickr) return; // Ya tiene flatpickr inicializado

                const minMonths = parseInt(input.dataset.minMonths || "0");

                const today = new Date();
                const minDate = minMonths > 0
                    ? new Date(today.getFullYear(), today.getMonth() + minMonths, today.getDate())
                    : null;

                const calendar = flatpickr(input, {
                    dateFormat: "d/m/Y",
                    minDate: minDate,
                    allowInput: false,
                    clickOpens: true,
                    positionElement: input,
                    showMonths: 2,
                    onReady: function(selectedDates, dateStr, instance) {
                        // Mostrar la selección de año por defecto si no hay restricción
                        if (!minDate) {
                            instance.currentYearElement.click();
                        }
                    }
                });

                const openCalendar = () => {
                    input.focus();
                    setTimeout(() => {
                        calendar.open();
                        if (!minDate) {
                            calendar.currentYearElement?.click(); // Abrir selector de año si no hay minDate
                        }
                    }, 100);
                };

                input.addEventListener("click", openCalendar);
            });
        }


        document.addEventListener("DOMContentLoaded", function () {
            inicializarDatePickers();
        });
    </script>

    <script>
        //SI FUNCIONA
        document.addEventListener("click", function (event) {
            // Obtener todos los dropdowns
            const allDropdowns = document.querySelectorAll(".dropdown-form");

            // Si el clic fue en una opción dentro del dropdown
            const option = event.target.closest(".option");
            if (option) {
                const dropdown = option.closest(".dropdown-form");
                const select = dropdown.closest(".custom-select");
                const selectedOption = select.querySelector(".selected-option");

                const selectedId = option.getAttribute("data-value"); // Obtener el ID seleccionado
                const optionHTML = option.innerHTML; // Copiar contenido HTML (imagen + texto si hay)

                // **Actualizar UI del select**
                selectedOption.innerHTML = optionHTML;
                selectedOption.setAttribute("data-value", selectedId);

                // Cerrar dropdown
                dropdown.style.display = "none";
                return;
            }

            // Verificar si el clic fue dentro de un custom-select
            const select = event.target.closest(".custom-select");

            if (select) {
                const selectedOption = select.querySelector(".selected-option");
                const dropdown = select.querySelector(".dropdown-form");

                // Cerrar todos los dropdowns antes de abrir el actual
                allDropdowns.forEach(d => {
                    if (d !== dropdown) d.style.display = "none";
                });

                // Alternar visibilidad
                dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";

                // Enfocar en el input de búsqueda cuando se abre
                const searchInput = dropdown.querySelector(".search-input");
                if (dropdown.style.display === "block") {
                    searchInput.focus();
                }

                return; // Evita que se cierre inmediatamente
            }

            // Si el clic fue fuera de cualquier select, cerrar todos los dropdowns abiertos
            allDropdowns.forEach(d => d.style.display = "none");
        });

        //SI FUNCIONA
        // Manejar el filtrado de opciones en el dropdown
        document.addEventListener("input", function (event) {
            if (event.target.classList.contains("search-input")) {
                const searchTerm = event.target.value.toLowerCase();
                const optionsList = event.target.closest(".dropdown-form").querySelectorAll(".option");

                optionsList.forEach(option => {
                    const text = option.textContent.toLowerCase();
                    option.style.display = text.includes(searchTerm) ? "flex" : "none";
                });
            }
        });
    </script>

    <script>
        let contadorViajero = @json($contadorViajero);
        const visa = @json($visa);

        //SI FUNCIONA
        function actualizarPagos() {
            let precioVisa = parseFloat(visa.precio);
            let tasaGobierno = parseFloat(visa.tasa_gobierno);

            // Actualizar TODAS las secciones de pago total
            document.querySelectorAll(".information-pago-hoy span:nth-child(2)").forEach(pagoHoy => {
                pagoHoy.textContent = `$. ${precioVisa * contadorViajero}`;
            });

            // Actualizar TODAS las secciones de tasas gubernamentales
            document.querySelectorAll(".information-pago-extra").forEach(contenedorTasas => {
                contenedorTasas.innerHTML = ""; // Vaciar el contenedor antes de agregar nuevas tasas
                for (let i = 0; i < contadorViajero; i++) {
                    let tasaDiv = document.createElement("div");
                    tasaDiv.classList.add("information-pago-tasas");
                    tasaDiv.innerHTML = `
                                    <span style="flex: 1 1 0%;">Tasas gubernamentales</span>
                                    <span style="text-wrap: nowrap; width: fit-content;">$. ${tasaGobierno}</span>
                                `;
                    contenedorTasas.appendChild(tasaDiv);
                }
            });
        }

        //SI FUNCIONA
        function agregarViajero() {
            console.log("Cantidad: " + contadorViajero);
            let contenedor = document.getElementById("contenedor-viajeros");
            contadorViajero++; // Incrementa el número del viajero

            // Clonar el primer viajero (que contiene los componentes dinámicos)
            const primerViajero = document.querySelector('.tab-viajero-box');

            // Mostrar indicador de carga
            const nuevoViajero = document.createElement('div');
            nuevoViajero.innerHTML = '<div class="loading">Cargando...</div>';

            // Añadir el nuevo viajero al contenedor primero para dar feedback visual
            contenedor.appendChild(nuevoViajero);
            console.log("Cantidad modificada: " + contadorViajero);

            // Cargar el contenido desde el servidor
            fetch(`/cargar-viajero/{{ $formulario->id }}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error al cargar el viajero');
                    }
                    return response.text();
                })
                .then(html => {
                    // Reemplazar el contenido del nuevo viajero con el HTML obtenido
                    nuevoViajero.innerHTML = html;

                    console.log(nuevoViajero);

                    // Actualizar el título/número del viajero
                    const tituloViajero = nuevoViajero.querySelector('.viajero-text');
                    if (tituloViajero) {
                        tituloViajero.textContent = `Viajero #${contadorViajero}`;
                    }

                    // Ya no es necesario limpiar los inputs pues vienen limpios del servidor

                    // Añadir el botón para eliminar el viajero
                    const deleteButton = document.createElement('div');
                    deleteButton.className = 'delete-form';
                    deleteButton.innerHTML = `
                                    <div style="display: inline; margin-right: 10px; font-size: 16px;">
                                        <i class="fa-solid fa-trash"></i>
                                    </div>
                                    <span>Eliminar viajero</span>
                                `;
                    deleteButton.onclick = function () { eliminarViajero(this); };

                    // Encontrar el contenedor del formulario y añadir el botón
                    const formularioViajero = nuevoViajero.querySelector('.tab-viajero-form');
                    if (formularioViajero) {
                        formularioViajero.appendChild(deleteButton);
                    }

                    contenedor.appendChild(nuevoViajero);

                    // 🚀 Re-inicializar flatpickr SOLO en el nuevo viajero
                    inicializarDatePickers(nuevoViajero);

                    // Actualizar los precios en el sidebar
                    actualizarPagos();
                })
                .catch(error => {
                    console.error('Error:', error);
                    nuevoViajero.innerHTML = '<div class="error">Error al cargar el formulario. Intente nuevamente.</div>';

                    const botonReintentar = document.createElement('button');
                    botonReintentar.textContent = 'Reintentar';
                    botonReintentar.className = 'btn btn-sm btn-warning mt-2';
                    botonReintentar.onclick = () => {
                        nuevoViajero.remove();
                        contadorViajero--;
                        agregarViajero();
                    };
                    nuevoViajero.appendChild(botonReintentar);
                });
        }

        //SI FUNCIONA
        function eliminarViajero(boton) {
            contadorViajero--;

            // Obtener el contenedor completo del viajero a eliminar
            const contenedorViajero = boton.closest('.tab-viajero-box');
            if (contenedorViajero) {
                contenedorViajero.remove();
            }

            // Actualizar numeración de viajeros
            const contenedoresViajeros = document.querySelectorAll('.tab-viajero-box');
            contenedoresViajeros.forEach((contenedor, index) => {
                const tituloViajero = contenedor.querySelector('.viajero-text');
                if (tituloViajero) {
                    tituloViajero.textContent = `Viajero #${index + 1}`;
                }
            });

            actualizarPagos();
        }

        //SI FUNCIONA
        document.addEventListener("click", function (event) {
            // Verifica si el clic fue en un .tab-viajero-select
            if (event.target.closest(".tab-viajero-select")) {
                let select = event.target.closest(".tab-viajero-select");
                let icono = select.querySelector(".tab-viajero-icon");
                let formulario = select.nextElementSibling; // El formulario justo después

                if (!formulario) return; // Evita errores si no hay formulario

                // Alternar clases en los elementos correspondientes
                select.classList.toggle("viajero-select-active");
                icono.classList.toggle("viajero-icon-rotated");
                formulario.classList.toggle("hidden");
            }

            if (event.target.closest(".tab-button-retroceder")) {
                let buttons = Array.from(document.querySelectorAll(".tab-button-retroceder"));
                let button = event.target.closest(".tab-button-retroceder");
                let index = buttons.indexOf(button);

                let tab1 = document.getElementById("tab1");
                let tab2 = document.getElementById("tab2");
                let tab3 = document.getElementById("tab3");
                let form = document.getElementById("visa-inscripcion");
                let revision = document.getElementById("revisar-solicitud");
                let point1 = document.getElementById("point1");
                let bar1 = document.getElementById("bar1");
                let point2 = document.getElementById("point2");
                let bar2 = document.getElementById("bar2");
                let point3 = document.getElementById("point3");

                switch (index) {
                    case 0:
                        window.history.back(); // Regresar a la página anterior
                        break;
                    case 1:
                        tab1.style.display = "grid";
                        tab2.style.display = "none";
                        bar1.classList.remove("inscripcion-bar-active");
                        point2.classList.remove("inscripcion-point-active");
                        // Restaurar datos del tab1
                        setTimeout(restaurarDatosTab1, 100);
                        break;
                    case 2:
                        tab2.style.display = "grid";
                        tab3.style.display = "none";
                        bar2.classList.remove("inscripcion-bar-active");
                        point3.classList.remove("inscripcion-point-active");
                        // Restaurar datos del tab2
                        setTimeout(restaurarDatosTab2, 100);
                        break;
                    case 3:
                        form.style.display = "grid";
                        revision.style.display = "none";
                        break;
                    default:
                        console.warn("Botón no reconocido");
                }
            }
        });
    </script>

    <script>
        const paises = @json($paises);
        let pais1 = @json($pais1);
        let pais2 = @json($pais2);

        const csrfToken = "{{ csrf()->token() }}";
        //SI FUNCIONA
        // Función para restaurar datos de viajeros cuando se vuelve al tab2
        function restaurarDatosTab2() {
            if (formData.viajeros && formData.viajeros.length > 0) {
                // Obtener todos los contenedores de viajeros actuales
                let contenedoresViajeros = document.querySelectorAll('.tab-viajero-box');

                // Si hay menos contenedores que viajeros, crear los necesarios
                while (contenedoresViajeros.length < formData.viajeros.length) {
                    agregarViajero();
                    contenedoresViajeros = document.querySelectorAll('.tab-viajero-box');
                }

                // Restaurar los datos de cada viajero
                formData.viajeros.forEach((viajero, index) => {
                    const contenedor = contenedoresViajeros[index];

                    // Abrir el formulario del viajero si está cerrado
                    const formularioViajero = contenedor.querySelector('.tab-viajero-form');
                    if (formularioViajero && formularioViajero.classList.contains('hidden')) {
                        // Simular clic en el encabezado para abrir el formulario
                        const encabezado = contenedor.querySelector('.tab-viajero-select');
                        if (encabezado) {
                            encabezado.click();
                        }
                    }

                    // Restaurar cada campo del viajero
                    for (const [campo, valor] of Object.entries(viajero)) {
                        // Buscar elementos con el nombre exacto o con corchetes []
                        const selectorCampo = `[name="${campo}"], [name="${campo}[]"]`;
                        const elementos = contenedor.querySelectorAll(selectorCampo);

                        elementos.forEach(elemento => {
                            if (elemento.classList.contains('date-picker')) {
                                elemento.value = valor;
                            } else if (elemento.type === 'checkbox') {
                                elemento.checked = valor;
                            } else if (elemento.classList.contains('selected-option')) {
                                elemento.setAttribute('data-value', valor);

                                // Buscar la opción correspondiente para mostrar el texto adecuado
                                const dropdown = elemento.closest('.custom-select');
                                if (dropdown) {
                                    const opcion = dropdown.querySelector(`.option[data-value="${valor}"]`);
                                    if (opcion) {
                                        elemento.innerHTML = opcion.innerHTML;
                                    }
                                }
                            } else if (elemento.tagName.toLowerCase() === 'input') {
                                elemento.value = valor;
                            } else if (elemento.tagName.toLowerCase() === 'select') {
                                elemento.value = valor;
                            }
                        });
                    }
                });
            }
        }

        //SI FUNCIONA
        // Función para restaurar datos cuando se vuelve al tab1
        function restaurarDatosTab1() {
            if (formData.variables_dinamicas) {
                // Recorrer todas las variables dinámicas almacenadas
                for (const [nombreCampo, valor] of Object.entries(formData.variables_dinamicas)) {
                    // Buscar el elemento correspondiente
                    const elemento = document.querySelector(`[name="${nombreCampo}"]`) || document.querySelector(`#${nombreCampo}`);

                    if (elemento) {
                        if (elemento.classList.contains('date-picker')) {
                            // DatePicker
                            elemento.value = valor;
                        } else if (elemento.type === 'checkbox') {
                            // Checkbox
                            elemento.checked = valor;
                        } else if (elemento.classList.contains('selected-option')) {
                            // Select personalizado
                            elemento.setAttribute('data-value', valor);

                            // Buscar la opción correspondiente para actualizar el texto mostrado
                            const dropdown = elemento.closest('.custom-select');
                            if (dropdown) {
                                const opcion = dropdown.querySelector(`.option[data-value="${valor}"]`);
                                if (opcion) {
                                    elemento.innerHTML = opcion.innerHTML;
                                }
                            }
                        } else if (elemento.tagName.toLowerCase() === 'input') {
                            // Input normal
                            elemento.value = valor;
                        } else if (elemento.tagName.toLowerCase() === 'select') {
                            // Select nativo
                            elemento.value = valor;
                        }
                    }
                }
            }
        }

        let formData = {
            visas_id: visa.id,
            variables_dinamicas: {},
            viajeros: []
        };

        document.addEventListener("click", function (event) {
            if (event.target.closest(".tab-button-continuar")) {
                let buttons = Array.from(document.querySelectorAll(".tab-button-continuar"));
                let button = event.target.closest(".tab-button-continuar");
                let index = buttons.indexOf(button);

                let tab1 = document.getElementById("tab1");
                let tab2 = document.getElementById("tab2");
                let tab3 = document.getElementById("tab3");
                let form = document.getElementById("visa-inscripcion");
                let revision = document.getElementById("revisar-solicitud");
                let point1 = document.getElementById("point1");
                let bar1 = document.getElementById("bar1");
                let point2 = document.getElementById("point2");
                let bar2 = document.getElementById("bar2");
                let point3 = document.getElementById("point3");

                let errores = [];

                // Validaciones y recolección de datos
                if (index === 0) {

                    // Recolectar todos los valores de los elementos dinámicos del primer tab
                    const elementosFormulario = tab1.querySelectorAll('input, select, .selected-option');

                    elementosFormulario.forEach(elemento => {
                        // Solo procesar elementos con name
                        const nombreCampo = elemento.name || elemento.getAttribute('name');
                        if (nombreCampo) {
                            if (elemento.classList.contains('date-picker')) {
                                // DatePicker
                                formData.variables_dinamicas[nombreCampo] = elemento.value;
                            } else if (elemento.type === 'checkbox') {
                                // Checkbox
                                formData.variables_dinamicas[nombreCampo] = elemento.checked;
                            } else if (elemento.classList.contains('selected-option')) {
                                // Select personalizado
                                formData.variables_dinamicas[nombreCampo] = elemento.getAttribute('data-value');
                            } else if (elemento.tagName.toLowerCase() === 'input') {
                                // Input normal (texto, número, etc.)
                                formData.variables_dinamicas[nombreCampo] = elemento.value.trim();
                            } else if (elemento.tagName.toLowerCase() === 'select') {
                                // Select nativo
                                formData.variables_dinamicas[nombreCampo] = elemento.value;
                            }
                        }
                    });

                    // Validación general para campos obligatorios
                    const camposObligatorios = tab1.querySelectorAll('[required]');

                    camposObligatorios.forEach(campo => {
                        const nombreCampo = campo.name || campo.getAttribute('name') || campo.id;
                        let valor = formData.variables_dinamicas[nombreCampo];

                        // Verificar si el campo está vacío
                        if (!valor || valor === '' || valor === null) {
                            // Obtener el texto de la etiqueta para personalizar el mensaje de error
                            let labelTexto = '';
                            const labelElement = tab1.querySelector(`label[for="${nombreCampo}"]`) ||
                                campo.closest('.form-box-input').querySelector('.form-label span');

                            if (labelElement) {
                                labelTexto = labelElement.textContent.trim();
                            } else {
                                // Si no se encuentra etiqueta, usar el nombre del campo
                                labelTexto = nombreCampo.charAt(0).toUpperCase() + nombreCampo.slice(1).replace(/-/g, ' ');
                            }

                            errores.push(`⚠️ El campo "${labelTexto}" es obligatorio.`);
                        }

                        // Validaciones específicas según el tipo de dato
                        if (valor) {
                            const error = validacionesGenerales(nombreCampo, valor, 1);

                            if(error != ""){
                                errores.push(error);
                            }

                            // Formatear fechas si es necesario
                            if (campo.classList.contains('date-picker')) {
                                formData.variables_dinamicas[nombreCampo] = formatFecha(valor);
                            }
                        }
                    });

                    // Si hay errores, mostrar alertas y detener el avance
                    if (errores.length > 0) {
                        alert(errores.join("\n"));
                        return;
                    }
                } else if (index === 1) {
                    // Recolectar datos de viajeros dinámicamente
                    let viajeros = [];

                    // Obtener todos los contenedores de viajeros
                    const contenedoresViajeros = tab2.querySelectorAll('.tab-viajero-box');
                    console.log("Cantidad contenedores: " + contenedoresViajeros.length);

                    contenedoresViajeros.forEach((contenedor, indexViajero) => {
                        // Objeto para almacenar los datos de este viajero
                        let viajero = {};
                        let erroresViajero = [];

                        // Obtener todos los elementos del formulario para este viajero
                        const elementosFormulario = contenedor.querySelectorAll('input, select, .selected-option');

                        elementosFormulario.forEach(elemento => {
                            // Solo procesar elementos con name
                            const nombreCampo = elemento.name || elemento.getAttribute('name');
                            if (nombreCampo) {
                                // Eliminar los corchetes [] que indican arrays
                                const nombreBase = nombreCampo.replace(/\[\]/g, '');

                                // Recolectar valor según tipo de elemento
                                if (elemento.classList.contains('date-picker')) {
                                    // Para componentes DatePicker
                                    viajero[nombreBase] = elemento.value;

                                    // Si es fecha de nacimiento, formatearla adecuadamente
                                    if (nombreBase.includes('fecha_nacimiento') || nombreBase.includes('birth_date')) {
                                        if (elemento.value) {
                                            viajero[nombreBase] = formatFecha(elemento.value);
                                        }
                                    }
                                } else if (elemento.type === 'checkbox') {
                                    viajero[nombreBase] = elemento.checked;
                                } else if (elemento.classList.contains('selected-option')) {
                                    viajero[nombreBase] = elemento.getAttribute('data-value');
                                } else if (elemento.tagName.toLowerCase() === 'input') {
                                    viajero[nombreBase] = elemento.value.trim();
                                } else if (elemento.tagName.toLowerCase() === 'select') {
                                    viajero[nombreBase] = elemento.value;
                                }

                                // Validación dinámica para campos requeridos
                                if (elemento.hasAttribute('required') &&
                                    (!viajero[nombreBase] || viajero[nombreBase] === '' || viajero[nombreBase] === null)) {

                                    // Buscar la etiqueta para personalizar el mensaje
                                    let labelTexto = '';
                                    const labelElement = contenedor.querySelector(`label[for="${nombreCampo}"]`) ||
                                        elemento.closest('.tab-viajero-item')?.querySelector('.viajero-item-label span') ||
                                        elemento.closest('.form-box-input')?.querySelector('.form-label span');

                                    if (labelElement) {
                                        labelTexto = labelElement.textContent.trim();
                                    } else {
                                        // Si no hay etiqueta, usar el nombre del campo formateado
                                        labelTexto = nombreBase.charAt(0).toUpperCase() + nombreBase.slice(1).replace(/[_-]/g, ' ');
                                    }

                                    erroresViajero.push(`⚠️ El campo "${labelTexto}" es obligatorio para el viajero #${indexViajero + 1}.`);
                                }

                                let valor = viajero[nombreBase];

                                // Validaciones específicas según el tipo de dato
                                if (valor) {
                                    const error = validacionesGenerales(nombreBase, valor, indexViajero);

                                    if(error != ""){
                                        erroresViajero.push(error);
                                    }
                                }
                            }
                        });

                        // Agregar todos los errores de este viajero
                        if (erroresViajero.length > 0) {
                            errores = [...errores, ...erroresViajero];
                        } else if (Object.keys(viajero).length > 0) {
                            // Solo agregar el viajero si tiene datos y no tiene errores
                            viajeros.push(viajero);
                        }
                    });

                    console.log("Cantidad Viajeros: " + viajeros.length);
                    // Validación general
                    if (viajeros.length === 0) {
                        errores.push("⚠️ Debes agregar al menos un viajero con datos válidos.");
                    }

                    if (errores.length > 0) {
                        alert(errores.join("\n"));
                        return;
                    }
                    console.log("Cantidad antes de pasaporte: " + contadorViajero);
                    // Guardar los viajeros válidos en formData
                    formData.viajeros = viajeros;

                    actualizarViajeroInfoExtra();
                } else if (index === 2) {
                    let viajerosBoxes = tab3.querySelectorAll(".tab-viajero-box");

                    viajerosBoxes.forEach((viajeroBox, i) => {
                        let viajero = {};
                        let erroresViajero = [];

                        const elementosFormulario = viajeroBox.querySelectorAll('input, select, .selected-option');

                        elementosFormulario.forEach(elemento => {
                            const nombreCampo = elemento.name || elemento.getAttribute('name');
                            if (nombreCampo) {
                                const nombreBase = nombreCampo.replace(/\[\]/g, '');

                                if (elemento.classList.contains('date-picker')) {
                                    viajero[nombreBase] = elemento.value;

                                    if (nombreBase.includes('fecha') && elemento.value) {
                                        viajero[nombreBase] = formatFecha(elemento.value);
                                    }
                                } else if (elemento.type === 'checkbox') {
                                    viajero[nombreBase] = elemento.checked;
                                } else if (elemento.classList.contains('selected-option')) {
                                    viajero[nombreBase] = elemento.getAttribute('data-value');
                                } else if (elemento.tagName.toLowerCase() === 'input') {
                                    viajero[nombreBase] = elemento.value.trim();
                                } else if (elemento.tagName.toLowerCase() === 'select') {
                                    viajero[nombreBase] = elemento.value;
                                }

                                // Validación de campo obligatorio
                                if (elemento.hasAttribute('required') &&
                                    (!viajero[nombreBase] || viajero[nombreBase] === '' || viajero[nombreBase] === null)) {

                                    let labelTexto = '';
                                    const labelElement = viajeroBox.querySelector(`label[for="${nombreCampo}"]`) ||
                                        elemento.closest('.tab-viajero-item')?.querySelector('.viajero-item-label span') ||
                                        elemento.closest('.form-box-input')?.querySelector('.form-label span');

                                    if (labelElement) {
                                        labelTexto = labelElement.textContent.trim();
                                    } else {
                                        labelTexto = nombreBase.charAt(0).toUpperCase() + nombreBase.slice(1).replace(/[_-]/g, ' ');
                                    }

                                    erroresViajero.push(`⚠️ El campo "${labelTexto}" es obligatorio para el viajero #${i + 1}.`);
                                }

                                let valor = viajero[nombreBase];

                                // Validaciones específicas según el tipo de dato
                                if (valor) {
                                    const error = validacionesGenerales(nombreBase, valor, i);

                                    if(error != ""){
                                        erroresViajero.push(error);
                                    }
                                }
                            }
                        });

                        if (erroresViajero.length > 0) {
                            errores = [...errores, ...erroresViajero];
                        } else if (Object.keys(viajero).length > 0) {
                            formData.viajeros[i] = {
                                ...formData.viajeros[i],
                                ...viajero
                            };
                        }
                    });

                    if (errores.length > 0) {
                        alert(errores.join("\n"));
                        return;
                    }

                    actualizarListaViajeros();
                    actualizarTotalPago();
                }


                switch (index) {
                    case 0:
                        tab1.style.display = "none";
                        tab2.style.display = "grid";
                        bar1.classList.add("inscripcion-bar-active");
                        point2.classList.add("inscripcion-point-active");
                        break;
                    case 1:
                        tab2.style.display = "none";
                        tab3.style.display = "grid";
                        bar2.classList.add("inscripcion-bar-active");
                        point3.classList.add("inscripcion-point-active");
                        break;
                    case 2:
                        form.style.display = "none";
                        revision.style.display = "grid";
                        break;
                    case 3:
                        console.log("Datos guardados en formData:", JSON.stringify(formData, null, 2));
                        data = "";

                        // Enviar formData al backend para generar el payload
                        // Función asíncrona para manejar el fetch
                        async function obtenerPayload() {
                            try {
                                // Preparar el objeto de datos final para el envío
                                // Extraer valores específicos necesarios para la API actual
                                // Buscar fecha_llegada desde el datepicker o elementos con esas clases/IDs
                                let fechaLlegada = '';
                                const posiblesFechas = ['date-picker', 'fecha_llegada', 'fecha-llegada'];

                                for (const posibleFecha of posiblesFechas) {
                                    if (formData.variables_dinamicas[posibleFecha]) {
                                        fechaLlegada = formData.variables_dinamicas[posibleFecha];
                                        break;
                                    }
                                }

                                const response = await fetch('/api/izipay/payload', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        "X-CSRF-TOKEN": csrfToken
                                    },
                                    body: JSON.stringify(formData)
                                });

                                data = await response.json(); // Asigna la respuesta JSON a data
                            } catch (error) {
                                console.error("Error al comunicarse con el backend:", error);
                            }
                        }

                        // Llamar a la función y luego validar data
                        obtenerPayload().then(() => {
                            if (data.signature) {
                                console.log("Payload recibido del backend:", data);

                                let form = document.createElement("form");
                                form.method = "POST";
                                form.action = "https://secure.micuentaweb.pe/vads-payment/";

                                // Agregar los campos necesarios de la respuesta del backend
                                form.innerHTML = `
                                                <input type="hidden" name="vads_action_mode" value="${data.vads_action_mode}" />
                                                <input type="hidden" name="vads_amount" value="${data.vads_amount}" />
                                                <input type="hidden" name="vads_ctx_mode" value="${data.vads_ctx_mode}" />
                                                <input type="hidden" name="vads_currency" value="${data.vads_currency}" /> 
                                                <input type="hidden" name="vads_cust_email" value="${data.vads_cust_email}" />
                                                <input type="hidden" name="vads_page_action" value="${data.vads_page_action}" />
                                                <input type="hidden" name="vads_payment_config" value="${data.vads_payment_config}" />
                                                <input type="hidden" name="vads_redirect_success_timeout" value="${data.vads_redirect_success_timeout}"/>
                                                <input type="hidden" name="vads_return_mode" value="${data.vads_return_mode}"/>
                                                <input type="hidden" name="vads_site_id" value="${data.vads_site_id}" />
                                                <input type="hidden" name="vads_trans_date" value="${data.vads_trans_date}" />
                                                <input type="hidden" name="vads_trans_id" value="${data.vads_trans_id}" />
                                                <input type="hidden" name="vads_url_return" value="${data.vads_url_return}"/>
                                                <input type="hidden" name="vads_version" value="${data.vads_version}" />
                                                <input type="hidden" name="signature" value="${data.signature}"/>
                                                <input type="submit" name="pagar" value="Pagar"/>
                                            `;

                                document.body.appendChild(form);
                                form.submit();
                            } else {
                                console.error("Error: Datos incompletos en la respuesta del backend.");
                            }
                        });

                        break;
                    default:
                        console.warn("Botón no reconocido");
                }
            }
        });

        function validacionesGenerales(nombreCampo, valor, index){
            let errores="";
            // Validar correo electrónico
            if (nombreCampo.includes('correo')) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(valor)) {
                    errores = "📧 Ingresa un correo electrónico válido.";
                }
            }

            // Validar número de teléfono
            if (nombreCampo.includes('telefono') || nombreCampo.includes('numero')) {
                const telefonoRegex = /^\+?[0-9]{7,15}$/;
                if (!telefonoRegex.test(valor)) {
                    errores = "📞 Ingresa un número de teléfono válido (7 a 15 dígitos, opcionalmente con '+').";
                }
            }

            // Validar edad viajero
            if (nombreCampo.includes('fecha_nacimiento')) {
                const fechaNacimiento = parseFechaDDMMYYYY(valor);
                if (!fechaNacimiento || isNaN(fechaNacimiento)) {
                    errores = `⚠️ La fecha de nacimiento del viajero #${index + 1} no es válida.`;
                } else {
                    const edad = calcularEdad(fechaNacimiento);
                    console.log("Edad: " + edad);
                    if (edad < 18) {
                        errores = `⚠️ El viajero #${index + 1} debe ser mayor de 18 años.`;
                    }
                }
            }
            return errores;
        }

        // Función para calcular la edad a partir de la fecha de nacimiento
        function calcularEdad(fechaNacimiento) {
            let hoy = new Date();
            let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
            let mesActual = hoy.getMonth();
            let diaActual = hoy.getDate();
            let mesNacimiento = fechaNacimiento.getMonth();
            let diaNacimiento = fechaNacimiento.getDate();

            // Ajustar si aún no ha pasado el cumpleaños este año
            if (mesActual < mesNacimiento || (mesActual === mesNacimiento && diaActual < diaNacimiento)) {
                edad--;
            }

            return edad;
        }

        function parseFechaDDMMYYYY(fechaStr) {
            if (typeof fechaStr !== "string") return null;

            const [dia, mes, anio] = fechaStr.split("/").map(Number);
            if (!dia || !mes || !anio) return null;

            return new Date(anio, mes - 1, dia);
        }

        function actualizarViajeroInfoExtra() {
            // Obtener el contenedor
            const contenedor = document.getElementById("viajeros-info-extra");
            if (!contenedor) return;

            // Limpiar el contenido actual
            contenedor.innerHTML = '';

            // Título principal (sin usar plantillas literales para evitar conflictos con Blade)
            contenedor.innerHTML = '<div class="tab-form-title"><span class="form-title-text">Tu información del pasaporte</span></div>';

            // Si no hay viajeros en formData, salir
            if (!formData.viajeros || formData.viajeros.length === 0) {
                return;
            }
            if (formData.viajeros.length != contadorViajero) {
                console.log("Cantidad Formdata: " + formData.viajeros.length);
                console.log("Cantidad contador: " + contadorViajero);
            }


            // Crear un contenedor para cada viajero
            formData.viajeros.forEach((viajero, index) => {
                if (index < contadorViajero) {
                    // Crear estructura básica para el contenedor del viajero
                    const viajeroContainer = document.createElement('div');
                    viajeroContainer.className = 'tab-viajero-box';

                    // Crear el encabezado del viajero
                    const selectContainer = document.createElement('div');
                    selectContainer.className = 'tab-viajero-select';

                    // Agregar el título del viajero
                    const textContainer = document.createElement('div');
                    textContainer.className = 'tab-viajero-text';

                    const nombres = viajero.nombres || '';

                    const spanTitle = document.createElement('span');
                    spanTitle.className = 'viajero-text';
                    spanTitle.textContent = 'Viajero #' + (index + 1) + ' - ' + nombres;

                    // Crear el icono
                    const iconContainer = document.createElement('div');
                    iconContainer.className = 'tab-viajero-icon';
                    iconContainer.innerHTML = '<div class="ge"><i class="fa-solid fa-chevron-down" style="font-size: 14px;"></i></div>';

                    // Formulario del viajero (oculto inicialmente)
                    const formContainer = document.createElement('div');
                    formContainer.className = 'tab-viajero-form hidden';

                    // Mostrar variables del pasaporte
                    // Cargar el contenido desde el servidor
                    fetch(`/cargar-pasaporte/{{ $formulario->id }}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Error al cargar el viajero');
                            }
                            return response.text();
                        })
                        .then(html => {
                            // Reemplazar el contenido del pasaporte con el HTML obtenido
                            formContainer.innerHTML = html;

                            console.log(formContainer);

                            // 🚀 Re-inicializar flatpickr SOLO en el nuevo viajero
                            inicializarDatePickers(formContainer);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            formContainer.innerHTML = '<div class="error">Error al cargar el formulario. Intente nuevamente.</div>';

                            const botonReintentar = document.createElement('button');
                            botonReintentar.textContent = 'Reintentar';
                            botonReintentar.className = 'btn btn-sm btn-warning mt-2';
                            botonReintentar.onclick = () => {
                                formContainer.remove();
                                actualizarViajeroInfoExtra();
                            };
                            formContainer.appendChild(botonReintentar);
                        });

                    // Ensamblar la estructura
                    textContainer.appendChild(spanTitle);
                    selectContainer.appendChild(textContainer);
                    selectContainer.appendChild(iconContainer);

                    viajeroContainer.appendChild(selectContainer);
                    viajeroContainer.appendChild(formContainer);

                    // Agregar al contenedor principal
                    contenedor.appendChild(viajeroContainer);
                }
            });
        }

        function actualizarListaViajeros() {
            let contenedorViajeros = document.querySelector(".viajeros-box");
            if (!contenedorViajeros) return;

            let html = `
                            <h5 class="viajeros-box-title">Viajeros</h5>
                        `;

            formData.viajeros.forEach((viajero, index) => {
                html += `
                                <div class="viajeros-box-item">
                                    <div style="display: inline;">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <p style="word-break: break-word; margin-bottom: 0;">${viajero.nombres} ${viajero.apellidos}</p>
                                </div>
                            `;
            });

            contenedorViajeros.innerHTML = html;
        }

        function actualizarTotalPago() {
            let contenedorTotal = document.getElementById("precioTotal");
            if (!contenedorTotal) return;

            let precioVisa = parseFloat(visa.precio);
            let tasaGobierno = parseFloat(visa.tasa_gobierno);

            let total = (precioVisa + tasaGobierno) * contadorViajero;

            contenedorTotal.innerHTML = `
                            <span>Total a pagar hoy</span>
                            <span>USD $. ${total.toFixed(2)}</span>
                        `;
        }

        function formatFecha(fecha) {
            let partes = fecha.split("/");
            return `${partes[0]}/${partes[1]}/${partes[2]}`; // Convierte "19/04/2025" → "2025-04-19"
        }
    </script>
@endsection