@extends('layouts.public')
@section('title', 'Contacto')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Navegación de migas de pan -->
        <div class="text-sm text-gray-500 mb-6">
            <a href="/" class="hover:text-blue-600">Inicio</a>
            <span class="mx-2">></span>
            <span class="font-bold">Contáctanos</span>
        </div>

        <!-- Título principal -->
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Contáctanos</h1>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-8 mb-8">
            <!-- Chatea con nosotros -->
            <div class="bg-teal-900 text-white rounded-xl p-8 col-span-2 md:h-4/5">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-teal-800 rounded-md flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                </div>
                <h2 class="text-2xl font-bold mb-3">Chatea con nosotros</h2>
                <p class="mb-4">Contáctanos por WhatsApp, estamos disponibles las 24 horas del día, los 7 días de la semana.</p>
                
                <a href="https://wa.me/923647947" class="inline-flex items-center bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 px-6 rounded-2xl transition duration-300 mt-3">
                    Chatear por WhatsApp
                    <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            <!-- Envíanos un e-mail -->
            <div class="bg-white border border-gray-200 rounded-lg p-8 col-span-3">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Envíanos un e-mail</h2>
                <p class="text-gray-600 mb-6">Tiempo de respuesta: 3 horas</p>
                
                <p class="text-gray-700 mb-4">Si necesitas ayuda, envíanos un email a <a href="mailto:contacto@visastraveltours.com" class="text-blue-600 hover:underline">contacto@visastraveltours.com</a></p>
                
                <p class="text-gray-700 mb-4">Si tienes una solicitud en curso, asegúrate de incluir tu número de pedido y contactarnos desde tu correo registrado.</p>
                
                <p class="text-gray-700 mb-4">Para obtener información sobre los requisitos de visa para tu viaje, indícanos tu nacionalidad, país de residencia y destino.</p>
                
                <p class="text-gray-700">Ofrecemos tiempos de respuesta más rápidos a través de WhatsApp y mediante nuestro chat en línea.</p>
            </div>
        </div>

        <!-- Usa nuestras herramientas de autoayuda -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Usa nuestras herramientas de autoayuda</h2>
            <p class="text-gray-600 mb-6">Consulta nuestras herramientas de fácil acceso que pueden ahorrarte tiempo.</p>
            
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                <a href="/" class="flex justify-between items-center py-4 px-2 border-b border-gray-200 hover:bg-gray-100 transition duration-150 rounded">
                    <span class="text-gray-800 font-medium">Iniciar nueva solicitud</span>
                    <svg class="w-5 h-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="/iniciar-sesion" class="flex justify-between items-center py-4 px-2 hover:bg-gray-100 transition duration-150 rounded">
                    <span class="text-gray-800 font-medium">Inicia sesión en tu cuenta</span>
                    <svg class="w-5 h-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
@endsection