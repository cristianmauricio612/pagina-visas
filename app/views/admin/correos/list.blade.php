@extends('layouts.admin')

@section('title', 'Administrar Correos de Marketing')

@push('resources')
<style>
    /* Estilos para el modal centrado */
    .modal-container {
        display: flex;
        align-items: center;
        justify-content: center;
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 50;
        overflow-y: auto;
    }

    .modal-content {
        margin: auto;
        width: 100%;
        max-width: 28rem;
    }

    /* Estilo para botones del modal */
    .modal-button {
        display: inline-flex;
        justify-content: center;
        width: auto;
        min-width: 80px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 0.375rem;
    }

    /* Ocultar tabla en móvil, mostrar tarjetas */
    @media (max-width: 768px) {
        .table-container {
            display: none;
        }

        .cards-container {
            display: block;
        }
    }

    /* Ocultar tarjetas en desktop, mostrar tabla */
    @media (min-width: 769px) {
        .table-container {
            display: block;
        }

        .cards-container {
            display: none;
        }
    }
</style>
@endpush

@section('content')
    {{-- Botón para abrir el Sidebar (Solo en esta vista) --}}
    <button id="openSidebar"
        class="fixed top-4 left-4 bg-gray-900 text-white w-10 h-10 flex items-center justify-center rounded-md text-lg lg:hidden shadow-md">
        <i class="fas fa-bars"></i>
    </button>

    <div class="py-6">
        {{-- Título --}}
        <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4 text-center md:text-left">
            Correos para Marketing
        </h1>

        {{-- Estadísticas --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
            <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                <p class="text-sm text-gray-500">Total Correos</p>
                <p class="text-xl font-bold text-gray-800" id="total-emails">-</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                <p class="text-sm text-gray-500">Convertidos</p>
                <p class="text-xl font-bold text-green-600" id="converted-emails">-</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                <p class="text-sm text-gray-500">Tasa de Conversión</p>
                <p class="text-xl font-bold text-indigo-600" id="conversion-rate">-</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                <p class="text-sm text-gray-500">Últimos 7 días</p>
                <p class="text-xl font-bold text-blue-600" id="last-7-days">-</p>
            </div>
        </div>

        {{-- Buscador y Botón Exportar --}}
        <div class="flex flex-col md:flex-row justify-between mb-6 gap-4">
            <input type="text" id="search-input" placeholder="Buscar correo..." class="p-2 border rounded w-full md:w-1/3">
            <a href="{{ route('admin.correos.exportar') }}"
                class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 text-center">
                <i class="fas fa-file-excel mr-2"></i>Exportar a Excel
            </a>
        </div>

        {{-- Tabla para dispositivos grandes --}}
        <div class="table-container w-full max-w-[100%] max-h-[600px] overflow-y-auto overflow-x-auto border rounded-lg">
            <table class="w-full md:min-w-full bg-white border border-gray-300" id="tabla-correos">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left w-12">ID</th>
                        <th class="py-2 px-4 text-left">Correo</th>
                        <th class="py-2 px-4 text-left">Fecha de Registro</th>
                        <th class="py-2 px-4 text-left">Página de Origen</th>
                        <th class="py-2 px-4 text-left">Estado</th>
                        <th class="py-2 px-4 text-left w-24">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Se llenará con JavaScript -->
                </tbody>
            </table>
        </div>

        {{-- Tarjetas para dispositivos móviles --}}
        <div class="cards-container space-y-4" id="cards-container">
            <!-- Se llenará con JavaScript -->
        </div>

        {{-- Paginación --}}
        <div id="pagination-container" class="mt-6 flex justify-center">
            <!-- Se llenará con JavaScript -->
        </div>
    </div>

    <!-- Modal para confirmar convertir - Restaurado al centro -->
    <div id="convertirModal" class="modal-container hidden">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>

        <div class="modal-content bg-white rounded-lg overflow-hidden shadow-xl transform transition-all mx-auto z-10">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-question-circle text-blue-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Confirmar conversión
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                ¿Estás seguro de que deseas marcar este correo como convertido? Esta acción registrará la fecha y hora actual como momento de conversión.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-center gap-4">
                <button type="button" id="confirmarConversion" class="modal-button bg-blue-600 text-white hover:bg-blue-700 sm:ml-3">
                    Confirmar
                </button>
                <button type="button" id="cancelarConversion" class="modal-button border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 sm:ml-3">
                    Cancelar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para confirmar eliminar - Restaurado al centro -->
    <div id="eliminarModal" class="modal-container hidden">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>

        <div class="modal-content bg-white rounded-lg overflow-hidden shadow-xl transform transition-all mx-auto z-10">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Confirmar eliminación
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                ¿Estás seguro de que deseas eliminar este correo? Esta acción no se puede deshacer.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-center gap-4">
                <button type="button" id="confirmarEliminacion" class="modal-button bg-red-600 text-white hover:bg-red-700 sm:ml-3">
                    Eliminar
                </button>
                <button type="button" id="cancelarEliminacion" class="modal-button border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 sm:ml-3">
                    Cancelar
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Botón del sidebar
            if (document.getElementById('openSidebar')) {
                document.getElementById('openSidebar').addEventListener('click', function() {
                    document.getElementById('sidebar').classList.remove('-translate-x-full');
                    this.classList.add('hidden');
                });
            }

            // Variables
            let currentPage = 1;
            const perPage = 10;
            let totalEmails = 0;
            let allEmails = [];
            let filteredEmails = [];
            let emailIdToConvert = null;
            let emailIdToDelete = null;

            // Referencias DOM
            const tableBody = document.querySelector('#tabla-correos tbody');
            const cardsContainer = document.getElementById('cards-container');
            const searchInput = document.getElementById('search-input');
            const totalEmailsEl = document.getElementById('total-emails');
            const convertedEmailsEl = document.getElementById('converted-emails');
            const conversionRateEl = document.getElementById('conversion-rate');
            const last7DaysEl = document.getElementById('last-7-days');
            const paginationContainer = document.getElementById('pagination-container');

            // Modales
            const convertirModal = document.getElementById('convertirModal');
            const eliminarModal = document.getElementById('eliminarModal');
            const confirmarConversionBtn = document.getElementById('confirmarConversion');
            const cancelarConversionBtn = document.getElementById('cancelarConversion');
            const confirmarEliminacionBtn = document.getElementById('confirmarEliminacion');
            const cancelarEliminacionBtn = document.getElementById('cancelarEliminacion');

            // Event Listeners
            searchInput.addEventListener('input', function() {
                filterEmails(this.value);
            });

            confirmarConversionBtn.addEventListener('click', function() {
                if (emailIdToConvert) {
                    convertirCorreo(emailIdToConvert);
                    hideModal(convertirModal);
                }
            });

            cancelarConversionBtn.addEventListener('click', function() {
                hideModal(convertirModal);
            });

            confirmarEliminacionBtn.addEventListener('click', function() {
                if (emailIdToDelete) {
                    eliminarCorreo(emailIdToDelete);
                    hideModal(eliminarModal);
                }
            });

            cancelarEliminacionBtn.addEventListener('click', function() {
                hideModal(eliminarModal);
            });

            // Inicializar
            cargarCorreos();

            // Función para cargar correos
            function cargarCorreos() {
                showLoading();

                fetch('/admin/correos-publicidad/listar')
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            allEmails = data.data;
                            filteredEmails = [...allEmails];
                            totalEmails = allEmails.length;

                            updateStats();
                            renderTable();
                            renderCards();
                            renderPagination();
                        } else {
                            showEmptyState();
                        }
                        hideLoading();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showEmptyState();
                        hideLoading();
                    });
            }

            // Función para actualizar estadísticas
            function updateStats() {
                const total = allEmails.length;
                const converted = allEmails.filter(email => email.convertido === 1).length;
                const rate = total > 0 ? ((converted / total) * 100).toFixed(1) : 0;

                // Calcular correos de los últimos 7 días
                const today = new Date();
                const sevenDaysAgo = new Date();
                sevenDaysAgo.setDate(today.getDate() - 7);

                const last7Days = allEmails.filter(email => {
                    const emailDate = new Date(email.fecha_registro);
                    return emailDate >= sevenDaysAgo;
                }).length;

                totalEmailsEl.textContent = total;
                convertedEmailsEl.textContent = converted;
                conversionRateEl.textContent = rate + '%';
                last7DaysEl.textContent = last7Days;
            }

            // Función para filtrar correos
            function filterEmails(query) {
                query = query.toLowerCase().trim();

                if (query === '') {
                    filteredEmails = [...allEmails];
                } else {
                    filteredEmails = allEmails.filter(email =>
                        email.correo.toLowerCase().includes(query) ||
                        (email.pagina_origen && email.pagina_origen.toLowerCase().includes(query))
                    );
                }

                currentPage = 1;
                renderTable();
                renderCards();
                renderPagination();
            }

            // Función para renderizar la tabla
            function renderTable() {
                tableBody.innerHTML = '';

                if (filteredEmails.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="6" class="py-4 px-4 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3"></i>
                                <p>No se encontraron correos.</p>
                            </td>
                        </tr>
                    `;
                    return;
                }

                const start = (currentPage - 1) * perPage;
                const end = Math.min(start + perPage, filteredEmails.length);
                const paginatedEmails = filteredEmails.slice(start, end);

                paginatedEmails.forEach(correo => {
                    const tr = document.createElement('tr');
                    tr.className = 'border-b hover:bg-gray-100';

                    const fechaRegistro = new Date(correo.fecha_registro).toLocaleString('es-ES');
                    const estadoBadge = correo.convertido
                        ? '<span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Convertido</span>'
                        : '<span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>';

                    tr.innerHTML = `
                        <td class="py-2 px-4">${correo.id}</td>
                        <td class="py-2 px-4">${correo.correo}</td>
                        <td class="py-2 px-4">${fechaRegistro}</td>
                        <td class="py-2 px-4">${correo.pagina_origen || 'N/A'}</td>
                        <td class="py-2 px-4">${estadoBadge}</td>
                        <td class="py-2 px-4">
                            <div class="flex space-x-2">
                                ${!correo.convertido ?
                                    `<button class="text-blue-500 hover:text-blue-700 convertir-correo" data-id="${correo.id}">
                                        <i class="fas fa-check"></i>
                                    </button>` : ''}
                                <button class="text-red-500 hover:text-red-700 eliminar-correo" data-id="${correo.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    `;

                    tableBody.appendChild(tr);
                });

                // Añadir eventos a los botones en la tabla
                document.querySelectorAll('#tabla-correos .eliminar-correo').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        openEliminarModal(id);
                    });
                });

                document.querySelectorAll('#tabla-correos .convertir-correo').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        openConvertirModal(id);
                    });
                });
            }

            // Función para renderizar tarjetas (versión móvil)
            function renderCards() {
                cardsContainer.innerHTML = '';

                if (filteredEmails.length === 0) {
                    cardsContainer.innerHTML = `
                        <div class="bg-white rounded-lg p-6 text-center text-gray-500 shadow">
                            <i class="fas fa-inbox text-4xl mb-3"></i>
                            <p>No se encontraron correos.</p>
                        </div>
                    `;
                    return;
                }

                const start = (currentPage - 1) * perPage;
                const end = Math.min(start + perPage, filteredEmails.length);
                const paginatedEmails = filteredEmails.slice(start, end);

                paginatedEmails.forEach(correo => {
                    const fechaRegistro = new Date(correo.fecha_registro).toLocaleString('es-ES');
                    const estadoBadge = correo.convertido
                        ? '<span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Convertido</span>'
                        : '<span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>';

                    const card = document.createElement('div');
                    card.className = 'bg-white rounded-lg shadow p-4 border border-gray-200';

                    card.innerHTML = `
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500 text-xs">ID: ${correo.id}</p>
                                <p class="font-medium text-gray-900">${correo.correo}</p>
                            </div>
                            <div>
                                ${estadoBadge}
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm text-gray-600"><span class="font-medium">Fecha:</span> ${fechaRegistro}</p>
                            <p class="text-sm text-gray-600 truncate"><span class="font-medium">Origen:</span> ${correo.pagina_origen || 'N/A'}</p>
                        </div>
                        <div class="mt-3 flex justify-end space-x-2">
                            ${!correo.convertido ?
                                `<button class="text-blue-500 hover:text-blue-700 bg-blue-50 p-2 rounded convertir-correo" data-id="${correo.id}">
                                    <i class="fas fa-check"></i>
                                </button>` : ''}
                            <button class="text-red-500 hover:text-red-700 bg-red-50 p-2 rounded eliminar-correo" data-id="${correo.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;

                    cardsContainer.appendChild(card);
                });

                // Añadir eventos a los botones en las tarjetas
                document.querySelectorAll('#cards-container .eliminar-correo').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        openEliminarModal(id);
                    });
                });

                document.querySelectorAll('#cards-container .convertir-correo').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        openConvertirModal(id);
                    });
                });
            }

            // Función para mostrar estado de carga
            function showLoading() {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="py-4 px-4 text-center text-gray-500">
                            <i class="fas fa-circle-notch fa-spin text-2xl"></i>
                            <p class="mt-2">Cargando correos...</p>
                        </td>
                    </tr>
                `;

                cardsContainer.innerHTML = `
                    <div class="bg-white rounded-lg p-6 text-center text-gray-500 shadow">
                        <i class="fas fa-circle-notch fa-spin text-3xl mb-3"></i>
                        <p>Cargando correos...</p>
                    </div>
                `;
            }

            function hideLoading() {
                // Se reemplaza al renderizar
            }

            function showEmptyState() {
                // Se maneja en las funciones de renderizado
            }

            // Funciones para los modales - CORREGIDAS
            function openConvertirModal(id) {
                console.log('Abriendo modal de conversión para ID:', id);
                emailIdToConvert = id;
                convertirModal.classList.remove('hidden');
            }

            function openEliminarModal(id) {
                console.log('Abriendo modal de eliminación para ID:', id);
                emailIdToDelete = id;
                eliminarModal.classList.remove('hidden');
            }

            function showModal(modal) {
                modal.classList.remove('hidden');
            }

            function hideModal(modal) {
                modal.classList.add('hidden');
            }

            // Función para convertir correo
            function convertirCorreo(id) {
                showLoading();

                fetch(`/admin/correos-publicidad/marcar-convertido/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf()->token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Actualizar el correo en los arrays
                        allEmails = allEmails.map(email => {
                            if (email.id == id) {
                                return {...email, convertido: 1, fecha_conversion: new Date().toISOString()};
                            }
                            return email;
                        });

                        filteredEmails = filteredEmails.map(email => {
                            if (email.id == id) {
                                return {...email, convertido: 1, fecha_conversion: new Date().toISOString()};
                            }
                            return email;
                        });

                        // Actualizar tabla y estadísticas
                        updateStats();
                        renderTable();
                        renderCards();

                        // Mostrar notificación
                        mostrarNotificacion('Correo marcado como convertido', 'success');
                    } else {
                        mostrarNotificacion('Error: ' + data.message, 'error');
                    }
                    hideLoading();
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarNotificacion('Error al marcar el correo', 'error');
                    hideLoading();
                });
            }

            // Función para eliminar correo
            function eliminarCorreo(id) {
                showLoading();

                fetch(`/admin/correos-publicidad/eliminar/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf()->token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Eliminar el correo de los arrays
                        allEmails = allEmails.filter(email => email.id != id);
                        filteredEmails = filteredEmails.filter(email => email.id != id);

                        // Actualizar tabla y estadísticas
                        updateStats();
                        renderTable();
                        renderCards();
                        renderPagination();

                        // Mostrar notificación
                        mostrarNotificacion('Correo eliminado correctamente', 'success');
                    } else {
                        mostrarNotificacion('Error: ' + data.message, 'error');
                    }
                    hideLoading();
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarNotificacion('Error al eliminar el correo', 'error');
                    hideLoading();
                });
            }

            // Función para renderizar paginación
            function renderPagination() {
                const totalPages = Math.ceil(filteredEmails.length / perPage);

                if (totalPages <= 1) {
                    paginationContainer.innerHTML = '';
                    return; // No mostrar paginación si hay solo una página
                }

                // Generar HTML de paginación
                let paginationHTML = '<div class="inline-flex rounded-md shadow-sm">';

                // Botón anterior
                paginationHTML += `
                    <button class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 ${currentPage === 1 ? 'opacity-50 cursor-not-allowed' : ''}"
                    ${currentPage === 1 ? 'disabled' : ''} onclick="prevPage()">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                `;

                // Números de página
                for (let i = 1; i <= totalPages; i++) {
                    paginationHTML += `
                        <button class="px-3 py-2 text-sm font-medium ${currentPage === i ? 'text-blue-600 bg-blue-50 border-blue-500' : 'text-gray-500 bg-white border-gray-300'} border hover:bg-gray-50"
                        onclick="goToPage(${i})">
                            ${i}
                        </button>
                    `;
                }

                // Botón siguiente
                paginationHTML += `
                    <button class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50 ${currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : ''}"
                    ${currentPage === totalPages ? 'disabled' : ''} onclick="nextPage()">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                `;

                paginationHTML += '</div>';

                paginationContainer.innerHTML = paginationHTML;

                // Definir funciones de paginación en el ámbito global
                window.prevPage = function() {
                    if (currentPage > 1) {
                        currentPage--;
                        renderTable();
                        renderCards();
                        renderPagination();
                    }
                };

                window.nextPage = function() {
                    const totalPages = Math.ceil(filteredEmails.length / perPage);
                    if (currentPage < totalPages) {
                        currentPage++;
                        renderTable();
                        renderCards();
                        renderPagination();
                    }
                };

                window.goToPage = function(page) {
                    currentPage = page;
                    renderTable();
                    renderCards();
                    renderPagination();
                };
            }

            // Función para mostrar notificaciones
            function mostrarNotificacion(mensaje, tipo) {
                // Implementar según tu sistema de notificaciones
                // Si tienes implementado algún sistema de notificaciones, úsalo aquí
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: tipo === 'success' ? '¡Éxito!' : 'Error',
                        text: mensaje,
                        icon: tipo,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    alert(mensaje);
                }
            }
        });
    </script>
@endsection
