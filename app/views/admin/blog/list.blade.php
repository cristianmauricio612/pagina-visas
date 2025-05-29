@extends('layouts.admin')
@section('title', 'Admin | Gestión del Blog')

@section('content')
    @php
        $categorias = \App\Models\BlogCategoria::all(); // Obtener todas las categorías
    @endphp

    {{-- Botón para abrir el Sidebar (Solo en esta vista) --}}
    <button id="openSidebar"
        class="fixed top-4 left-4 bg-gray-900 text-white w-10 h-10 flex items-center justify-center rounded-md text-lg lg:hidden shadow-md">
        <i class="fas fa-bars"></i>
    </button>

    <div class="py-6">
        {{-- Título --}}
        <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4 text-center md:text-left">
            Gestión del Blog
        </h1>

        {{-- Buscador, Filtros y Botón Agregar --}}
        <div class="flex flex-col md:flex-row justify-between mb-6 gap-4">
            <div class="flex flex-col md:flex-row gap-2 w-full md:w-2/3">
                <input type="text" id="search-input" placeholder="Buscar artículo..." class="p-2 border rounded flex-grow">

                <select id="filter-estado" class="p-2 border rounded">
                    <option value="">Todos los estados</option>
                    <option value="borrador">Borrador</option>
                    <option value="publicado">Publicado</option>
                    <option value="archivado">Archivado</option>
                </select>

                <select id="filter-categoria" class="p-2 border rounded">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->nombre }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.blog.addView') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Nuevo Artículo
                </a>
                <a href="{{ route('admin.blog.categorias.listView') }}"
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                    Categorías
                </a>
            </div>
        </div>

        {{-- Contenedor con scroll horizontal y vertical --}}
        <div class="w-full max-w-[100%] max-h-[600px] overflow-y-auto overflow-x-auto border rounded-lg">
            <table class="w-full md:min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left w-12">ID</th>
                        <th class="py-2 px-4 text-left">Título</th>
                        <th class="py-2 px-4 text-left">Categoría</th>
                        <th class="py-2 px-4 text-left">Autor</th>
                        <th class="py-2 px-4 text-left">Estado</th>
                        <th class="py-2 px-4 text-left">Fecha</th>
                        <th class="py-2 px-4 text-left">Vistas</th>
                        <th class="py-2 px-4 text-left w-32">Acciones</th>
                    </tr>
                </thead>
                <tbody id="blog-table-body">
                    <tr>
                        <td colspan="8" class="py-4 px-4 text-center text-gray-500">Cargando artículos...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="mt-4 flex justify-between items-center">
            <div>
                <span id="total-items">0</span> artículos encontrados
            </div>
            <div class="flex gap-2">
                <button id="prev-page" class="px-3 py-1 border rounded disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <span id="current-page" class="px-3 py-1">Página 1</span>
                <button id="next-page" class="px-3 py-1 border rounded disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('openSidebar').addEventListener('click', function () {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            this.classList.add('hidden'); // Oculta el botón de abrir
        });

        // Configuración inicial de la paginación
        let currentPage = 1;
        let totalPages = 1;

        document.addEventListener("DOMContentLoaded", function () {
            // Cargar artículos al cargar la página
            cargarArticulos();

            // Configurar eventos de filtros
            $("#search-input").on("keyup", function () {
                currentPage = 1;
                cargarArticulos();
            });

            $("#filter-estado, #filter-categoria").on("change", function () {
                currentPage = 1;
                cargarArticulos();
            });

            // Configurar eventos de paginación
            $("#prev-page").on("click", function() {
                if (currentPage > 1) {
                    currentPage--;
                    cargarArticulos();
                }
            });

            $("#next-page").on("click", function() {
                if (currentPage < totalPages) {
                    currentPage++;
                    cargarArticulos();
                }
            });
        });

        // Token CSRF para operaciones AJAX
        const csrfToken = "{{ csrf()->token() }}";

        // Función para cargar artículos según los filtros
        function cargarArticulos() {
            const busqueda = $("#search-input").val().trim();
            const estado = $("#filter-estado").val();
            const categoria = $("#filter-categoria").val();

            $("#blog-table-body").html('<tr><td colspan="8" class="py-4 px-4 text-center">Cargando artículos...</td></tr>');

            $.ajax({
                url: "/admin/blog/buscar",
                type: "GET",
                data: {
                    q: busqueda,
                    estado: estado,
                    categoria: categoria,
                    page: currentPage,
                    per_page: 10
                },
                dataType: "json",
                success: function (response) {
                    $("#blog-table-body").empty();

                    if (!response.data || response.data.length === 0) {
                        $("#blog-table-body").html('<tr><td colspan="8" class="py-4 px-4 text-center">No se encontraron artículos.</td></tr>');
                        $("#total-items").text("0");
                        return;
                    }

                    // Actualizar información de paginación
                    totalPages = response.total_pages;
                    $("#total-items").text(response.total);
                    $("#current-page").text("Página " + currentPage + " de " + totalPages);

                    // Habilitar/deshabilitar botones de paginación
                    $("#prev-page").prop("disabled", currentPage <= 1);
                    $("#next-page").prop("disabled", currentPage >= totalPages);

                    // Generar filas de la tabla
                    let html = "";
                    response.data.forEach(articulo => {
                        const fecha = articulo.fecha_publicacion
                            ? new Date(articulo.fecha_publicacion).toLocaleDateString('es-ES')
                            : 'Sin publicar';

                        // Definir clase para el estado
                        let estadoClass = '';
                        switch(articulo.estado) {
                            case 'publicado':
                                estadoClass = 'bg-green-100 text-green-800';
                                break;
                            case 'borrador':
                                estadoClass = 'bg-yellow-100 text-yellow-800';
                                break;
                            case 'archivado':
                                estadoClass = 'bg-gray-100 text-gray-800';
                                break;
                        }

                        html += `
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-2 px-4">${articulo.id}</td>
                                <td class="py-2 px-4 font-medium">${articulo.titulo}</td>
                                <td class="py-2 px-4">${articulo.categoria ? articulo.categoria.nombre : 'Sin categoría'}</td>
                                <td class="py-2 px-4">${articulo.autor_id ? articulo.autor_nombre_completo || 'Sin autor' : 'Sin autor'}</td>
                                <td class="py-2 px-4">
                                    <span class="px-2 py-1 rounded-full text-xs ${estadoClass}">
                                        ${articulo.estado.charAt(0).toUpperCase() + articulo.estado.slice(1)}
                                    </span>
                                </td>
                                <td class="py-2 px-4">${fecha}</td>
                                <td class="py-2 px-4">${articulo.vistas || 0}</td>
                                <td class="py-2 px-4">
                                    <div class="flex space-x-2">
                                        <a href="/admin/blog/editar/${articulo.id}"
                                            class="text-blue-500 hover:text-blue-700" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="cambiarEstado(${articulo.id}, '${articulo.estado === 'publicado' ? 'borrador' : 'publicado'}')"
                                            class="text-${articulo.estado === 'publicado' ? 'yellow' : 'green'}-500 hover:text-${articulo.estado === 'publicado' ? 'yellow' : 'green'}-700"
                                            title="${articulo.estado === 'publicado' ? 'Pasar a borrador' : 'Publicar'}">
                                            <i class="fas fa-${articulo.estado === 'publicado' ? 'pause' : 'play'}"></i>
                                        </button>
                                        <button onclick="eliminarArticulo(${articulo.id})"
                                            class="text-red-500 hover:text-red-700" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <a href="/${articulo.slug}" target="_blank"
                                            class="text-gray-500 hover:text-gray-700" title="Ver en sitio">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });

                    $("#blog-table-body").html(html);
                },
                error: function (xhr) {
                    let errorMessage = "Error al cargar los artículos.";
                    if (xhr.status === 404) {
                        errorMessage = "No se encontraron artículos.";
                    } else if (xhr.status === 500) {
                        errorMessage = "Error interno del servidor.";
                    }

                    $("#blog-table-body").html(`<tr><td colspan="8" class="py-4 px-4 text-center">${errorMessage}</td></tr>`);
                    console.error("Error en la búsqueda:", xhr.responseText);
                }
            });
        }

        // Función para cambiar el estado de un artículo
        function cambiarEstado(id, nuevoEstado) {
            if (!confirm(`¿Estás seguro de cambiar el estado a ${nuevoEstado}?`)) {
                return;
            }

            $.ajax({
                url: `/admin/blog/cambiar-estado/${id}`,
                type: "PUT",
                data: JSON.stringify({ estado: nuevoEstado }),
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                },
                success: function (response) {
                    if (response.status === 'success') {
                        alert(`Estado cambiado a ${nuevoEstado} exitosamente`);
                        cargarArticulos(); // Recargar la tabla
                    } else {
                        alert(`Error: ${response.message}`);
                    }
                },
                error: function (xhr) {
                    alert("Error al cambiar el estado");
                    console.error("Error:", xhr.responseText);
                }
            });
        }

        // Función para eliminar un artículo
        function eliminarArticulo(id) {
            if (!confirm("¿Estás seguro de eliminar este artículo? Esta acción no se puede deshacer.")) {
                return;
            }

            $.ajax({
                url: `/admin/blog/eliminar/${id}`,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                },
                success: function (response) {
                    if (response.status === 'success') {
                        alert("Artículo eliminado exitosamente");
                        cargarArticulos(); // Recargar la tabla
                    } else {
                        alert(`Error: ${response.message}`);
                    }
                },
                error: function (xhr) {
                    alert("Error al eliminar el artículo");
                    console.error("Error:", xhr.responseText);
                }
            });
        }
    </script>
@endsection
