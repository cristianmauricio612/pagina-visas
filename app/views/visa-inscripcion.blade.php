@extends('layouts.public')

@section('title', 'Visa-Inscripcion')

@section('content')
    <div class="visa-inscripcion">
        <form class="row g-3 needs-validation" novalidate>
            <div class="col-md-4">
                <label for="validationCustom01" class="form-label">Fecha de llegada</label>
                <input type="date" class="form-control" id="validationCustom01" name="fecha_llegada" value="Mark" required>
                <div class="valid-feedback">
                Looks good!
                </div>
            </div>
            <div class="col-md-4">
                <label for="validationCustomUsername" class="form-label">Correo</label>
                <div class="input-group has-validation">
                <span class="input-group-text" id="inputGroupPrepend">@</span>
                <input type="text" class="form-control" id="validationCustomUsername" name="correo" aria-describedby="inputGroupPrepend" required>
                <div class="invalid-feedback">
                    Please choose a username.
                </div>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit form</button>
            </div>
        </form>
    </div>

    <script>
        (() => {
            'use strict';

            // Selecciona todos los formularios con la clase "needs-validation"
            const forms = document.querySelectorAll('.needs-validation');

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    event.preventDefault(); // Evita que el formulario se envíe automáticamente

                    if (!form.checkValidity()) {
                        event.stopPropagation();
                    } else {
                        // Capturar los datos del formulario
                        let formData = new FormData(form);

                        let viajeros = [
                            { nombres_pasaporte: "Juan", apellidos_pasaporte: "Martinez", fecha_nacimiento: "01/01/1900", nacionalidad_pasaporte_id: 1, numero_pasaporte: null, fecha_caducidad_pasaporte: null, pais_nacimiento_id: 1, nivel_estudios: "superior"},
                            { nombres_pasaporte: "Ana", apellidos_pasaporte: "Martinez", fecha_nacimiento: "02/01/1900", nacionalidad_pasaporte_id: 1, numero_pasaporte: 73586218, fecha_caducidad_pasaporte: "02/08/2028", pais_nacimiento_id: 1, nivel_estudios: "superior"}
                        ];

                        formData.append('visas_id', $visa->id);
                        formData.append('fecha_salida', null);
                        formData.append("viajeros", JSON.stringify(viajeros));

                        // 📌 Enviar manualmente los datos con fetch()
                        fetch(form.action, {
                            method: form.method,
                            body: formData
                        })
                        .then(response => response.json()) // Suponiendo que el servidor devuelve JSON
                        .then(data => {
                            console.log('Respuesta del servidor:', data);
                            // Aquí puedes hacer algo con la respuesta, como mostrar un mensaje
                        })
                        .catch(error => console.error('Error en el envío:', error));
                    }

                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>

    <link rel="stylesheet" href="{{ assets("css/visa-inscripcion.css") }}">
@endsection