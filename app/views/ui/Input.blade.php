{{-- 
    Phone Input Component
    
    @param string $label - Texto de la etiqueta
    @param string $name - Nombre del campo de formulario
    @param string $id - ID del campo (opcional, por defecto usa $name)
    @param string|null $placeholder - Texto del placeholder (null para no mostrar)
    @param bool $required - Indica si el campo es obligatorio (opcional, por defecto false)
    @param bool $disabled - Indica si el campo está deshabilitado (opcional, por defecto false)
    @param string|null $alert - Mensaje de alerta o información adicional (null para no mostrar)
    @param string $value - Valor preestablecido (opcional)
    @param string $type - Tipo de input (opcional, por defecto 'tel')
    @param bool $spellcheck - Habilitar/deshabilitar corrector ortográfico (opcional, por defecto false)
    @param string $autocomplete - Tipo de autocompletado (opcional, por defecto 'on')
--}}

@php
    $id = $variable->nombre;
    $name = $variable->nombre;
    $required = $variable->obligatoriedad;
    $disabled = $disabled ?? false;
    $value = $variable->valor ?? '';
    $type = $variable->tipo_elemento == "INPUT_TEXT" ? 'text' : 'number' ;
    $spellcheck = $spellcheck ?? false;
    $autocomplete = $autocomplete ?? 'on';
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

            <div style="position: relative;">
                <input 
                    class="form-input" 
                    name="{{ $name }}" 
                    id="{{ $id }}"
                    @if($placeholder !== null) placeholder="{{ $placeholder }}" @endif
                    value="{{ $value }}"
                    type="{{ $type }}"
                    spellcheck="{{ $spellcheck ? 'true' : 'false' }}"
                    autocomplete="{{ $autocomplete }}"
                    {{ $required ? 'required' : '' }}
                    {{ $disabled ? 'disabled' : '' }}
                >
            </div>

            @if($alert !== null)
            <div class="form-alert">
                <span>{{ $alert }}</span>
            </div>
            @endif
        </div>
    </div>
</div>