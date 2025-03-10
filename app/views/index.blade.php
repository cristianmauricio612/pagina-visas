@extends('layouts.public')

@section('title', 'Home')

@section('content')
    <div class="hero">
        @php
            $paises = \App\Models\Pais::all();
        @endphp
        <div class="hero-form-container">
            <h1 class="hero-title">
                Obtén tu visa para cualquier destino
            </h1>
            <div class="hero-form-box">
                <div class="hero-form">
                    <div class="hero-form-selects">
                        <div class="select-container">
                            <label for="origen">¿De dónde soy?</label>
                            <select id="origen">
                                @foreach ($paises as $pais)
                                    <option value="{{ $pais->id }}"><img src="{{ $pais->imagen }}" alt="" style="width: 32; height: 32; margin-right: 10px">{{ $pais->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="select-container">
                            <label for="destino">¿A dónde viajo?</label>
                            <select id="destino">
                                @foreach ($paises as $pais)
                                    <option value="{{ $pais->id }}"><img src="{{ $pais->imagen }}" alt="" style="width: 32; height: 32; margin-right: 10px">{{ $pais->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="hero-form-button-container">
                        <div class="hero-form-button">
                            <button class="hero-button" id="buscarVisas">¡Comenzar ahora! <i class="fa fa-arrow-right"></i></button>
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
        <p class="text-center">Te explicamos cómo solicitar los diferentes documentos de viaje con nosotros.</p>
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

    <div class="container my-5 ">
        <h2 class="text-center fw-bold pt-5" style="font-size: 3rem">Destinos más populares</h2>
        <p class="text-center pb-5">Descubre qué necesitas para viajar a nuestros destinos más populares.</p>
        <div class="most-visited-container">

                <a href="{{route('canada-p-eta')}}" class="card border-0 rounded-4 overflow-hidden">
                    <img src="{{assets('img/elegirnos.jpg')}}" class="card-img-top" alt="Australia">
                    <div class="card-body text-white text-center">
                        <h5 class="card-title">Canada</h5>
                        <p class="card-text">
                            <span><i class="fa-solid fa-user-group"></i> +126,697 Visas procesadas</span>
                        </p>
                    </div>
                </a>
                <a href="{{route('estados-unidos-p-esta')}}" class="card border-0 rounded-4 overflow-hidden">
                    <img src="{{assets('img/elegirnos.jpg')}}" class="card-img-top" alt="India">
                    <div class="card-body text-white text-center">
                        <h5 class="card-title">Estados Unidos</h5>
                        <p class="card-text">
                            <span><i class="fa-solid fa-user-group"></i> +149,245 Visas procesadas</span>
                        </p>
                    </div>
                </a>
                <a href="{{route('india-p-tourist-e-visa')}}" class="card border-0 rounded-4 overflow-hidden">
                    <img src="{{assets('img/elegirnos.jpg')}}" class="card-img-top" alt="Colombia">
                    <div class="card-body text-white text-center">
                        <h5 class="card-title">India</h5>
                        <p class="card-text">
                            <span><i class="fa-solid fa-user-group"></i> +31,546 Visas procesadas</span>
                        </p>
                    </div>
                </a>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("buscarVisas").addEventListener("click", function() {
                // Obtener los valores seleccionados de los selects
                let pais1 = document.getElementById("origen").value;
                let pais2 = document.getElementById("destino").value;
                let posicion = "0";

                // Verificar que ambos países hayan sido seleccionados
                if (!pais1 || !pais2) {
                    alert("Por favor, selecciona ambos países.");
                    return;
                }

                // Construir la URL de la ruta y redirigir
                let url = `/visas/${pais1}/${pais2}/${posicion}`;
                window.location.href = url;
            });
        });
    </script>
    <link rel="stylesheet" href="{{ assets("css/index.css") }}">
@endsection
