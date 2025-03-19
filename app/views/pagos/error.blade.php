@extends('layouts.public')

@section('title', 'Pago Erroneo')

@push('resources')
    <link rel="stylesheet" href="{{ assets("css/pago-erroneo.css") }}">
@endpush

@section('content')
    <div class="container">
        <h1>⚠️ Error en el Pago</h1>
        <p>Hubo un problema procesando tu pago. Inténtalo nuevamente.</p>
        <a href="/" class="btn">Volver al inicio</a>
    </div>
@endsection