@extends('layouts.public')

@section('title', 'Home')

@push('resources')
    <link rel="stylesheet" href="{{ assets("css/index.css") }}">
@endpush

@section('content')
    <div class="hero">
        <div class="hero-form-container">
            <h1 class="hero-title">
                Obtén tu visa para cualquier destino
            </h1>
            <div class="hero-form-box">
                <div class="hero-form">
                    <div class="hero-form-selects">
                        <div class="select-container">
                            <label for="origen">¿De dónde soy?</label>
                            <div class="custom-select" id="from-select">
                                @foreach ($paises as $pais)
                                    @if ($pais->nombre == "Perú")
                                        <div class="selected-option" data-value="{{ $pais->id }}" id="origen">
                                            <img src="{{ $pais->imagen }}" alt="{{ $pais->nombre }}"> {{ $pais->nombre }}
                                        </div>
                                    @endif
                                @endforeach

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
                        </div>
                        <div class="select-container">
                            <label for="destino">¿A dónde viajo?</label>
                            <div class="custom-select" id="to-select">
                                <div class="selected-option" data-value="{{ $paises[0]->id }}" id="destino">
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
                        </div>
                    </div>
                    <div class="hero-form-button-container">
                        <div class="hero-form-button">
                            <button class="hero-button" onclick="verVisa()">¡Comenzar ahora! <i class="fa fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PORQUE ELEGIRNOS -->
    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-xl-2">
            <div class="col d-flex flex-column align-items-center">
                <img style="max-width: 100%" class="rounded-4" src="{{assets('img/elegirnos.jpg')}}" alt="">
                <div class="d-flex justify-content-start w-100">
                    <h2 class="pt-4" style="font-size: 3rem; font-weight: bold; text-align: start">Por qué elegirnos</h2>
                </div>
                <p>Estos son los motivos por los cuales iVisa es la mejor opción para ti y por qué deberías probar nuestros servicios.</p>
            </div>
            <div class="col">
                <div class="row row-cols-1 row-cols-md-2 pick-us-squares">
                    <div class="col">
                        <div class="pick-us-sub-container d-flex flex-column align-items-center">
                            <i class="fa-solid fa-hourglass-start"></i>
                            <h3 class="text-center">Sencillez</h3>
                            <p style="text-align: center">Nuestro proceso es mucho más sencillo y ágil que el del gobierno.</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="pick-us-sub-container d-flex flex-column align-items-center">
                            <i class="fa-solid fa-user-shield"></i>
                            <h3 class="text-center">Seguro</h3>
                            <p style="text-align: center">Tu información siempre está segura con nosotros.</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="pick-us-sub-container d-flex flex-column align-items-center">
                            <i class="fa-solid fa-circle-check"></i>
                            <h3 class="text-center">Orientación al éxito</h3>
                            <p style="text-align: center">El 99% de nuestras solicitudes son aprobadas.</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="pick-us-sub-container d-flex flex-column align-items-center">
                            <i class="fa-solid fa-circle-question"></i>
                            <h3 class="text-center">Compromiso</h3>
                            <p style="text-align: center">Estamos aquí para ayudarte 24/7.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- PORQUE ELEGIRNOS END-->

    <!-- NUESTRO PROCESO DE APLICACION -->
    <div class="container mt-5">
        <h2 class="text-center fw-bold" style="font-size: 3rem">Nuestro proceso de aplicación</h2>
        <p class="text-center mb-6 sm:mb-8">Te explicamos cómo solicitar los diferentes documentos de viaje con nosotros.</p>
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col d-flex justify-content-center">
                <div>
                    <div class="d-flex mb-4">
                        <div class="circle">
                            01
                        </div>
                        <div>
                            <h3 class="fw-bold">Inicia tu solicitud</h3>
                            <p>Responde algunas preguntas, realiza el pago y completa los detalles finales.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="circle">
                            02
                        </div>
                        <div>
                            <h3 class="fw-bold">Nosotros nos encargamos del resto</h3>
                            <p>Recibe tu documento por correo electrónico. En caso necesites una cita en la embajada, nos encargaremos de agendarla por ti.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="circle">
                            03
                        </div>
                        <div>
                            <h3 class="fw-bold">¡Disfruta de tu viaje!</h3>
                            <p>Prepárate para mostrar tu pasaporte y tus documentos cuando llegues a tu destino.</p>
                        </div>
                    </div>
                    <button class="button-apply-now">Aplica ahora <i class="fa-solid fa-arrow-right"></i></button>
                </div>
            </div>
            <div class="col  d-flex justify-content-center">
                <img class="rounded-4 hide-mobile" src="{{assets('img/elegirnos.jpg')}}" style="height: 35rem;max-width: 70%; object-fit: cover" alt="">
            </div>
        </div>
    </div>
    <!-- NUESTRO PROCESO DE APLICACION END-->

    <!-- ARTÍCULOS EN TENDENCIA -->
    <div class="container mx-auto px-4 py-12 mt-8">
        <h2 class="text-center font-bold text-5xl mb-4" style="font-size: 3rem">Artículos en tendencia</h2>
        <p class="text-center text-gray-600 mb-10">Descubre nuestros artículos más populares sobre visas y trámites</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($articulosPopulares as $articulo)
            <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 flex flex-col h-full">
                <div class="relative">
                    @if($articulo->tieneImagen())
                        <img src="{{ $articulo->imagen }}" alt="{{ $articulo->titulo }}" class="w-full h-56 object-cover">
                    @else
                        <div class="w-full h-56 flex items-center justify-center bg-gradient-to-r from-red-500 to-blue-900">
                            <i class="fa-solid fa-newspaper text-white text-5xl"></i>
                        </div>
                    @endif

                    <!-- Badge de vistas -->
                    <div class="absolute bottom-3 right-3">
                        <span class="bg-white text-gray-800 text-xs px-3 py-1 rounded-full shadow-md flex items-center">
                            <i class="fa-solid fa-eye mr-1"></i> {{ number_format($articulo->vistas) }} vistas
                        </span>
                    </div>

                    <!-- Badge de categoría si existe -->
                    @if($articulo->categoria)
                    <div class="absolute top-3 left-3">
                        <span class="bg-white text-xs px-3 py-1 rounded-full shadow-md">
                            @if($articulo->categoria->icono)
                                <i class="{{ $articulo->categoria->icono }} mr-1"></i>
                            @endif
                            {{ $articulo->categoria->nombre }}
                        </span>
                    </div>
                    @endif
                </div>

                <div class="p-6 flex-grow">
                    <h3 class="text-xl font-bold mb-3 text-slate-800">
                        {{ $articulo->titulo }}
                    </h3>
                    <p class="text-gray-600 text-sm mb-4">
                        {{ $articulo->extracto(100) }}
                    </p>
                </div>

                <div class="px-6 pb-6 pt-2 flex justify-between items-center">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-8 w-8 rounded-full" src="https://randomuser.me/api/portraits/men/{{ $articulo->id % 80 }}.jpg" alt="{{ $articulo->autor }}">
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-700">{{ $articulo->autor }}</p>
                        </div>
                    </div>
                    <a href="{{ $articulo->url() }}" class="button-apply-now inline-flex items-center w-auto">
                        Leer más
                        <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('blog.index') }}" class="button-apply-now">
                Ver todos los artículos
                <i class="fa-solid fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
    <!-- ARTÍCULOS EN TENDENCIA END -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
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
