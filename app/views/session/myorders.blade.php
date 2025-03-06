@extends('layouts.public')
@section('title', 'Visa')

@section('content')
    @php
        $usuario = session()->get('usuario');
        if(!$usuario){
            redirect('/iniciar-sesion');
        }
        $pedidos = \APP\MODELS\VisaInscripcion::where('correo','LIKE',$usuario['email']);
    @endphp
    <div class="main-container">
        <div class="info-visa-container">
            <div class="return-page">
                <div class="small-title-page">
                    <a class="inicio-link" href="/">
                        <span>Inicio</span>
                    </a>
                    <span> > </span>
                    <a class="inicio-link" href="/account">
                        <span>Mi cuenta</span>
                    </a>
                    <span> > </span>
                    <b>Mis pedidos</b>
                </div>
            </div>
            <div class="saludo">
                <span>Mis pedidos</span>
            </div>
            
        </div>

        <div class="editar-container">
            <a href="/account" class="back-link">← Mi cuenta</a>
            <h2>Datos personales</h2>
            <hr>
            <form id="updateEmailForm">
                {{ csrf()->form() }}
                <label for="email">Correo electronico</label>
                <input type="email" id="email" name="email" value="{{$usuario['email']}}" required>
    
                <label for="language">Idioma</label>
                <select id="language" name="language">
                    <option selected value="spanish">Español</option>
                </select>
    
                <div class="btn-container">
                    <button class="btn-guardar" data-id="{{$usuario['id']}}" type="submit">Guardar detalles</button>
                </div>
            </form>
            
        </div>
    </div>

    <script>
        document.getElementById("updateEmailForm").addEventListener("submit", function(event) {
            event.preventDefault();
    
            const formData = new FormData(event.target);
            const data = Object.fromEntries(formData.entries());
            let id = document.querySelector(".btn-guardar").getAttribute("data-id");
    
            fetch("/account/datos-personales/actualizar/" + id, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json().then(json => ({ status: response.status, body: json }))) 
            .then(result => {
                if (result.status === 200) {
                    console.log("✅ Usuario actualizado:", result.body);
                    alert("✅ Usuario actualizado exitosamente");
                    window.location.href = "/account"; 
                } else {
                    console.error("❌ Error al actualizar usuario:", result.body);
                    alert(`❌ Error: ${result.body.message}`);
                }
            })
            .catch(error => {
                console.error("❌ Error inesperado:", error);
                alert("❌ Ocurrió un error inesperado. Revisa la consola para más detalles.");
            });
        });
    </script>
    

    <link href="{{ assets('css/personal-data.css') }}" rel="stylesheet">
@endsection