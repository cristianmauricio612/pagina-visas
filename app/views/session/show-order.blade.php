<div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
        <div class="modal-header bg-gradient-primary text-white">
            <h5 class="modal-title" id="showModalLabel">
                <i class="fas fa-passport me-2"></i>Detalles de la Visa - {{$visa->nombre}}
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                
                <!-- Sección de Número de Pedido y Estado -->
                <div class="row mb-4 align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0 fw-bold">Pedido #{{$pedido_visa->numero_pedido}}</h4>
                            <div class="ms-3">
                                @php
                                    $statusClasses = [
                                        'pendiente' => 'bg-warning',
                                        'pagado' => 'bg-success',
                                        'en proceso' => 'bg-info',
                                        'terminado' => 'bg-secondary'
                                    ];
                                    $statusClass = $statusClasses[$pedido_visa->status_pago] ?? 'bg-warning';
                                @endphp
                                <span class="badge {{$statusClass}} text-white fw-bold fs-6">
                                    {{ucfirst($pedido_visa->status_pago)}}
                                </span>
                            </div>
                        </div>
                        <p class="text-muted mb-0 mt-2">
                            <i class="far fa-calendar-alt me-1"></i> Creado el {{Carbon\Carbon::parse($pedido_visa->created_at)->format('d/m/Y')}}
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <span class="badge bg-primary fs-6">
                            <i class="fas fa-money-bill-wave me-1"></i> Pago Total: $ {{number_format($pedido_visa->pago_total, 2)}}
                        </span>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Resumen de pagos -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="fw-bold mb-3"><i class="fas fa-file-invoice-dollar me-2"></i>Resumen de Pagos</h5>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-2">Pago sin tasa</h6>
                                <span class="fs-4 fw-bold">$ {{number_format($pedido_visa->pago_sintasa, 2)}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-2">Tasa de gobierno</h6>
                                <span class="fs-4 fw-bold">$ {{number_format($pedido_visa->tasa_gobierno_total, 2)}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100 bg-light">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-2">Pago Total</h6>
                                <span class="fs-4 fw-bold">$ {{number_format($pedido_visa->pago_total, 2)}}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información de la Visa -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="fw-bold mb-3"><i class="fas fa-id-card me-2"></i>Información de la Visa</h5>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                @php
                                    $pais1 = \APP\MODELS\Pais::find($visa->pais1_id);
                                    $pais2 = \APP\MODELS\Pais::find($visa->pais2_id);
                                @endphp
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Visa:</strong> {{$visa->nombre}}</p>
                                        <p><strong>País de Partida:</strong>
                                            @if(!empty($pais1->imagen))
                                                <img src="{{$pais1->imagen}}" alt="{{$pais1->nombre}}" width="24" height="16" class="me-1">
                                            @endif
                                            {{$pais1->nombre}}
                                        </p>
                                        <p><strong>País de Destino:</strong>
                                            @if(!empty($pais2->imagen))
                                                <img src="{{$pais2->imagen}}" alt="{{$pais2->nombre}}" width="24" height="16" class="me-1">
                                            @endif
                                            {{$pais2->nombre}}
                                        </p>
                                        <p><strong>Tiempo de validez:</strong> {{$visa->tiempo_validez}}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>N° Entradas:</strong> {{$visa->numero_entradas}}</p>
                                        <p><strong>Estancia máxima:</strong> {{$visa->estancia_maxima}}</p>
                                        <p><strong>Precio base:</strong> $ {{number_format($visa->precio, 2)}}</p>
                                        <p><strong>Tasa de gobierno (por persona):</strong> $ {{number_format($visa->tasa_gobierno, 2)}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información del Pedido (Variables Dinámicas) -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="fw-bold mb-3"><i class="fas fa-clipboard-list me-2"></i>Detalles del Viaje</h5>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="row">
                                    @php
                                        // Obtener todas las variables relacionadas con el pedido
                                        $variables_pedido = \APP\MODELS\VisaInscripcionVariable::where('visa_inscripcion_id', $pedido_visa->id)->get();
                                        
                                        // Variables a mostrar
                                        $variables_mostradas = [];
                                    @endphp
                                    
                                    @if(count($variables_pedido) > 0)
                                        @foreach($variables_pedido as $variable_rel)
                                            @php
                                                $variable = \APP\MODELS\Variable::find($variable_rel->variable_id);
                                                
                                                // Saltar si la variable no existe o es de tipo CHECKBOX_RESTRICTIVE
                                                if(!$variable || $variable->tipo_elemento === 'CHECKBOX_RESTRICTIVE') continue;
                                                
                                                // Formatear el valor según el tipo de variable
                                                $valor = $variable_rel->valor;
                                                
                                                // Si el valor es null o vacío, mostrar "No hay datos"
                                                if ($valor === null || $valor === '') {
                                                    $valor = 'No hay datos';
                                                } else {
                                                    // Si es un ID de país, buscar el nombre
                                                    if($variable->isPais && is_numeric($valor)) {
                                                        $pais = \APP\MODELS\Pais::find($valor);
                                                        if($pais) {
                                                            $valor = $pais->nombre;
                                                        } else {
                                                            $valor = 'No hay datos';
                                                        }
                                                    }
                                                    
                                                    // Si es una fecha, formatearla
                                                    if(strpos(strtolower($variable->nombre), 'fecha') !== false) {
                                                        try {
                                                            $valor = Carbon\Carbon::parse($valor)->format('d/m/Y');
                                                        } catch(\Exception $e) {
                                                            // Si hay error al parsear, mantener el valor original
                                                        }
                                                    }
                                                }
                                                
                                                // Guardar la variable para mostrarla
                                                $variables_mostradas[] = [
                                                    'nombre' => $variable->nombre_campo ?: ucfirst(str_replace('_', ' ', $variable->nombre)),
                                                    'valor' => $valor
                                                ];
                                            @endphp
                                        @endforeach
                                        
                                        @if(count($variables_mostradas) > 0)
                                            @foreach($variables_mostradas as $var)
                                                <div class="col-md-4 mb-3">
                                                    <p class="mb-1">
                                                        <strong>{{$var['nombre']}}:</strong>
                                                    </p>
                                                    <p class="border-bottom pb-2">{{$var['valor']}}</p>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-12">
                                                <p class="text-muted fst-italic">No hay información adicional disponible</p>
                                            </div>
                                        @endif
                                    @else
                                        <div class="col-12">
                                            <p class="text-muted fst-italic">No hay información adicional disponible</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección de Viajeros -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="fw-bold mb-3"><i class="fas fa-users me-2"></i>Información de Viajeros</h5>
                    </div>
                    
                    @php
                        $viajeros = \APP\MODELS\Viajero::where('visa_inscripcion_id', $pedido_visa->id)->get();
                    @endphp
                    
                    @if(count($viajeros) > 0)
                        @foreach($viajeros as $index => $viajero)
                            <div class="col-12 mb-4">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold">Viajero #{{$index + 1}}</h6>
                                        <button class="btn btn-sm btn-outline-primary" type="button" 
                                                data-bs-toggle="collapse" data-bs-target="#viajero{{$viajero->id}}" 
                                                aria-expanded="{{$index === 0 ? 'true' : 'false'}}" aria-controls="viajero{{$viajero->id}}">
                                            {{$index === 0 ? 'Ocultar detalles' : 'Ver detalles'}}
                                        </button>
                                    </div>
                                    <div class="collapse {{$index === 0 ? 'show' : ''}}" id="viajero{{$viajero->id}}">
                                        <div class="card-body">
                                            @php
                                                // Obtener todas las variables relacionadas con el viajero
                                                $variables_viajero = \APP\MODELS\ViajeroVariable::where('viajero_id', $viajero->id)->get();
                                                
                                                // Agrupar variables por tipo
                                                $variables_agrupadas = [];
                                                
                                                foreach($variables_viajero as $var_rel) {
                                                    $variable = \APP\MODELS\Variable::find($var_rel->variable_id);
                                                    
                                                    // Saltar si la variable no existe o es de tipo CHECKBOX_RESTRICTIVE
                                                    if(!$variable || $variable->tipo_elemento === 'CHECKBOX_RESTRICTIVE') continue;
                                                    
                                                    $tipo = $variable->tipo_variable ?: 'GENERAL';
                                                    if(!isset($variables_agrupadas[$tipo])) {
                                                        $variables_agrupadas[$tipo] = [];
                                                    }
                                                    
                                                    // Formatear valor
                                                    $valor = $var_rel->valor;
                                                    
                                                    // Si el valor es null o vacío, mostrar "No hay datos"
                                                    if ($valor === null || $valor === '') {
                                                        $valor = 'No hay datos';
                                                    } else {
                                                        // Si es un ID de país, buscar el nombre
                                                        if($variable->isPais && is_numeric($valor)) {
                                                            $pais = \APP\MODELS\Pais::find($valor);
                                                            if($pais) {
                                                                $valor = $pais->nombre;
                                                            } else {
                                                                $valor = 'No hay datos';
                                                            }
                                                        }
                                                        
                                                        // Si es una fecha, formatearla
                                                        if(strpos(strtolower($variable->nombre), 'fecha') !== false || 
                                                        strpos(strtolower($variable->nombre_campo), 'fecha') !== false) {
                                                            try {
                                                                $valor = Carbon\Carbon::parse($valor)->format('d/m/Y');
                                                            } catch(\Exception $e) {
                                                                // Si hay error al parsear, mantener el valor original
                                                            }
                                                        }
                                                    }
                                                    
                                                    $variables_agrupadas[$tipo][] = [
                                                        'nombre' => $variable->nombre_campo ?: ucfirst(str_replace('_', ' ', $variable->nombre)),
                                                        'valor' => $valor
                                                    ];
                                                }
                                            @endphp
                                            
                                            @if(count($variables_agrupadas) > 0)
                                                <!-- Mostrar variables agrupadas por tipo -->
                                                @foreach($variables_agrupadas as $tipo => $vars)
                                                    <div class="mb-4">
                                                        <h6 class="text-primary mb-3">{{ucfirst(strtolower($tipo))}}</h6>
                                                        <div class="row">
                                                            @foreach($vars as $var)
                                                                <div class="col-md-4 mb-3">
                                                                    <p class="mb-1"><strong>{{$var['nombre']}}:</strong></p>
                                                                    <p class="border-bottom pb-2">{{$var['valor']}}</p>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-muted fst-italic">No hay información detallada disponible para este viajero</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="alert alert-info">
                                No se encontraron viajeros asociados a este pedido.
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Pie del modal -->
                <div class="row">
                    <div class="col-12 text-center mt-2">
                        <p class="text-muted">
                            <small>Si tienes alguna pregunta o necesitas ayuda, contáctanos en cualquier momento.</small>
                        </p>
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>