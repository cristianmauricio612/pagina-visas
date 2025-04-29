@extends('layouts.public')
@section('title', 'Mis Pedidos')

@push('resources')
    <link href="{{ assets('css/myorders.css') }}" rel="stylesheet">
    <link href="{{ assets('css/modal/show-order.css') }}" rel="stylesheet">
@endpush

@section('content')
    @php
        $usuario = session()->get('usuario');
        if (!$usuario) {
            redirect('/iniciar-sesion');
        }
        
        // Obtener la variable de correo desde la tabla de variables
        $correoVariable = \App\Models\Variable::where('nombre', 'correo')->first();
        
        // Buscar los IDs de los pedidos que tienen el correo del usuario actual
        $pedidosIds = [];
        if ($correoVariable) {
            $pedidosRelaciones = \App\Models\VisaInscripcionVariable::where('variable_id', $correoVariable->id)
                ->where('valor', 'LIKE', $usuario['email'])
                ->pluck('visa_inscripcion_id')
                ->toArray();
            
            // Obtener los pedidos completos
            $pedidos = \App\Models\VisaInscripcion::whereIn('id', $pedidosRelaciones)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Fallback al método anterior si no se encuentra la variable
            $pedidos = \APP\MODELS\VisaInscripcion::where('correo', 'LIKE', $usuario['email'])
                ->orderBy('created_at', 'desc')
                ->get();
        }
    @endphp
    <div class="main-container">
        <div class="info-visa-container">
            <div class="return-page">
                <div class="small-title-page">
                    <a class="inicio-link" href="/">
                        <span>Inicio</span>
                    </a>
                    <span> > </span>
                    <a class="inicio-link" href="/account">
                        <span>Mi cuenta</span>
                    </a>
                    <span> > </span>
                    <b>Mis pedidos</b>
                </div>
            </div>
            <div class="saludo">
                <span>Mis pedidos</span>
            </div>
        </div>

        <div class="orders-container">
            <a href="/account" class="back-link">← Mi cuenta</a>
            <div class="orders-part">
                @if ($pedidos->count() == 0)
                    <h2>No tienes pedidos en curso</h2>
                    <p>No has iniciado una solicitud para ningún viaje próximo.</p>
                    <div class="btn-container">
                        <a class="btn-inicio btn" href="/">Iniciar una solicitud</a>
                    </div>
                @else
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Número de pedido</th>
                                <th>Nombre de la Visa</th>
                                <th>Fecha de creación</th>
                                <th>Pago sin tasa</th>
                                <th>Pago total de tasa</th>
                                <th>Pago total</th>
                                <th>Status</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedidos as $pedido)
                                @php
                                    $visa = \APP\MODELS\Visa::find($pedido->visas_id);
                                    // Formatear fecha de creación como dd/mm/aaaa
                                    $fechaCreacion = \Carbon\Carbon::parse($pedido->created_at)->format('d/m/Y');
                                    
                                    // Determinar el color y texto del estado
                                    $statusClasses = [
                                        'pendiente' => 'status pending',
                                        'pagado' => 'status approved',
                                        'en proceso' => 'status processing',
                                        'terminado' => 'status completed'
                                    ];
                                    $statusClass = $statusClasses[$pedido->status_pago] ?? 'status pending';
                                @endphp
                                <tr>
                                    <td>{{$pedido->numero_pedido}}</td>
                                    <td>{{$visa->nombre}}</td>
                                    <td>{{$fechaCreacion}}</td>
                                    <td>${{number_format($pedido->pago_sintasa, 2)}}</td>
                                    <td>${{number_format($pedido->tasa_gobierno_total, 2)}}</td>
                                    <td>${{number_format($pedido->pago_total, 2)}}</td>
                                    <td><span class="{{$statusClass}}">{{ucfirst($pedido->status_pago)}}</span></td>
                                    <td>
                                        <a class="btn-view show-visa" href="{{route('account-show-order', $pedido->id)}}">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>  

    <!-- Modal para visualizar detalles del pedido -->
    <div class="modal fade" id="show-visa-Modal" tabindex="-1" 
        aria-labelledby="showModalLabel" aria-hidden="true">
    </div> 

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll("a.show-visa").forEach(function (link) {
                link.addEventListener("click", function (e) {
                    e.preventDefault();

                    fetch(this.href)
                        .then(response => response.text())
                        .then(html => {
                            let modal = document.getElementById("show-visa-Modal");
                            if (modal) {
                                modal.innerHTML = html;
                                let bootstrapModal = new bootstrap.Modal(modal);
                                bootstrapModal.show();
                            } else {
                                console.error("Modal no encontrado en el DOM.");
                            }
                        })
                        .catch(error => console.error("Error al cargar el modal:", error));
                });
            });
        });
    </script>
@endsection