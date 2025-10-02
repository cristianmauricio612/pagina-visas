<div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
        <div class="modal-header bg-gradient-primary text-white">
            <h5 class="modal-title" id="showModalLabel">
                <i class="fas fa-passport me-2"></i>Detalles de la Visa - {{$visa->nombre}}
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="max-height: 70vh; overflow-y: auto; padding: 20px;">
            <div class="container" style="max-height: 100%; overflow-y: auto;">
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
                            <i class="far fa-calendar-alt me-1"></i> Creado el
                            {{Carbon\Carbon::parse($pedido_visa->created_at)->format('d/m/Y')}}
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <span class="badge bg-primary fs-6">
                            <i class="fas fa-money-bill-wave me-1"></i> Pago Total: $
                            {{number_format($pedido_visa->pago_total, 2)}}
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
                                <span class="fs-4 fw-bold">$
                                    {{number_format($pedido_visa->tasa_gobierno_total, 2)}}</span>
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
                                    $pais1 = \App\Models\Pais::find($visa->pais1_id);
                                    $pais2 = \App\Models\Pais::find($visa->pais2_id);
                                @endphp
                                <div class="row">
                                    <div class="col-md-6 flex flex-col gap-2">
                                        <p><strong>Visa:</strong> {{$visa->nombre}}</p>
                                        <p class="flex flex-row gap-2 ">
                                            <strong>País de Partida:</strong>
                                            <span class="flex flex-row items-center gap-0.5">
                                                @if(!empty($pais1->imagen))
                                                    <img src="{{$pais1->imagen}}" alt="{{$pais1->nombre}}" width="24" height="16" class="me-1">
                                                @endif
                                                {{$pais1->nombre}}
                                            </span>
                                        </p>
                                        <p class="flex flex-row gap-2">
                                            <strong>País de Destino:</strong>
                                            <span class="flex flex-row items-center gap-0.5">
                                            @if(!empty($pais2->imagen))
                                                <img src="{{$pais2->imagen}}" alt="{{$pais2->nombre}}" width="24"
                                                        height="16" class="me-1">
                                                @endif
                                                {{$pais2->nombre}}
                                            </span>
                                        </p>
                                        <p><strong>Tiempo de validez:</strong> {{$visa->tiempo_validez}}</p>
                                    </div>
                                    <div class="col-md-6 flex flex-col gap-2">
                                        <p><strong>N° Entradas:</strong> {{$visa->numero_entradas}}</p>
                                        <p><strong>Estancia máxima:</strong> {{$visa->estancia_maxima}}</p>
                                        <p><strong>Precio base:</strong> $ {{number_format($visa->precio, 2)}}</p>
                                        <p><strong>Tasa de gobierno (por persona):</strong> $
                                            {{number_format($visa->tasa_gobierno, 2)}}</p>
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
                                        $variables_pedido = \App\Models\VisaInscripcionVariable::where('visa_inscripcion_id', $pedido_visa->id)->get();

                                        // Variables a mostrar
                                        $variables_mostradas = [];
                                    @endphp

                                    @if(count($variables_pedido) > 0)
                                        @foreach($variables_pedido as $variable_rel)
                                            @php
                                                $variable = \App\Models\Variable::find($variable_rel->variable_id);

                                                // Saltar si la variable no existe o es de tipo CHECKBOX_RESTRICTIVE
                                                if (!$variable || $variable->tipo_elemento === 'CHECKBOX_RESTRICTIVE')
                                                    continue;

                                                // Formatear el valor según el tipo de variable
                                                $valor = $variable_rel->valor;

                                                // Si el valor es null o vacío, mostrar "No hay datos"
                                                if ($valor === null || $valor === '') {
                                                    $valor = 'No hay datos';
                                                } else {
                                                    // Si es un ID de país, buscar el nombre
                                                    if ($variable->isPais && is_numeric($valor)) {
                                                        $pais = \App\Models\Pais::find($valor);
                                                        if ($pais) {
                                                            $valor = $pais->nombre;
                                                        } else {
                                                            $valor = 'No hay datos';
                                                        }
                                                    }

                                                    // Si es una fecha, formatearla
                                                    if (strpos(strtolower($variable->nombre), 'fecha') !== false) {
                                                        try {
                                                            $valor = Carbon\Carbon::parse($valor)->format('d/m/Y');
                                                        } catch (\Exception $e) {
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
                <div class="mb-6">
                    <h5 class="text-lg font-bold mb-4 flex items-center">
                        <i class="fas fa-users mr-2"></i>Información de Viajeros
                    </h5>

                    @php
                        $viajeros = \App\Models\Viajero::where('visa_inscripcion_id', $pedido_visa->id)->get();
                    @endphp

                    @if(count($viajeros) > 0)
                        @foreach($viajeros as $index => $viajero)
                            <div class="mb-4">
                                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                                    <!-- Header del viajero -->
                                    <div class="bg-gray-50 px-6 py-4 flex justify-between items-center">
                                        <h6 class="text-sm font-bold text-gray-800 mb-0">Viajero #{{$index + 1}}</h6>
                                        <button
                                            onclick="
                                                var content = document.getElementById('content-viajero-{{$viajero->id}}');
                                                var button = this;
                                                if (content.classList.contains('hidden')) {
                                                    content.classList.remove('hidden');
                                                    button.textContent = 'Ocultar detalles';
                                                } else {
                                                    content.classList.add('hidden');
                                                    button.textContent = 'Ver detalles';
                                                }
                                            "
                                            class="px-3 py-1 text-sm bg-blue-50 text-blue-600 border border-blue-200 rounded-md hover:bg-blue-100 transition-colors duration-200"
                                            id="btn-viajero-{{$viajero->id}}">
                                            {{$index === 0 ? 'Ocultar detalles' : 'Ver detalles'}}
                                        </button>
                                    </div>

                                    <!-- Contenido del viajero -->
                                    <div
                                        id="content-viajero-{{$viajero->id}}"
                                        class="{{$index === 0 ? 'block' : 'hidden'}} transition-all duration-300">
                                        <div class="p-6">
                                            @php
                                                // Obtener todas las variables relacionadas con el viajero
                                                $variables_viajero = \App\Models\ViajeroVariable::where('viajero_id', $viajero->id)->get();

                                                // Agrupar variables por tipo
                                                $variables_agrupadas = [];

                                                foreach ($variables_viajero as $var_rel) {
                                                    $variable = \App\Models\Variable::find($var_rel->variable_id);

                                                    // Saltar si la variable no existe o es de tipo CHECKBOX_RESTRICTIVE
                                                    if (!$variable || $variable->tipo_elemento === 'CHECKBOX_RESTRICTIVE')
                                                        continue;

                                                    $tipo = $variable->tipo_variable ?: 'GENERAL';
                                                    if (!isset($variables_agrupadas[$tipo])) {
                                                        $variables_agrupadas[$tipo] = [];
                                                    }

                                                    // Formatear valor
                                                    $valor = $var_rel->valor;

                                                    // Si el valor es null o vacío, mostrar "No hay datos"
                                                    if ($valor === null || $valor === '') {
                                                        $valor = 'No hay datos';
                                                    } else {
                                                        // Si es un ID de país, buscar el nombre
                                                        if ($variable->isPais && is_numeric($valor)) {
                                                            $pais = \App\Models\Pais::find($valor);
                                                            if ($pais) {
                                                                $valor = $pais->nombre;
                                                            } else {
                                                                $valor = 'No hay datos';
                                                            }
                                                        }

                                                        // Si es una fecha, formatearla
                                                        if (
                                                            strpos(strtolower($variable->nombre), 'fecha') !== false ||
                                                            strpos(strtolower($variable->nombre_campo), 'fecha') !== false
                                                        ) {
                                                            try {
                                                                $valor = Carbon\Carbon::parse($valor)->format('d/m/Y');
                                                            } catch (\Exception $e) {
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
                                                    <div class="mb-6">
                                                        <h6 class="text-blue-600 font-semibold text-sm mb-3 uppercase tracking-wider">{{ucfirst(strtolower($tipo))}}</h6>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                                            @foreach($vars as $var)
                                                                <div class="space-y-1">
                                                                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">{{$var['nombre']}}</p>
                                                                    <p class="text-sm text-gray-900 font-medium border-b border-gray-200 pb-2">{{$var['valor']}}</p>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-gray-500 italic text-center py-8">No hay información detallada disponible para este viajero</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <p class="text-blue-800 text-sm">No se encontraron viajeros asociados a este pedido.</p>
                        </div>
                    @endif
                </div>


                <!-- Pie del modal -->
                <div class="row">
                    <div class="col-12 text-center mt-2">
                        <p class="text-muted">
                            <small>Si tienes alguna pregunta o necesitas ayuda, contáctanos en cualquier
                                momento.</small>
                        </p>
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

