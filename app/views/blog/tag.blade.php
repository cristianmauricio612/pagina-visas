@extends('layouts.public')
@section('title', $tagObj->nombre . ' - Blog Visas Travel')
@section('description', 'Artículos etiquetados con ' . $tagObj->nombre)
@section('keyword', 'blog, ' . $tagObj->nombre . ', visas, viajes')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Enlace "Atrás" -->
    <div class="mb-6">
        <a href="{{ route('blog.index') }}" class="inline-flex items-center hover:text-blue-600 text-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Atrás
        </a>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Contenido principal con artículos - AJUSTADO A 2 COLUMNAS -->
        <div class="w-full lg:w-3/4 order-1">
            <!-- Título simple como en la imagen -->
            <h1 class="text-3xl font-bold mb-8">{{ $tagObj->nombre }}</h1>

            @if($articulos->count() > 0)
                <!-- Grid de artículos AJUSTADO A 2 COLUMNAS -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                    @foreach($articulos as $articulo)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all">
                        <a href="{{ $articulo->url() }}" class="block">
                            <div class="relative">
                                @if($articulo->tieneImagen())
                                    <img src="{{ $articulo->imagen }}" alt="{{ $articulo->titulo }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 flex items-center justify-center"
                                         style="background-color: {{ ['#60a5fa', '#34d399', '#fbbf24', '#f87171'][array_rand(['#60a5fa', '#34d399', '#fbbf24', '#f87171'])] }}">
                                        @if($articulo->categoria && $articulo->categoria->icono)
                                            <i class="{{ $articulo->categoria->icono }} text-white text-4xl"></i>
                                        @else
                                            <div class="text-white text-4xl">📝</div>
                                        @endif
                                    </div>
                                @endif

                                <!-- Badge de categoría -->
                                @if($articulo->categoria)
                                <div class="absolute bottom-2 right-2">
                                    <span class="inline-block px-2 py-1 text-xs font-medium bg-white text-gray-800 rounded-full shadow-sm">
                                        @if($articulo->categoria->icono)
                                            <i class="{{ $articulo->categoria->icono }} mr-1"></i>
                                        @endif
                                        {{ $articulo->categoria->nombre }}
                                    </span>
                                </div>
                                @endif
                            </div>

                            <div class="p-4">
                                <h3 class="text-lg font-bold mb-2 text-slate-800 hover:text-slate-600">
                                    {{ $articulo->titulo }}
                                </h3>

                                <div class="flex items-center mt-2">
                                    <div class="flex-shrink-0">
                                        <img class="h-8 w-8 rounded-full" src="https://randomuser.me/api/portraits/men/{{ $articulo->id % 80 }}.jpg" alt="{{ $articulo->autor }}">
                                    </div>
                                    <div class="ml-2">
                                        <p class="text-sm text-gray-600">{{ $articulo->autor }}</p>
                                        <p class="text-xs text-gray-500">{{ $articulo->fechaFormateada() }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                <!-- Paginación -->
                @if($totalPages > 1)
                <div class="flex justify-center mt-10">
                    <div class="inline-flex shadow-sm">
                        @if($page > 1)
                            <a href="?page={{ $page - 1 }}" class="py-2 px-4 border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 rounded-l-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                        @endif

                        @for($i = 1; $i <= $totalPages; $i++)
                            <a href="?page={{ $i }}" class="py-2 px-4 border border-gray-300 {{ $i == $page ? 'bg-blue-50 text-blue-600 font-medium' : 'bg-white text-gray-500 hover:bg-gray-50' }}">
                                {{ $i }}
                            </a>
                        @endfor

                        @if($page < $totalPages)
                            <a href="?page={{ $page + 1 }}" class="py-2 px-4 border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 rounded-r-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
                @endif
            @else
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <p class="text-lg text-gray-600">No se encontraron artículos con esta etiqueta.</p>
                    <a href="{{ route('blog.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">
                        Ver todos los artículos
                    </a>
                </div>
            @endif
        </div>

        <!-- Barra lateral derecha SOLO CON ETIQUETAS -->
        <div class="w-full lg:w-1/4 order-2">
            <div class="sticky top-24">
                <!-- Título de Etiquetas -->
                <div class="flex items-center mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <h2 class="text-lg font-medium">Etiquetas</h2>
                </div>

                <!-- Listado de etiquetas -->
                <div class="bg-white rounded-lg shadow-sm p-5">
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $t)
                        <a href="{{ $t->url() }}"
                           class="px-3 py-1 text-sm rounded-full {{ $t->id == $tagObj->id ? 'bg-slate-800 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            {{ $t->nombre }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
