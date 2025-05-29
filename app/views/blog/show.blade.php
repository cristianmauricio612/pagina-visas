@extends('layouts.public')
@section('title', $articulo->titulo . ' - Blog Visas Travel')
@section('description', $articulo->meta_description ?? $articulo->extracto(160))
@section('keyword', $articulo->meta_keywords ?? 'blog, visas, viajes')

@section('content')
    <!-- SECCIÓN 1: CABECERA DEL ARTÍCULO -->
    <div class="container mx-auto px-4 py-8">
        <!-- Enlace para regresar -->
        <div class="mb-6">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center hover:text-blue-600 text-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Artículos
            </a>
        </div>

        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Imagen principal del artículo -->
            <div class="w-full lg:w-1/2 relative">
                <div class="rounded-lg overflow-hidden">
                    @if($articulo->tieneImagen())
                        <img src="{{ $articulo->imagen }}" alt="{{ $articulo->titulo }}" class="w-full h-auto">
                    @else
                        <div class="w-full h-72 flex items-center justify-center"
                            style="background-color: {{ ['#fbbf24', '#34d399', '#f59e0b', '#10b981'][array_rand(['#fbbf24', '#34d399', '#f59e0b', '#10b981'])] }}">
                            @if($articulo->categoria && $articulo->categoria->icono)
                                <i class="{{ $articulo->categoria->icono }} text-white text-6xl"></i>
                            @else
                                <div class="text-white text-5xl">📝</div>
                            @endif
                        </div>
                    @endif

                    <!-- Badge de categoría en la imagen -->
                    @if($articulo->categoria)
                        <div class="absolute bottom-3 right-3">
                            <span class="inline-block px-2 py-1 text-xs font-medium bg-white rounded shadow-sm">
                                {{ $articulo->categoria->nombre }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Título y metadata del artículo -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center">
                <!-- Badge de tiempo de lectura CORREGIDO para ajustarse al contenido -->
                <div class="w-fit inline-block px-3 py-1 rounded-full text-sm font-medium bg-gray-100 mb-4">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $articulo->tiempo_lectura }} minutos de lectura
                    </div>
                </div>

                <!-- Título del artículo -->
                <h1 class="text-3xl md:text-4xl font-bold mb-6">
                    {{ $articulo->titulo }}
                </h1>

                <!-- Información del autor -->
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        @if($articulo->autorObj && $articulo->autorObj->tieneImagen())
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $articulo->autorObj->avatarUrl() }}"
                                alt="{{ $articulo->autorObj->nombreCompleto() }}">
                        @else
                            <img class="h-10 w-10 rounded-full"
                                src="https://randomuser.me/api/portraits/men/{{ $articulo->id % 80 }}.jpg" alt="Autor">
                        @endif
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">
                            {{ $articulo->autorObj ? $articulo->autorObj->nombreCompleto() : 'Anónimo' }}
                        </p>
                        @if($articulo->autorObj && $articulo->autorObj->puesto)
                            <p class="text-xs text-gray-500">{{ $articulo->autorObj->puesto }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN 2: CONTENIDO DEL ARTÍCULO Y SIDEBAR -->
        <div class="mt-12 border-t pt-10">
            <div class="flex flex-col lg:flex-row gap-10">
                <!-- Columna de contenido (2/3) -->
                <div class="w-full lg:w-2/3">
                    <!-- Contenido del artículo CORREGIDO para HTML -->
                    <div
                        class="prose prose-lg max-w-none prose-ul:list-disc prose-ol:list-decimal prose-li:marker:text-gray-500">
                        {!! html_entity_decode($articulo->contenido) !!}
                    </div>
                    <!-- Estilos de refuerzo para listas -->
                    <style>
                        .prose ul {
                            list-style-type: disc !important;
                            padding-left: 1.5em !important;
                            margin-top: 1em !important;
                            margin-bottom: 1em !important;
                        }

                        .prose ol {
                            list-style-type: decimal !important;
                            padding-left: 1.5em !important;
                            margin-top: 1em !important;
                            margin-bottom: 1em !important;
                        }

                        .prose li {
                            margin-top: 0.5em !important;
                            margin-bottom: 0.5em !important;
                        }
                    </style>
                </div>

                <!-- Columna lateral (1/3) -->
                <div class="w-full lg:w-1/3">
                    <!-- Autor detallado -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                @if($articulo->autorObj && $articulo->autorObj->tieneImagen())
                                    <img class="h-16 w-16 rounded-full object-cover"
                                        src="{{ $articulo->autorObj->avatarUrl() }}"
                                        alt="{{ $articulo->autorObj->nombreCompleto() }}">
                                @else
                                    <img class="h-16 w-16 rounded-full"
                                        src="https://randomuser.me/api/portraits/men/{{ $articulo->id % 80 }}.jpg" alt="Autor">
                                @endif
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold">
                                    {{ $articulo->autorObj ? $articulo->autorObj->nombreCompleto() : 'Anónimo' }}</h3>
                                @if($articulo->autorObj && $articulo->autorObj->puesto)
                                    <p class="text-sm">{{ $articulo->autorObj->puesto }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Etiquetas -->
                    @if(isset($articulo->tags) && count($articulo->tags) > 0)
                        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                            <h3 class="flex items-center text-lg font-medium mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Etiquetas
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($articulo->tags as $tag)
                                    <a href="{{ $tag->url() }}"
                                        class="px-3 py-1 bg-gray-100 rounded-full hover:bg-gray-200 text-sm">
                                        {{ $tag->nombre }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Artículos destacados -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="flex items-center text-lg font-medium mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                            Destacar
                        </h3>

                        <!-- Artículos destacados -->
                        <div class="space-y-6">
                            @foreach($articulosPopulares->take(2) as $popular)
                                @if($popular->id != $articulo->id)
                                    <div class="group">
                                        <a href="{{ $popular->url() }}" class="block">
                                            <div class="relative mb-3 overflow-hidden rounded-lg">
                                                @if($popular->tieneImagen())
                                                    <img src="{{ $popular->imagen }}" alt="{{ $popular->titulo }}"
                                                        class="w-full h-40 object-cover group-hover:opacity-90 transition">
                                                @else
                                                    <div class="w-full h-40 flex items-center justify-center"
                                                        style="background-color: {{ ['#60a5fa', '#f59e0b', '#ef4444', '#10b981'][array_rand(['#60a5fa', '#f59e0b', '#ef4444', '#10b981'])] }}">
                                                        @if($popular->categoria && $popular->categoria->icono)
                                                            <i class="{{ $popular->categoria->icono }} text-white text-3xl"></i>
                                                        @else
                                                            <div class="text-white text-3xl">📝</div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            <h4 class="font-bold group-hover:text-slate-600">
                                                {{ $popular->titulo }}
                                            </h4>
                                        </a>

                                        <div class="flex items-center mt-2">
                                            <div class="flex-shrink-0">
                                                @if($popular->autorObj && $popular->autorObj->tieneImagen())
                                                    <img class="h-6 w-6 rounded-full object-cover" src="{{ $popular->autorObj->avatarUrl() }}" alt="{{ $popular->autorObj->nombreCompleto() }}">
                                                @else
                                                    <img class="h-6 w-6 rounded-full" src="https://randomuser.me/api/portraits/men/{{ $popular->id % 80 }}.jpg" alt="Autor">
                                                @endif
                                            </div>
                                            <div class="ml-2">
                                                <p class="text-sm font-medium">{{ $popular->autorObj ? $popular->autorObj->nombreCompleto() : 'Anónimo' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN 3: ARTÍCULOS RELACIONADOS -->
        @if(isset($articulosRelacionados) && count($articulosRelacionados) > 0)
            <div class="mt-16 mb-10">
                <h2 class="flex items-center text-xl font-medium mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    Más artículos como este
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($articulosRelacionados as $relacionado)
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                            <a href="{{ $relacionado->url() }}" class="block">
                                <div class="relative">
                                    @if($relacionado->tieneImagen())
                                        <img src="{{ $relacionado->imagen }}" alt="{{ $relacionado->titulo }}"
                                            class="w-full h-40 object-cover">
                                    @else
                                        <div class="w-full h-40 flex items-center justify-center"
                                            style="background-color: {{ ['#60a5fa', '#34d399', '#fbbf24', '#f87171'][array_rand(['#60a5fa', '#34d399', '#fbbf24', '#f87171'])] }}">
                                            @if($relacionado->categoria && $relacionado->categoria->icono)
                                                <i class="{{ $relacionado->categoria->icono }} text-white text-3xl"></i>
                                            @else
                                                <div class="text-white text-3xl">📝</div>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Badge de categoría -->
                                    @if($relacionado->categoria)
                                        <div class="absolute top-2 right-2">
                                            <span class="inline-block px-2 py-1 text-xs font-medium bg-white rounded-md shadow-sm">
                                                {{ $relacionado->categoria->nombre }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-4">
                                    <h3 class="font-bold mb-2">
                                        {{ $relacionado->titulo }}
                                    </h3>

                                    <div class="flex items-center mt-2">
                                        <div class="flex-shrink-0">
                                            @if($relacionado->autorObj && $relacionado->autorObj->tieneImagen())
                                                <img class="h-6 w-6 rounded-full object-cover" src="{{ $relacionado->autorObj->avatarUrl() }}" alt="{{ $relacionado->autorObj->nombreCompleto() }}">
                                            @else
                                                <img class="h-6 w-6 rounded-full" src="https://randomuser.me/api/portraits/men/{{ $relacionado->id % 80 }}.jpg" alt="Autor">
                                            @endif
                                        </div>
                                        <div class="ml-2">
                                            <p class="text-sm font-medium">{{ $relacionado->autorObj ? $relacionado->autorObj->nombreCompleto() : 'Anónimo' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
