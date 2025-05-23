@extends('layouts.public')

@section('title', 'Reclamación Enviada - Visas Travel')
@section('description', 'Su reclamación ha sido enviada exitosamente. Le responderemos en un plazo máximo de 30 días calendario.')
@section('keyword', 'reclamación enviada, confirmación, visas travel')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Navegación de migas de pan -->
    <div class="text-sm text-gray-500 mb-6">
        <a href="/" class="hover:text-blue-600">Inicio</a>
        <span class="mx-2">></span>
        <a href="{{route('libro-reclamaciones')}}" class="hover:text-blue-600">Libro de Reclamaciones</a>
        <span class="mx-2">></span>
        <span class="font-bold">Confirmación</span>
    </div>

    <!-- Contenido principal -->
    <div class="max-w-4xl mx-auto">
        <!-- Mensaje de éxito principal -->
        <div class="text-center mb-8">
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
                <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-4">¡Reclamación Enviada Exitosamente!</h1>
            <p class="text-xl text-gray-600 mb-6">
                Hemos recibido su reclamación y será procesada por nuestro equipo especializado.
            </p>
        </div>

        <!-- Información del proceso -->
        <div class="bg-blue-50 border-l-4 border-blue-400 p-6 mb-8 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-blue-800 mb-2">Información importante</h3>
                    <div class="text-blue-700 space-y-2">
                        <p>• Le responderemos en un plazo <strong>máximo de 30 días calendario</strong></p>
                        <p>• Recibirá una confirmación por correo electrónico</p>
                        <p>• Nuestro equipo revisará su caso detalladamente</p>
                        <p>• Le notificaremos cualquier actualización por email</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Próximos pasos -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0">
                        <div class="bg-blue-100 rounded-full p-2">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="ml-3 text-lg font-medium text-gray-900">Revise su correo</h3>
                </div>
                <p class="text-gray-600">
                    Hemos enviado una confirmación con los detalles de su reclamación. Si no la encuentra, revise su carpeta de spam.
                </p>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0">
                        <div class="bg-green-100 rounded-full p-2">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="ml-3 text-lg font-medium text-gray-900">Tiempo de respuesta</h3>
                </div>
                <p class="text-gray-600">
                    Nuestro compromiso es responder en máximo 30 días calendario. En muchos casos, la respuesta puede ser más rápida.
                </p>
            </div>
        </div>

        <!-- Información de contacto -->
        <div class="bg-gray-50 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">¿Necesita más información?</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                    </svg>
                    <span class="text-gray-700">contacto@visastraveltours.com</span>
                </div>
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                    </svg>
                    <span class="text-gray-700">+51 923 647 947</span>
                </div>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/"
               class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Volver al inicio
            </a>

            <a href="{{route('contact')}}"
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                Contactarnos
            </a>
        </div>

        <!-- Información adicional -->
        <div class="mt-12 text-center">
            <p class="text-sm text-gray-500">
                Su reclamación es importante para nosotros. Nos esforzamos por mejorar continuamente nuestros servicios.
            </p>
            <p class="text-sm text-gray-500 mt-2">
                Gracias por confiar en Visas Travel & Tours.
            </p>
        </div>
    </div>
</div>
@endsection
