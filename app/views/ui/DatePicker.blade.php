{{-- 
    Date Input Component
    
    @param string $label - Texto de la etiqueta
    @param string $name - Nombre del campo de formulario
    @param string $id - ID del campo (opcional, por defecto usa $name)
    @param string|null $placeholder - Texto del placeholder (null para no mostrar)
    @param bool $required - Indica si el campo es obligatorio (opcional, por defecto false)
    @param bool $disabled - Indica si el campo está deshabilitado (opcional, por defecto false)
    @param string|null $alert - Mensaje de alerta (null para no mostrar)
    @param string $value - Valor preestablecido (opcional)
    @param string $iconId - ID para el ícono (opcional, por defecto 'calendar-icon-{$id}')
    @param string $containerId - ID para el contenedor del calendario (opcional, por defecto 'calendar-container-{$id}')
    @param array $columns - Número de columnas para el calendario (opcional, por defecto 2)
--}}

@php
$id = $variable->nombre;
$name = $variable->nombre;
$required = $variable->obligatoriedad;
$disabled = $disabled ?? false;
$value = $variable->valor ?? '';
$iconId = $iconId ?? "calendar-icon-{$variable->nombre}";
$containerId = $containerId ?? "calendar-container";
$columns = $columns ?? 2;
$label = $variable->encabezado;
$alert = $variable->advertencia ?? null;
$placeholder = $variable->placeholder ?? null;
// $placeholder y $alert se usan directamente, pueden ser null para omitirlos
@endphp

<div class="form-box-input container-{{$variable->nombre}}" id="container-{{$id}}">
    <div class="form-box-date">
        <div class="">
            @if(isset($label))
            <label class="form-label">
                <span>{{ $label }}</span>
            </label>
            @endif

            <div columns="{{ $columns }}" disabled="{{ $disabled ? 'true' : 'false' }}">
                <div style="position: relative;">
                    <input 
                        @if($placeholder !== null) placeholder="{{ $placeholder }}" @endif
                        class="form-input date-picker" 
                        name="{{ $name }}" 
                        id="{{ $id }}"
                        value="{{ $value }}"
                        data-min-months="{{ $variable->pivot->meses_espera ?? 0 }}" {{-- Nuevo --}}
                        {{ $required ? 'required' : '' }}
                        {{ $disabled ? 'disabled' : '' }}
                    >

                    <div class="form-icon-content" id="{{ $iconId }}">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                </div>
                <div class="form-schedule" id="{{ $containerId }}"></div>
            </div>

            @if($alert !== null)
                <div class="form-alert">
                    <span>{{ $alert }}</span>
                </div>
            @endif
        </div>
    </div>

    
    
</div>