<!doctype html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="{{assets('fontawesome/css/all.css')}}" rel="stylesheet">
    <link href="{{ assets('css/menu-admin.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('resources')
</head>

<body class="flex bg-gray-100">

    {{-- Sidebar --}}
    <div id="sidebar" class="w-64 bg-gray-900 text-white min-h-screen p-5 flex flex-col fixed lg:relative transition-all duration-300 transform -translate-x-full lg:translate-x-0">
        
        {{-- Botón de Cerrar Sidebar (Solo visible en móviles) --}}
        <button id="closeSidebar" class="absolute top-4 right-4 bg-red-500 text-white w-10 h-10 flex items-center justify-center rounded-full text-xl lg:hidden">
            <i class="fas fa-times"></i>
        </button>

        {{-- Logo y Nombre --}}
        <div class="flex items-center mb-6">
            <img src="{{ assets('img/av.png') }}" alt="Visa Asesores" class="w-10 h-10 mr-3">
            <span class="text-x font-semibold">Visa Asesores</span>
        </div>

        <nav class="flex-1">
            <ul>
                {{-- Home --}}
                <li class="mb-2">
                    <a href="{{route('admin.homeView')}}" class="flex items-center w-full text-left p-3 rounded-md outline-none hover:bg-gray-800 transition">
                        <i class="fas fa-home mr-2"></i> Home
                    </a>
                </li>

                {{-- Usuarios --}}
                <li class="mb-2">
                    <button class="flex items-center w-full text-left p-3 rounded-md outline-none hover:bg-gray-800 transition" onclick="toggleMenu('usuarios')">
                        <i class="fas fa-users mr-2"></i> Usuarios
                    </button>
                    <ul id="usuarios" class="ml-6 mt-1 hidden transition-all">
                        <li>
                            <a href="{{route('admin.usuarios.listView')}}" class="flex items-center p-2 text-gray-300 hover:text-white hover:border-l-4 hover:border-white">
                                <i class="fas fa-list mr-2"></i> Listar
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin.usuarios.addView')}}" class="flex items-center p-2 text-gray-300 hover:text-white hover:border-l-4 hover:border-white">
                                <i class="fas fa-plus-circle mr-2"></i> Crear
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Países --}}
                <li class="mb-2">
                    <button class="flex items-center w-full text-left p-3 rounded-md outline-none hover:bg-gray-800 transition" onclick="toggleMenu('paises')">
                        <i class="fas fa-globe mr-2"></i> Países
                    </button>
                    <ul id="paises" class="ml-6 mt-1 hidden transition-all">
                        <li>
                            <a href="{{route('admin.paises.listView')}}" class="flex items-center p-2 text-gray-300 hover:text-white hover:border-l-4 hover:border-white">
                                <i class="fas fa-list mr-2"></i> Listar
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin.paises.addView')}}" class="flex items-center p-2 text-gray-300 hover:text-white hover:border-l-4 hover:border-white">
                                <i class="fas fa-plus-circle mr-2"></i> Crear
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Visas --}}
                <li class="mb-2">
                    <button class="flex items-center w-full text-left p-3 rounded-md outline-none hover:bg-gray-800 transition" onclick="toggleMenu('visas')">
                        <i class="fas fa-passport mr-2"></i> Visas
                    </button>
                    <ul id="visas" class="ml-6 mt-1 hidden transition-all">
                        <li>
                            <a href="{{route('admin.visas.listView')}}" class="flex items-center p-2 text-gray-300 hover:text-white hover:border-l-4 hover:border-white">
                                <i class="fas fa-list mr-2"></i> Listar
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin.visas.addView')}}" class="flex items-center p-2 text-gray-300 hover:text-white hover:border-l-4 hover:border-white">
                                <i class="fas fa-plus-circle mr-2"></i> Crear
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Pedidos --}}
                <li class="mb-2">
                    <button class="flex items-center w-full text-left p-3 rounded-md outline-none hover:bg-gray-800 transition" onclick="toggleMenu('pedidos')">
                        <i class="fas fa-shopping-cart mr-2"></i> Pedidos
                    </button>
                    <ul id="pedidos" class="ml-6 mt-1 hidden transition-all">
                        <li>
                            <a href="{{route('admin.pedidos.listView')}}" class="flex items-center p-2 text-gray-300 hover:text-white hover:border-l-4 hover:border-white">
                                <i class="fas fa-list mr-2"></i> Listar
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin.pedidos.addView')}}" class="flex items-center p-2 text-gray-300 hover:text-white hover:border-l-4 hover:border-white">
                                <i class="fas fa-plus-circle mr-2"></i> Crear
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        {{-- Botón de Cerrar Sesión --}}
        <div class="mt-auto">
            <a href="" class="w-full flex items-center justify-center bg-red-600 text-white py-3 rounded-md hover:bg-red-700 transition">
                <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
            </a>
        </div>
    </div>

    {{-- Contenido Principal --}}
    <div class="flex-1 p-10 transition-all duration-300 max-w-[100vw]">
        @yield('content')
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const closeSidebar = document.getElementById('closeSidebar');

        closeSidebar.addEventListener('click', function () {
            sidebar.classList.add('-translate-x-full');
            document.getElementById('openSidebar').classList.remove('hidden'); // Mostrar el botón de abrir
        });

        function toggleMenu(menuId) {
            let menu = document.getElementById(menuId);
            menu.classList.toggle('hidden');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>