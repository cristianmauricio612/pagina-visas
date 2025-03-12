@extends('layouts.public')

@section('title', 'Visa-Inscripcion')

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
                        <span class="inscripcion-point-container">
                            <span class="inscripcion-point">1</span>
                        </span>
                        <span class="inscripcion-point-text">Detalles del viaje</span>
                    </div>

                    <div class="inscripcion-progress-bar"></div>

                    <div class="inscripcion-progress-points" style="--tw-space-x-reverse: 0; margin-right: calc(32px* var(--tw-space-x-reverse)); margin-left: calc(32px* calc(1 - var(--tw-space-x-reverse)));">
                        <span class="inscripcion-point-container">
                            <span class="inscripcion-point">2</span>
                        </span>
                        <span class="inscripcion-point-text">Información personal</span>
                    </div>

                    <div class="inscripcion-progress-bar"></div>

                    <div class="inscripcion-progress-points" style="--tw-space-x-reverse: 0; margin-right: calc(32px* var(--tw-space-x-reverse)); margin-left: calc(32px* calc(1 - var(--tw-space-x-reverse)));">
                        <span class="inscripcion-point-container">
                            <span class="inscripcion-point">3</span>
                        </span>
                        <span class="inscripcion-point-text">Pago</span>
                    </div>
                </div>
            </div>

            <div class="tab" id="tab-1">
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
                                                <input placeholder="DD/MM/YYYY" class="form-input" type="text" readonly
                                                    name="fecha-llegada" id="date-picker">

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

            <div class="tab" id="tab-2" style="display: none;">
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
                                                            @foreach ([
                                                                1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 
                                                                5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 
                                                                9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                                                                ] as $num => $mes)
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

            <div class="tab" id="tab-3" style="display: none;">
                <div class="tab-form">
                    <div>
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
                                                                @foreach ([
                                                                    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 
                                                                    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 
                                                                    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                                                                    ] as $num => $mes)
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

                                    <div class="delete-form" onclick="eliminarViajero(this)" style="display: none;">
                                        <div style="display: inline; margin-right: 10px; font-size: 16px;">
                                            <i class="fa-solid fa-trash"></i>
                                        </div>
                                        <span>Eliminar viajero</span>
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
                                    <p style="word-break: break-word;">{{ $viajero->nombres_pasaporte }} {{ $viajero->apellidos_pasaporte }}</p>
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
                            <div class="box-total-text">
                                <span>Total a pagar hoy</span>
                                <span>USD $. {{ ($visa->precio + $visa->tasa_gobierno) * $contadorViajero }}</span>
                            </div>
                        </div>

                        <div class="tab-information-buttons">
                            <button class="tab-button-continuar" id="btnContinuePay">
                                <span class="">Continuar con el pago</span>
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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const input = document.getElementById("date-picker");
            const icon = document.getElementById("calendar-icon");

            // Número de días mínimos desde hoy
            const minDays = 3;

            // Inicializar Flatpickr con opciones mejoradas
            const calendar = flatpickr(input, {
                dateFormat: "d/m/Y",
                minDate: new Date().fp_incr(minDays),
                allowInput: false,
                clickOpens: true,
                inline: false,
                defaultHour: 0,
                defaultMinute: 0,
                positionElement: input,
                showMonths: 2,
            });

            // Evento para abrir el calendario al hacer clic en el icono
            icon.addEventListener("click", function () {
                calendar.open();
            });

            const customSelects = document.querySelectorAll(".custom-select");

            customSelects.forEach(select => {
                const selectedOption = select.querySelector(".selected-option");
                const dropdown = select.querySelector(".dropdown-form");
                const searchInput = select.querySelector(".search-input");
                const optionsList = select.querySelectorAll(".option");
                const isPaisSelect = select.querySelector(".option img") !== null; // Si hay imágenes, es el select de países

                // Mostrar dropdown
                selectedOption.addEventListener("click", function () {
                    dropdown.style.display = "block";
                    searchInput.focus();
                });

                // Filtrar búsqueda
                searchInput.addEventListener("input", function () {
                    const filter = searchInput.value.toLowerCase();
                    optionsList.forEach(option => {
                        const text = option.textContent.toLowerCase();
                        option.style.display = text.includes(filter) ? "flex" : "none";
                    });
                });

                // Seleccionar opción
                optionsList.forEach(option => {
                    option.addEventListener("click", function () {
                        const selectedId = this.getAttribute("data-value"); // Obtener ID del país seleccionado
                        const optionText = this.textContent.trim(); // Obtener solo el texto
                        let optionHTML = this.innerHTML; // Copiar contenido HTML (imagen + texto si hay)

                        // **Actualizar UI del select**
                        selectedOption.innerHTML = optionHTML;
                        dropdown.style.display = "none";
                        searchInput.value = "";
                        optionsList.forEach(opt => (opt.style.display = "flex"));
                    });
                });

                // Cerrar dropdown al hacer clic fuera
                document.addEventListener("click", function (event) {
                    if (!select.contains(event.target)) {
                        dropdown.style.display = "none";
                    }
                });
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

    <link rel="stylesheet" href="{{ assets("css/visa-inscripcion.css") }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection