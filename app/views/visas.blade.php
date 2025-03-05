@extends('layouts.public')

@section('title', 'Visas')

@section('content')
    
    @php
        $paises = \App\Models\Pais::all();

        $visa_temp = "";

        if($visas->isNotEmpty()){
            $visa_temp = $visas[0];
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

            <div class="visa-select">
                <label class="origen-label">Solicitar</label>
                <div class="custom-select" id="visa">
                    @if ($visas->isNotEmpty())
                        <div class="selected-option" data-value="{{ $visa_temp->id }}">
                            {{ $visa_temp->nombre }}
                        </div>
                    @else
                        <div class="selected-option">
                            No hay visas
                        </div>
                    @endif
                    <div class="dropdown-form">
                        <input type="text" class="search-input">
                        <div class="options-list">
                            @if ($visas->isNotEmpty())
                                @foreach ($visas as $visa)
                                    <div class="option" data-value="{{ $visa->id }}">
                                        {{ $visa->nombre }}
                                    </div>
                                @endforeach
                            @else
                                <div class="option">
                                    No hay visas
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="visas-information">
            
            <button id="solicitarVisa">Solicitar ahora</button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("solicitarVisa").addEventListener("click", function() {
                // Obtener los valores seleccionados de los selects
                let id = document.getElementById("visa").value;

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

                // Mostrar dropdown en el lugar del select
                selectedOption.addEventListener("click", function () {
                    dropdown.style.display = "block";
                    searchInput.focus();
                });

                // Buscar país en el input
                searchInput.addEventListener("input", function () {
                    const filter = searchInput.value.toLowerCase();
                    optionsList.forEach(option => {
                        const text = option.textContent.toLowerCase();
                        option.style.display = text.includes(filter) ? "flex" : "none";
                    });
                });

                // Seleccionar un país
                optionsList.forEach(option => {
                    option.addEventListener("click", function () {
                        const imgSrc = this.querySelector("img").src;
                        selectedOption.innerHTML = `<img src="${imgSrc}" alt=""> ${this.textContent}`;
                        selectedOption.style.display = "flex";
                        dropdown.style.display = "none";
                        searchInput.value = "";
                        optionsList.forEach(opt => (opt.style.display = "flex"));
                    });
                });

                // Cerrar dropdown si el usuario hace clic fuera
                document.addEventListener("click", function (event) {
                    if (!select.contains(event.target)) {
                        dropdown.style.display = "none";
                    }
                });
            });
        });
    </script>
    <link rel="stylesheet" href="{{ assets("css/visas.css") }}">
@endsection