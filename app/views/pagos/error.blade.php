@extends('layouts.public')

@section('title', 'Pago Erroneo')

@push('resources')
    <link rel="stylesheet" href="{{ assets("css/pago-erroneo.css") }}">
@endpush

@section('content')
    <div class="error-container">
        <div class="error-content">
            <div class="icon-content"><i class="fa-regular fa-circle-xmark fa-shake"></i></div>
            <div class="error-text">El pago ha resultado fallido</div>
            <div class="error-warning">
                Ha ocurrido un error durante el proceso de pago de tu pedido.<br>
                Por favor, vuelve a intentarlo o contacta con el comercio.
            </div>
        </div>
    </div>
@endsection