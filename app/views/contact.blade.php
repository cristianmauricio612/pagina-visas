@extends('layouts.public')
@section('title', 'Contacto')
@push('resources')
    <link href="{{assets('css/contact.css') }}" rel="stylesheet">
@endpush
@section('content')

    @php
        $paises = \App\Models\Pais::all();
    @endphp

    <div class="container my-5">
        <h1 class="fw-bold text-center py-5" style="font-size: 3rem">CONTACTO</h1>
        <div class="row row-cols-1 row-cols-md-2 my-5">
            <div class="col d-flex justify-content-center mb-3">
                <img style="max-width: 100%" class="rounded-5" src="{{assets('img/elegirnos.jpg')}}" alt="">
            </div>
            <div class="col">
                <h2 class="fw-bold">
                    ¡Contáctanos y Viaja al país de tus sueños!
                </h2>
                <p>
                    ¿Estás listo para emprender el viaje al país que siempre soñaste? Que ningun trámite de Visa te detenga,
                    nuestros asesores se ocuparán de todo, tu solo alista tus maletas.
                </p>
            </div>
        </div>

        <div class="container">
            <div class="row row-cols-1 row-cols-md-3 contact-container rounded-5 p-5 my-5">
                <div class="col">
                    <h2>LLÁMANOS</h2>
                    <p>+51 959 590 094 / +51 980 514 075</p>
                    <p>+51 967 284 888 / +51 967 911 764</p>
                    <p>+51 960 308 837</p>
                </div>
                <div class="col">
                    <h2>E-MAIL</h2>
                    <p>visastravel.info@gmail.com</p>
                </div>

                <div class="col">
                    <h2>VISÍTANOS</h2>
                    <p>Calle Monitor Huascar 165, Santiago de Surco, Lima, Perú</p>
                    <p>Lunes – Viernes de 08:00 am a 06:00 pm</p>
                    <p>Lunes – Viernes de 08:00 am a 06:00 pm</p>
                </div>
            </div>
        </div>
        <div class="container mt-5">
            <h2 class="text-center fw-bold">FORMULARIO <br> DE CONTACTO</h2>
            <p class="text-center">Nuestros asesores se pondrán en contacto contigo.</p>


            <form id="contactForm">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre *</label>
                        <input type="text" class="form-control" name="nombre" required>
                    </div>
                    <div class="col-md-6">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" name="apellidos">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" class="form-control" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono *</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="telefono" required placeholder="+51 987 654 321">
                    </div>
                </div>

                <div class="row mb-0 mb-md-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="nacionalidad" class="form-label">Nacionalidad *</label>
                        <select class="form-select" name="nacionalidad" required>
                            <option selected>Seleccione una opción</option>
                            @foreach ($paises as $pais)
                                <option>{{ $pais->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="dobleNacionalidad" class="form-label">¿Tiene doble nacionalidad? *</label>
                        <select class="form-select" name="dobleNacionalidad" required>
                            <option selected>Seleccione una opción</option>
                            <option>Si</option>
                            <option>No</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-0 mb-md-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="paisDestino" class="form-label">País de Destino *</label>
                        <select class="form-select" name="paisDestino" required>
                            <option selected>Seleccione una opción</option>
                            @foreach ($paises as $pais)
                                <option>{{ $pais->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="motivoViaje" class="form-label">Motivo de Viaje *</label>
                        <select class="form-select" name="motivoViaje" required>
                            <option selected>Seleccione una opción</option>
                            <option value="Turismo">Turismo</option>
                            <option value="Asistir a un evento (Conferencia, boda, concierto, etc)">Asistir a un evento
                                (Conferencia, boda, concierto, etc)</option>
                            <option value="Atención Médica">Atención Médica</option>
                            <option value="Negocios">Negocios</option>
                            <option value="Trabajo">Trabajo</option>
                            <option value="Estudios">Estudios</option>
                            <option value="Tengo una escala en este país">Tengo una escala en este país</option>
                            <option value="Otros">Otros</option>
                        </select>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="detalleConsulta" class="form-label">Detalle su consulta: *</label>
                    <textarea class="form-control" name="detalleConsulta" rows="3" required></textarea>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="consentimiento" required>
                    <label class="form-check-label" for="consentimiento">Estoy de acuerdo con la política de
                        privacidad.</label>
                </div>

                <button type="submit" class="button-send-form">ENVIAR</button>
            </form>
        </div>
    </div>

    <script>
        const csrfToken = "{{ csrf()->token() }}";

        document.getElementById("contactForm").addEventListener("submit", function (event) {
            event.preventDefault(); // Evita la recarga

            const formData = new FormData(event.target);
            const data = Object.fromEntries(formData.entries());

            fetch("/contact-mail", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("✅ " + data.message);
                        document.getElementById("contactForm").reset();
                    } else {
                        alert("❌ " + data.errors.join("\n"));
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("❌ Hubo un problema al enviar el formulario.");
                });
        });
    </script>

@endsection