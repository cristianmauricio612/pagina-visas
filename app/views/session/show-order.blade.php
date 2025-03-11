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
                    <div class="col-md-4">
                        <h6 class="text-muted">Fecha de Salida:</h6>
                        <p class="fw-bold">{{$pedido_visa->fecha_salida}}</p>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted">Fecha de Llegada:</h6>
                        <p class="fw-bold">{{$pedido_visa->fecha_llegada}}</p>
                    </div>
                </div>

                <!-- Pago -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <h6 class="text-muted">Pago Total:</h6>
                        <span class="badge bg-info fs-6">$ {{$pedido_visa->pago_total}}</span>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted">Pago Hoy:</h6>
                        <span class="badge bg-info fs-6">$ {{$pedido_visa->pago_hoy}}</span>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted">Tasa gobierno total:</h6>
                        <span class="badge bg-info fs-6">$ {{$pedido_visa->tasa_gobierno_total}}</span>
                    </div>
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
                                $pais1 = \APP\MODELS\Pais::find($visa->pais1_id);
                                $pais2 = \APP\MODELS\Pais::find($visa->pais2_id);
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
                <div class="mt-4" >
                    <h5 class="text-primary">Información de Viajeros y Pasaporte</h5>
                    <div class="table-responsive" style="max-width: 100%;">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>N°</th>
                                    <th>Nombres</th>
                                    <th>Appelidos</th>
                                    <th>Fecha de nacimiento</th>
                                    <th>País de nacimiento</th>
                                    <th>Nivel de Estudio</th>
                                    <th>Pasaporte</th>
                                    <th>Nacionalidad Pasaporte</th>
                                    <th>Fecha de caducidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $viajeros = \APP\MODELS\Viajero::where('visa_inscripcion_id','LIKE',$pedido_visa->id)->get();
                                @endphp
                                @foreach($viajeros as $viajero)
                                    @php
                                        $pais_nacimiento = \APP\MODELS\Pais::find($viajero->pais_nacimiento_id);
                                        $nacionalidad_pasaporte = \APP\MODELS\Pais::find($viajero->nacionalidad_pasaporte_id);
                                        $index = 1;
                                    @endphp
                                    <tr>
                                        <td>{{$index}}</td>
                                        <td>{{$viajero->nombres_pasaporte}}</td>
                                        <td>{{$viajero->apellidos_pasaporte}}</td>
                                        <td>{{$viajero->fecha_nacimiento}}</td>
                                        <td>{{$pais_nacimiento->nombre}}</td>
                                        <td>{{$viajero->nivel_estudios}}</td>
                                        <td>{{$viajero->numero_pasaporte}}</td>
                                        <td>{{$nacionalidad_pasaporte->nombre}}</td>
                                        <td>{{$viajero->fecha_caducidad_pasaporte}}</td>
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
