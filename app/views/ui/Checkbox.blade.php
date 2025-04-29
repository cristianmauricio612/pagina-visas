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

@php
    $restricciones = App\Models\Restriccion::with('variableRestringida')->where('variable_id', $variable->id)->get();
    $elementos_afectados = $restricciones->pluck('variableRestringida.nombre')->toArray();
@endphp
<div class="tab-viajero-item container-{{$variable->nombre}}" id="container-{{$variable->nombre}}">
    <div class="form-check" style="display: flex; align-items: center; gap: 7px;">
        <input class="form-check-input 
            {{ isset($variable->tipo_elemento) && $variable->tipo_elemento === 'CHECKBOX_RESTRICTIVE' &&
    isset($elementos_afectados) && !empty($elementos_afectados) ? 'ocultarInputs' : '' }}" type="checkbox"
            value="{{ isset($variable->valor) ? $variable->valor : '' }}" id="{{ $variable->nombre }}"
            name="{{ $variable->nombre }}" data-elementos-afectados='@json($elementos_afectados)'
            @if($variable->tipo_variable === 'VISA') data-contexto="visa" @endif {{ isset($obligatoriedad) &&
    $obligatoriedad ? 'required' : '' }} {{ isset($variable->valor) && $variable->valor ? 'checked' : '' }}
            style="width: 20px; height: 20px;">

        <label class="form-check-label" style="margin-top: 7px;">
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

    @if(isset($variable->tipo_elemento) && $variable->tipo_elemento === 'CHECKBOX_RESTRICTIVE' && isset($elementos_afectados) && !empty($elementos_afectados))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.addEventListener('change', function (event) {
                    const checkbox = event.target;

                    if (checkbox.classList.contains('form-check-input') && checkbox.classList.contains('ocultarInputs')) {
                        const elementosAfectados = JSON.parse(checkbox.dataset.elementosAfectados || '[]');
                        const estaChecked = checkbox.checked;
                        const esVisa = checkbox.dataset.contexto === 'visa';

                        elementosAfectados.forEach(nombre => {
                            let elemento;

                            if (esVisa) {
                                elemento = document.getElementById('container-' + nombre);
                            } else {
                                const form = checkbox.closest('.tab-viajero-form');
                                if (form) {
                                    elemento = form.querySelector('.container-' + nombre);
                                }
                            }

                            if (elemento) {
                                elemento.style.display = estaChecked ? 'none' : '';
                                elemento.querySelectorAll('input, select, textarea').forEach(input => {
                                    input.disabled = estaChecked;
                                    
                                    if (estaChecked) {
                                        input.removeAttribute('required');
                                    } else {
                                        input.setAttribute('required', true);
                                    }
                                });
                            }
                        });
                    }
                });

                // Opcional: ejecutar estado inicial también para los checkboxes existentes
                document.querySelectorAll('.form-check-input.ocultarInputs').forEach(checkbox => {
                    const event = new Event('change');
                    checkbox.dispatchEvent(event);
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