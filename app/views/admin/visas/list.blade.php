@extends('layouts.admin')
@section('title', 'Admin | Listar visas')

@section('content')
    @php
        $visas = \App\Models\Visa::all(); // Obtener todas las visas
    @endphp

    {{-- Botón para abrir el Sidebar (Solo en esta vista) --}}
    <button id="openSidebar" class="fixed top-4 left-4 bg-gray-900 text-white w-10 h-10 flex items-center justify-center rounded-md text-lg lg:hidden shadow-md">
        <i class="fas fa-bars"></i>
    </button>

    <div class="py-6">
        {{-- Título --}}
        <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4 text-center md:text-left">
            Gestión de Visas
        </h1>

        {{-- Buscador y Botón Agregar --}}
        <div class="flex flex-col md:flex-row justify-between mb-6 gap-4">
            <input type="text" id="search-input" placeholder="Buscar visa..." class="p-2 border rounded w-full md:w-1/3">
            <a href="{{ route('admin.visas.addView') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Agregar Visa
            </a>
        </div>

        {{-- Contenedor con scroll horizontal y vertical --}}
        <div class="w-full max-w-[100%] max-h-[600px] overflow-y-auto overflow-x-auto border rounded-lg">
            <table class="w-full md:min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left w-12 whitespace-nowrap">ID</th>
                        <th class="py-2 px-4 text-left w-48 whitespace-nowrap">País 1</th>
                        <th class="py-2 px-4 text-left w-48 whitespace-nowrap">País 2</th>
                        <th class="py-2 px-4 text-left w-48 whitespace-nowrap">Nombre</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Tiempo Validez</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Entradas</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Estancia Máxima</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Necesita Visa</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Precio</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Tasa Gobierno</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Acciones</th>
                    </tr>
                </thead>
                <tbody id="visas-table-body">
                    @forelse ($visas as $visa)
                        @php
                            $pais1 = \App\Models\Pais::find($visa->pais1_id)->nombre;
                            $pais2 = \App\Models\Pais::find($visa->pais2_id)->nombre;
                        @endphp
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-2 px-4 whitespace-nowrap">{{ $visa->id }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $pais1 }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $pais2 }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $visa->nombre }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $visa->tiempo_validez }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $visa->numero_entradas }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $visa->estancia_maxima }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $visa->necesita_visa ? 'Sí' : 'No' }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">MXN {{ number_format($visa->precio, 2) }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">MXN {{ number_format($visa->tasa_gobierno, 2) }}</td>
                            <td class="py-2 px-4 flex space-x-2 whitespace-nowrap">
                                <a href="{{route('admin.visas.editView', $visa->id)}}" class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="submit" class="text-red-500 hover:text-red-700" data-id="{{ $visa->id }}"
                                    onclick="deleteVisa(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="py-2 px-4 text-center text-gray-500">No hay visas registradas.</td>
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
                searchVisa();
            });
        });

        const csrfToken = "{{ csrf()->token() }}";

        function deleteVisa(button) {
            let id = $(button).data("id");

            if (!id) {
                alert("Error: ID de la visa no encontrada.");
                return;
            }

            if (!confirm("¿Estás seguro de eliminar esta visa?")) {
                return;
            }

            $.ajax({
                url: "/admin/visas/eliminar/" + id,
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken // Incluir el token en los headers
                },
                success: function (response) {
                    alert("✅ Visa eliminada correctamente");
                    setTimeout(function () {
                        location.reload();
                    }, 500);
                },
                error: function (xhr) {
                    alert("❌ Error al eliminar visa: " + xhr.responseText);
                }
            });
        }
   
        function searchVisa() {
            let description = $("#search-input").val().trim();

            $("#visas-table-body").html('<tr><td colspan="6">Cargando...</td></tr>');

            $.ajax({
                url: "/admin/visas/buscar",
                type: "GET",
                data: { descripcion: description },
                dataType: "json",
                success: function (data) {
                    $("#visas-table-body").empty();

                    if (!Array.isArray(data) || data.length === 0) {
                        $("#visas-table-body").html('<tr><td colspan="6">No se encontraron usuarios.</td></tr>');
                        return;
                    }

                    let html = "";
                    data.forEach(visa => {
                        html += `
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="py-2 px-4 whitespace-nowrap">${visa.id}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">${visa.pais1.nombre}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">${visa.pais2.nombre}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">${visa.nombre}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">${visa.tiempo_validez}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">${visa.numero_entradas}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">${visa.estancia_maxima}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">${visa.necesita_visa ? 'Si' : 'No'}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">MXN ${visa.precio ? parseFloat(visa.precio).toFixed(2) : '0.00'}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">MXN ${visa.tasa_gobierno ? parseFloat(visa.tasa_gobierno).toFixed(2) : '0.00'}</td>

                                    <td class="py-2 px-4 flex space-x-2 whitespace-nowrap">
                                        <a href="/admin/visas/editar/${visa.id}" class="text-blue-500 hover:text-blue-700">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="submit" class="text-red-500 hover:text-red-700" data-id="${visa.id}"
                                            onclick="deleteVisa(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                    });

                    $("#visas-table-body").html(html);
                },
                error: function (xhr) {
                    let errorMessage = "Error al cargar los usuarios.";
                    if (xhr.status === 404) {
                        errorMessage = "No se encontraron usuarios.";
                    } else if (xhr.status === 500) {
                        errorMessage = "Error interno del servidor.";
                    }

                    $("#visas-table-body").html(`<tr><td colspan="6">${errorMessage}</td></tr>`);
                    console.error("Error en la búsqueda:", xhr.responseText);
                }
            });
        }
   </script>
@endsection
