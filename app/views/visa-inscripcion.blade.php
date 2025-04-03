@extends('layouts.public')

@section('title', 'Visa-Inscripcion')

@push('resources')
    <link rel="stylesheet" href="{{ assets("css/visa-inscripcion.css") }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')
        @php
            $contadorViajero = 1;
            $paises = \App\Models\Pais::all();
            $pais1 = \App\Models\Pais::find($visa->pais1_id);
            $pais2 = \App\Models\Pais::find($visa->pais2_id);

            $viajero1 = new App\Models\Viajero();

            $viajeros = [$viajero1];
        @endphp
    <div class="visa-inscripcion" id="visa-inscripcion">
        <div class="visa-inscripcion-container">
            <div class="visa-inscripcion-title">
                <h1 class="inscripcion-title-text">
                    <span>{{ $visa->nombre }}</span>
                </h1>
            </div>

            <div>
                <div class="visa-inscripcion-progress">
                    <div class="inscripcion-progress-points">
                        <span id="point1" class="inscripcion-point-container inscripcion-point-active">
                            <span class="inscripcion-point">1</span>
                        </span>
                        <span class="inscripcion-point-text">Detalles del viaje</span>
                    </div>

                    <div id="bar1" class="inscripcion-progress-bar"></div>

                    <div class="inscripcion-progress-points" style="--tw-space-x-reverse: 0; margin-right: calc(32px* var(--tw-space-x-reverse)); margin-left: calc(32px* calc(1 - var(--tw-space-x-reverse)));">
                        <span id="point2" class="inscripcion-point-container">
                            <span class="inscripcion-point">2</span>
                        </span>
                        <span class="inscripcion-point-text">Información personal</span>
                    </div>

                    <div id="bar2" class="inscripcion-progress-bar"></div>

                    <div class="inscripcion-progress-points" style="--tw-space-x-reverse: 0; margin-right: calc(32px* var(--tw-space-x-reverse)); margin-left: calc(32px* calc(1 - var(--tw-space-x-reverse)));">
                        <span id="point3" class="inscripcion-point-container">
                            <span class="inscripcion-point">3</span>
                        </span>
                        <span class="inscripcion-point-text">Pago</span>
                    </div>
                </div>
            </div>

            <div class="tab" id="tab1" style="">
                <div class="tab-form">
                    <div>
                        <div class="tab-form-title">
                            <span class="form-title-text">Detalles de tu viaje</span>
                        </div>

                        <div class="tab-form-box">
                            <div class="form-box-input">
                                <div class="form-box-date">
                                    <div class="">
                                        <label class="form-label">
                                            <span>¿Cuándo llegas a Estados Unidos?</span>
                                        </label>

                                        <div columns="2" disabled="false">
                                            <div style="position: relative;">
                                                <input placeholder="DD/MM/YYYY" class="form-input" name="fecha-llegada" id="date-picker">

                                                <div class="form-icon-content" id="calendar-icon">
                                                    <i class="fa-solid fa-calendar-days"></i>
                                                </div>
                                            </div>
                                            <div class="form-schedule" id="calendar-container"></div>
                                        </div>

                                        <div class="form-alert">
                                            <span>Ingresa la fecha exacta. No se aceptan fechas estimadas.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-box-input">
                                <div class="form-box-date">
                                    <div class="">
                                        <label class="form-label">
                                            <span>Correo electrónico</span>
                                        </label>

                                        <div style="position: relative;">
                                            <input class="form-input" name="correo" required=""
                                                placeholder="alguien@gmail.com" spellcheck="false" autocomplete="on"
                                                type="email">
                                        </div>

                                        <div class="form-alert">
                                            <span>Usamos esta información para mantenerte informado sobre el estado de tu
                                                solicitud.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-box-input">
                                <div class="form-box-date">
                                    <div class="">
                                        <label class="form-label">
                                            <span>Número de contacto</span>
                                        </label>

                                        <div style="position: relative;">
                                            <input class="form-input" name="telefono" required=""
                                                placeholder="+51 904080946" spellcheck="false" autocomplete="on"
                                                type="tel">
                                        </div>

                                        <div class="form-alert">
                                            <span>Usamos esta información para mantenerte informado sobre el estado de tu
                                                solicitud.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-box-input" style="display: none;">
                                <div data-ivisa-slug="consent_to_marketing_emails"
                                    data-ivisa-question-selector="general.consent_to_marketing_emails"
                                    class="form-box-date">
                                    <div class="">
                                        <div style="position: relative;">
                                            <div disabled="false" class="form-box-accept">
                                                <div>
                                                    <input type="checkbox" name="general.consent_to_marketing_emails"
                                                        class="form-accept-checkbox"
                                                        id="customCheckgeneral.consent_to_marketing_emails">
                                                </div>
                                                <label class="form-accept-text"
                                                    data-handle="label-general.consent_to_marketing_emails"
                                                    for="customCheckgeneral.consent_to_marketing_emails">
                                                    Quiero recibir
                                                    actualizaciones de iVisa, lanzamientos de productos y ofertas
                                                    personalizadas. Puedo optar por no recibirlos en cualquier
                                                    momento.
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-information">
                    <div class="tab-information-container">
                        <div class="tab-information-box">
                            <div class="information-box" data-handle="sidebar-summary-breakdown">
                                <div class="information-box-title">
                                    <ul class="information-title-text">
                                        <li>{{ $visa->nombre }}</li>
                                    </ul>
                                </div>

                                <div class="information-pago-hoy" style="display: none;">
                                    <span style="flex: 1 1 0%;">Pago a realizar hoy&nbsp;</span>
                                    <span style="text-wrap: nowrap; width: fit-content;">
                                        $. {{ $visa->precio * $contadorViajero}}
                                    </span>
                                </div>

                                <div class="information-pago-extra">
                                    @for ($i = 0; $i < $contadorViajero; $i++)
                                        <div class="information-pago-tasas">
                                            <span style="flex: 1 1 0%;">Tasas gubernamentales</span>
                                            <span style="text-wrap: nowrap; width: fit-content;">
                                                $. {{ $visa->tasa_gobierno }}
                                            </span>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="information-box-total">
                                <div class="box-total-text">
                                    <span>Total a pagar hoy</span>
                                    <span>Se calculará al momento de pagar</span>
                                </div>
                                <div class="gx zj bk"></div>
                            </div>
                        </div>

                        <div class="tab-information-buttons">
                            <button class="tab-button-continuar" id="btnContinueSidebar">
                                <span class="">Guardar y continuar</span>
                            </button>

                            <div
                                style="--tw-space-y-reverse: 0; margin-top: calc(24px* calc(1 - var(--tw-space-y-reverse))); margin-bottom: calc(24px* var(--tw-space-y-reverse));">
                                <button class="tab-button-retroceder" id="btnPreviousSidebar">
                                    <i class="fa-solid fa-arrow-left-long"></i>
                                    <span>Atrás</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab" id="tab2" style="display: none;">
                <div class="tab-form">
                    <div>
                        <div class="tab-form-title">
                            <span class="form-title-text">Tus datos personales</span>
                        </div>

                        <div>
                            <p class="form-title-warning">Asegúrate de que coincidan exactamente con los datos de tu pasaporte.</p>
                        </div>

                        <div class="tab-viajero-box">
                            <div class="tab-viajero-select">
                                <div class="tab-viajero-text">
                                    <span class="viajero-text">Viajero #1</span>
                                </div>
                                <div class="tab-viajero-icon">
                                    <div class="ge">
                                        <i class="fa-solid fa-chevron-down" style="font-size: 14px;"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-viajero-form hidden">
                                <div class="tab-viajero-item">
                                    <div class="w-100 h-100">
                                        <div class="">
                                            <label class="viajero-item-label">
                                                <span>Nombre(s)</span>
                                            </label>

                                            <div style="position: relative;">
                                                <input class="viajero-item-input" name="nombres[]" required="" placeholder="Cristian Alexander" spellcheck="false" autocomplete="given-name" type="text">
                                            </div>
                                            
                                            <div class="viajero-item-warning">
                                                <span>Ingresa tus datos tal como aparecen en tu pasaporte.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-viajero-item">
                                    <div class="w-100 h-100">
                                        <div class="">
                                            <label class="viajero-item-label">
                                                <span>Apellidos</span>
                                            </label>

                                            <div style="position: relative;">
                                                <input class="viajero-item-input" name="apellidos[]" required="" placeholder="Mauricio Tecco" spellcheck="false" autocomplete="family-name" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-viajero-item">
                                    <div class="w-100 h-100">
                                        <div class="">
                                            <label class="viajero-item-label">
                                                <span>Fecha de nacimiento</span>
                                            </label>

                                            <div style="position: relative;">
                                                <div type="date" class="tab-viajero-date">
                                                    <div class="viajero-date-container">
                                                        <select name="dia[]" class="select-dia">
                                                            <option disabled="" selected value="">Día</option>
                                                            @for ($i = 1; $i <= 31; $i++)
                                                                <option value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                        
                                                        <select name="mes[]" class="select-mes">
                                                            <option disabled="" selected value="">Mes</option>
                                                            @foreach ([1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'] as $num => $mes)
                                                                <option value="{{ $num }}">{{ $mes }}</option>
                                                            @endforeach
                                                        </select>
                                                        
                                                        <select name="anio[]" class="select-anio">
                                                            <option disabled="" selected value="">Año</option>
                                                            @php $anioActual = date('Y'); @endphp
                                                            @for ($i = 0; $i <= 100; $i++)
                                                                <option value="{{ $anioActual - $i }}">{{ $anioActual - $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="delete-form" onclick="eliminarViajero(this)" style="display: none;">
                                    <div style="display: inline; margin-right: 10px; font-size: 16px;">
                                        <i class="fa-solid fa-trash"></i>
                                    </div>
                                    <span>Eliminar viajero</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="contenedor-viajeros">
                        <!-- Aquí se agregarán los formularios dinámicamente -->
                    </div>

                    <div class="add-form">
                        <button class="add-form-button" onclick="agregarViajero()">
                            <div style="display: inline; margin-right: 10px; font-size: 16px;">
                                <i class="fa-solid fa-circle-plus"></i>
                            </div>
                            <span>Añadir otro viajero</span>
                        </button>
                    </div>
                </div>

                <div class="tab-information">
                    <div class="tab-information-container">
                        <div class="tab-information-box">
                            <div class="information-box" data-handle="sidebar-summary-breakdown">
                                <div class="information-box-title">
                                    <ul class="information-title-text">
                                        <li>{{ $visa->nombre }}</li>
                                    </ul>
                                </div>

                                <div class="information-pago-hoy" style="display: none;">
                                    <span style="flex: 1 1 0%;">Pago a realizar hoy&nbsp;</span>
                                    <span style="text-wrap: nowrap; width: fit-content;">
                                        $. {{ $visa->precio * $contadorViajero}}
                                    </span>
                                </div>

                                <div class="information-pago-extra">
                                    @for ($i = 0; $i < $contadorViajero; $i++)
                                        <div class="information-pago-tasas">
                                            <span style="flex: 1 1 0%;">Tasas gubernamentales</span>
                                            <span style="text-wrap: nowrap; width: fit-content;">
                                                $. {{ $visa->tasa_gobierno }}
                                            </span>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="information-box-total">
                                <div class="box-total-text">
                                    <span>Total a pagar hoy</span>
                                    <span>Se calculará al momento de pagar</span>
                                </div>
                                <div class="gx zj bk"></div>
                            </div>
                        </div>

                        <div class="tab-information-buttons">
                            <button class="tab-button-continuar" id="btnContinueSidebar">
                                <span class="">Guardar y continuar</span>
                            </button>

                            <div
                                style="--tw-space-y-reverse: 0; margin-top: calc(24px* calc(1 - var(--tw-space-y-reverse))); margin-bottom: calc(24px* var(--tw-space-y-reverse));">
                                <button class="tab-button-retroceder" id="btnPreviousSidebar">
                                    <i class="fa-solid fa-arrow-left-long"></i>
                                    <span>Atrás</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab" id="tab3" style="display: none;">
                <div class="tab-form">
                    <div id="viajeros-info-extra">
                        <div class="tab-form-title">
                            <span class="form-title-text">Tu información del pasaporte</span>
                        </div>

                        @for ($i = 0; $i < $contadorViajero; $i++)
                            <div class="tab-viajero-box">
                                <div class="tab-viajero-select">
                                    <div class="tab-viajero-text">
                                        <span class="viajero-text">Viajero #{{ $i+1 }}</span>
                                    </div>
                                    <div class="tab-viajero-icon">
                                        <div class="ge">
                                            <i class="fa-solid fa-chevron-down" style="font-size: 14px;"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-viajero-form hidden">
                                    <div class="tab-viajero-item">
                                        <div class="w-100 h-100">
                                            <label class="viajero-item-label">
                                                <span>Nacionalidad segun el pasaporte</span>
                                            </label>
                                        </div>
                                        
                                        <div class="custom-select" id="origen-pasaporte">
                                            <div class="selected-option" name="nacionalidad_pasaporte[]" data-value="{{ $pais1->id }}">
                                                <img src="{{ $pais1->imagen }}" alt="{{ $pais1->nombre }}"> {{ $pais1->nombre }}
                                            </div>
                                            <div class="dropdown-form">
                                                <input type="text" class="search-input" placeholder="Buscar país...">
                                                <div class="options-list">
                                                    @foreach ($paises as $pais)
                                                        <div class="option" data-value="{{ $pais->id }}">
                                                            <img src="{{ $pais->imagen }}" alt="{{ $pais->nombre }}"> {{ $pais->nombre }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-viajero-item">
                                        <div class="w-100 h-100">
                                            <div class="">
                                                <label class="viajero-item-label">
                                                    <span>Número de pasaporte</span>
                                                </label>

                                                <div style="position: relative;">
                                                    <input class="viajero-item-input" name="numero_pasaporte[]" required="" spellcheck="false" autocomplete="numero_pasaporte" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-viajero-item">
                                        <div class="w-100 h-100">
                                            <div class="">
                                                <label class="viajero-item-label">
                                                    <span>Fecha de caducidad del pasaporte</span>
                                                </label>

                                                <div style="position: relative;">
                                                    <div type="date" class="tab-viajero-date">
                                                        <div class="viajero-date-container">
                                                            <select name="dia[]" class="select-dia">
                                                                <option disabled="" selected value="">Día</option>
                                                                @for ($i = 1; $i <= 31; $i++)
                                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                            
                                                            <select name="mes[]" class="select-mes">
                                                                <option disabled="" selected value="">Mes</option>
                                                                @foreach ([1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'] as $num => $mes)
                                                                    <option value="{{ $num }}">{{ $mes }}</option>
                                                                @endforeach
                                                            </select>
                                                            
                                                            <select name="anio[]" class="select-anio">
                                                                <option disabled="" selected value="">Año</option>
                                                                @php $anioActual = date('Y'); @endphp
                                                                @for ($i = 0; $i <= 50; $i++)
                                                                    <option value="{{ $anioActual + $i }}">{{ $anioActual + $i }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-viajero-item">
                                        <div class="w-100 h-100">
                                            <label class="viajero-item-label">
                                                <span>País de nacimiento</span>
                                            </label>
                                        </div>
                                        
                                        <div class="custom-select">
                                            <div class="selected-option" name="pais_nacimiento[]" data-value="{{ $pais1->id }}">
                                                <img src="{{ $pais1->imagen }}" alt="{{ $pais1->nombre }}"> {{ $pais1->nombre }}
                                            </div>
                                            <div class="dropdown-form">
                                                <input type="text" class="search-input" placeholder="Buscar país...">
                                                <div class="options-list">
                                                    @foreach ($paises as $pais)
                                                        <div class="option" data-value="{{ $pais->id }}">
                                                            <img src="{{ $pais->imagen }}" alt="{{ $pais->nombre }}"> {{ $pais->nombre }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-viajero-item">
                                        <div class="w-100 h-100">
                                            <label class="viajero-item-label">
                                                <span>Nivel de estudios</span>
                                            </label>
                                        </div>
                                        
                                        <div class="custom-select">
                                            <div class="selected-option" name="nivel_estudios[]" data-value="Algunos cursos de nivel de posgrado">
                                                Algunos cursos de nivel de posgrado
                                            </div>
                                            <div class="dropdown-form">
                                                <input type="text" class="search-input" placeholder="Buscar país...">
                                                <div class="options-list">
                                                    <div class="option" data-value="Algunos cursos de nivel de doctorado">
                                                        Algunos cursos de nivel de doctorado
                                                    </div>
                                                    <div class="option" data-value="Algunos cursos de nivel de posgrado">
                                                        Algunos cursos de nivel de posgrado
                                                    </div>
                                                    <div class="option" data-value="Algunos cursos universitarios">
                                                        Algunos cursos universitarios
                                                    </div>
                                                    <div class="option" data-value="Doctorado">
                                                        Doctorado
                                                    </div>
                                                    <div class="option" data-value="Escuela secundaria, con titulo">
                                                        Escuela secundaria, con titulo
                                                    </div>
                                                    <div class="option" data-value="Escuela secundaria, sin titulo">
                                                        Escuela secundaria, sin titulo
                                                    </div>
                                                    <div class="option" data-value="Escuela vocacional">
                                                        Escuela vocacional
                                                    </div>
                                                    <div class="option" data-value="Solo escuela primaria">
                                                        Solo escuela primaria
                                                    </div>
                                                    <div class="option" data-value="Titulo de posgrado">
                                                        Titulo de posgrado
                                                    </div>
                                                    <div class="option" data-value="Titulo universitario">
                                                        Titulo universitario
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="viajero-item-warning">
                                                <span>Se consideran hijos hasta los 21 años.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="tab-information">
                    <div class="tab-information-container">
                        <div class="tab-information-box">
                            <div class="information-box" data-handle="sidebar-summary-breakdown">
                                <div class="information-box-title">
                                    <ul class="information-title-text">
                                        <li>{{ $visa->nombre }}</li>
                                    </ul>
                                </div>

                                <div class="information-pago-hoy" style="display: none;">
                                    <span style="flex: 1 1 0%;">Pago a realizar hoy&nbsp;</span>
                                    <span style="text-wrap: nowrap; width: fit-content;">
                                        $. {{ $visa->precio * $contadorViajero}}
                                    </span>
                                </div>

                                <div class="information-pago-extra">
                                    @for ($i = 0; $i < $contadorViajero; $i++)
                                        <div class="information-pago-tasas">
                                            <span style="flex: 1 1 0%;">Tasas gubernamentales</span>
                                            <span style="text-wrap: nowrap; width: fit-content;">
                                                $. {{ $visa->tasa_gobierno }}
                                            </span>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="information-box-total">
                                <div class="box-total-text">
                                    <span>Total a pagar hoy</span>
                                    <span>Se calculará al momento de pagar</span>
                                </div>
                                <div class="gx zj bk"></div>
                            </div>
                        </div>

                        <div class="tab-information-buttons">
                            <button class="tab-button-continuar" id="btnContinueSidebar">
                                <span class="">Guardar y continuar</span>
                            </button>

                            <div
                                style="--tw-space-y-reverse: 0; margin-top: calc(24px* calc(1 - var(--tw-space-y-reverse))); margin-bottom: calc(24px* var(--tw-space-y-reverse));">
                                <button class="tab-button-retroceder" id="btnPreviousSidebar">
                                    <i class="fa-solid fa-arrow-left-long"></i>
                                    <span>Atrás</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="revisar-solicitud" id="revisar-solicitud" style="display: none;">
        <div class="revisar-solicitud-container">
            <div class="visa-inscripcion-title" style="margin-top: 18px;">
                <h1 class="inscripcion-title-text">
                    <span class="inscripcion-title-span">Revisa tu solicitud</span>
                </h1>
            </div>

            <div class="tab">
                <div class="tab-form">
                    <div class="informacion-completa">
                        <div class="informacion-general">
                            <div class="informacion-general-box">
                                <div class="informacion-general-nombre">
                                    <h2>{{ $visa->nombre }}</h2>
                                    <img src="{{ $pais2->imagen }}" height="40" width="40">
                                </div>

                                <p class="informacion-general-item">Válido por: <span class="info-general-item-black">2 años desde la emisión</span></p>
                                <p class="informacion-general-item">Estancia máxima: <span class="info-general-item-black">2 años por entrada</span></p>
                                <p class="informacion-general-item" style="margin: 0;">Número de entradas: <span class="info-general-item-black">Entrada múltiple</span></p>
                            </div>
                        </div>
                        <div class="viajeros-box">
                            <h5 class="viajeros-box-title">Viajeros</h5>
                            @foreach ($viajeros as $viajero)
                                <div class="viajeros-box-item">
                                    <div style="display: inline;">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <p style="word-break: break-word; margin-bottom: 0;">{{ $viajero->nombres_pasaporte }} {{ $viajero->apellidos_pasaporte }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="tab-information">
                    <div class="tab-information-container">
                        <div class="information-box-final" data-handle="sidebar-summary-breakdown">
                            <div class="information-box-title">
                                <ul class="information-title-text">
                                    <li>{{ $visa->nombre }}</li>
                                </ul>
                            </div>

                            <div class="information-pago-hoy">
                                <span style="flex: 1 1 0%;">Pago a realizar hoy&nbsp;</span>
                                <span style="text-wrap: nowrap; width: fit-content;">
                                    $. {{ $visa->precio * $contadorViajero}}
                                </span>
                            </div>

                            <div class="information-pago-extra">
                                @for ($i = 0; $i < $contadorViajero; $i++)
                                    <div class="information-pago-tasas">
                                        <span style="flex: 1 1 0%;">Tasas gubernamentales</span>
                                        <span style="text-wrap: nowrap; width: fit-content;">
                                            $. {{ $visa->tasa_gobierno }}
                                        </span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <div class="information-box-total">
                            <div id="precioTotal" class="box-total-text">
                                <span>Total a pagar hoy</span>
                                <span>USD $. {{ ($visa->precio + $visa->tasa_gobierno) * $contadorViajero }}</span>
                            </div>
                        </div>

                        <div class="tab-information-buttons">
                            <button class="tab-button-continuar" id="btnContinuePay">
                                <span class="">Continuar con el pago</span>
                            </button>

                            <div style="--tw-space-y-reverse: 0; margin-top: calc(24px* calc(1 - var(--tw-space-y-reverse))); margin-bottom: calc(24px* var(--tw-space-y-reverse));">
                                <button class="tab-button-retroceder" id="btnPreviousSidebar">
                                    <i class="fa-solid fa-arrow-left-long"></i>
                                    <span>Atrás</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        let calendar;

        document.addEventListener("DOMContentLoaded", function () {
            const input = document.getElementById("date-picker");
            const icon = document.getElementById("calendar-icon");

            // Número de días mínimos desde hoy
            const minDays = 3;

            // Inicializar Flatpickr con opciones mejoradas
            calendar = flatpickr(input, {
                dateFormat: "d/m/Y",
                minDate: new Date().fp_incr(minDays),
                allowInput: false,
                clickOpens: true,
                positionElement: input,
                showMonths: 2,
            });

            const openCalendar = () => {
                input.focus();
                setTimeout(() => {
                    calendar.open();
                }, 100);
            };

            // Escuchar eventos en el icono
            icon.addEventListener("click", openCalendar);
            input.addEventListener("click", openCalendar);

            document.addEventListener("click", function (event) {
                // Obtener todos los dropdowns
                const allDropdowns = document.querySelectorAll(".dropdown-form");

                // Si el clic fue en una opción dentro del dropdown
                const option = event.target.closest(".option");
                if (option) {
                    const dropdown = option.closest(".dropdown-form");
                    const select = dropdown.closest(".custom-select");
                    const selectedOption = select.querySelector(".selected-option");

                    const selectedId = option.getAttribute("data-value"); // Obtener el ID seleccionado
                    const optionHTML = option.innerHTML; // Copiar contenido HTML (imagen + texto si hay)

                    // **Actualizar UI del select**
                    selectedOption.innerHTML = optionHTML;
                    selectedOption.setAttribute("data-value", selectedId);

                    // Cerrar dropdown
                    dropdown.style.display = "none";
                    return;
                }
                
                // Verificar si el clic fue dentro de un custom-select
                const select = event.target.closest(".custom-select");
                
                if (select) {
                    const selectedOption = select.querySelector(".selected-option");
                    const dropdown = select.querySelector(".dropdown-form");

                    // Cerrar todos los dropdowns antes de abrir el actual
                    allDropdowns.forEach(d => {
                        if (d !== dropdown) d.style.display = "none";
                    });

                    // Alternar visibilidad
                    dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";

                    // Enfocar en el input de búsqueda cuando se abre
                    const searchInput = dropdown.querySelector(".search-input");
                    if (dropdown.style.display === "block") {
                        searchInput.focus();
                    }

                    return; // Evita que se cierre inmediatamente
                }

                // Si el clic fue fuera de cualquier select, cerrar todos los dropdowns abiertos
                allDropdowns.forEach(d => d.style.display = "none");
            });

            // Manejar el filtrado de opciones en el dropdown
            document.addEventListener("input", function (event) {
                if (event.target.classList.contains("search-input")) {
                    const searchTerm = event.target.value.toLowerCase();
                    const optionsList = event.target.closest(".dropdown-form").querySelectorAll(".option");

                    optionsList.forEach(option => {
                        const text = option.textContent.toLowerCase();
                        option.style.display = text.includes(searchTerm) ? "flex" : "none";
                    });
                }
            });
        });

        let contadorViajero = @json($contadorViajero);
        const visa = @json($visa);

        function actualizarPagos() {
            let precioVisa = parseFloat(visa.precio);
            let tasaGobierno = parseFloat(visa.tasa_gobierno);

            // Actualizar TODAS las secciones de pago total
            document.querySelectorAll(".information-pago-hoy span:nth-child(2)").forEach(pagoHoy => {
                pagoHoy.textContent = `$. ${precioVisa * contadorViajero}`;
            });

            // Actualizar TODAS las secciones de tasas gubernamentales
            document.querySelectorAll(".information-pago-extra").forEach(contenedorTasas => {
                contenedorTasas.innerHTML = ""; // Vaciar el contenedor antes de agregar nuevas tasas
                for (let i = 0; i < contadorViajero; i++) {
                    let tasaDiv = document.createElement("div");
                    tasaDiv.classList.add("information-pago-tasas");
                    tasaDiv.innerHTML = `
                        <span style="flex: 1 1 0%;">Tasas gubernamentales</span>
                        <span style="text-wrap: nowrap; width: fit-content;">$. ${tasaGobierno}</span>
                    `;
                    contenedorTasas.appendChild(tasaDiv);
                }
            });
        }

        function agregarViajero() {
            let contenedor = document.getElementById("contenedor-viajeros");
            contadorViajero++; // Incrementa el número del viajero

            let nuevoViajero = document.createElement("div");
            nuevoViajero.classList.add("tab-viajero-box");
            nuevoViajero.innerHTML = `
                <div class="tab-viajero-select">
                    <div class="tab-viajero-text">
                        <span class="viajero-text">Viajero #${contadorViajero}</span>
                    </div>
                    <div class="tab-viajero-icon">
                        <div class="ge">
                            <i class="fa-solid fa-chevron-down" style="font-size: 14px;"></i>
                        </div>
                    </div>
                </div>

                <div class="tab-viajero-form hidden">
                    <div class="tab-viajero-item">
                        <div class="w-100 h-100">
                            <label class="viajero-item-label"><span>Nombre(s)</span></label>
                            <div style="position: relative;">
                                <input class="viajero-item-input" name="nombres[]" required placeholder="Cristian Alexander" spellcheck="false" autocomplete="given-name" type="text">
                            </div>
                            <div class="viajero-item-warning">
                                <span>Ingresa tus datos tal como aparecen en tu pasaporte.</span>
                            </div>
                        </div>
                    </div>

                    <div class="tab-viajero-item">
                        <div class="w-100 h-100">
                            <label class="viajero-item-label"><span>Apellidos</span></label>
                            <div style="position: relative;">
                                <input class="viajero-item-input" name="apellidos[]" required placeholder="Mauricio Tecco" spellcheck="false" autocomplete="family-name" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="tab-viajero-item">
                        <div class="w-100 h-100">
                            <label class="viajero-item-label"><span>Fecha de nacimiento</span></label>
                            <div style="position: relative;">
                                <div class="tab-viajero-date">
                                    <div class="viajero-date-container">
                                        <select name="dia[]" class="select-dia">
                                            <option disabled selected value="">Día</option>
                                            ${Array.from({length: 31}, (_, i) => `<option value="${i + 1}">${i + 1}</option>`).join('')}
                                        </select>

                                        <select name="mes[]" class="select-mes">
                                            <option disabled selected value="">Mes</option>
                                            ${["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
                                                .map((mes, i) => `<option value="${i + 1}">${mes}</option>`).join('')}
                                        </select>

                                        <select name="anio[]" class="select-anio">
                                            <option disabled selected value="">Año</option>
                                            ${Array.from({length: 101}, (_, i) => {
                                                let anio = new Date().getFullYear() - i;
                                                return `<option value="${anio}">${anio}</option>`;
                                            }).join('')}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="delete-form" onclick="eliminarViajero(this)">
                        <div style="display: inline; margin-right: 10px; font-size: 16px;">
                            <i class="fa-solid fa-trash"></i>
                        </div>
                        <span>Eliminar viajero</span>
                    </div>
                </div>
            `;

            contenedor.appendChild(nuevoViajero);

            actualizarPagos();
        }

        function eliminarViajero(boton) {
            contadorViajero--;
            boton.parentElement.parentElement.remove();
            actualizarPagos();
        }

        document.addEventListener("click", function (event) {
            // Verifica si el clic fue en un .tab-viajero-select
            if (event.target.closest(".tab-viajero-select")) {
                let select = event.target.closest(".tab-viajero-select");
                let icono = select.querySelector(".tab-viajero-icon");
                let formulario = select.nextElementSibling; // El formulario justo después

                if (!formulario) return; // Evita errores si no hay formulario

                // Alternar clases en los elementos correspondientes
                select.classList.toggle("viajero-select-active");
                icono.classList.toggle("viajero-icon-rotated");
                formulario.classList.toggle("hidden");
            }

            if (event.target.closest(".tab-button-retroceder")) {
                let buttons = Array.from(document.querySelectorAll(".tab-button-retroceder"));
                let button = event.target.closest(".tab-button-retroceder");
                let index = buttons.indexOf(button);
                
                let tab1 = document.getElementById("tab1");
                let tab2 = document.getElementById("tab2");
                let tab3 = document.getElementById("tab3");
                let form = document.getElementById("visa-inscripcion");
                let revision = document.getElementById("revisar-solicitud");
                let point1 = document.getElementById("point1");
                let bar1 = document.getElementById("bar1");
                let point2 = document.getElementById("point2");
                let bar2 = document.getElementById("bar2");
                let point3 = document.getElementById("point3");

                switch (index) {
                    case 0:
                        window.history.back(); // Regresar a la página anterior
                        break;
                    case 1:
                        tab1.style.display = "grid";
                        tab2.style.display = "none";
                        bar1.classList.remove("inscripcion-bar-active");
                        point2.classList.remove("inscripcion-point-active");
                        break;
                    case 2:
                        tab2.style.display = "grid";
                        tab3.style.display = "none";
                        bar2.classList.remove("inscripcion-bar-active");
                        point3.classList.remove("inscripcion-point-active");
                        break;
                    case 3:
                        form.style.display = "grid";
                        revision.style.display = "none";
                        break;
                    default:
                        console.warn("Botón no reconocido");
                }
            }
        });

        function actualizarDias(selectMes, selectAnio, selectDia) {
            if (!selectMes || !selectAnio || !selectDia) return; // Evitar errores si faltan elementos

            const mes = parseInt(selectMes.value);
            const anio = parseInt(selectAnio.value);

            // Días de cada mes (considerando años bisiestos)
            const diasPorMes = [31, (anio % 4 === 0 && anio % 100 !== 0) || (anio % 400 === 0) ? 29 : 28,
                                31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

            const maxDias = diasPorMes[mes - 1] || 31; // Evita valores indefinidos

            // Guardar el día previamente seleccionado
            const diaSeleccionado = parseInt(selectDia.value);

            // Vaciar y volver a llenar el select de días
            selectDia.innerHTML = '<option disabled selected value="">Día</option>';
            for (let i = 1; i <= maxDias; i++) {
                const option = document.createElement("option");
                option.value = i;
                option.textContent = i;
                if (i === diaSeleccionado) option.selected = true; // Mantener selección si es válida
                selectDia.appendChild(option);
            }
        }

        // Delegación de eventos para manejar selects existentes y dinámicos
        document.addEventListener("change", function (event) {
            const select = event.target;
            const container = select.closest(".viajero-date-container");

            if (!container) return; // Si no es un select dentro de .viajero-date-container, ignorar

            const selectDia = container.querySelector(".select-dia");
            const selectMes = container.querySelector(".select-mes");
            const selectAnio = container.querySelector(".select-anio");

            if (select === selectMes || select === selectAnio) {
                actualizarDias(selectMes, selectAnio, selectDia);
            }
        });

        // Inicializar selects en la carga de la página
        document.querySelectorAll(".viajero-date-container").forEach(container => {
            const selectDia = container.querySelector(".select-dia");
            const selectMes = container.querySelector(".select-mes");
            const selectAnio = container.querySelector(".select-anio");

            actualizarDias(selectMes, selectAnio, selectDia);
        });
    </script>

    <script>
        const paises = @json($paises);
        let pais1 = @json($pais1);
        let pais2 = @json($pais2);

        const csrfToken = "{{ csrf()->token() }}";

        let formData = {
            visas_id: visa.id,
            fecha_llegada: "",
            fecha_salida: null,
            correo: "",
            telefono: "",
            viajeros: []
        };

        document.addEventListener("click", function (event) {
            if (event.target.closest(".tab-button-continuar")) {
                let buttons = Array.from(document.querySelectorAll(".tab-button-continuar"));
                let button = event.target.closest(".tab-button-continuar");
                let index = buttons.indexOf(button);
                
                let tab1 = document.getElementById("tab1");
                let tab2 = document.getElementById("tab2");
                let tab3 = document.getElementById("tab3");
                let form = document.getElementById("visa-inscripcion");
                let revision = document.getElementById("revisar-solicitud");
                let point1 = document.getElementById("point1");
                let bar1 = document.getElementById("bar1");
                let point2 = document.getElementById("point2");
                let bar2 = document.getElementById("bar2");
                let point3 = document.getElementById("point3");

                let errores = [];

                // Validaciones y recolección de datos
                if (index === 0) {

                    // Capturar datos
                    let fechaLlegada = document.getElementById("date-picker").value.trim();
                    let correo = document.querySelector("input[name='correo']").value.trim();
                    let telefono = document.querySelector("input[name='telefono']").value.trim();

                    // Verificar fecha de llegada
                    if (!fechaLlegada) {
                        errores.push("📅 Debes ingresar una fecha de llegada.");
                    } else {
                        formData.fecha_llegada = formatFecha(fechaLlegada); // Guardar la fecha en el objeto
                    }

                    // Verificar correo electrónico con regex
                    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!correo || !emailRegex.test(correo)) {
                        errores.push("📧 Ingresa un correo válido.");
                    } else {
                        formData.correo = correo; // Guardar el correo en el objeto
                    }

                    // Verificar número de telefono
                    let telefonoRegex = /^\+?[0-9]{7,15}$/;
                    if (!telefono || !telefonoRegex.test(telefono)) {
                        errores.push("📞 Ingresa un número de teléfono válido (7 a 15 dígitos, opcionalmente con '+').");
                    } else {
                        formData.telefono = telefono; // Guardar el teléfono en el objeto
                    }

                    // Si hay errores, mostrar alertas y detener el avance
                    if (errores.length > 0) {
                        alert(errores.join("\n"));
                        return;
                    }
                }else if (index === 1) {
                    let viajeros = [];
                    let nombres = document.querySelectorAll('input[name="nombres[]"]');
                    let apellidos = document.querySelectorAll('input[name="apellidos[]"]');
                    let dias = document.querySelectorAll('select[name="dia[]"]');
                    let meses = document.querySelectorAll('select[name="mes[]"]');
                    let anios = document.querySelectorAll('select[name="anio[]"]');

                    for (let i = 0; i < nombres.length; i++) {
                        let nombre = nombres[i]?.value.trim();
                        let apellido = apellidos[i]?.value.trim();
                        let dia = dias[i]?.value;
                        let mes = meses[i]?.value;
                        let anio = anios[i]?.value;

                        if (!nombre || !apellido || !dia || !mes || !anio) {
                            errores.push(`⚠️ Completa todos los datos del viajero ${i + 1}.`);
                        }

                        // Calcular edad
                        let fechaNacimiento = new Date(anio, mes - 1, dia);
                        let edad = calcularEdad(fechaNacimiento);

                        if (edad < 18) {
                            errores.push(`🚫 El viajero ${i + 1} debe ser mayor de 18 años.`);
                        } else {
                            viajeros.push({
                                nombres: nombre,
                                apellidos: apellido,
                                fecha_nacimiento: `${anio}/${mes.padStart(2, "0")}/${dia.padStart(2, "0")}`
                            });
                        }
                    }

                    if (viajeros.length === 0) {
                        errores.push("⚠️ Debes ingresar al menos un viajero.");
                    } else {
                        formData.viajeros = viajeros;
                        actualizarViajeroInfoExtra();
                    }

                    // Si hay errores, mostrar alertas y detener el avance
                    if (errores.length > 0) {
                        alert(errores.join("\n"));
                        return;
                    }
                }else if (index === 2) {
                    let viajerosBoxes = document.querySelectorAll(".tab-viajero-box");
                    let mitad = viajerosBoxes.length / 2;
                    let viajerosInfo = Array.from(viajerosBoxes).slice(mitad);
                    
                    viajerosInfo.forEach((viajeroBox, i) => {
                        let nacionalidad = viajeroBox.querySelector(".selected-option[name='nacionalidad_pasaporte[]']")?.getAttribute("data-value");
                        let numeroPasaporte = viajeroBox.querySelector("input[name='numero_pasaporte[]']")?.value.trim();
                        let diaCaducidad = viajeroBox.querySelector("select[name='dia[]']")?.value;
                        let mesCaducidad = viajeroBox.querySelector("select[name='mes[]']")?.value;
                        let anioCaducidad = viajeroBox.querySelector("select[name='anio[]']")?.value;
                        let paisNacimiento = viajeroBox.querySelector(".selected-option[name='pais_nacimiento[]']")?.getAttribute("data-value");
                        let nivelEstudios = viajeroBox.querySelector(".selected-option[name='nivel_estudios[]']")?.getAttribute("data-value");

                        if (!nacionalidad || !numeroPasaporte || isNaN(diaCaducidad) || diaCaducidad === "" ||isNaN(mesCaducidad) || mesCaducidad === "" || isNaN(anioCaducidad) || anioCaducidad === "" || !paisNacimiento || !nivelEstudios) {
                            errores.push(`⚠️ Completa todos los datos del viajero ${i + 1}.`);
                        } else {
                            formData.viajeros[i] = {
                                ...formData.viajeros[i],
                                nacionalidad_pasaporte: nacionalidad,
                                numero_pasaporte: numeroPasaporte,
                                fecha_caducidad_pasaporte: `${anioCaducidad}/${mesCaducidad.padStart(2, "0")}/${diaCaducidad.padStart(2, "0")}`,
                                pais_nacimiento: paisNacimiento,
                                nivel_estudios: nivelEstudios
                            };

                            actualizarListaViajeros();
                            actualizarTotalPago();
                        }
                    });

                    if (errores.length > 0) {
                        alert(errores.join("\n"));
                        return;
                    }
                }

                switch (index) {
                    case 0:
                        tab1.style.display = "none";
                        tab2.style.display = "grid";
                        bar1.classList.add("inscripcion-bar-active");
                        point2.classList.add("inscripcion-point-active");
                        break;
                    case 1:
                        tab2.style.display = "none";
                        tab3.style.display = "grid";
                        bar2.classList.add("inscripcion-bar-active");
                        point3.classList.add("inscripcion-point-active");
                        break;
                    case 2:
                        form.style.display = "none";
                        revision.style.display = "grid";
                        break;
                    case 3:
                        console.log("Datos guardados en formData:", JSON.stringify(formData, null, 2));
                        data = "";

                        // Enviar formData al backend para generar el payload
                        // Función asíncrona para manejar el fetch
                        async function obtenerPayload() {
                            try {
                                const response = await fetch('/api/izipay/payload', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        "X-CSRF-TOKEN": csrfToken
                                    },
                                    body: JSON.stringify(formData)
                                });

                                data = await response.json(); // Asigna la respuesta JSON a data
                            } catch (error) {
                                console.error("Error al comunicarse con el backend:", error);
                            }
                        }

                        // Llamar a la función y luego validar data
                        obtenerPayload().then(() => {
                            if (data.signature) {
                                console.log("Payload recibido del backend:", data);

                                let form = document.createElement("form");
                                form.method = "POST";
                                form.action = "https://secure.micuentaweb.pe/vads-payment/";

                                // Agregar los campos necesarios de la respuesta del backend
                                form.innerHTML = `
                                    <input type="hidden" name="vads_action_mode" value="${data.vads_action_mode}" />
                                    <input type="hidden" name="vads_amount" value="${data.vads_amount}" />
                                    <input type="hidden" name="vads_ctx_mode" value="${data.vads_ctx_mode}" />
                                    <input type="hidden" name="vads_currency" value="${data.vads_currency}" /> 
                                    <input type="hidden" name="vads_cust_email" value="${data.vads_cust_email}" />
                                    <input type="hidden" name="vads_page_action" value="${data.vads_page_action}" />
                                    <input type="hidden" name="vads_payment_config" value="${data.vads_payment_config}" />
                                    <input type="hidden" name="vads_redirect_success_timeout" value="${data.vads_redirect_success_timeout}"/>
                                    <input type="hidden" name="vads_return_mode" value="${data.vads_return_mode}"/>
                                    <input type="hidden" name="vads_site_id" value="${data.vads_site_id}" />
                                    <input type="hidden" name="vads_trans_date" value="${data.vads_trans_date}" />
                                    <input type="hidden" name="vads_trans_id" value="${data.vads_trans_id}" />
                                    <input type="hidden" name="vads_url_return" value="${data.vads_url_return}"/>
                                    <input type="hidden" name="vads_version" value="${data.vads_version}" />
                                    <input type="hidden" name="signature" value="${data.signature}"/>
                                    <input type="submit" name="pagar" value="Pagar"/>
                                `;

                                document.body.appendChild(form);
                                form.submit();
                            } else {
                                console.error("Error: Datos incompletos en la respuesta del backend.");
                            }
                        });

                        break;
                    default:
                        console.warn("Botón no reconocido");
                }
            }
        });

        // Función para calcular la edad a partir de la fecha de nacimiento
        function calcularEdad(fechaNacimiento) {
            let hoy = new Date();
            let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
            let mesActual = hoy.getMonth();
            let diaActual = hoy.getDate();
            let mesNacimiento = fechaNacimiento.getMonth();
            let diaNacimiento = fechaNacimiento.getDate();

            // Ajustar si aún no ha pasado el cumpleaños este año
            if (mesActual < mesNacimiento || (mesActual === mesNacimiento && diaActual < diaNacimiento)) {
                edad--;
            }

            return edad;
        }

        function actualizarViajeroInfoExtra() {
            let contenedor = document.getElementById("viajeros-info-extra");
            contenedor.innerHTML = ""; // Limpiar el contenido actual

            let tituloHTML = `
                <div class="tab-form-title">
                    <span class="form-title-text">Tu información del pasaporte</span>
                </div>
            `;
            contenedor.innerHTML = tituloHTML;

            for (let i = 0; i < contadorViajero; i++) {
                let viajeroHTML = `
                    <div class="tab-viajero-box">
                        <div class="tab-viajero-select">
                            <div class="tab-viajero-text">
                                <span class="viajero-text">Viajero #${i + 1}</span>
                            </div>
                            <div class="tab-viajero-icon">
                                <div class="ge">
                                    <i class="fa-solid fa-chevron-down" style="font-size: 14px;"></i>
                                </div>
                            </div>
                        </div>

                        <div class="tab-viajero-form hidden">
                            <div class="tab-viajero-item">
                                <label class="viajero-item-label"><span>Nacionalidad según el pasaporte</span></label>
                                <div class="custom-select">
                                    <div class="selected-option" name="nacionalidad_pasaporte[]" data-value="${pais1.id}">
                                        <img src="${pais1.imagen}" alt="${pais1.nombre}"> ${pais1.nombre}
                                    </div>
                                    <div class="dropdown-form">
                                        <input type="text" class="search-input" placeholder="Buscar país...">
                                        <div class="options-list">
                                            ${paises.map(pais => 
                                                `<div class="option" data-value="${pais.id}">
                                                    <img src="${pais.imagen}" alt="${pais.nombre}"> ${pais.nombre}
                                                </div>`).join('')}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-viajero-item">
                                <label class="viajero-item-label"><span>Número de pasaporte</span></label>
                                <input class="viajero-item-input" name="numero_pasaporte[]" type="text">
                            </div>

                            <div class="tab-viajero-item">
                                <label class="viajero-item-label"><span>Fecha de caducidad del pasaporte</span></label>
                                <div class="tab-viajero-date">
                                    <div class="viajero-date-container">
                                        <select name="dia[]" class="select-dia">
                                            <option disabled selected>Día</option>
                                            ${[...Array(31).keys()].map(d => `<option value="${d + 1}">${d + 1}</option>`).join('')}
                                        </select>
                                        <select name="mes[]" class="select-mes">
                                            <option disabled selected>Mes</option>
                                            ${[
                                                'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                                                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                                            ].map((mes, index) => `<option value="${index + 1}">${mes}</option>`).join('')}
                                        </select>
                                        <select name="anio[]" class="select-anio">
                                            <option disabled selected>Año</option>
                                            ${[...Array(51).keys()].map(a => {
                                                let year = new Date().getFullYear() + a;
                                                return `<option value="${year}">${year}</option>`;
                                            }).join('')}
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-viajero-item">
                                <label class="viajero-item-label"><span>País de nacimiento</span></label>
                                <div class="custom-select">
                                    <div class="selected-option" name="pais_nacimiento[]" data-value="${pais1.id}">
                                        <img src="${pais1.imagen}" alt="${pais1.nombre}"> ${pais1.nombre}
                                    </div>
                                    <div class="dropdown-form">
                                        <input type="text" class="search-input" placeholder="Buscar país...">
                                        <div class="options-list">
                                            ${paises.map(pais => 
                                                `<div class="option" data-value="${pais.id}">
                                                    <img src="${pais.imagen}" alt="${pais.nombre}"> ${pais.nombre}
                                                </div>`).join('')}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-viajero-item">
                                <label class="viajero-item-label"><span>Nivel de estudios</span></label>
                                <div class="custom-select">
                                    <div class="selected-option" name="nivel_estudios[]" data-value="Algunos cursos de nivel de posgrado">
                                        Algunos cursos de nivel de posgrado
                                    </div>
                                    <div class="dropdown-form">
                                        <input type="text" class="search-input" placeholder="Buscar nivel de estudios...">
                                        <div class="options-list">
                                            ${[
                                                "Algunos cursos de nivel de doctorado",
                                                "Algunos cursos de nivel de posgrado",
                                                "Algunos cursos universitarios",
                                                "Doctorado",
                                                "Escuela secundaria, con título",
                                                "Escuela secundaria, sin título",
                                                "Escuela vocacional",
                                                "Solo escuela primaria",
                                                "Título de posgrado",
                                                "Título universitario"
                                            ].map(nivel => `<div class="option" data-value="${nivel}">${nivel}</div>`).join('')}
                                        </div>
                                    </div>
                                </div>
                                <div class="viajero-item-warning">
                                    <span>Se consideran hijos hasta los 21 años.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                contenedor.innerHTML += viajeroHTML;
            }
        }
    
        function actualizarListaViajeros() {
            let contenedorViajeros = document.querySelector(".viajeros-box");
            if (!contenedorViajeros) return;

            let html = `
                <h5 class="viajeros-box-title">Viajeros</h5>
            `;

            formData.viajeros.forEach((viajero, index) => {
                html += `
                    <div class="viajeros-box-item">
                        <div style="display: inline;">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <p style="word-break: break-word; margin-bottom: 0;">${viajero.nombres} ${viajero.apellidos}</p>
                    </div>
                `;
            });

            contenedorViajeros.innerHTML = html;
        }

        function actualizarTotalPago() {
            let contenedorTotal = document.getElementById("precioTotal");
            if (!contenedorTotal) return;

            let precioVisa = parseFloat(visa.precio);
            let tasaGobierno = parseFloat(visa.tasa_gobierno);

            let total = (precioVisa + tasaGobierno) * contadorViajero;

            contenedorTotal.innerHTML = `
                <span>Total a pagar hoy</span>
                <span>USD $. ${total.toFixed(2)}</span>
            `;
        }

        function formatFecha(fecha) {
            let partes = fecha.split("/");
            return `${partes[0]}/${partes[1]}/${partes[2]}`; // Convierte "19/04/2025" → "2025-04-19"
        }
    </script>
@endsection