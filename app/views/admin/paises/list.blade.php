@extends('layouts.admin')
@section('title', 'Admin | Listar paises')

@section('content')
    @php
        $paises = \App\Models\Pais::all();
    @endphp
    {{-- Botón para abrir el Sidebar (Solo en esta vista) --}}
    <button id="openSidebar" class="fixed top-4 left-4 bg-gray-900 text-white w-10 h-10 flex items-center justify-center rounded-md text-lg lg:hidden shadow-md">
        <i class="fas fa-bars"></i>
    </button>

    <div class="py-6">
        {{-- Título --}}
        <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4 text-center md:text-left">
            Gestión de Países
        </h1>

        {{-- Buscador y Botón Agregar --}}
        <div class="flex flex-col md:flex-row justify-between mb-6 gap-4">
            <input type="text" id="search-input" placeholder="Buscar país..." class="p-2 border rounded w-full md:w-1/3">
            <a href="{{ route('admin.paises.addView') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Agregar País
            </a>
        </div>

        {{-- Contenedor con scroll horizontal y vertical --}}
        <div class="w-full max-w-[100%] max-h-[800px] overflow-y-auto overflow-x-auto border rounded-lg">
            <table class="w-full md:min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left w-12">ID</th>
                        <th class="py-2 px-4 text-left w-48">Nombre</th>
                        <th class="py-2 px-4 text-left w-32">Imagen</th>
                        <th class="py-2 px-4 text-left w-32">Acciones</th>
                    </tr>
                </thead>
                <tbody id="paises-table-body">
                    @forelse ($paises as $pais)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-2 px-4">{{ $pais->id }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $pais->nombre }}</td>
                            <td class="py-2 px-4">
                                <img src="{{ $pais->imagen}}" alt="{{ $pais->nombre }}" class="w-14 h-10 object-cover rounded border">
                            </td>
                            <td class="py-2 px-4 flex space-x-2">
                                <a href="" class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="submit" class="text-red-500 hover:text-red-700" data-id="{{ $pais->id }}"
                                    onclick="deletePais(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-2 px-4 text-center text-gray-500">No hay países registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('openSidebar').addEventListener('click', function () {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            this.classList.add('hidden'); // Oculta el botón de abrir
        });

        document.addEventListener("DOMContentLoaded", function () {
            $("#search-input").on("keyup", function () {
                searchPais();
            });
        });

        const csrfToken = "{{ csrf()->token() }}";

        function deletePais(button) {
            let id = $(button).data("id");

            if (!id) {
                alert("Error: ID del pais no encontrado.");
                return;
            }

            if (!confirm("¿Estás seguro de eliminar este pais?")) {
                return;
            }

            $.ajax({
                url: "/admin/paises/eliminar/" + id,
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken // Incluir el token en los headers
                },
                success: function (response) {
                    alert("✅ Pais eliminado correctamente");
                    setTimeout(function () {
                        location.reload();
                    }, 500);
                },
                error: function (xhr) {
                    alert("❌ Error al eliminar pais: " + xhr.responseText);
                }
            });
        }

        function searchPais() {
            let description = $("#search-input").val().trim();

            $("#paises-table-body").html('<tr><td colspan="6">Cargando...</td></tr>');

            $.ajax({
                url: "/admin/paises/buscar",
                type: "GET",
                data: { descripcion: description },
                dataType: "json",
                success: function (data) {
                    $("#paises-table-body").empty();

                    if (!Array.isArray(data) || data.length === 0) {
                        $("#paises-table-body").html('<tr><td colspan="6">No se encontraron paises.</td></tr>');
                        return;
                    }

                    let html = "";
                    data.forEach(pais => {
                        html += `
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="py-2 px-4">${pais.id}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">${pais.nombre}</td>
                                    <td class="py-2 px-4">
                                        <img src="${pais.imagen}" alt="${pais.nombre}" class="w-14 h-10 object-cover rounded border">
                                    </td>
                                    <td class="py-2 px-4 flex space-x-2">
                                        <a href="" class="text-blue-500 hover:text-blue-700">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="submit" class="text-red-500 hover:text-red-700" data-id="${pais.id}"
                                            onclick="deletePais(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                    });

                    $("#paises-table-body").html(html);
                },
                error: function (xhr) {
                    let errorMessage = "Error al cargar los paises.";
                    if (xhr.status === 404) {
                        errorMessage = "No se encontraron usuarios.";
                    } else if (xhr.status === 500) {
                        errorMessage = "Error interno del servidor.";
                    }

                    $("#paises-table-body").html(`<tr><td colspan="6">${errorMessage}</td></tr>`);
                    console.error("Error en la búsqueda:", xhr.responseText);
                }
            });
        }
    </script>
@endsection