@extends('layouts.admin')

@section('title', 'Administrar Correos de Marketing')

@push('resources')
    <style>
        .badge.bg-success {
            background-color: #28a745 !important;
        }
        .badge.bg-warning {
            background-color: #ffc107 !important;
            color: #212529 !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Correos para Marketing</h5>
                        <div>
                            <a href="{{ route('admin.correos.exportar') }}" class="btn btn-sm btn-success">
                                <i class="fas fa-file-excel me-1"></i> Exportar a CSV
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tabla-correos">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Correo</th>
                                        <th>Fecha de Registro</th>
                                        <th>Página de Origen</th>
                                        <th>IP</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Se llenará con JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cargar lista de correos
            cargarCorreos();

            // Función para cargar correos
            function cargarCorreos() {
                fetch('/admin/correos-publicidad/listar')
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            const tbody = document.querySelector('#tabla-correos tbody');
                            tbody.innerHTML = '';

                            data.data.forEach(correo => {
                                const tr = document.createElement('tr');

                                const fechaRegistro = new Date(correo.fecha_registro).toLocaleString('es-ES');
                                const estadoBadge = correo.convertido
                                    ? '<span class="badge bg-success">Convertido</span>'
                                    : '<span class="badge bg-warning">Pendiente</span>';

                                tr.innerHTML = `
                                    <td>${correo.id}</td>
                                    <td>${correo.correo}</td>
                                    <td>${fechaRegistro}</td>
                                    <td>${correo.pagina_origen || 'N/A'}</td>
                                    <td>${correo.ip_usuario || 'N/A'}</td>
                                    <td>${estadoBadge}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger eliminar-correo" data-id="${correo.id}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                `;

                                tbody.appendChild(tr);
                            });

                            // Añadir eventos a los botones de eliminar
                            document.querySelectorAll('.eliminar-correo').forEach(btn => {
                                btn.addEventListener('click', function() {
                                    const id = this.getAttribute('data-id');
                                    if (confirm('¿Estás seguro de que deseas eliminar este correo?')) {
                                        eliminarCorreo(id);
                                    }
                                });
                            });
                        } else {
                            alert('Error al cargar los correos');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al cargar los correos');
                    });
            }

            // Función para eliminar correo
            function eliminarCorreo(id) {
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
                        alert('Correo eliminado correctamente');
                        cargarCorreos();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar el correo');
                });
            }
        });
    </script>
@endsection
