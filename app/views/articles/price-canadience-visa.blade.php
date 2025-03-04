@extends('layouts.public')

@section('title', 'Visa')

@section('content')

    <div class="info-visa-container">
        <div class="return-page">
            <div class="small-title-page">
                <a class="inicio-link" href="/">
                    <span>Inicio</span>
                </a>
                <span> > </span>
                <b class="name-page">Visa para Canadá: Requisitos, costos y más</b>
            </div>
        </div>
        <div class="title-page">
            Visa para Canadá: Requisitos, costos y más
        </div>
        <div class="text-page">
            <div class="info-text">
                <span class="small-info">
                    <span class="info-name">
                        iVisa
                    </span>
                    <div class="separator"></div>
                    4 min leer
                    <div class="separator"></div>
                    Actualizado el Sep 09, 2024
                </span>
            </div>
        </div>
    </div>

    <div class="info-container">
        <div class="division">
            <div class="info-col-table">
                <div class="info-table-form">
                    <div style="padding: 32px">
                        <form action="">
                            <p class="form-title">Solicitar ahora</p>
                            <h4 class="label-form">¿De dónde eres?</h4>
                            <div class="custom-select" id="from-select">
                                <div class="selected-option">
                                    <img src="flags/peru.png" alt="Perú"> Perú
                                </div>
                                <div class="dropdown-form">
                                    <input type="text" class="search-input" placeholder="Buscar país...">
                                    <div class="options-list">
                                        <div class="option" data-value="peru"><img src="flags/peru.png" alt="Perú"> Perú
                                        </div>
                                        <div class="option" data-value="alemania"><img src="flags/germany.png"
                                                alt="Alemania"> Alemania</div>
                                        <div class="option" data-value="australia"><img src="flags/australia.png"
                                                alt="Australia"> Australia</div>
                                        <div class="option" data-value="canada"><img src="flags/canada.png" alt="Canadá">
                                            Canadá</div>
                                    </div>
                                </div>
                            </div>

                            <h4 class="label-form">Where are you going?</h4>
                            <div class="custom-select" id="to-select">
                                <div class="selected-option">
                                    <img src="flags/canada.png" alt="Canadá"> Canadá
                                </div>
                                <div class="dropdown-form">
                                    <input type="text" class="search-input" placeholder="Buscar país...">
                                    <div class="options-list">
                                        <div class="option" data-value="peru"><img src="flags/peru.png" alt="Perú"> Perú
                                        </div>
                                        <div class="option" data-value="alemania"><img src="flags/germany.png"
                                                alt="Alemania"> Alemania</div>
                                        <div class="option" data-value="australia"><img src="flags/australia.png"
                                                alt="Australia"> Australia</div>
                                        <div class="option" data-value="canada"><img src="flags/canada.png" alt="Canadá">
                                            Canadá</div>
                                    </div>
                                </div>
                            </div>

                            <button class="apply-btn">¡Aplica ahora! <span>→</span></button>
                        </form>
                    </div>
                </div>
                <div class="info-table">
                    <div style="padding: 32px">
                        <p class="info-title">Ir a:</p>
                        <ul style="list-style: none; padding-left: 0%; margin-bottom: 0%;">
                            <li>
                                <a href="#need-a-visa-to-go-canada" class="info-item">
                                    <span class="info-number">01</span>
                                    <div class="separator"></div>
                                    <span class="info-text-option">¿Se necesita una visa para viajar a Canadá?</span>
                                </a>
                            </li>
                            <li>
                                <a href="#requiers-to-get-visa-canada" class="info-item">
                                    <span class="info-number">02</span>
                                    <div class="separator"></div>
                                    <span class="info-text-option">Requisitos para Obtener la Visa de Canadá</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="info-col-article">
                <p class="many-text">Si planeas viajar a Canadá, es probable que necesites de
                    una Visa para ingresar al país. En este artículo te explicamos los requerimientos que necesitas para
                    tramitarla.
                </p>
                <p class="all-text"><img data-zoom-image=""
                        data-src="https://d2kzh91pcly9gn.cloudfront.net/-morrainelakecnim.webp" alt="canada"
                        data-ll-status="loaded" class="image entered loaded"
                        src="https://d2kzh91pcly9gn.cloudfront.net/-morrainelakecnim.webp" style="">
                </p>

                <h2 id="need-a-visa-to-go-canada" class="subtitle">¿Se necesita una visa para viajar a Canadá?</h2>

                <p class="many-text">Si, la mayoría de los viajeros que deseen visitar el país
                    como turista necesitan una Visa. Para algunas nacionalidades solo es necesario solicitar una
                    autorización electrónica de viaje o ETA.
                </p>
                <p class="all-text">Puedes chequear en la <a href="https://ircc.canada.ca/english/visit/visas.asp"
                        class="text-link" target="_blank" rel="nofollow">página oficial del gobierno de Canadá</a> si eres
                    elegible para una
                    Visa o ETA.
                </p>
                <p class="all-text">La Visa tiene una validez de 10 años o hasta un mes antes que caduque el pasaporte con
                    el que solicitó la visa. Durante todo ese tiempo podrás visitar el país las veces que quieras, sin
                    embargo, sin sobrepasar estancias de 6 meses por visita.
                </p>

                <h2 id="requiers-to-get-visa-canada" class="subtitle">Requisitos para Obtener la Visa de Canadá</h2>

                <p class="many-text">Para poder tramitar la Visa se necesitan presentar algunos
                    documentos esenciales:
                </p>

                <ul class="list-categories">
                    <li class="list-item"><strong>Pasaporte válido</strong> - Debes presentar un pasaporte que no haya
                        vencido, no tenga
                        ninguna página rota, o que sea ilegible; es importante que se vea el nombre, documento de identidad
                        y otros datos personales. Es importante, porque al no ser una visa electrónica, esta será adjuntada
                        al pasaporte.
                    </li>
                    <li class="list-item"><strong>Fotografía</strong> - Debes adjuntar con la solicitud dos fotografías de
                        pasaporte a color
                        que hayan sido tomadas en los últimos tres meses. Esta fotografía debe cumplir con los
                        requerimientos tradicionales de una fotografía tipo pasaporte.
                    </li>
                    <li class="list-item"><strong>Solvencia económica</strong> - Debes acreditar solvencia económica
                        suficiente para costear
                        tu estancia y el regreso a tu país.
                    </li>
                    <li class="list-item"><strong>Lazos personales o profesionales</strong> - Debes demostrar que tienes
                        obligaciones
                        personales o profesionales en tu país. Estas pueden ser una familia, estudios o un trabajo estable.
                    </li>
                    <li class="list-item"><strong>Temas legales</strong> - No debes tener ningún antecedente penal o haber
                        infringido alguna
                        ley migratoria o de visado.
                    </li>
                    <li class="list-item"><strong>Temas de salud</strong> - Debes estar seguro de que no padeces ninguna
                        enfermedad contagiosa
                        grave que suponga algún riesgo para la salud pública de Canadá.</li>
                    <li class="list-item"><strong>Correo electrónico</strong> - Es importante que los solicitantes presenten
                        su correo para
                        poder contactarlos si existe algún problema con la solicitud o si existen más requerimientos para el
                        proceso.
                    </li>
                    <li class="list-item"><strong>Método de pago</strong> - Puedes pagar las solicitudes en línea mediante
                        una tarjeta de
                        crédito o una de débito.
                    </li>
                </ul>

                <h3 class="subtitle-sub">Datos biométricos requeridos para solicitar la visa de Canadá</h3>

                <p class="many-text">IEs importante recalcar que los postulantes de este tipo
                    de visa que deben presentar sus datos biométricos en algún centro de aplicación son aquellos que no han
                    presentado esta información en los últimos 10 años.
                </p>

                <p class="all-text">Los datos biométricos exigidos por Canadá son la toma de
                    las huellas dactilares y la toma de una fotografía digital para que toda esta información sea subida al
                    sistema. Esto permite que cuando llegues al país, cualquier agente de migraciones tenga tus datos.
                </p>

                <h3 class="subtitle-sub">¿Se necesita visa para hacer escala en Canadá?</h3>

                <p class="many-text">No importa si tu estancia dura menos de 48 horas, siempre
                    necesitarás una visa de tránsito o una ETA si eres elegible. Puedes solicitarla vía web o asistir a la
                    embajada más cercana y presentar los documentos que te soliciten.
                </p>

                <h3 class="subtitle-sub">Costo de la visa para Canadá</h3>

                <p class="many-text">El costo siempre depende del país de origen y de la tasa
                    de servicio que cobre la empresa con quien estás realizando el procedimiento.
                </p>
                <p class="all-text">El precio de la visa de turista para Canadá es de
                    aproximadamente 100USD. Si deseas obtenerla con nosotros, a ese monto se debe agregar el monto del
                    servicio.
                </p>
                <p class="all-text">En iVisa cobramos 3 diferentes montos de servicio
                    dependiendo del tipo de procedimiento que elijas para realizar tu trámite.
                </p>
                <ul class="list-categories">
                    <li class="list-item"><strong>Velocidad de procesamiento estándar</strong> - Este es el servicio
                        estándar (<strong>24
                            horas</strong>) y por ende tiene el menor precio de todos (<strong>USD $99.49</strong>).
                    </li>
                    <li class="list-item"><strong>Velocidad de procesamiento rápido</strong> - Este servicio es más rápido
                        que el estándar
                        (<strong>6 horas</strong>), para viajeros que tienen alguna fecha determinada de viaje (<strong>USD
                            $129.49</strong>).
                    </li>
                    <li class="list-item"><strong>Velocidad de procesamiento súper rápido</strong> - Este es el servicio
                        para los viajeros que
                        están apurados (<strong>2 horas</strong>) y necesitan su documento lo antes posible (<strong>USD
                            $193.49</strong>).
                    </li>
                </ul>

                <div style="margin: 45px 0; text-align: center; width: 100%;">
                    <a class="apply-now-btn">Apply now</a>
                </div>

                <h3 class="subtitle-sub">¿Se necesita una carta para solicitar la visa de turista para Canadá?</h3>

                <p class="many-text">Si, este documento es clave para el proceso de tramitación
                    de tu visa de turista para Canadá. Esta debe ser redactada cuidadosamente y y con sumo detalle. Si bien
                    no existe una fórmula exacta para redactar la carta, nosotros recomendamos que la estructura tenga lo
                    siguiente:
                </p>

                <ul class="list-categories">
                    <li class="list-item">Fecha.</li>
                    <li class="list-item">Ciudad – País de origen.</li>
                    <li class="list-item">Introducción del caso - Saludo.</li>
                    <li class="list-item">Interés de viaje – Propósito.</li>
                    <li class="list-item">Presentación personal.</li>
                    <li class="list-item">Explicación del viaje y como lo pagarás.</li>
                    <li class="list-item">Cierre – Agradecimiento.</li>
                </ul>

                <p class="many-text">Esta estructura permite tener una coherencia en toda la
                    carta y facilita a los agentes migratorios poder leerla sin ningún problema.
                </p>

                <h3 class="subtitle-sub">¿Cuál es el proceso de solicitud de la visa de turista para Canadá?</h3>

                <p class="many-text">Si vas a realizar el proceso de solicitud por tu cuenta
                    debes considerar la siguiente información:
                </p>

                <ul class="list-categories">
                    <li class="list-item">Debes verificar tu elegibilidad de viajero.</li>
                    <li class="list-item">Debes crear una cuenta en el <a
                            href="https://www.canada.ca/en/immigration-refugees-citizenship/services/visit-canada/accounts.html"
                            target="_blank" class="text-link" rel="nofollow">portal IRCC.</a></li>
                    <li class="list-item">Debes completar los documentos requeridos para tramitar la visa de turista
                        canadiense.</li>
                    <li class="list-item">Debes enviar el formulario del documento de viaje.</li>
                    <li class="list-item">Debes enviar los documentos solicitados al consulado o embajada más cercana.</li>
                    <li class="list-item">Debes mantener comunicación con el consulado o embajada para esperar el último
                        paso.</li>
                    <li class="list-item">Una vez aceptado, debes enviar el pasaporte para obtener la visa. Luego debes
                        esperar que te
                        devuelvan el documento de viaje.</li>
                </ul>

                <h3 class="subtitle-sub">¿Necesitas Seguro de Viaje para Canadá?</h3>

                <p class="many-text">Cuando planeas un viaje, es muy importante contar con un
                    seguro de viaje no importa cuál sea tu destino. Hay distintos tipos de seguros de salud. Para mayor
                    información y contratación puedes acceder a través de <a
                        href="https://www.intermundial.es/afiliados/seguros-de-viaje-recomendado?tduid=a2505c6202eb9[…]&amp;utm_campaign=General&amp;utm_content=3281006&amp;utm_term=23927290"
                        target="_blank" rel="nofollow" class="text-link">este enlace</a> a la web de Intermundial.
                </p>

                <div style="margin: 45px 0; text-align: center; width: 100%;">
                    <a class="apply-now-btn">Apply now</a>
                </div>

                <h3 class="subtitle-sub">Obtener más información acerca de la Visa para Canadá</h3>

                <p class="many-text">Si tienes alguna duda sobre la visa turista de Canadá o
                    sobre los servicios de iVisa, puedes ponerte en contacto con nuestro <a href="/contact-us"
                        target="_blank" class="text-link" rel="nofollow">equipo de atención al cliente</a> o escribirnos a
                    <strong>help@iVisa</strong>. Nuestros expertos están disponibles las 24 horas del día.</p>
            </div>
        </div>
    </div>

    <div class="info-related">
        <div class="related-container">
            <h2 class="related-title">Artículos relacionados</h2>
            <div class="related-space">
                <a href="#" tabindex="-1" style="text-decoration: none">
                    <button class="related-button" type="submit">
                        Leer más
                    </button>
                </a>
            </div>
        </div>
        <div class="card-container">
            <a class="card-0" href="#">
                <img class="xy hg zp ie entered loaded"
                    data-src="https://ivisa.s3.amazonaws.com/website-assets/blog/man-working-laptop-hat-outdoor.webp"
                    alt="Guía de tarjetas de llegada: Información clave para viajeros cover image" width="425" height="200"
                    data-ll-status="loaded"
                    src="https://ivisa.s3.amazonaws.com/website-assets/blog/man-working-laptop-hat-outdoor.webp">
                <div class="card-content">
                    <span class="tag">Artículo</span>
                    <h3>Guía de tarjetas de llegada: Información clave para viajeros</h3>
                </div>
            </a>
            <a class="card-1" href="#">
                <img class="xy hg zp ie entered loaded"
                    data-src="https://ivisa.s3.amazonaws.com/website-assets/blog/traveler-on-mountain-view.webp"
                    alt="Puntos clave para la carta de invitación: Cómo escribir la invitación perfecta cover image"
                    width="425" height="200" data-ll-status="loaded"
                    src="https://ivisa.s3.amazonaws.com/website-assets/blog/traveler-on-mountain-view.webp">
                <div class="card-content">
                    <span class="tag">Artículo</span>
                    <h3>Puntos clave para la carta de invitación: Cómo escribir la invitación perfecta</h3>
                </div>
            </a>
            <a class="card-2" href="#">
                <img class="xy hg zp ie entered loaded"
                    data-src="https://ivisa.s3.amazonaws.com/website-assets/blog/female-travel-bangkok.webp"
                    alt="Guía completa de eVisas: Definición, proceso, requisitos y más cover image" width="425"
                    height="200" data-ll-status="loaded"
                    src="https://ivisa.s3.amazonaws.com/website-assets/blog/female-travel-bangkok.webp">
                <div class="card-content">
                    <span class="tag">Artículo</span>
                    <h3>Guía completa de eVisas: Definición, proceso, requisitos y más</h3>
                </div>
            </a>

            <div class="other-button">
                <a href="#" tabindex="-1" class="viewmore-button">
                    <button class="related-button" type="submit">
                        Leer más
                    </button>
                </a>
            </div>
        </div>
    </div>

    <link href="{{ assets('css/price-canadience-visa.css') }}" rel="stylesheet">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const customSelects = document.querySelectorAll(".custom-select");

            customSelects.forEach(select => {
                const selectedOption = select.querySelector(".selected-option");
                const dropdown = select.querySelector(".dropdown-form");
                const searchInput = select.querySelector(".search-input");
                const optionsList = select.querySelectorAll(".option");

                // Mostrar dropdown en el lugar del select
                selectedOption.addEventListener("click", function () {
                    dropdown.style.display = "block";
                    searchInput.focus();
                });

                // Buscar país en el input
                searchInput.addEventListener("input", function () {
                    const filter = searchInput.value.toLowerCase();
                    optionsList.forEach(option => {
                        const text = option.textContent.toLowerCase();
                        option.style.display = text.includes(filter) ? "flex" : "none";
                    });
                });

                // Seleccionar un país
                optionsList.forEach(option => {
                    option.addEventListener("click", function () {
                        const imgSrc = this.querySelector("img").src;
                        selectedOption.innerHTML = `<img src="${imgSrc}" alt=""> ${this.textContent}`;
                        selectedOption.style.display = "flex";
                        dropdown.style.display = "none";
                        searchInput.value = "";
                        optionsList.forEach(opt => (opt.style.display = "flex"));
                    });
                });

                // Cerrar dropdown si el usuario hace clic fuera
                document.addEventListener("click", function (event) {
                    if (!select.contains(event.target)) {
                        dropdown.style.display = "none";
                    }
                });
            });
        });
    </script>
@endsection