@extends('layouts.public')
@section('title', 'Blog - Visas Travel')
@section('description', 'Información útil sobre visas y trámites migratorios')
@section('keyword', 'blog, visas, viajes, trámites')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar de Categorías -->
        <div class="w-full md:w-1/4 lg:w-1/5">
            <div class="sticky top-24">
                <h2 class="flex items-center text-xl font-medium mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Categorías
                </h2>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('blog.index') }}" class="block py-2 px-4 rounded-md bg-slate-800 text-white hover:bg-slate-700">
                            Todos los artículos
                        </a>
                    </li>
                    @foreach($categorias as $cat)
                    <li>
                        <a href="{{ $cat->url() }}" class="block py-2 px-4 rounded-md bg-gray-100 hover:bg-gray-200">
                            @if($cat->icono)
                                <i class="{{ $cat->icono }} mr-2"></i>
                            @endif
                            {{ $cat->nombre }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="w-full md:w-3/4 lg:w-4/5">
            <!-- Título Principal -->
            <h1 class="text-5xl font-serif font-bold text-slate-800 mb-10">Todos los artículos</h1>

            <!-- Estructura de filas de contenido -->
            <div class="mb-16">
                <!-- Fila 1: Destacado y Tendencias -->
                <div class="flex flex-col lg:flex-row gap-10 mb-16">
                    <!-- Columna Izquierda: Destacar -->
                    <div class="w-full lg:w-1/2">
                        <div class="flex items-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                            <h2 class="text-xl font-medium">Destacado</h2>
                        </div>

                        <!-- Artículo Destacado -->
                        @if($articuloDestacado)
                        <div class="rounded-xl overflow-hidden shadow-md bg-white transition-all hover:shadow-lg">
                            <div class="relative">
                                @if($articuloDestacado->tieneImagen())
                                    <img src="{{ $articuloDestacado->imagen }}" alt="{{ $articuloDestacado->titulo }}" class="w-full h-80 object-cover">
                                @else
                                    <div class="w-full h-80 bg-amber-400 flex items-center justify-center">
                                        <!-- Placeholder con diseño tipo ilustración -->
                                        <div class="text-white text-4xl">🌍</div>
                                    </div>
                                @endif

                                <!-- Badge de categoría -->
                                @if($articuloDestacado->categoria)
                                    <div class="absolute bottom-4 right-4">
                                        <span class="bg-white text-xs uppercase tracking-wider px-3 py-1 rounded-full shadow-md">
                                            @if($articuloDestacado->categoria->icono)
                                                <i class="{{ $articuloDestacado->categoria->icono }} mr-1"></i>
                                            @endif
                                            {{ $articuloDestacado->categoria->nombre }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-4">
                                    <a href="{{ $articuloDestacado->url() }}" class="text-slate-800 hover:text-slate-600">
                                        {{ $articuloDestacado->titulo }}
                                    </a>
                                </h3>

                                <div class="flex items-center mt-4">
                                    <div class="flex-shrink-0">
                                        <img class="h-8 w-8 rounded-full" src="https://randomuser.me/api/portraits/men/32.jpg" alt="{{ $articuloDestacado->autor }}">
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-700">{{ $articuloDestacado->autor }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Columna Derecha: Tendencias -->
                    <div class="w-full lg:w-1/2">
                        <div class="flex items-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            <h2 class="text-xl font-medium">Tendencias</h2>
                        </div>

                        <div class="space-y-6">
                            @foreach($articulosPopulares->take(4) as $popular)
                            <div class="flex gap-4 items-center">
                                <div class="w-24 h-24 flex-shrink-0">
                                    @if($popular->tieneImagen())
                                        <img src="{{ $popular->imagen }}" alt="{{ $popular->titulo }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <div class="w-full h-full bg-blue-100 rounded-lg flex items-center justify-center">
                                            @if($popular->categoria && $popular->categoria->icono)
                                                <i class="{{ $popular->categoria->icono }} text-3xl text-blue-500"></i>
                                            @else
                                                <span class="text-3xl">📝</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-medium text-slate-800">
                                        <a href="{{ $popular->url() }}" class="hover:text-blue-600">
                                            {{ $popular->titulo }}
                                        </a>
                                    </h3>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Secciones por Categoría -->
                @foreach($categorias as $categoria)
                    @php
                        $articulosCategoria = App\Models\Blog::porCategoria($categoria->id)->limit(2)->get();
                    @endphp

                    @if(count($articulosCategoria) > 0)
                        <div class="mb-16">
                            <!-- Encabezado de Categoría -->
                            <div class="flex justify-between items-center mb-8">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full mr-3">
                                        @if($categoria->icono)
                                            <i class="{{ $categoria->icono }} text-slate-700"></i>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                            </svg>
                                        @endif
                                    </span>
                                    <h2 class="text-xl font-medium">{{ $categoria->nombre }}</h2>
                                </div>
                                <a href="{{ $categoria->url() }}" class="flex items-center text-sm font-medium text-slate-700 hover:text-blue-600">
                                    Leer más
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>

                            <!-- Artículos de la Categoría -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                @foreach($articulosCategoria as $articulo)
                                <div class="rounded-xl overflow-hidden shadow-md bg-white hover:shadow-lg transition-all">
                                    <div class="relative">
                                        @if($articulo->tieneImagen())
                                            <img src="{{ $articulo->imagen }}" alt="{{ $articulo->titulo }}" class="w-full h-52 object-cover">
                                        @else
                                            <div class="w-full h-52 flex items-center justify-center"
                                                 style="background-color: {{ ['#60a5fa', '#34d399', '#fbbf24', '#f87171', '#a78bfa'][array_rand(['#60a5fa', '#34d399', '#fbbf24', '#f87171', '#a78bfa'])] }}">
                                                <!-- Imagen placeholder estilizada con icono de categoría si está disponible -->
                                                @if($categoria->icono)
                                                    <i class="{{ $categoria->icono }} text-white text-4xl"></i>
                                                @endif
                                            </div>
                                        @endif

                                        <!-- Badge pequeño de categoría -->
                                        <div class="absolute bottom-2 right-2">
                                            <span class="bg-white text-xs px-2 py-1 rounded-full shadow-sm">
                                                @if($categoria->icono)
                                                    <i class="{{ $categoria->icono }} mr-1"></i>
                                                @endif
                                                {{ $categoria->nombre }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="p-5">
                                        <h3 class="text-lg font-bold mb-3">
                                            <a href="{{ $articulo->url() }}" class="text-slate-800 hover:text-slate-600">
                                                {{ $articulo->titulo }}
                                            </a>
                                        </h3>

                                        <div class="flex items-center mt-4">
                                            <div class="flex-shrink-0">
                                                <img class="h-7 w-7 rounded-full" src="https://randomuser.me/api/portraits/men/{{ $articulo->id % 80 }}.jpg" alt="{{ $articulo->autor }}">
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-700">{{ $articulo->autor }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
