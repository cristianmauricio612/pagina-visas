@extends('layouts.public')
@section('title', 'Visa')

@section('content')
    @php
        $usuario = session()->get('usuario');
        if (!$usuario) {
            redirect('/iniciar-sesion');
        }
        $pedidos = \APP\MODELS\VisaInscripcion::where('correo', 'LIKE', $usuario['email'])->get();
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
                                <th>Codigo</th>
                                <th>Visa</th>
                                <th>Fecha de llegada</th>
                                <th>Fecha de salida</th>
                                <th>Pago total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedidos as $pedido)
                                @php
                                    $visa = \APP\MODELS\Visa::find($pedido->visas_id);
                                @endphp
                                <tr>
                                    <td>{{$pedido->numero_pedido}}</td>
                                    <td>{{$visa->nombre}}</td>
                                    <td>{{$pedido->fecha_salida}}</td>
                                    <td>{{$pedido->fecha_llegada}}</td>
                                    <td>{{$pedido->pago_total}}</td>
                                    <!-- <td><span class="status approved">Aprobada</span></td>-->
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

    <!-- Modal para Editar -->
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

    <link href="{{ assets('css/myorders.css') }}" rel="stylesheet">
@endsection