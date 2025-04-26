{{-- 
    checkbox.blade.php - Componente de checkbox personalizable
    
    Parámetros esperados:
    - nombre: Identificador único del campo (obligatorio)
    - encabezado: Texto que se mostrará como etiqueta (obligatorio)
    - valor: Valor predeterminado (opcional)
    - advertencia: Texto de advertencia o ayuda (opcional)
    - obligatoriedad: Si el campo es obligatorio (opcional, por defecto false)
    - clase: Clases CSS adicionales (opcional)
    - tipo_elemento: Tipo de checkbox (CHECKBOX_RESTRICTIVE o CHECKBOX_INFORMATIVE)
    - elementos_afectados: Array con los nombres de los elementos a ocultar/mostrar (solo para CHECKBOX_RESTRICTIVE)
--}}

<div class="tab-viajero-item container-{{$variable->nombre}}" id="container-{{$variable->nombre}}">
    <div class="form-check" style="display: flex; align-items: center; gap: 7px;">
        <input 
            class="form-check-input 
            {{ isset($variable->tipo_elemento) && $variable->tipo_elemento === 'CHECKBOX_RESTRICTIVE' && 
            isset($elementos_afectados) && !empty($elementos_afectados) ? 'ocultarInputs' : '' }}" 
            type="checkbox" 
            value="{{ isset($variable->valor) ? $variable->valor : '' }}" 
            id="{{ $variable->nombre }}" 
            name="{{ $variable->nombre }}"
            {{ isset($obligatoriedad) && $obligatoriedad ? 'required' : '' }}
            {{ isset($variable->valor) && $variable->valor ? 'checked' : '' }}
            style="width: 20px; height: 20px;">
            
        <label class="form-check-label" for="{{ $variable->nombre }}" style="margin-top: 7px;">
            {{ $variable->encabezado }}
            @if(isset($variable->obligatoriedad) && $variable->obligatoriedad)
                <span class="text-danger">*</span>
            @endif
        </label>
    </div>
    
    @if(isset($variable->advertencia) && !empty($variable->advertencia))
        <div class="form-text text-muted">
            {{ $variable->advertencia }}
        </div>
    @endif

    @php
        $restricciones = App\Models\Restriccion::with('variableRestringida')->where('variable_id', $variable->id)->get();
        $elementos_afectados = $restricciones->pluck('variableRestringida.nombre')->toArray();
    @endphp

    @if(isset($variable->tipo_elemento) && $variable->tipo_elemento === 'CHECKBOX_RESTRICTIVE' && $variable->tipo_variable === 'VISA' && isset($elementos_afectados) && !empty($elementos_afectados))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkbox = document.getElementById('{{ $variable->nombre }}');
                
                // Función para actualizar la visibilidad de los elementos afectados
                function actualizarVisibilidad() {
                    const elementosAfectados = {!! json_encode($elementos_afectados) !!};
                    const estaChecked = checkbox.checked;
                    
                    elementosAfectados.forEach(function(elementoNombre) {
                        const elemento = document.getElementById('container-'+elementoNombre);
                        
                        if (elemento) {
                            // Si es un elemento directo
                            if (estaChecked) {
                                elemento.style.display = 'none';
                                elemento.disabled = true;
                            } else {
                                elemento.style.display = '';
                                elemento.disabled = false;
                            }
                        }
                    });
                }
                
                // Configurar evento de cambio
                checkbox.addEventListener('change', actualizarVisibilidad);
                
                // Inicializar estado
                actualizarVisibilidad();
            });
            
        </script>
    @elseif(isset($variable->tipo_elemento) && $variable->tipo_elemento === 'CHECKBOX_RESTRICTIVE' && isset($elementos_afectados) && !empty($elementos_afectados))
        <script>
            document.querySelectorAll('.ocultarInputs').forEach(checkbox => {
                    checkbox.addEventListener('change', () => {
                        // Encuentra el contenedor específico del formulario de este viajero
                        const viajeroForm = checkbox.closest('.tab-viajero-form');
                        const elementosAfectados = {!! json_encode($elementos_afectados) !!};

                        elementosAfectados.forEach(function(elementoNombre) {
                            const elemento = viajeroForm.querySelector('container-'+elementoNombre);
                            
                            if (elemento) {
                                // Si es un elemento directo
                                if (estaChecked) {
                                    elemento.style.display = 'none';
                                    elemento.disabled = true;
                                } else {
                                    elemento.style.display = '';
                                    elemento.disabled = false;
                                }
                            }
                        });
                    });
                });
        </script>
    @endif
</div>

{{--
    Ejemplo de uso del componente de checkbox:
    @include('ruta.al.checkbox', [
        'nombre' => 'omitirPasaporte',
        'encabezado' => 'Omite introducir por ahora la información del pasaporte',
        'tipo_elemento' => 'CHECKBOX_RESTRICTIVE',
        'elementos_afectados' => ['numeroPasaporte', 'fechaExpiracion', 'paisEmision'],
        'advertencia' => 'Al marcar esta casilla, algunos campos serán ocultados'
    ])
--}}