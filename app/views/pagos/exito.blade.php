@extends('layouts.public')

@section('title', 'Pago Exitoso')

@push('resources')
    <link rel="stylesheet" href="{{ assets("css/pago-exito.css") }}">
@endpush

@section('content')
    <div class="container">
        <h1>¡Pago Exitoso! 🎉</h1>
        <p>Tu pago ha sido procesado correctamente.</p>
        <a href="/" class="btn">Volver al inicio</a>
    </div>
@endsection