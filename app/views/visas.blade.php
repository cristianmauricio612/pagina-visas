@extends('layouts.public')

@section('title', 'Visas')

@push('resources')
    <link rel="stylesheet" href="{{ assets("css/visas.css") }}">
@endpush

@section('content')
    
    @php
        $paises = \App\Models\Pais::all();

        $visa_temp = "";

        if($visas->isNotEmpty()){
            $visa_temp = $visas[intval($posicion)];
        }

    @endphp
    <div class="visas">
        <div class="select-visas">
            <div class="visa-title">
                ¡Aplica ahora para tu
                @if ($visas->isNotEmpty())
                    @if ($visa_temp->necesita_visa === 0)
                        <span>trip</span>
                    @else
                        <span>{{ $visa_temp->nombre }}</span>
                    @endif
                @else
                    <span>trip</span>
                @endif
            </div>

            @if ($visas->isNotEmpty())
                @if ($visa_temp->necesita_visa === 0)
                    <div class="visa-verification-img">
                        <img src="{{ assets('img/no-necesitas-visa.png') }}" alt="">
                    </div>
                @else
                    <div class="visa-verification">
                        <div class="visa-verification-label">Se requiere una visa</div>
                        <div class="visa-verification-text">Se requiere un documento de viaje. Podemos ayudarte a tramitar este documento.</div>
                    </div>
                @endif
            @else
                <div class="visa-verification">
                    <div class="visa-verification-label">Se requiere una visa</div>
                    <div class="visa-verification-text">Actualmente, no podemos ayudarte a tramitar este documento de viaje.</div>
                </div>
            @endif

            <div class="visa-select">
                <label class="origen-label">¿Cuál es tu nacionalidad?</label>
                <div class="custom-select" id="origen">
                    <div class="selected-option" data-value="{{ $pais1->id }}">
                        <img src="{{ $pais1->imagen }}" alt="{{ $pais1->nombre }}"> {{ $pais1->nombre }}
                    </div>
                    <div class="dropdown-form">
                        <input type="text" class="search-input" placeholder="Buscar país...">
                        <div class="options-list">
                            @foreach ($paises as $pais)
                                <div class="option" data-value="{{ $pais->id }}">
                                    <img src="{{ $pais->imagen }}" alt="{{ $pais->nombre }}"> {{ $pais->nombre }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="origen-warning">Asegúrate de seleccionar la nacionalidad del pasaporte con el que viajarás.</div>
            </div>

            <div class="visa-select" style="margin-bottom: 32px;">
                <label class="origen-label">Solicitar</label>
                <div class="custom-select">
                    @if ($visas->isNotEmpty())
                        @if ($visa_temp->necesita_visa !== 0)
                            <div id="visa" class="selected-option" data-value="{{ $visa_temp->id }}">
                                {{ $visa_temp->nombre }} - {{ $visa_temp->tiempo_validez }}, {{ $visa_temp->numero_entradas }}
                            </div>
                        @else
                            <div class="selected-option">
                                No hay visas
                            </div>
                        @endif
                    @else
                        <div class="selected-option">
                            No hay visas
                        </div>
                    @endif
                    <div class="dropdown-form">
                        <input type="text" class="search-input">
                        <div class="options-list">
                            @if ($visas->isNotEmpty())
                                @if ($visa_temp->necesita_visa !== 0)
                                    @foreach ($visas as $visa)
                                        <div class="option" data-value="{{ $visa->id }}">
                                            {{ $visa->nombre }} - {{ $visa->tiempo_validez }}, {{ $visa->numero_entradas }}
                                        </div>
                                    @endforeach
                                @else
                                    <div class="option" data-value="No hay visas">
                                        No hay visas
                                    </div>
                                @endif
                            @else
                                <div class="option" data-value="No hay visas">
                                    No hay visas
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="visas-information">
            @if ($visas->isNotEmpty())
                @if ($visa_temp->necesita_visa !== 0)
                    <div class="visa-information-container">
                        <span class="visa-information-span">
                            <div style="display: inline;">
                                <i class="fa-solid fa-fire"></i>
                            </div>
                            El más solicitado
                        </span>

                        <div class="visa-information-title">
                            {{ $visa_temp->nombre }}
                        </div>

                        <div class="visa-information">
                            <div class="visa-information-item">
                                <div class="visa-information-icon">
                                    <i class="fa-solid fa-calendar-days"></i>
                                </div>
                                <div class="visa-information-text">
                                    <div class="visa-text-label">Válido por</div>
                                    <div class="visa-text-content">{{ $visa_temp->tiempo_validez }} desde la emisión</div>
                                </div>
                            </div>

                            <div class="visa-information-item">
                                <div class="visa-information-icon">
                                    <i class="fa-solid fa-plane-arrival"></i>
                                </div>
                                <div class="visa-information-text">
                                    <div class="visa-text-label">Número de entradas</div>
                                    <div class="visa-text-content">{{ $visa_temp->numero_entradas }}</div>
                                </div>
                            </div>

                            <div class="visa-information-item">
                                <div class="visa-information-icon">
                                    <i class="fa-solid fa-calendar-check"></i>
                                </div>
                                <div class="visa-information-text">
                                    <div class="visa-text-label">Estancia máxima</div>
                                    <div class="visa-text-content">{{ $visa_temp->estancia_maxima }} por entrada</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="visa-information-button">
                        <button id="solicitarVisa">Solicitar ahora</button>
                    </div>
                @else
                    <div class="visa-information-button">
                        <button id="solicitarVisa" disabled>Solicitar ahora</button>
                    </div>
                @endif
            @else
                <div class="visa-information-button">
                    <button id="solicitarVisa" disabled>Solicitar ahora</button>
                </div>
            @endif
        </div>
    </div>

    <script>
        const paises = @json($paises);
        const visas = @json($visas);
        let pais1 = @json($pais1);
        let pais2 = @json($pais2);
        let posicion = @json($posicion);

        function actualizarPagina() {

            if (!pais1 || !pais2) return;

            // Construir la nueva URL con los países seleccionados
            const nuevaURL = `/visas/${pais1.id}/${pais2.id}/${posicion}`;
            
            // Redirigir a la nueva URL (esto recarga la página)
            window.location.href = nuevaURL;
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("solicitarVisa").addEventListener("click", function() {
                // Obtener los valores seleccionados de los selects
                let id = document.getElementById("visa").getAttribute("data-value");

                // Construir la URL de la ruta y redirigir
                let url = `/visa-inscripcion/${id}`;
                window.location.href = url;
            });

            const customSelects = document.querySelectorAll(".custom-select");

            customSelects.forEach(select => {
                const selectedOption = select.querySelector(".selected-option");
                const dropdown = select.querySelector(".dropdown-form");
                const searchInput = select.querySelector(".search-input");
                const optionsList = select.querySelectorAll(".option");
                const isPaisSelect = select.querySelector(".option img") !== null; // Si hay imágenes, es el select de países

                // Mostrar dropdown
                selectedOption.addEventListener("click", function () {
                    dropdown.style.display = "block";
                    searchInput.focus();
                });

                // Filtrar búsqueda
                searchInput.addEventListener("input", function () {
                    const filter = searchInput.value.toLowerCase();
                    optionsList.forEach(option => {
                        const text = option.textContent.toLowerCase();
                        option.style.display = text.includes(filter) ? "flex" : "none";
                    });
                });

                // Seleccionar opción
                optionsList.forEach(option => {
                    option.addEventListener("click", function () {
                        const selectedId = this.getAttribute("data-value"); // Obtener ID del país seleccionado
                        const optionText = this.textContent.trim(); // Obtener solo el texto
                        let optionHTML = this.innerHTML; // Copiar contenido HTML (imagen + texto si hay)

                        // **Actualizar UI del select**
                        selectedOption.innerHTML = optionHTML;
                        dropdown.style.display = "none";
                        searchInput.value = "";
                        optionsList.forEach(opt => (opt.style.display = "flex"));

                        // **Si es el select de países, buscar en el array `paises`**
                        if (isPaisSelect) {
                            const selectedPais = paises.find(pais => pais.id == selectedId);
                            if (selectedPais) {
                                pais1 = selectedPais;
                                console.log("País 1 actualizado:", pais1);
                                actualizarPagina(); // 🔹 Redirigir a la nueva URL
                            }
                        }else{
                            if(selectedId != "No hay visas"){
                                // Buscar la posición del elemento en la lista de visas
                                const selectedVisaIndex = visas.findIndex(visa => visa.id == selectedId);
                                if (selectedVisaIndex != null) {
                                    posicion = selectedVisaIndex;
                                    console.log("Posicion actualizada:", posicion);
                                    actualizarPagina(); // 🔹 Redirigir a la nueva URL
                                }
                            }
                        }
                    });
                });

                // Cerrar dropdown al hacer clic fuera
                document.addEventListener("click", function (event) {
                    if (!select.contains(event.target)) {
                        dropdown.style.display = "none";
                    }
                });
            });
        });
    </script>
@endsection