@extends('layouts.public')

@section('title', 'Pago Exitoso')

@push('resources')
    <link rel="stylesheet" href="{{ assets("css/pago-exito.css") }}">
@endpush

@section('content')
    <div class="exito-container">
        <div class="exito-content">
            <div class="icon-content"><i class="fa-regular fa-circle-check fa-beat-fade"></i></div>
            <div class="exito-text">El pago ha resultado exitoso</div>
            <div class="exito-warning">
                Muchas gracias por su compra.<br>
                Tu ID de pedido es <a id="pedido-id" class="exito-login" onclick="checkLogin()">{{ $visaInscripcion->numero_pedido }}</a>.<br>
                Copia este codigo para poder acceder a los datos de tu pedido desde el <a class="exito-login" href="/iniciar-sesion">Login</a>.
            </div>
        </div>
    </div>

    <script>
        const csrfToken = "{{ csrf()->token() }}";
        function checkLogin() {
            const email = document.getElementById('pedido-id').textContent;

            fetch("/order-check", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: JSON.stringify({ email: email })
                })
                    .then(response => response.json().then(data => ({ status: response.status, body: data })))
                    .then(result => {
                        if (result.status === 200 && result.body.redirect) {
                            window.location.href = result.body.redirect; // Redirigir a la nueva vista
                        } else if (result.status === 402) {
                            console.error("❌ ", result.body.message);
                        } else {
                            console.error("❌ Error desconocido:", result.body);
                        }
                    })
                    .catch(error => {
                        console.error("❌ Error inesperado:", error);
                    });
        }
    </script>
@endsection