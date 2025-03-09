@extends('layouts.public')
@section('title', 'Sobre nosotros')
@push('resources')
    <link href="{{assets('css/about-us.css') }}" rel="stylesheet">
@endpush
@section('content')


    <div class="container py-5">
        <h1 class="text-center" style="font-size: 1rem; font-weight: bold">SOBRE NOSOTROS</h1>

        <h2 class="text-center au-subtitle">
            ¿QUIÉNES SOMOS?
        </h2>

        <div class="d-flex justify-content-center pt-3">
            <img class="au-image" src="{{assets('img/elegirnos.jpg')}}" alt="">
        </div>


        <div class="row d-md-flex d-block custom-container my-5">
            <div class="col-12 col-md-4">
                <div class="custom-card d-flex align-items-start">
                    <div class="d-flex flex-md-column justify-content-center">
                        <div class="py-md-3 d-flex justify-content-center"><i class="fas fa-star me-3 me-md-0"></i></div>
                        <div class="">
                            <p class="mb-0 text-center">
                                Más que una VISA, es ir por lo que amas. Somos una organización que brinda asesoramiento a nuestros clientes en la obtención de la Visa a los Estados Unidos, Canadá, Reino Unido, Australia, Nueva Zelanda, China, India, Japón y Dubai.
                            </p></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="custom-card d-flex align-items-start">
                    <div class="d-flex flex-md-column justify-content-center">
                        <div class="py-md-3 d-flex justify-content-center"><i class="fas fa-thumbs-up me-3 me-md-0"></i></div>
                        <div class="">
                            <p class="mb-0 text-center">
                                Ofrecemos diferentes tipos de visas para que usted como cliente pueda desarrollar todas las actividades deseadas en su destino. Visas de turismo, visa de estudio, peticiones, visa de novios, visa de tránsito, Green Card, visa de tripulante y mucho más.
                            </p></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="custom-card d-flex align-items-start">
                    <div class="d-flex flex-md-column justify-content-center">
                        <div class="py-md-3 d-flex justify-content-center"><i class="fas fa-globe me-3 me-md-0"></i></div>
                        <div class="">
                            <p class="mb-0 text-center">Estamos al tanto con las regulaciones impuestas por el gobierno con respecto a la Covid-19. Además, nuestra atención es 100% virtual brindando mayor seguridad a nuestros clientes.</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container pt-5" style="padding-bottom: 5rem">
    <h2 class="text-center au-subtitle">NUESTRO ENFOQUE</h2>

    <div class="d-flex justify-content-center pt-3">
        <img class="au-image" src="{{assets('img/elegirnos.jpg')}}" alt="">
    </div>


        <div class="row d-md-flex d-block custom-container my-5">
            <div class="col-12 col-md-4">
                <div class="custom-card d-flex align-items-start">
                    <div class="d-flex flex-column justify-content-center">
                        <div class="py-md-3 mb-3 d-flex justify-content-center"><i class="fa-solid fa-eye"></i></div>
                        <div class="py-md-3 d-flex justify-content-center fw-bold">VISIÓN</div>
                        <div class="">
                            <p class="mb-0 text-center">Ser los lideres en nuestro sector para contribuir a que las personas puedan viajar sin restricciones a cualquier parte del mundo y ser ciudadanos sin fronteras.</p></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="custom-card d-flex align-items-start">
                    <div class="d-flex flex-column justify-content-center">
                        <div class="py-md-3 mb-3 d-flex justify-content-center"><i class="fa-solid fa-bullseye"></i></div>
                        <div class="py-md-3 d-flex justify-content-center fw-bold">MISIÓN</div>
                        <div class="">
                            <p class="mb-0 text-center">Asesorar a todas las personas para que puedan viajar a cualquier parte del mundo de manera legal, facilitando todos los procesos de visa.</p></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="custom-card d-flex align-items-start">
                    <div class="d-flex flex-column justify-content-center">
                        <div class="py-md-3 mb-3 d-flex justify-content-center"><i class="fa-solid fa-scale-balanced"></i></div>
                        <div class="py-md-3 d-flex justify-content-center fw-bold">VALORES</div>
                        <div class="">
                            <p class="mb-0 text-center">Orientación al cliente Confidencialidad Transparencia Responsabilidad Social Apoyo al Colaborador Competitividad laboral.</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
