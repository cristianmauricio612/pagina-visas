{{--
Custom Select Component with Search and Images

@param string $label - Texto de la etiqueta
@param string $name - Nombre del campo de formulario (si es múltiple, añada [] al final)
@param string $id - ID del componente select (opcional, por defecto usa $name)
@param string|null $placeholder - Texto del placeholder para la búsqueda (null para no mostrar)
@param array $options - Array de opciones disponibles (debe ser una colección de objetos)
@param mixed $selected - Opción seleccionada por defecto (opcional, puede ser un ID o un objeto completo)
@param string $optionValueField - Nombre del campo que se usará como valor (por defecto 'id')
@param string $optionTextField - Nombre del campo que se usará como texto (por defecto 'nombre')
@param string|null $optionImageField - Nombre del campo que se usará como URL de imagen (null para no mostrar imágenes)
@param string|null $optionImageAltField - Nombre del campo que se usará como texto alternativo de imagen (por defecto
usa $optionTextField)
@param bool $multiple - Permite selección múltiple (opcional, por defecto false)
@param string $containerClass - Clase CSS adicional para el contenedor principal (opcional)
@param string $labelClass - Clase CSS adicional para la etiqueta (opcional)
@param string $dropdownClass - Clase CSS adicional para el dropdown (opcional)
--}}

@php
    $opciones = $variable->opciones;
    $paises = App\Models\Pais::all();
    // Configuraciones principales
    $id = $variable->nombre;
    $name = $variable->nombre;
    $placeholder = $variable->placeholder ?? 'Buscar...';
    $multiple = $multiple ?? false;
    $labelClass = $labelClass ?? 'viajero-item-label';
    $dropdownClass = $dropdownClass ?? '';
    $label = $variable->encabezado;

    // Determinar el valor seleccionado
    $selectedOption = null;
    $index = 0;
    // Buscar el objeto seleccionado en las opciones
    if ($variable->isPais) {
        foreach ($paises as $pais) {
            if ($pais->nombre == "Perú") {
                $selectedOption = $pais;
            }
        }
    } else {
        foreach ($opciones as $opcion) {
            if ($index < 1) {
                $selectedOption = $opcion;
            }
            $index++;
        }
    }

@endphp

<div class="tab-viajero-item container-{{$variable->nombre}}" id="container-{{$id}}">
    @if(isset($label))
        <div class="w-100 h-100">
            <label class="{{ $labelClass }}">
                <span>{{ $label }}</span>
            </label>
        </div>
    @endif

    @if ($variable->isPais)
        <div class="custom-select" id="{{ $id }}">
            <div class="selected-option" name="{{ $name }}"
                data-value="{{ $selectedOption ? $selectedOption->id : '' }}">
                @if($selectedOption)
                    @if($selectedOption->imagen && isset($selectedOption->imagen))
                        <img src="{{ $selectedOption->imagen }}" alt="{{ $selectedOption->nombre }}">
                    @endif
                    {{ $selectedOption->nombre }}
                @else
                    {{ $placeholder ?? 'Seleccionar' }}
                @endif
            </div>
            <div class="dropdown-form {{ $dropdownClass }}">
                @if($placeholder !== null)
                    <input type="text" class="search-input" placeholder="{{ $placeholder }}">
                @endif
                <div class="options-list">
                    @foreach ($paises as $pais)
                        <div class="option" data-value="{{ $pais->id }}">
                            @if($pais->imagen && isset($pais->imagen))
                                <img src="{{ $pais->imagen }}" alt="{{ $pais->nombre }}">
                            @endif
                            {{ $pais->nombre }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="custom-select" id="{{ $id }}">
            <div class="selected-option" name="{{ $name }}"
                data-value="{{ $selectedOption ? $selectedOption->contenido : '' }}">
                @if($selectedOption)
                    @if($selectedOption->imagen && isset($selectedOption->imagen))
                        <img src="{{ $selectedOption->imagen }}" alt="{{ $selectedOption->contenido }}">
                    @endif
                    {{ $selectedOption->contenido }}
                @else
                    {{ $placeholder ?? 'Seleccionar' }}
                @endif
            </div>
            <div class="dropdown-form {{ $dropdownClass }}">
                @if($placeholder !== null)
                    <input type="text" class="search-input" placeholder="{{ $placeholder }}">
                @endif
                <div class="options-list">
                    @foreach ($opciones as $opcion)
                        <div class="option" data-value="{{ $opcion->contenido }}">
                            @if($opcion->imagen && isset($opcion->imagen))
                                <img src="{{ $opcion->imagen }}" alt="{{ $opcion->contenido }}">
                            @endif
                            {{ $opcion->contenido }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

</div>