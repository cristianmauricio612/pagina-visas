@extends('layouts.admin')
@section('title', 'Admin | Autores del Blog')

@section('content')
    {{-- Botón para abrir el Sidebar (Solo en esta vista) --}}
    <button id="openSidebar"
        class="fixed top-4 left-4 bg-gray-900 text-white w-10 h-10 flex items-center justify-center rounded-md text-lg lg:hidden shadow-md z-20">
        <i class="fas fa-bars"></i>
    </button>

    <div class="py-4 sm:py-6 px-2 sm:px-4">
        {{-- Título --}}
        <h1 class="text-xl sm:text-2xl md:text-4xl font-bold text-gray-800 mb-4 text-center md:text-left">
            Autores del Blog
        </h1>

        {{-- Botones de acción --}}
        <div class="flex justify-center md:justify-end mb-4 sm:mb-6">
            <button onclick="openCreateModal()"
                class="bg-blue-500 text-white px-3 py-2 sm:px-4 sm:py-2 text-sm sm:text-base rounded-md hover:bg-blue-600 flex items-center">
                <i class="fas fa-plus mr-1 sm:mr-2"></i>
                <span>Nuevo Autor</span>
            </button>
        </div>

        {{-- Tabla de autores - Versión escritorio --}}
        <div class="hidden md:block bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Imagen
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Correo
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Puesto
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Artículos
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="autores-container-desktop">
                        <tr>
                            <td colspan="8" class="px-4 py-3 text-center text-sm text-gray-500">
                                Cargando autores...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Versión móvil - Tarjetas --}}
        <div class="md:hidden space-y-4" id="autores-container-mobile">
            <div class="bg-white rounded-lg shadow-md p-4 text-center text-sm text-gray-500">
                Cargando autores...
            </div>
        </div>
    </div>

    {{-- Modal Crear/Editar Autor SIMPLIFICADO Y CORREGIDO --}}
    <div id="autorModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg w-full max-w-2xl mx-4" style="max-height: 90vh;">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-xl font-semibold text-gray-800" id="modalTitle">Editar Autor</h3>
                <button type="button" onclick="closeModal('autorModal')" class="text-gray-400 hover:text-gray-600 text-xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="overflow-y-auto p-4" style="max-height: calc(90vh - 130px);">
                <form id="autorForm" enctype="multipart/form-data">
                    <input type="hidden" id="autor_id" value="">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Columna izquierda -->
                        <div>
                            <div class="mb-4">
                                <label for="nombre" class="block text-gray-700 font-medium mb-2">Nombre <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="nombre" name="nombre"
                                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label for="apellido" class="block text-gray-700 font-medium mb-2">Apellido</label>
                                <input type="text" id="apellido" name="apellido"
                                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div class="mb-4">
                                <label for="correo" class="block text-gray-700 font-medium mb-2">Correo Electrónico</label>
                                <input type="email" id="correo" name="correo"
                                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div class="mb-4">
                                <label for="puesto" class="block text-gray-700 font-medium mb-2">Puesto/Cargo</label>
                                <input type="text" id="puesto" name="puesto"
                                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Ej: Editor, Redactor, Especialista en Visados">
                            </div>
                        </div>

                        <!-- Columna derecha -->
                        <div>
                            <div class="mb-4">
                                <label for="bio" class="block text-gray-700 font-medium mb-2">Biografía</label>
                                <textarea id="bio" name="bio" rows="4"
                                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium mb-2">Imagen del Autor</label>
                                <div class="flex items-center space-x-4 mb-2">
                                    <div id="preview-container" class="hidden">
                                        <img id="imagen-preview" class="w-20 h-20 object-cover rounded-full border" src="">
                                    </div>
                                    <div id="current-image-container" class="hidden">
                                        <img id="current-imagen" class="w-20 h-20 object-cover rounded-full border" src="">
                                    </div>
                                    <input type="file" id="imagen" name="imagen" class="hidden" accept="image/*">
                                    <button type="button" onclick="document.getElementById('imagen').click()"
                                        class="flex-1 p-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                                        <i class="fas fa-upload mr-1"></i> Seleccionar Imagen
                                    </button>
                                </div>
                                <p class="text-sm text-gray-500">Formatos: JPG, PNG. Máx: 2MB</p>
                            </div>

                            <div class="mb-4">
                                <label class="flex items-center">
                                    <input type="checkbox" id="activo" name="activo"
                                        class="form-checkbox h-5 w-5 text-blue-600" checked>
                                    <span class="ml-2">Autor Activo</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="border-t p-4 flex justify-end space-x-3">
                <button type="button" onclick="closeModal('autorModal')"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                    <i class="fas fa-times mr-1"></i> Cancelar
                </button>
                <button type="button" onclick="guardarAutor()"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    <i class="fas fa-save mr-1"></i> Guardar
                </button>
            </div>
        </div>
    </div>

    {{-- Modal Confirmar Eliminación --}}
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-lg w-full max-w-md mx-auto p-4 sm:p-6">
            <div class="mb-4">
                <h3 class="text-lg sm:text-xl font-semibold text-red-600">Confirmar Eliminación</h3>
                <p class="mt-2 text-gray-600">¿Estás seguro de que deseas eliminar este autor? Esta acción no se puede
                    deshacer.</p>
                <p class="mt-2 text-sm text-gray-500" id="deleteWarning"></p>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button onclick="closeModal('deleteModal')"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                    Cancelar
                </button>
                <button onclick="confirmarEliminacion()" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    Eliminar
                </button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('openSidebar').addEventListener('click', function () {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            this.classList.add('hidden');
        });

        // Variables globales
        let currentAutorId = null;
        const csrfToken = "{{ csrf()->token() }}";

        // Cargar autores al cargar la página
        document.addEventListener('DOMContentLoaded', function () {
            cargarAutores();
        });

        // Vista previa de imagen
        document.getElementById('imagen').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('imagen-preview').src = e.target.result;
                    document.getElementById('preview-container').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        // Manejar envío del formulario
        document.getElementById('autorForm').addEventListener('submit', function (e) {
            e.preventDefault();

            // Crear FormData para enviar archivos
            const formData = new FormData();
            const id = document.getElementById('autor_id').value;

            // Agregar campos al FormData
            formData.append('nombre', document.getElementById('nombre').value);
            formData.append('apellido', document.getElementById('apellido').value);
            formData.append('correo', document.getElementById('correo').value);
            formData.append('puesto', document.getElementById('puesto').value);
            formData.append('bio', document.getElementById('bio').value);
            formData.append('activo', document.getElementById('activo').checked ? '1' : '0');

            // Agregar imagen solo si se seleccionó una
            const imagenInput = document.getElementById('imagen');
            if (imagenInput.files.length > 0) {
                formData.append('imagen', imagenInput.files[0]);
            }

            // Determinar si es crear o actualizar
            const url = id ? `/admin/blog/autores/actualizar/${id}` : '/admin/blog/autores/crear';

            // Para PUT (editar), agregamos un campo _method
            if (id) {
                formData.append('_method', 'PUT');
            }

            // Agregar token CSRF
            formData.append('_csrf', csrfToken);

            // Mostrar indicador de carga
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
            submitBtn.disabled = true;

            // Enviar solicitud - Siempre usamos POST para enviar archivos
            fetch(url, {
                method: 'POST', // Siempre POST cuando hay archivos
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                    // No incluir Content-Type aquí para que el navegador lo configure con el boundary correcto
                },
                body: formData
            })
                .then(response => response.json())
                .then(result => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;

                    if (result.status === 'success') {
                        alert(id ? 'Autor actualizado exitosamente' : 'Autor creado exitosamente');
                        closeModal('autorModal');
                        cargarAutores();
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

        // Función para cargar autores
        function cargarAutores() {
            // Mostrar indicadores de carga
            document.getElementById('autores-container-desktop').innerHTML =
                `<tr><td colspan="8" class="px-4 py-3 text-center text-sm text-gray-500">
                                        <i class="fas fa-spinner fa-spin mr-2"></i>Cargando autores...
                                    </td></tr>`;

            document.getElementById('autores-container-mobile').innerHTML =
                `<div class="bg-white rounded-lg shadow-md p-4 text-center text-sm text-gray-500">
                                        <i class="fas fa-spinner fa-spin mr-2"></i>Cargando autores...
                                    </div>`;

            fetch('/admin/blog/autores/listar')
                .then(response => response.json())
                .then(result => {
                    const desktopContainer = document.getElementById('autores-container-desktop');
                    const mobileContainer = document.getElementById('autores-container-mobile');

                    if (!result.data || result.data.length === 0) {
                        const emptyMessage = `<div class="text-center text-sm text-gray-500 py-4">
                                            No hay autores registrados.
                                            <button onclick="openCreateModal()" class="text-blue-500 hover:underline">
                                                Crear un autor
                                            </button>
                                        </div>`;

                        desktopContainer.innerHTML = `<tr><td colspan="8" class="px-4 py-3">${emptyMessage}</td></tr>`;
                        mobileContainer.innerHTML = `<div class="bg-white rounded-lg shadow-md p-4">${emptyMessage}</div>`;
                        return;
                    }

                    let desktopHtml = '';
                    let mobileHtml = '';

                    result.data.forEach(autor => {
                        const nombreCompleto = autor.apellido ? `${autor.nombre} ${autor.apellido}` : autor.nombre;
                        const avatarUrl = autor.imagen || autor.avatarUrl || `https://randomuser.me/api/portraits/men/${autor.id % 80}.jpg`;

                        // HTML para versión escritorio (tabla)
                        desktopHtml += `
                                            <tr>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    ${autor.id}
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded-full object-cover" src="${avatarUrl}" alt="${nombreCompleto}">
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">${nombreCompleto}</div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="text-sm text-gray-500">${autor.correo || '-'}</div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="text-sm text-gray-500">${autor.puesto || '-'}</div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${autor.activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                                        ${autor.activo ? 'Activo' : 'Inactivo'}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    ${autor.articulos_count || 0}
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                                    <div class="flex space-x-3">
                                                        <button onclick="editarAutor(${autor.id})" class="text-blue-600 hover:text-blue-900">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button onclick="eliminarAutor(${autor.id}, '${nombreCompleto}', ${autor.articulos_count || 0})" class="text-red-600 hover:text-red-900">
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
                                                    <div class="flex items-center mb-4">
                                                        <div class="flex-shrink-0 mr-3">
                                                            <img class="h-12 w-12 rounded-full object-cover" src="${avatarUrl}" alt="${nombreCompleto}">
                                                        </div>
                                                        <div>
                                                            <div class="font-medium">${nombreCompleto}</div>
                                                            <div class="text-sm text-gray-500">${autor.puesto || 'Sin puesto asignado'}</div>
                                                        </div>
                                                        <div class="ml-auto">
                                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${autor.activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                                                ${autor.activo ? 'Activo' : 'Inactivo'}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    ${autor.correo ? `
                                                    <div class="text-sm text-gray-500 mb-2">
                                                        <i class="fas fa-envelope mr-1"></i> ${autor.correo}
                                                    </div>
                                                    ` : ''}

                                                    ${autor.bio ? `
                                                    <div class="text-sm text-gray-600 mb-3">
                                                        ${autor.bio.substring(0, 100)}${autor.bio.length > 100 ? '...' : ''}
                                                    </div>
                                                    ` : ''}

                                                    <div class="flex justify-between items-center">
                                                        <div class="text-xs text-gray-500">
                                                            <i class="fas fa-newspaper mr-1"></i> ${autor.articulos_count || 0} artículos
                                                        </div>
                                                        <div class="flex space-x-2">
                                                            <button onclick="editarAutor(${autor.id})" class="p-2 bg-blue-100 text-blue-600 rounded-md">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button onclick="eliminarAutor(${autor.id}, '${nombreCompleto}', ${autor.articulos_count || 0})" class="p-2 bg-red-100 text-red-600 rounded-md">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
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
                                        Error al cargar autores. Intenta recargar la página.
                                    </div>`;

                    document.getElementById('autores-container-desktop').innerHTML =
                        `<tr><td colspan="8" class="px-4 py-3">${errorMessage}</td></tr>`;
                    document.getElementById('autores-container-mobile').innerHTML =
                        `<div class="bg-white rounded-lg shadow-md p-4">${errorMessage}</div>`;
                });
        }

        // Funciones para manejar el modal
        function openCreateModal() {
            // Limpiar formulario
            document.getElementById('autorForm').reset();
            document.getElementById('autor_id').value = '';
            document.getElementById('activo').checked = true;

            // Limpiar previsualizaciones
            document.getElementById('preview-container').classList.add('hidden');
            document.getElementById('current-image-container').classList.add('hidden');

            // Actualizar título
            document.getElementById('modalTitle').textContent = 'Nuevo Autor';

            // Mostrar modal
            document.getElementById('autorModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden'); // Prevenir scroll

            // Enfocar en el primer campo
            setTimeout(() => document.getElementById('nombre').focus(), 100);
        }

        function editarAutor(id) {
            // Mostrar indicador de carga en el modal
            document.getElementById('autorModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden'); // Prevenir scroll
            document.getElementById('modalTitle').textContent = 'Cargando...';

            // Deshabilitar campos mientras se carga
            const campos = ['nombre', 'apellido', 'correo', 'puesto', 'bio', 'imagen', 'activo'];
            campos.forEach(campo => document.getElementById(campo).disabled = true);

            // Limpiar previsualizaciones
            document.getElementById('preview-container').classList.add('hidden');
            document.getElementById('current-image-container').classList.add('hidden');

            // Obtener datos del autor
            fetch(`/admin/blog/autores/obtener/${id}`)
                .then(response => response.json())
                .then(result => {
                    // Habilitar campos
                    campos.forEach(campo => document.getElementById(campo).disabled = false);

                    if (result.status === 'success') {
                        const autor = result.data;

                        // Llenar formulario
                        document.getElementById('autor_id').value = autor.id;
                        document.getElementById('nombre').value = autor.nombre || '';
                        document.getElementById('apellido').value = autor.apellido || '';
                        document.getElementById('correo').value = autor.correo || '';
                        document.getElementById('puesto').value = autor.puesto || '';
                        document.getElementById('bio').value = autor.bio || '';
                        document.getElementById('activo').checked = autor.activo;

                        // Mostrar imagen actual si existe
                        if (autor.imagen) {
                            document.getElementById('current-imagen').src = autor.imagen;
                            document.getElementById('current-image-container').classList.remove('hidden');
                        }

                        // Actualizar título
                        document.getElementById('modalTitle').textContent = 'Editar Autor';

                        // Enfocar en el primer campo
                        setTimeout(() => document.getElementById('nombre').focus(), 100);
                    } else {
                        alert(`Error: ${result.message}`);
                        closeModal('autorModal');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al cargar los datos del autor');
                    closeModal('autorModal');
                });
        }

        function eliminarAutor(id, nombre, articulosCount) {
            currentAutorId = id;

            // Actualizar mensaje de advertencia
            let mensaje = `Estás a punto de eliminar al autor "${nombre}".`;
            if (articulosCount > 0) {
                mensaje += ` Este autor tiene ${articulosCount} artículo(s) asociado(s).`;
            }

            document.getElementById('deleteWarning').textContent = mensaje;

            // Mostrar modal
            document.getElementById('deleteModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden'); // Prevenir scroll
        }

        function confirmarEliminacion() {
            if (!currentAutorId) return;

            // Cambiar texto de botón para indicar carga
            const deleteBtn = document.querySelector('#deleteModal button:last-child');
            const originalText = deleteBtn.innerHTML;
            deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Eliminando...';
            deleteBtn.disabled = true;

            fetch(`/admin/blog/autores/eliminar/${currentAutorId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'success') {
                        alert('Autor eliminado exitosamente');
                        closeModal('deleteModal');
                        cargarAutores();
                    } else {
                        alert(`Error: ${result.message}`);
                        // Restaurar botón
                        deleteBtn.innerHTML = originalText;
                        deleteBtn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar el autor');
                    // Restaurar botón
                    deleteBtn.innerHTML = originalText;
                    deleteBtn.disabled = false;
                });
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.classList.remove('overflow-hidden'); // Permitir scroll
        }

        // Nueva función para guardar autor
        function guardarAutor() {
            // Crear FormData para enviar archivos
            const formData = new FormData();
            const id = document.getElementById('autor_id').value;

            // Agregar campos al FormData
            formData.append('nombre', document.getElementById('nombre').value);
            formData.append('apellido', document.getElementById('apellido').value || '');
            formData.append('correo', document.getElementById('correo').value || '');
            formData.append('puesto', document.getElementById('puesto').value || '');
            formData.append('bio', document.getElementById('bio').value || '');
            formData.append('activo', document.getElementById('activo').checked ? '1' : '0');

            // Agregar imagen solo si se seleccionó una
            const imagenInput = document.getElementById('imagen');
            if (imagenInput.files.length > 0) {
                formData.append('imagen', imagenInput.files[0]);
            }

            // Determinar si es crear o actualizar
            const url = id ? `/admin/blog/autores/actualizar/${id}` : '/admin/blog/autores/crear';

            // Para PUT (editar), agregamos un campo _method
            if (id) {
                formData.append('_method', 'PUT');
            }

            // Agregar token CSRF
            formData.append('_csrf', csrfToken);

            // Mostrar indicador de carga
            const submitBtn = document.querySelector('#autorModal button[type="button"]:last-child');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
            submitBtn.disabled = true;

            // Enviar solicitud - Siempre usamos POST para enviar archivos
            fetch(url, {
                method: 'POST', // Siempre POST cuando hay archivos
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
                .then(response => response.json())
                .then(result => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;

                    if (result.status === 'success') {
                        alert(id ? 'Autor actualizado exitosamente' : 'Autor creado exitosamente');
                        closeModal('autorModal');
                        cargarAutores();
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
        }

        // Cerrar modales al hacer clic fuera o presionar ESC
        window.addEventListener('click', function (e) {
            const autorModal = document.getElementById('autorModal');
            const deleteModal = document.getElementById('deleteModal');

            // Si el clic fue fuera del contenido del modal
            if (e.target === autorModal) {
                closeModal('autorModal');
            }

            if (e.target === deleteModal) {
                closeModal('deleteModal');
            }
        });

        window.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeModal('autorModal');
                closeModal('deleteModal');
            }
        });
    </script>
@endsection
