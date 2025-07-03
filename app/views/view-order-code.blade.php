@extends('layouts.public')
@section('title', 'Visa')

@push('resources')
    <link href="{{ assets('css/myorders.css') }}" rel="stylesheet">
@endpush

@section('content')
    @php
        $pedido_id = session()->get('pedido_visa');
        $visa_id = session()->get('visa');

        if ($pedido_id == null && $visa_id == null) {
            redirect('/iniciar-sesion');
        }

        $pedido_visa = \App\Models\VisaInscripcion::find($pedido_id['id']);
        $visa = \App\Models\Visa::find($visa_id['id']);
        $pedidoVariables = \App\Models\VisaInscripcionVariable::with('variable')
            ->where('visa_inscripcion_id', $pedido_visa['id'])->get();
    @endphp

    <div class="main-container">
        <div class="info-visa-container">
            <div class="return-page">
                <div class="small-title-page">
                    <a class="inicio-link" style="cursor: pointer" onclick="close_order()">
                        <span>Login</span>
                    </a>
                    <span> > </span>
                    <b>Mi pedido</b>
                </div>
            </div>
            <div class="saludo">
                <span>Mi pedido</span>
            </div>

        </div>

        <div class="orders-container">
            <a onclick="close_order()" class="back-link" style="cursor: pointer">← Login</a>
            <div class="orders-part">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Visa</th>
                            <th>Pago sin Tasa</th>
                            <th>Pago Total</th>
                            <th>Tasa de Gobierno Total</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$pedido_visa->numero_pedido}}</td>
                            <td>{{$visa->nombre}}</td>
                            <td>{{$pedido_visa->pago_sintasa}}</td>
                            <td>{{$pedido_visa->pago_total}}</td>
                            <td>{{$pedido_visa->tasa_gobierno_total}}</td>
                            <td>{{$pedido_visa->status_pago}}</td>
                            <!-- <td><span class="status approved">Aprobada</span></td>-->
                            <td>
                                <a class="btn-view show-visa" data-bs-toggle="modal" data-bs-target="#show-visa-Modal">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="show-visa-Modal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showModalLabel">Detalles de la Visa - {{$visa->nombre}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">

                        <!-- Sección de Información General -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <h6 class="text-muted">Código del Pedido:</h6>
                                <p class="fw-bold">{{$pedido_visa->numero_pedido}}</p>
                            </div>
                            @foreach ($pedidoVariables as $pedidoVariable)
                                @if ($pedidoVariable->variable->tipo_elemento != 'CHECKBOX_RESTRICTIVE')
                                    
                                    <div class="col-md-4">
                                        <h6 class="text-muted">{{$pedidoVariable->variable->nombre_campo}}:</h6>
                                        @if ($pedidoVariable->variable->isPais)
                                            @php
                                                $pais = \App\Models\Pais::find($pedidoVariable->valor);
                                            @endphp
                                            <td>{{$pais->nombre}}</td>
                                        @else
                                            <td>{{$pedidoVariable->valor ?: 'Sin valor'}}</td>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Tabla de Información Adicional -->
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Campo</th>
                                        <th>Detalle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $pais1 = \App\Models\Pais::find($visa->pais1_id);
                                        $pais2 = \App\Models\Pais::find($visa->pais2_id);
                                    @endphp
                                    <tr>
                                        <td>País de Partida</td>
                                        <td>{{$pais1->nombre}}</td>
                                    </tr>
                                    <tr>
                                        <td>País de Destino</td>
                                        <td>{{$pais2->nombre}}</td>
                                    </tr>
                                    <tr>
                                        <td>Tiempo de validez</td>
                                        <td>{{$visa->tiempo_validez}}</td>
                                    </tr>
                                    <tr>
                                        <td>N° Entradas</td>
                                        <td>{{$visa->numero_entradas}}</td>
                                    </tr>
                                    <tr>
                                        <td>Estancia máxima</td>
                                        <td>{{$visa->estancia_maxima}}</td>
                                    </tr>
                                    <tr>
                                        <td>Precio</td>
                                        <td>{{$visa->precio}}</td>
                                    </tr>
                                    <tr>
                                        <td>Tasa de gobierno</td>
                                        <td>{{$visa->tasa_gobierno}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Sección de Viajeros -->
                        <div class="mt-4">
                            <h5 class="text-primary">Información de Viajeros y Pasaporte</h5>
                            <div class="table-responsive" style="max-width: 100%;">
                                <table class="table table-bordered">
                                    @php
                                        $primerViajero = \App\Models\Viajero::where('visa_inscripcion_id', $pedido_visa->id)->first();
                                        $viajeros = \App\Models\Viajero::where('visa_inscripcion_id', $pedido_visa->id)->get();
                                    @endphp

                                    <thead class="table-light">
                                        <tr>
                                            <th>N°</th>
                                            @if ($primerViajero)
                                                @php
                                                    $viajeroVariables  = \App\Models\ViajeroVariable::with('variable')
                                                        ->where('viajero_id', $primerViajero->id)->get();
                                                @endphp
                                                @foreach ($viajeroVariables as $viajeroVariable)
                                                    @if ($viajeroVariable->variable->tipo_elemento != 'CHECKBOX_RESTRICTIVE')
                                                        <th>{{ $viajeroVariable->variable->nombre_campo }}</th>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                            $index = 1;
                                        @endphp
                                        @foreach($viajeros as $viajero)
                                            @php
                                                $viajeroVariables = \App\Models\ViajeroVariable::with('variable')
                                                    ->where('viajero_id', $viajero->id)->get();
                                            @endphp
                                            <tr>
                                                <td>{{$index}}</td>
                                                @foreach ($viajeroVariables as $viajeroVariable)
                                                    @if ($viajeroVariable->variable->tipo_elemento != 'CHECKBOX_RESTRICTIVE')
                                                        @if ($viajeroVariable->variable->isPais)
                                                            @php
                                                                $pais = \App\Models\Pais::find($viajeroVariable->valor);
                                                            @endphp
                                                            <td>{{$pais->nombre}}</td>
                                                        @else
                                                            <td>{{$viajeroVariable->valor ?: 'Sin valor'}}</td>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </tr>
                                            @php
                                                $index++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        function close_order() {
            fetch("/close-order", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf()->token() }}" // Token CSRF
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        alert("✅ Pedido cerrado correctamente");
                        window.location.href = "/iniciar-sesion"; // Redirigir al login
                    } else {
                        alert("❌ Error: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("❌ Error inesperado: ", error);
                    alert("❌ Ocurrió un error inesperado.");
                });
        }
    </script>
@endsection