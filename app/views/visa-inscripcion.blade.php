@extends('layouts.public')

@section('title', 'Visa-Inscripcion')

@section('content')
        @php
            $visa_inscripcion = new App\Models\VisaInscripcion();
            $viajero1 = new App\Models\Viajero();

            $visa_inscripcion->pago_hoy = 0.00;
            $visa_inscripcion->tasa_gobierno_total = 0.00;

            $viajeros = [$viajero1];
        @endphp
    <div class="visa-inscripcion">
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

                    <div class="inscripcion-progress-points"
                        style="--tw-space-x-reverse: 0; margin-right: calc(32px* var(--tw-space-x-reverse)); margin-left: calc(32px* calc(1 - var(--tw-space-x-reverse)));">
                        <span class="inscripcion-point-container">
                            <span class="inscripcion-point">2</span>
                        </span>
                        <span class="inscripcion-point-text">Información personal</span>
                    </div>

                    <div class="inscripcion-progress-bar"></div>

                    <div class="inscripcion-progress-points"
                        style="--tw-space-x-reverse: 0; margin-right: calc(32px* var(--tw-space-x-reverse)); margin-left: calc(32px* calc(1 - var(--tw-space-x-reverse)));">
                        <span class="inscripcion-point-container">
                            <span class="inscripcion-point">3</span>
                        </span>
                        <span class="inscripcion-point-text">Pago</span>
                    </div>
                </div>
            </div>

            <div class="tab" style="display: none;">
                <div class="tab-form">
                    <div>
                        <div class="tab-form-title">
                            <span class="form-title-text">Detalles de tu viaje</span>
                        </div>

                        <div class="tab-form-box">
                            <div class="form-box-input">
                                <div data-ivisa-slug="arrival_date" data-ivisa-question-selector="general.arrival_date"
                                    class="form-box-date">
                                    <div class="">
                                        <label class="form-label">
                                            <span>¿Cuándo llegas a Estados Unidos?</span>
                                        </label>

                                        <div columns="2" disabled="false">
                                            <div style="position: relative;">
                                                <input placeholder="DD/MM/YYYY" class="form-input" type="text" readonly
                                                    name="general.arrival_date" id="date-picker">

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
                                <div data-ivisa-slug="email" data-ivisa-question-selector="general.email"
                                    class="form-box-date">
                                    <div class="">
                                        <label class="form-label">
                                            <span>Correo electrónico</span>
                                        </label>

                                        <div style="position: relative;">
                                            <input class="form-input" name="general.email" required=""
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
                                        <li>Estados Unidos Formulario de inscripción a la Lotería DV</li>
                                    </ul>
                                </div>

                                <div class="information-pago-hoy" style="display: none;">
                                    <span style="flex: 1 1 0%;">Pago a realizar hoy&nbsp;</span>
                                    <span style="text-wrap: nowrap; width: fit-content;">$.
                                        {{ $visa_inscripcion->pago_hoy }}</span>
                                </div>

                                <div class="information-pago-extra">
                                    <div class="information-pago-despues" style="display: none;">
                                        <span class="pago-despues-text">Pago a realizar posteriormente</span>
                                        <span class="pago-despues-price">$. 0</span>
                                    </div>

                                    @foreach ($viajeros as $viajero)
                                                <div class="information-pago-tasas">
                                            <span style="flex: 1 1 0%;">Tasas gubernamentales</span>
                                            <span style="text-wrap: nowrap; width: fit-content;">$.
                                                {{ $visa_inscripcion->tasa_gobierno_total }}</span>
                                        </div>
                                    @endforeach
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

            <div class="tab">
                <div class="tab-form">
                    <div>
                        <div class="tab-form-title">
                            <span class="form-title-text">Tus datos personales</span>
                        </div>

                        <div>
                            <p class="form-title-warning">Asegúrate de que coincidan exactamente con los datos de tu
                                pasaporte.</p>
                        </div>

                        <div class="tab-viajero-box">
                            <div class="tab-viajero-select" data-handle="travelerSectionWrapper-0">
                                <div class="tab-viajero-text">
                                    <span class="viajero-text">Viajero #1</span>
                                </div>
                                <div class="kl jn gr ho gf ip it ig">
                                    <div class="ge">
                                        <i class="fa-solid fa-chevron-down" style="font-size: 20px;"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="md brz bdq la zz" data-handle="travelerSection-0" style="display: none;">
                                <div class="ez bei ez bei">
                                    <div data-ivisa-slug="first_name" data-ivisa-question-selector="applicant.0.first_name"
                                        class="gx hv">
                                        <div class=""><label
                                                class="gf ip v2-space-x-8 yr"><span>Nombre(s)</span></label><!---->
                                            <div class="ds"><input class="cuf v2-small lg:v2-medium"
                                                    name="applicant.0.first_name" required="" placeholder="Juan Guillermo"
                                                    spellcheck="false" autocomplete="given-name" type="text"><!----></div>
                                            <!----><!---->
                                            <div class="oh bfg bnn ms cn"><span>Ingresa tus datos tal como aparecen en tu
                                                    pasaporte.</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ez bei ez bei">
                                    <div data-ivisa-slug="last_name" data-ivisa-question-selector="applicant.0.last_name"
                                        class="gx hv">
                                        <div class=""><label
                                                class="gf ip v2-space-x-8 yr"><span>Apellidos</span></label><!---->
                                            <div class="ds"><input class="cuf v2-small lg:v2-medium"
                                                    name="applicant.0.last_name" required="" placeholder="Lopez Diaz"
                                                    spellcheck="false" autocomplete="family-name" type="text"><!----></div>
                                            <!----><!----><!---->
                                        </div>
                                    </div>
                                </div>
                                <div class="ez bei ez bei">
                                    <div data-ivisa-slug="dob" data-ivisa-question-selector="applicant.0.dob" class="gx hv">
                                        <div class=""><label class="gf ip v2-space-x-8 yr"><span>Fecha de
                                                    nacimiento</span></label><!---->
                                            <div class="ds">
                                                <div modelmodifiers="[object Object]" type="date" class="bbu bpv"><!---->
                                                    <div class="gf ip"><!----><select name="applicant.0.dob.day"
                                                            class="cuf v2-small lg:v2-medium fs tn ivisa-input-default"
                                                            autocomplete="bday-day">
                                                            <option disabled="" value="">Día</option>
                                                        </select><select name="applicant.0.dob.month"
                                                            class="cuf v2-small lg:v2-medium fs tn ivisa-input-default"
                                                            autocomplete="bday-year">
                                                            <option disabled="" value="">Mes</option>
                                                        </select><select name="applicant.0.dob.year"
                                                            class="cuf v2-small lg:v2-medium ivisa-input-default">
                                                            <option disabled="" value="">Año</option>
                                                        </select></div>
                                                </div><!---->
                                            </div><!----><!----><!---->
                                        </div>
                                    </div>
                                </div><!---->
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
                                        <li>Estados Unidos Formulario de inscripción a la Lotería DV</li>
                                    </ul>
                                </div>

                                <div class="information-pago-hoy" style="display: none;">
                                    <span style="flex: 1 1 0%;">Pago a realizar hoy&nbsp;</span>
                                    <span style="text-wrap: nowrap; width: fit-content;">$.
                                        {{ $visa_inscripcion->pago_hoy }}</span>
                                </div>

                                <div class="information-pago-extra">
                                    <div class="information-pago-despues" style="display: none;">
                                        <span class="pago-despues-text">Pago a realizar posteriormente</span>
                                        <span class="pago-despues-price">$. 0</span>
                                    </div>

                                    @foreach ($viajeros as $viajero)
                                                <div class="information-pago-tasas">
                                            <span style="flex: 1 1 0%;">Tasas gubernamentales</span>
                                            <span style="text-wrap: nowrap; width: fit-content;">$.
                                                {{ $visa_inscripcion->tasa_gobierno_total }}</span>
                                        </div>
                                    @endforeach
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
        });
    </script>

    <link rel="stylesheet" href="{{ assets("css/visa-inscripcion.css") }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection