@extends('layouts.public')
@section('title', $categoriaObj->nombre . ' - Blog Visas Travel')
@section('description', 'Artículos sobre ' . $categoriaObj->nombre)
@section('keyword', 'blog, ' . $categoriaObj->nombre . ', visas, viajes')

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
                        <a href="{{ route('blog.index') }}" class="block py-2 px-4 rounded-md bg-gray-100 hover:bg-gray-200">
                            Todos los artículos
                        </a>
                    </li>
                    @foreach($categorias as $cat)
                    <li>
                        <a href="{{ $cat->url() }}"
                           class="block py-2 px-4 rounded-md {{ $cat->id == $categoriaObj->id ? 'bg-slate-800 text-white hover:bg-slate-700' : 'bg-gray-100 hover:bg-gray-200' }}">
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
            <!-- Título de la Categoría -->
            <h1 class="text-5xl font-bold mb-10">{{ $categoriaObj->nombre }}</h1>

            <div class="mb-16">
                <!-- Título "Destacar" -->
                <div class="flex items-center mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                    <h2 class="text-xl font-medium">Destacados</h2>
                </div>

                <!-- Dos artículos destacados en formato horizontal -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-16">
                    @foreach($articulos->take(2) as $index => $articulo)
                    <div class="rounded-xl overflow-hidden shadow-md bg-white hover:shadow-lg transition-all">
                        <div class="relative">
                            @if($articulo->tieneImagen())
                                <img src="{{ $articulo->imagen }}" alt="{{ $articulo->titulo }}" class="w-full h-60 object-cover">
                            @else
                                <div class="w-full h-60 flex items-center justify-center"
                                     style="background-color: {{ ['#fbbf24', '#ef4444'][$index % 2] }}">
                                    <!-- Placeholder con diseño tipo ilustración basado en la categoría -->
                                    @if($categoriaObj->icono)
                                        <i class="{{ $categoriaObj->icono }} text-white text-5xl"></i>
                                    @else
                                        <div class="text-white text-4xl">🌍</div>
                                    @endif
                                </div>
                            @endif

                            <!-- Badge de categoría -->
                            <div class="absolute bottom-3 right-3">
                                <span class="bg-white text-xs uppercase px-3 py-1 rounded-full shadow-md">
                                    {{ $categoriaObj->nombre }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-4">
                                <a href="{{ $articulo->url() }}" class="text-slate-800 hover:text-slate-600">
                                    {{ $articulo->titulo }}
                                </a>
                            </h3>

                            <div class="flex items-center mt-4">
                                <div class="flex-shrink-0">
                                    <img class="h-8 w-8 rounded-full" src="https://randomuser.me/api/portraits/men/{{ $articulo->id % 80 }}.jpg" alt="{{ $articulo->autor }}">
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium">{{ $articulo->autor }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Sección con título de la categoría para los artículos restantes -->
                @if($articulos->count() > 2)
                <div class="mb-6">
                    <div class="flex items-center mb-6">
                        <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full mr-3">
                            @if($categoriaObj->icono)
                                <i class="{{ $categoriaObj->icono }}"></i>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                            @endif
                        </span>
                        <h2 class="text-xl font-medium">{{ $categoriaObj->nombre }}</h2>
                    </div>

                    <!-- Artículos restantes en formato de grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                        @foreach($articulos->skip(2) as $articulo)
                        <div class="rounded-xl overflow-hidden shadow-md bg-white hover:shadow-lg transition-all">
                            <div class="relative">
                                @if($articulo->tieneImagen())
                                    <img src="{{ $articulo->imagen }}" alt="{{ $articulo->titulo }}" class="w-full h-52 object-cover">
                                @else
                                    <div class="w-full h-52 flex items-center justify-center"
                                         style="background-color: {{ ['#60a5fa', '#34d399', '#fbbf24', '#f87171', '#a78bfa'][array_rand(['#60a5fa', '#34d399', '#fbbf24', '#f87171', '#a78bfa'])] }}">
                                        <!-- Imagen placeholder estilizada con icono de categoría -->
                                        @if($categoriaObj->icono)
                                            <i class="{{ $categoriaObj->icono }} text-white text-4xl"></i>
                                        @endif
                                    </div>
                                @endif

                                <!-- Badge pequeño de categoría -->
                                <div class="absolute bottom-2 right-2">
                                    <span class="bg-white text-xs px-2 py-1 rounded-full shadow-sm">
                                        @if($categoriaObj->icono)
                                            <i class="{{ $categoriaObj->icono }} mr-1"></i>
                                        @endif
                                        {{ $categoriaObj->nombre }}
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
                                        <p class="text-sm font-medium">{{ $articulo->autor }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Paginación -->
                @if($totalPages > 1)
                <div class="flex justify-center mt-10">
                    <div class="inline-flex shadow-sm">
                        @if($page > 1)
                            <a href="?page={{ $page - 1 }}" class="py-2 px-4 border border-gray-300 bg-white hover:bg-gray-50 rounded-l-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                        @endif

                        @for($i = 1; $i <= $totalPages; $i++)
                            <a href="?page={{ $i }}" class="py-2 px-4 border border-gray-300 {{ $i == $page ? 'bg-blue-50 text-blue-600 font-medium' : 'bg-white hover:bg-gray-50' }}">
                                {{ $i }}
                            </a>
                        @endfor

                        @if($page < $totalPages)
                            <a href="?page={{ $page + 1 }}" class="py-2 px-4 border border-gray-300 bg-white hover:bg-gray-50 rounded-r-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
