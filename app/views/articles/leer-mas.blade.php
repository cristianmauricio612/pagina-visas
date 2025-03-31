@extends('layouts.public')

@section('title', 'Visa')

@push('resources')
    <link href="{{ assets('css/leer-mas.css') }}" rel="stylesheet">
@endpush

@section('content')
    @php
        $paises = \App\Models\Pais::all();
    @endphp
    <div class="info-visa-container">
        <div class="return-page">
            <div class="small-title-page">
                <a class="inicio-link" href="/">
                    <span>Inicio</span>
                </a>
                <span> > </span>
                <b class="name-page">Artículos recientes: Viaja a</b>
            </div>
        </div>
        <div class="title-page">
            Artículos recientes: Viaja a
        </div>
    </div>

    <div class="info-container" style="margin-bottom: 100px">
        <div class="division">
            <div class="info-col-article">
                <ul class="lista">
                    <li><a href="/electronic-visa">Guía completa de eVisas: Definición, proceso, requisitos y más <span class="icon">›</span></a></li>
                    <li><a href="carta-invitacion.html">Puntos clave para la carta de invitación: Cómo escribir la invitación perfecta <span class="icon">›</span></a></li>
                    <li><a href="/que-es-una-visa">¿Qué es una visa? Definición y todos los tipos de visas <span class="icon">›</span></a></li>
                    <li><a href="/electronic-visa">Guía completa de eVisas: Definición, proceso, requisitos y más <span class="icon">›</span></a></li>
                    <li><a href="/arrived-visa">Guía completa de visa a la llegada: Definición, proceso, requisitos y más <span class="icon">›</span></a></li>
                    <li><a href="visas-cita.html">Visas que requieren cita: Qué son y cómo solicitarlas <span class="icon">›</span></a></li>
                    <li><a href="/arrived-visa">Guía completa de visa a la llegada: Definición, proceso, requisitos y más<span class="icon">›</span></a></li>
                </ul>
            </div>
            <div class="info-col-table">
                <div class="info-table-form">
                    <div style="padding: 32px">
                        <form>
                            <p class="form-title">Solicitar ahora</p>
                            <h4 class="label-form">¿De dónde eres?</h4>
                            <div class="custom-select" id="from-select">
                                <div class="selected-option" data-value="{{ $paises[0]->id }}" id="origen">
                                    <img src="{{ $paises[0]->imagen }}" alt="{{ $paises[0]->nombre }}"> {{ $paises[0]->nombre }}
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

                            <h4 class="label-form">Where are you going?</h4>
                            <div class="custom-select" id="to-select">
                                <div class="selected-option" data-value="{{ $paises[1]->id }}" id="destino">
                                    <img src="{{ $paises[1]->imagen }}" alt="{{ $paises[1]->nombre }}"> {{ $paises[1]->nombre }}
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

                            <button class="apply-btn" type="button" onClick="verVisa()">¡Aplica ahora! <span>→</span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
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
                        const selectedId = this.getAttribute("data-value"); // Obtener ID del país seleccionado
                        const optionText = this.textContent.trim(); // Obtener solo el texto
                        let optionHTML = this.innerHTML; // Copiar contenido HTML (imagen + texto si hay)

                        // **Actualizar UI del select**
                        selectedOption.innerHTML = optionHTML;
                        selectedOption.dataset.value = selectedId;
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
        function verVisa() {
            // Obtener los valores seleccionados de los selects
            let pais1 = document.getElementById("origen").getAttribute("data-value");
            let pais2 = document.getElementById("destino").getAttribute("data-value");
            let posicion = 0;

            // Verificar que ambos países hayan sido seleccionados
            if (!pais1 || !pais2) {
                alert("Por favor, selecciona ambos países.");
                return;
            }

            // Construir la URL de la ruta y redirigir
            let url = `/visas/1/3/0`;
            window.location.href = '/visas/'+pais1+'/'+pais2+'/'+posicion;
        }
    </script>
@endsection