@extends('layouts.admin')
@section('title', 'Admin | Listar usuarios')

@section('content')
    @php
        $usuarios = \App\Models\User::all(); // Obtener todos los usuarios
    @endphp

    {{-- Botón para abrir el Sidebar (Solo en esta vista) --}}
    <button id="openSidebar"
        class="fixed top-4 left-4 bg-gray-900 text-white w-10 h-10 flex items-center justify-center rounded-md text-lg lg:hidden shadow-md">
        <i class="fas fa-bars"></i>
    </button>

    <div class="py-6">
        {{-- Título --}}
        <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4 text-center md:text-left">
            Gestión de Usuarios
        </h1>

        {{-- Buscador y Botón Agregar --}}
        <div class="flex flex-col md:flex-row justify-between mb-6 gap-4">
            <input type="text" id="search-input" placeholder="Buscar usuario..." class="p-2 border rounded w-full md:w-1/3">
            <a href="{{ route('admin.usuarios.addView') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Agregar Usuario
            </a>
        </div>

        {{-- Contenedor con scroll horizontal y vertical --}}
        <div class="w-full max-w-[100%] max-h-[600px] overflow-y-auto overflow-x-auto border rounded-lg">
            <table class="w-full md:min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left w-12">ID</th>
                        <th class="py-2 px-4 text-left w-48">Nombre</th>
                        <th class="py-2 px-4 text-left w-48">Apellido</th>
                        <th class="py-2 px-4 text-left w-48">Correo</th>
                        <th class="py-2 px-4 text-left w-32">Acciones</th>
                    </tr>
                </thead>
                <tbody id="users-table-body">
                    @forelse ($usuarios as $usuario)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-2 px-4">{{ $usuario->id }}</td>
                            <td class="py-2 px-4">{{ $usuario->nombre }}</td>
                            <td class="py-2 px-4">{{ $usuario->apellido }}</td>
                            <td class="py-2 px-4">{{ $usuario->email }}</td>
                            <td class="py-2 px-4 flex space-x-2">
                                <a href="{{route('admin.usuarios.editView', $usuario->id)}}"
                                    class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="submit" class="text-red-500 hover:text-red-700" data-id="{{ $usuario->id }}"
                                    onclick="deleteUser(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-2 px-4 text-center text-gray-500">No hay usuarios registrados.</td>
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
                searchUser();
            });
        });

        const csrfToken = "{{ csrf()->token() }}";

        function deleteUser(button) {
            let id = $(button).data("id");

            if (!id) {
                alert("Error: ID del usuario no encontrado.");
                return;
            }

            if (!confirm("¿Estás seguro de eliminar este usuario?")) {
                return;
            }

            $.ajax({
                url: "/admin/usuarios/eliminar/" + id,
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken // Incluir el token en los headers
                },
                success: function (response) {
                    alert("✅ Usuario eliminado correctamente");
                    setTimeout(function () {
                        location.reload();
                    }, 500);
                },
                error: function (xhr) {
                    alert("❌ Error al eliminar usuario: " + xhr.responseText);
                }
            });
        }

        function searchUser() {
            let description = $("#search-input").val().trim();

            $("#users-table-body").html('<tr><td colspan="6">Cargando...</td></tr>');

            $.ajax({
                url: "/admin/usuarios/buscar",
                type: "GET",
                data: { descripcion: description },
                dataType: "json",
                success: function (data) {
                    $("#users-table-body").empty();

                    if (!Array.isArray(data) || data.length === 0) {
                        $("#users-table-body").html('<tr><td colspan="6">No se encontraron usuarios.</td></tr>');
                        return;
                    }

                    let html = "";
                    data.forEach(user => {
                        html += `
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="py-2 px-4">${user.id}</td>
                                    <td class="py-2 px-4">${user.nombre}</td>
                                    <td class="py-2 px-4">${user.apellido}</td>
                                    <td class="py-2 px-4">${user.email}</td>
                                    <td class="py-2 px-4 flex space-x-2">
                                        <a href="/admin/usuarios/editar/${user.id}"
                                            class="text-blue-500 hover:text-blue-700">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="submit" class="text-red-500 hover:text-red-700" data-id="${user.id}"
                                            onclick="deleteUser(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                    });

                    $("#users-table-body").html(html);
                },
                error: function (xhr) {
                    let errorMessage = "Error al cargar los usuarios.";
                    if (xhr.status === 404) {
                        errorMessage = "No se encontraron usuarios.";
                    } else if (xhr.status === 500) {
                        errorMessage = "Error interno del servidor.";
                    }

                    $("#users-table-body").html(`<tr><td colspan="6">${errorMessage}</td></tr>`);
                    console.error("Error en la búsqueda:", xhr.responseText);
                }
            });
        }
    </script>
@endsection