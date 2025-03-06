@extends('layouts.public')
@section('title', 'Visa')

@section('content')
    @php
        $usuario = session()->get('usuario');
        if(!$usuario){
            redirect('/iniciar-sesion');
        }
    @endphp
    <div class="main-container">
        <div class="info-visa-container">
            <div class="return-page">
                <div class="small-title-page">
                    <a class="inicio-link" href="/">
                        <span>Inicio</span>
                    </a>
                    <span> > </span>
                </div>
            </div>
        </div>

        <div class="cuadros-container">
            <div class="card">
                <a href="{{route('account-mis-pedidos')}}" class="card-link">
                    <div class="icon"><i class="fa-solid fa-scroll"></i></div>
                    <div class="card-text">
                        <h3>Mis pedidos</h3>
                        <p>Consulta tus pedidos y documentos de viaje.</p>
                    </div>

                </a>
            </div>
            <div class="card">
                <a href="{{route('account-datos-personales')}}" class="card-link">
                    <div class="icon"><i class="fa-solid fa-user"></i> </div>
                    <div class="card-text">
                        <h3>Datos personales</h3>
                        <p>Actualiza la configuración de tu correo electrónico e idioma.</p>
                    </div>
                </a>
            </div>
            <div class="card">
                <a href="{{route('account-seguridad-privacidad')}}" class="card-link">
                    <div class="icon"><i class="fa-solid fa-lock"></i> </div>
                    <div class="card-text">
                        <h3>Seguridad y privacidad</h3>
                        <p>Actualiza tu contraseña.</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <link href="{{ assets('css/account.css') }}" rel="stylesheet">
@endsection