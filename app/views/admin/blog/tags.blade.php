@extends('layouts.admin')
@section('title', 'Admin | Tags del Blog')

@section('content')
    {{-- Botón para abrir el Sidebar (Solo en esta vista) --}}
    <button id="openSidebar"
        class="fixed top-4 left-4 bg-gray-900 text-white w-10 h-10 flex items-center justify-center rounded-md text-lg lg:hidden shadow-md z-20">
        <i class="fas fa-bars"></i>
    </button>

    <div class="py-4 sm:py-6 px-2 sm:px-4">
        {{-- Título --}}
        <h1 class="text-xl sm:text-2xl md:text-4xl font-bold text-gray-800 mb-4 text-center md:text-left">
            Tags del Blog
        </h1>

        {{-- Botones de acción --}}
        <div class="flex justify-center md:justify-end mb-4 sm:mb-6">
            <button onclick="openCreateModal()" class="bg-blue-500 text-white px-3 py-2 sm:px-4 sm:py-2 text-sm sm:text-base rounded-md hover:bg-blue-600 flex items-center">
                <i class="fas fa-plus mr-1 sm:mr-2"></i>
                <span>Nuevo Tag</span>
            </button>
        </div>

        {{-- Tabla de tags - Versión escritorio --}}
        <div class="hidden md:block bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Descripción
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Uso
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Artículos
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="tags-container-desktop">
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-sm text-gray-500">
                                Cargando tags...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Versión móvil - Tarjetas --}}
        <div class="md:hidden space-y-4" id="tags-container-mobile">
            <div class="bg-white rounded-lg shadow-md p-4 text-center text-sm text-gray-500">
                Cargando tags...
            </div>
        </div>
    </div>

    {{-- Modal Crear/Editar Tag --}}
    <div id="tagModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-lg w-full max-w-md mx-auto p-4 sm:p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg sm:text-xl font-semibold" id="modalTitle">Nuevo Tag</h3>
                <button onclick="closeModal('tagModal')" class="text-gray-400 hover:text-gray-600 text-xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="tagForm">
                <input type="hidden" id="tag_id" value="">

                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700 font-medium mb-2">Nombre <span class="text-red-500">*</span></label>
                    <input type="text" id="nombre" name="nombre" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="descripcion" class="block text-gray-700 font-medium mb-2">Descripción</label>
                    <textarea id="descripcion" name="descripcion" rows="3" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" onclick="closeModal('tagModal')" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Confirmar Eliminación --}}
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-lg w-full max-w-md mx-auto p-4 sm:p-6">
            <div class="mb-4">
                <h3 class="text-lg sm:text-xl font-semibold text-red-600">Confirmar Eliminación</h3>
                <p class="mt-2 text-gray-600">¿Estás seguro de que deseas eliminar este tag? Esta acción no se puede deshacer.</p>
                <p class="mt-2 text-sm text-gray-500" id="deleteWarning"></p>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button onclick="closeModal('deleteModal')" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                    Cancelar
                </button>
                <button onclick="confirmarEliminacion()" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    Eliminar
                </button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('openSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            this.classList.add('hidden');
        });

        // Variables globales
        let currentTagId = null;
        const csrfToken = "{{ csrf()->token() }}";

        // Cargar tags al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            cargarTags();
        });

        // Manejar envío del formulario
        document.getElementById('tagForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Recopilar datos del formulario
            const data = {
                nombre: document.getElementById('nombre').value,
                descripcion: document.getElementById('descripcion').value
            };

            // Determinar si es crear o actualizar
            const id = document.getElementById('tag_id').value;
            const url = id ? `/admin/blog/tags/actualizar/${id}` : '/admin/blog/tags/crear';
            const method = id ? 'PUT' : 'POST';

            // Mostrar indicador de carga
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
            submitBtn.disabled = true;

            // Enviar solicitud
            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;

                if (result.status === 'success') {
                    alert(id ? 'Tag actualizado exitosamente' : 'Tag creado exitosamente');
                    closeModal('tagModal');
                    cargarTags();
                } else {
                    alert(`Error: ${result.message}`);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al procesar la solicitud');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });

        // Función para cargar tags
        function cargarTags() {
            // Mostrar indicadores de carga
            document.getElementById('tags-container-desktop').innerHTML =
                `<tr><td colspan="6" class="px-4 py-3 text-center text-sm text-gray-500">
                    <i class="fas fa-spinner fa-spin mr-2"></i>Cargando tags...
                </td></tr>`;

            document.getElementById('tags-container-mobile').innerHTML =
                `<div class="bg-white rounded-lg shadow-md p-4 text-center text-sm text-gray-500">
                    <i class="fas fa-spinner fa-spin mr-2"></i>Cargando tags...
                </div>`;

            fetch('/admin/blog/tags/listar')
            .then(response => response.json())
            .then(result => {
                const desktopContainer = document.getElementById('tags-container-desktop');
                const mobileContainer = document.getElementById('tags-container-mobile');

                if (!result.data || result.data.length === 0) {
                    const emptyMessage = `<div class="text-center text-sm text-gray-500 py-4">
                        No hay tags registrados.
                        <button onclick="openCreateModal()" class="text-blue-500 hover:underline">
                            Crear un tag
                        </button>
                    </div>`;

                    desktopContainer.innerHTML = `<tr><td colspan="6" class="px-4 py-3">${emptyMessage}</td></tr>`;
                    mobileContainer.innerHTML = `<div class="bg-white rounded-lg shadow-md p-4">${emptyMessage}</div>`;
                    return;
                }

                let desktopHtml = '';
                let mobileHtml = '';

                result.data.forEach(tag => {
                    // HTML para versión escritorio (tabla)
                    desktopHtml += `
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                ${tag.id}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    ${tag.nombre}
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm text-gray-500">
                                    ${tag.descripcion ? tag.descripcion.substring(0, 30) + (tag.descripcion.length > 30 ? '...' : '') : 'Sin descripción'}
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                ${tag.uso_contador || 0}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                ${tag.articulos_count || 0}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-3">
                                    <button onclick="editarTag(${tag.id})" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="eliminarTag(${tag.id}, '${tag.nombre}', ${tag.articulos_count || 0})" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;

                    // HTML para versión móvil (tarjetas)
                    mobileHtml += `
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-4">
                                <div class="font-medium mb-2">${tag.nombre}</div>

                                <div class="text-sm text-gray-500 mb-2">
                                    ${tag.descripcion ? tag.descripcion.substring(0, 50) + (tag.descripcion.length > 50 ? '...' : '') : 'Sin descripción'}
                                </div>

                                <div class="flex justify-between text-xs text-gray-500 mb-2">
                                    <div>
                                        <i class="fas fa-chart-line mr-1"></i> ${tag.uso_contador || 0} usos
                                    </div>
                                    <div>
                                        <i class="fas fa-newspaper mr-1"></i> ${tag.articulos_count || 0} artículos
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-2 mt-2">
                                    <button onclick="editarTag(${tag.id})" class="p-2 bg-blue-100 text-blue-600 rounded-md">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="eliminarTag(${tag.id}, '${tag.nombre}', ${tag.articulos_count || 0})" class="p-2 bg-red-100 text-red-600 rounded-md">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                });

                desktopContainer.innerHTML = desktopHtml;
                mobileContainer.innerHTML = mobileHtml;
            })
            .catch(error => {
                console.error('Error:', error);
                const errorMessage = `<div class="text-center text-red-500 py-4">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    Error al cargar tags. Intenta recargar la página.
                </div>`;

                document.getElementById('tags-container-desktop').innerHTML =
                    `<tr><td colspan="6" class="px-4 py-3">${errorMessage}</td></tr>`;
                document.getElementById('tags-container-mobile').innerHTML =
                    `<div class="bg-white rounded-lg shadow-md p-4">${errorMessage}</div>`;
            });
        }

        // Funciones para manejar el modal
        function openCreateModal() {
            // Limpiar formulario
            document.getElementById('tagForm').reset();
            document.getElementById('tag_id').value = '';

            // Actualizar título
            document.getElementById('modalTitle').textContent = 'Nuevo Tag';

            // Mostrar modal
            document.getElementById('tagModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden'); // Prevenir scroll

            // Enfocar en el primer campo
            setTimeout(() => document.getElementById('nombre').focus(), 100);
        }

        function editarTag(id) {
            // Mostrar indicador de carga en el modal
            document.getElementById('tagModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden'); // Prevenir scroll
            document.getElementById('modalTitle').textContent = 'Cargando...';

            // Deshabilitar campos mientras se carga
            const campos = ['nombre', 'descripcion'];
            campos.forEach(campo => document.getElementById(campo).disabled = true);

            // Obtener datos del tag
            fetch(`/admin/blog/tags/obtener/${id}`)
            .then(response => response.json())
            .then(result => {
                // Habilitar campos
                campos.forEach(campo => document.getElementById(campo).disabled = false);

                if (result.status === 'success') {
                    const tag = result.data;

                    // Llenar formulario
                    document.getElementById('tag_id').value = tag.id;
                    document.getElementById('nombre').value = tag.nombre;
                    document.getElementById('descripcion').value = tag.descripcion || '';

                    // Actualizar título
                    document.getElementById('modalTitle').textContent = 'Editar Tag';

                    // Enfocar en el primer campo
                    setTimeout(() => document.getElementById('nombre').focus(), 100);
                } else {
                    alert(`Error: ${result.message}`);
                    closeModal('tagModal');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar los datos del tag');
                closeModal('tagModal');
            });
        }

        function eliminarTag(id, nombre, articulosCount) {
            currentTagId = id;

            // Actualizar mensaje de advertencia
            let mensaje = `Estás a punto de eliminar el tag "${nombre}".`;
            if (articulosCount > 0) {
                mensaje += ` Este tag está asociado a ${articulosCount} artículo(s).`;
            }

            document.getElementById('deleteWarning').textContent = mensaje;

            // Mostrar modal
            document.getElementById('deleteModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden'); // Prevenir scroll
        }

        function confirmarEliminacion() {
            if (!currentTagId) return;

            // Cambiar texto de botón para indicar carga
            const deleteBtn = document.querySelector('#deleteModal button:last-child');
            const originalText = deleteBtn.innerHTML;
            deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Eliminando...';
            deleteBtn.disabled = true;

            fetch(`/admin/blog/tags/eliminar/${currentTagId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    alert('Tag eliminado exitosamente');
                    closeModal('deleteModal');
                    cargarTags();
                } else {
                    alert(`Error: ${result.message}`);
                    // Restaurar botón
                    deleteBtn.innerHTML = originalText;
                    deleteBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar el tag');
                // Restaurar botón
                deleteBtn.innerHTML = originalText;
                deleteBtn.disabled = false;
            });
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.classList.remove('overflow-hidden'); // Permitir scroll
        }

        // Cerrar modales al hacer clic fuera o presionar ESC
        window.addEventListener('click', function(e) {
            const tagModal = document.getElementById('tagModal');
            const deleteModal = document.getElementById('deleteModal');

            // Si el clic fue fuera del contenido del modal
            if (e.target === tagModal) {
                closeModal('tagModal');
            }

            if (e.target === deleteModal) {
                closeModal('deleteModal');
            }
        });

        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal('tagModal');
                closeModal('deleteModal');
            }
        });
    </script>
@endsection
