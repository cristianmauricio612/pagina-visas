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
        <div class="row row-cols-md-1 row-cols-lg-2">
            <div class="col d-flex flex-column align-items-center">
                <img class="rounded-4" src="{{assets('img/elegirnos.jpg')}}" alt="">
                <h2>Por qué elegirnos</h2>
                <p>Estos son los motivos por los cuales iVisa es la mejor opción para ti y por qué deberías probar nuestros servicios.</p>
            </div>
            <div class="col">
                <div class="row row-cols-1 row-cols-md-2">
                    <div class="col">
                        <div class="pick-us-sub-container d-flex flex-column align-items-center">
                            <i class="fa-solid fa-hourglass-start"></i>
                            <h3>Sencillez</h3>
                            <p style="text-align: center">Nuestro proceso es mucho más sencillo y ágil que el del gobierno.</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="pick-us-sub-container d-flex flex-column align-items-center">
                            <i class="fa-solid fa-hourglass-start"></i>
                            <h3>Sencillez</h3>
                            <p style="text-align: center">Nuestro proceso es mucho más sencillo y ágil que el del gobierno.</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="pick-us-sub-container d-flex flex-column align-items-center">
                            <i class="fa-solid fa-hourglass-start"></i>
                            <h3>Sencillez</h3>
                            <p style="text-align: center">Nuestro proceso es mucho más sencillo y ágil que el del gobierno.</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="pick-us-sub-container d-flex flex-column align-items-center">
                            <i class="fa-solid fa-hourglass-start"></i>
                            <h3>Sencillez</h3>
                            <p style="text-align: center">Nuestro proceso es mucho más sencillo y ágil que el del gobierno.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- PORQUE ELEGIRNOS END-->

    <!-- NUESTRO PROCESO DE APLICACION -->
    <div class="container mt-5">
        <h2>Nuestro proceso de aplicación</h2>
        <p>Te explicamos cómo solicitar los diferentes documentos de viaje con nosotros.</p>
        <div class="row row-cols-md-1">
            <div class="col">
                <div class="d-flex mb-4">
                    <div class="circle">
                        01
                    </div>
                    <div>
                        <h3>Inicia tu solicitud</h3>
                        <p>Responde algunas preguntas, realiza el pago y completa los detalles finales.</p>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <div class="circle">
                        02
                    </div>
                    <div>
                        <h3>Inicia tu solicitud</h3>
                        <p>Responde algunas preguntas, realiza el pago y completa los detalles finales.</p>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <div class="circle">
                        03
                    </div>
                    <div>
                        <h3>Inicia tu solicitud</h3>
                        <p>Responde algunas preguntas, realiza el pago y completa los detalles finales.</p>
                    </div>
                </div>
                <button class="btn btn-success">Aplica ahora -></button>
            </div>
            <div class="col"></div>
        </div>
    </div>
    <!-- NUESTRO PROCESO DE APLICACION END-->

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
