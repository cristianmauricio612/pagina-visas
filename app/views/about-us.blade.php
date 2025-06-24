@extends('layouts.public')
@section('title', 'Sobre nosotros')
@section('content')

<div class="container mx-auto px-4">
    <!-- Sección principal centrada -->
    <div class="max-w-4xl mx-auto text-center mb-12 mt-8">
        <h1 class="font-headings tracking-tight scroll-mt-[120px] text-4xl font-bold text-gray-800 mb-6">Viaja sin preocupaciones, nosotros nos encargamos del resto</h1>
        <p class="text-lg text-gray-600">
            En Visas Travel & Tours, entendemos que cada viaje es una nueva oportunidad, una experiencia por vivir y una historia por contar. Nuestro propósito es hacer que todo el proceso de trámite de visas sea tan sencillo y libre de estrés como el destino que sueñas visitar.
        </p>
    </div>

    <!-- Imagen centrada debajo del texto principal -->
    <div class="max-w-4xl mx-auto mb-24">
        <img src="{{assets('img/Nosotros.jpg')}}" alt="Nuestro equipo" class="w-full h-auto rounded-lg shadow-lg">
    </div>

    <!-- Primera sección alternada: Texto a la izquierda, imagen a la derecha -->
    <div class="flex flex-col md:flex-row items-center max-w-6xl mx-auto mb-24">
        <div class="w-full md:w-1/2 md:pr-12 mb-8 md:mb-0">
            <h2 class="font-headings tracking-tight scroll-mt-[120px] text-3xl font-bold text-gray-800 mb-6">Ayudarte es nuestro objetivo número 1</h2>
            <p class="text-lg text-gray-600 mb-4">
                Nuestra misión es clara: ser tu aliado en cada solicitud de visa, garantizando que tu experiencia sea fluida, rápida y exitosa. Sabemos que cada cliente es único, por eso personalizamos nuestros servicios para adaptarnos a tus necesidades y hacer que el proceso sea lo más simple posible.
            </p>
        </div>
        <div class="w-full md:w-1/2">
            <img src="{{assets('img/Ayudarte es nuestro objetivo numero 1.jpg')}}" alt="Nuestro servicio" class="w-full h-auto rounded-lg shadow-lg">
        </div>
    </div>

    <!-- Segunda sección alternada: Imagen a la izquierda, texto a la derecha -->
    <div class="flex flex-col md:flex-row-reverse items-center max-w-6xl mx-auto mb-24">
        <div class="w-full md:w-1/2 md:pl-12 mb-8 md:mb-0">
            <h2 class="font-headings tracking-tight scroll-mt-[120px] text-3xl font-bold text-gray-800 mb-6">Nuestra atención se basa en 3 pilares</h2>
            <ul class="text-lg text-gray-600 space-y-4">
                <li>
                    <span class="font-bold">Experiencia y conocimiento:</span> Más de una década asesorando a miles de viajeros, con un equipo especializado en diferentes tipos de visas.
                </li>
                <li>
                    <span class="font-bold">Compromiso y transparencia:</span> Cada caso es importante para nosotros, por eso trabajamos con integridad y claridad en cada paso.
                </li>
                <li>
                    <span class="font-bold">Cercanía y empatía:</span> No solo somos expertos en trámites, sino también en entender tus preocupaciones y expectativas.
                </li>
            </ul>
        </div>
        <div class="w-full md:w-1/2">
            <img src="{{assets('img/Ayudarte es nuestro objetivo numero 1.jpg')}}" alt="Nuestros pilares" class="w-full h-auto rounded-lg shadow-lg">
        </div>
    </div>

    <!-- Tercera sección: Números destacados en tarjetas -->
    <div class="max-w-6xl mx-auto mb-16 px-4">
        <h2 class="font-headings tracking-tight scroll-mt-[120px] text-3xl font-bold text-gray-900 mb-10">Los números importan, así que aquí mostramos algunos de ellos...</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Tarjeta 1 -->
            <div class="bg-gray-50 p-8 rounded-lg">
                <div class="bg-purple-100 w-12 h-12 rounded-lg flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>

                <h3 class="text-6xl font-bold text-gray-900 mb-4">2,000+</h3>

                <p class="text-lg text-gray-600">
                    Visas aprobadas para destinos como EE.UU., Canadá, Australia, y más países alrededor del mundo.
                </p>
            </div>

            <!-- Tarjeta 2 -->
            <div class="bg-gray-50 p-8 rounded-lg">
                <div class="bg-orange-100 w-12 h-12 rounded-lg flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>

                <h3 class="text-6xl font-bold text-gray-900 mb-4">3,000+</h3>

                <p class="text-lg text-gray-600">
                    Renovaciones exitosas de visas realizadas, garantizando que tus planes no se detengan en ningún momento.
                </p>
            </div>

            <!-- Tarjeta 3 -->
            <div class="bg-gray-50 p-8 rounded-lg">
                <div class="bg-green-100 w-12 h-12 rounded-lg flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <h3 class="text-6xl font-bold text-gray-900 mb-4">5,000+</h3>

                <p class="text-lg text-gray-600">
                    Viajeros satisfechos que confiaron en nosotros para hacer realidad sus sueños de viaje a destinos internacionales.
                </p>
            </div>
        </div>
    </div>

    <!-- Cuarta sección centrada -->
    <div class="max-w-4xl mx-auto text-center mb-8">
        <h2 class="font-headings tracking-tight scroll-mt-[120px] text-3xl font-bold text-gray-800 mb-6">¿Qué estamos construyendo?</h2>
        <p class="text-lg text-gray-600 mb-8">
            Estamos creando un futuro donde cada vez más personas puedan cumplir sus sueños de viajar sin fronteras. Nos esforzamos por ser más que una agencia de visas, queremos ser el puente que conecta tus deseos con destinos en todo el mundo. Buscamos innovar constantemente, ofrecer un servicio excepcional y construir relaciones a largo plazo con nuestros clientes, para que siempre puedas contar con nosotros en cada nueva aventura.
        </p>
        <p class="text-lg font-semibold text-gray-700">
            Gracias por confiar en Visas Travel & Tours. Sigamos construyendo historias juntos.
        </p>
    </div>
</div>

@endsection
