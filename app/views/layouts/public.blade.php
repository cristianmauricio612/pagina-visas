<!doctype html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keyword')">
    <meta name="robots" content="index, follow">
    <link href="{{assets('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{assets('fontawesome/css/all.css')}}" rel="stylesheet">
    <link href="{{assets('css/styles.css') }}" rel="stylesheet">
    @stack('resources')
</head>
@php
    $usuario = session()->get('usuario');
@endphp
<body>
    <div class="header" id="principal-nav">
        <div class="header-container">
            <a href="/" class="logo-container nav-link" >
                <img src="{{ assets("img/av.png") }}" alt="" style="height: 32px">
                <span>Visa Asesores</span>
            </a>

            <div class="menu-container">
                <nav class="nav-container">
                    <div class="dropdown">
                        <span class="dropdown-custom dropdown-toggle-custom" data-bs-toggle="dropdown" aria-expanded="false">
                            <span>Obtener mi visa</span>
                            <i class="fa-solid fa-angle-down i-content"></i>
                            <i class="fa-solid fa-angle-up i-content" hidden></i>
                        </span>

                        <ul class="dropdown-menu dropdown-menu-end mt-3">
                            <li>
                                <a class="dropdown-item" href="{{route('estados-unidos-p-esta')}}">
                                    <img class="gn gv hr entered loaded" data-src="https://d1bfs3rtmjstvi.cloudfront.net/img/circle-flags/KE.png" alt="KE Flag" data-ll-status="loaded" src="https://d1bfs3rtmjstvi.cloudfront.net/img/circle-flags/KE.png" style="height:16px; width:16px">
                                    Estados Unidos ESTA
                                </a>
                            </li>
                            <li><a class="dropdown-item" href="#">Otro</a></li>
                        </ul>
                    </div>
                    <div class="dropdown ms-4">
                        <span class="dropdown-custom dropdown-toggle-custom" data-bs-toggle="dropdown" aria-expanded="false">
                            <span>Viaja con seguridad</span>
                            <i class="fa-solid fa-angle-down i-content"></i>
                            <i class="fa-solid fa-angle-up i-content" hidden></i>
                        </span>

                        <ul class="dropdown-menu dropdown-menu-end mt-3">
                            <li class="dropdown-submenu">
                                <a class="dropdown-item sub-dropdown-toggle" href="#">Viaja con seguridad
                                    <i class="fa-solid fa-angle-down sub-icon"></i>
                                </a>
                                <ul class="submenu">
                                    <li><a class="dropdown-item" href="{{route('about-visa')}}">¿Qué es una visa?</a></li>
                                    <li><a class="dropdown-item" href="#">Opción 2</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item sub-dropdown-toggle" href="#">Documentación y visados más comunes
                                    <i class="fa-solid fa-angle-down sub-icon"></i>
                                </a>
                                <ul class="submenu">
                                    <li><a class="dropdown-item" href="{{route('electronic-visa')}}">Visa electrónica (eVisa)</a></li>
                                    <li><a class="dropdown-item" href="{{route('arrived-visa')}}">Visa de llegada</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item sub-dropdown-toggle" href="#">Lo más destacado
                                    <i class="fa-solid fa-angle-down sub-icon"></i>
                                </a>
                                <ul class="submenu">
                                    <li><a class="dropdown-item" href="{{route('price-canadience-visa')}}">Precio de la visa canadiense</a></li>
                                    <li><a class="dropdown-item" href="{{route('visa-validity')}}">Vigencia visado de Estados Unidos</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="country-container ms-4">
                    <span>ES</span>
                    <span class="mx-2 vr" style="height: 16px; margin-top: 2px;"></span>
                    <span>S/. PEN</span>
                </div>
                @if (!$usuario)
                    <div class="ms-4">
                        <a href="{{route('iniciar-sesion')}}">
                            <button class="button-login">Iniciar sesión</button>
                        </a>
                    </div>
                @else
                    <div class="dropdown ms-4">
                        <span class="dropdown-custom dropdown-toggle-custom" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user"></i>
                            <span>{{$usuario['nombre']}}</span>
                            <i class="fa-solid fa-angle-down i-content"></i>
                            <i class="fa-solid fa-angle-up i-content" hidden></i>
                        </span>

                        <ul class="dropdown-menu dropdown-menu-end mt-3">
                            <li class="dropdown-submenu">
                                <a class="dropdown-item" href="{{route('account')}}">Mi cuenta
                                </a>
                            </li>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item" href="#">Mis pedidos
                                </a>
                            </li>
                            <hr>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item" onclick="logout()">Cerrar Sesion
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif

                <button class="menu-toggle ms-auto" id="menuToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="countryModal" tabindex="-1" aria-labelledby="countryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Botón de cierre en la esquina -->
                <button type="button" class="btn-close custom-close" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <!-- Título -->
                <div class="modal-title-container">
                    <span>Selecciona tus preferencias de país y divisa</span>
                </div>

                <!-- Cuerpo del modal -->
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="languageSelect" class="form-label">Idioma</label>
                            <select class="form-select" id="languageSelect">
                                <option selected>Español</option>
                                <option>Inglés</option>
                                <option>Francés</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="currencySelect" class="form-label">Divisa</label>
                            <select class="form-select" id="currencySelect">
                                <option selected>PEN S/.</option>
                                <option>USD $</option>
                                <option>EUR €</option>
                            </select>
                        </div>
                    </form>
                </div>

                <!-- Botón separado del contenido -->
                <div class="modal-footer custom-footer">
                    <button type="button" class="btn custom-btn" data-bs-dismiss="modal">Actualizar preferencias</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Menú lateral -->
    <div class="side-menu" id="sideMenu">
        <button class="close-menu" id="closeMenu">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="side-menu-content">
            <div class="title-modal-vertical">Explora</div>
            <ul class="modal-vertical-list">
                <!-- Primera opción con submenús -->
                <li class="modal-vertical-item modal-vertical-has-submenu">
                    <div class="modal-vertical-title">
                        <span><i class="fa-solid fa-passport"></i> Obtener mi visa</span>
                        <i class="fa-solid fa-angle-down modal-vertical-toggle-submenu"></i>
                    </div>
                    <ul class="modal-vertical-submenu">
                        <li class="modal-vertical-title"><a href="#">Opción 1</a></li>
                        <li class="modal-vertical-title"><a href="#">Opción 2</a></li>
                    </ul>
                </li>

                <!-- Segunda opción con submenús anidados -->
                <li class="modal-vertical-item modal-vertical-has-submenu">
                    <div class="modal-vertical-title">
                        <span><i class="fa-solid fa-plane"></i> Viaja con seguridad</span>
                        <i class="fa-solid fa-angle-down modal-vertical-toggle-submenu"></i>
                    </div>
                    <ul class="modal-vertical-submenu">
                        <li class="modal-vertical-item modal-vertical-has-submenu">
                            <div class="modal-vertical-title">
                                <span>Viaja con seguridad</span>
                                <i class="fa-solid fa-angle-down modal-vertical-toggle-submenu"></i>
                            </div>
                            <ul class="modal-vertical-submenu">
                                <li class="modal-vertical-title"><a href="#">Opción 1</a></li>
                                <li class="modal-vertical-title"><a href="#">Opción 2</a></li>
                            </ul>
                        </li>
                        <li class="modal-vertical-item modal-vertical-has-submenu">
                            <div class="modal-vertical-title">
                                <span>Documentación y visados más comunes</span>
                                <i class="fa-solid fa-angle-down modal-vertical-toggle-submenu"></i>
                            </div>
                            <ul class="modal-vertical-submenu">
                                <li class="modal-vertical-title"><a href="#">Opción 3</a></li>
                                <li class="modal-vertical-title"><a href="#">Opción 4</a></li>
                            </ul>
                        </li>
                        <li class="modal-vertical-item modal-vertical-has-submenu">
                            <div class="modal-vertical-title">
                                <span>Lo mas destacado</span>
                                <i class="fa-solid fa-angle-down modal-vertical-toggle-submenu"></i>
                            </div>
                            <ul class="modal-vertical-submenu">
                                <li class="modal-vertical-title"><a href="#">Opción 3</a></li>
                                <li class="modal-vertical-title"><a href="#">Opción 4</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>

            <div class="configurations-modal-vertical mt-4">Ajustes</div>
            <ul class="menu-list">
                <li id="openLanguageModal">
                    <i class="fa-solid fa-globe"></i> Español - ES
                </li>
                <li id="openCurrencyModal">
                    <i class="fa-solid fa-dollar-sign"></i> Peruvian Nuevo Sol
                </li>
            </ul>

            <button class="btn-login">Iniciar sesión</button>
        </div>
    </div>

    <!-- Modal vertical de selección de idioma -->
    <div id="languageModal" class="modal-vertical">
        <div class="modal-vertical-content">
            <button id="closeLanguageModal" class="modal-vertical-close"><i class="fa-solid fa-xmark"></i></button>
            <div class="modal-language-title">Selecciona tu idioma</div>
            <ul class="modal-vertical-languages">
                <li><i class="fa-solid fa-globe"></i> English</li>
                <li><i class="fa-solid fa-globe"></i> Español</li>
            </ul>
        </div>
    </div>

    <!-- Modal vertical de selección de divisa -->
    <div id="currencyModal" class="modal-vertical">
        <div class="modal-vertical-content">
            <button id="closeCurrencyModal" class="modal-vertical-close"><i class="fa-solid fa-xmark"></i></button>
            <div class="modal-language-title">Selecciona tu moneda</div>
            <ul class="modal-vertical-currencies">
                <li>English</li>
                <li>Español</li>
            </ul>
        </div>
    </div>

@yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <!-- Sección de Visas más solicitadas -->
                <div class="col-md-4">
                    <h5>
                        <button class="btn btn-link dropdown-toggle mobile-dropdown" type="button" data-bs-toggle="collapse" data-bs-target="#visasList" aria-expanded="false">
                            Visas más solicitadas
                        </button>
                        <span class="desktop-title">Visas más solicitadas</span>
                    </h5>
                    <ul class="list-unstyled collapse d-md-block" id="visasList">
                        <li><a href="{{route('canada-p-eta')}}">Canada ETA</a></li>
                        <li><a href="{{route('estados-unidos-p-esta')}}">Estados Unidos ESTA</a></li>
                        <li><a href="{{route('india-p-tourist-e-visa')}}">India eVISA</a></li>
                    </ul>
                </div>

                <!-- Sección de Blogs sobre viajes -->
                <div class="col-md-4">
                    <h5>
                        <button class="btn btn-link dropdown-toggle mobile-dropdown" type="button" data-bs-toggle="collapse" data-bs-target="#blogsList" aria-expanded="false">
                            Nuestros blogs sobre viajes
                        </button>
                        <span class="desktop-title">Nuestros blogs sobre viajes</span>
                    </h5>
                    <ul class="list-unstyled collapse d-md-block" id="blogsList">
                        <li><a href="#">Visa de Vietnam para Argentinos</a></li>
                        <li><a href="#">Requisitos y costos de la visa para Turquía</a></li>
                        <li><a href="#">¿Puedo visitar Canadá con una visa de EE. UU.?</a></li>
                        <li><a href="#">Visa EAU - Visa de tránsito para los Emiratos Árabes Unidos</a></li>
                        <li><a href="#">¿Puedo ir a México una Green Card?</a></li>
                    </ul>
                </div>

                <!-- Sección de la Empresa -->
                <div class="col-md-4">
                    <h5>
                        <button class="btn btn-link dropdown-toggle mobile-dropdown" type="button" data-bs-toggle="collapse" data-bs-target="#empresaList" aria-expanded="false">
                            Empresa
                        </button>
                        <span class="desktop-title">Empresa</span>
                    </h5>
                    <ul class="list-unstyled collapse d-md-block" id="empresaList">
                        <li><a href="{{route('about-us')}}">Sobre Visa Asesores</a></li>
                        <li><a href="{{route('contact')}}">Contáctate con nosotros</a></li>
                        <li><a href="#">Sitemap</a></li>
                    </ul>
                </div>
            </div>

            <!-- Redes Sociales -->
            <div class="text-center my-4">
                <h5>Conéctate con nosotros:</h5>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <!-- Línea divisoria -->
            <hr class="border-light">

            <!-- Sección inferior -->
            <div class="row text-center">
                <div class="col-md-6">
                    <p class="mb-0">© 2014-2025 Visa Asesores. Todos los derechos reservados.</p>
                    <p>
                        <a href="#">Condiciones del servicio</a> |
                        <a href="#">Política de privacidad</a>
                    </p>
                </div>
                <div class="col-md-6">
                    <p><i class="fas fa-phone"></i> +34 518 88 00 30</p>
                    <p>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/2/21/Flag_of_Spain.svg" width="20"> Español
                        | S/. PEN ▼
                    </p>
                    <!-- Botones de descarga -->
                    <div class="d-flex justify-content-center">
                        <a href="#" class="me-2">
                            <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" width="120">
                        </a>
                        <a href="#">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" width="135">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

@stack('js')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script>
    function logout() {
        fetch("/logout", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf()->token() }}" // Token CSRF
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert("✅ Sesión cerrada correctamente");
                window.location.href = "/iniciar-sesion"; // Redirigir al login
            } else {
                alert("❌ Error: " + data.message);
            }
        })
        .catch(error => {
            console.error("❌ Error inesperado: ", error);
            alert("❌ Ocurrió un error inesperado.");
        });
    }
    document.addEventListener("DOMContentLoaded", function () {
        // ===============================
        // 🔽 MANEJO DE DROPDOWN PRINCIPAL
        // ===============================
        document.querySelectorAll(".dropdown-toggle-custom").forEach((dropdownButton) => {
            const iconDown = dropdownButton.querySelector(".fa-angle-down");
            const iconUp = dropdownButton.querySelector(".fa-angle-up");

            dropdownButton.addEventListener("click", function () {
                const isExpanded = this.getAttribute("aria-expanded") === "true";

                // Alternar visibilidad de las flechas
                iconDown.hidden = isExpanded;
                iconUp.hidden = !isExpanded;
            });
        });

        // ===============================
        // 🔽 MANEJO DE SUBMENÚS INTERNOS
        // ===============================
        document.querySelectorAll(".sub-dropdown-toggle").forEach((toggle) => {
            toggle.addEventListener("click", function (e) {
                e.preventDefault();
                const parent = this.closest(".dropdown-submenu");
                const submenu = parent.querySelector(".submenu");
                const icon = this.querySelector(".sub-icon");

                // Alternar visibilidad del submenú
                submenu.classList.toggle("show");

                // Rotar la flecha de submenú
                icon.style.transform = submenu.classList.contains("show") ? "rotate(180deg)" : "rotate(0deg)";
            });
        });

        // ===============================
        // 🚫 EVITAR CIERRE AL CLICKEAR SUBMENÚ
        // ===============================
        document.querySelectorAll(".dropdown-menu").forEach((menu) => {
            menu.addEventListener("click", function (e) {
                e.stopPropagation();
            });
        });

        // ===============================
        // 🌍 ABRIR MODAL DE PAÍSES
        // ===============================
        const countryContainer = document.querySelector(".country-container");
        const countryModalElement = document.getElementById("countryModal");

        if (countryContainer && countryModalElement) {
            const countryModal = new bootstrap.Modal(countryModalElement);
            countryContainer.addEventListener("click", function () {
                countryModal.show();
            });
        }

        // ===============================
        // 📜 MENÚ LATERAL (ABRIR / CERRAR)
        // ===============================
        const menuToggle = document.getElementById("menuToggle");
        const sideMenu = document.getElementById("sideMenu");
        const closeMenu = document.getElementById("closeMenu");

        if (menuToggle && sideMenu && closeMenu) {
            // Abrir menú
            menuToggle.addEventListener("click", function () {
                sideMenu.classList.add("show");
            });

            // Cerrar menú
            closeMenu.addEventListener("click", function () {
                sideMenu.classList.remove("show");
            });

            // Cerrar menú al hacer clic fuera
            document.addEventListener("click", function (event) {
                if (!sideMenu.contains(event.target) && !menuToggle.contains(event.target)) {
                    sideMenu.classList.remove("show");
                }
            });
        }

        // ===============================
        // 🔽 MENÚ VERTICAL CON SUBMENÚS
        // ===============================
        document.querySelectorAll(".modal-vertical-title").forEach(item => {
            item.addEventListener("click", function () {
                const parent = this.parentElement;
                const submenu = parent.querySelector(".modal-vertical-submenu");

                if (submenu) {
                    const isActive = parent.classList.contains("active");

                    // Cerrar todos los submenús hermanos
                    parent.parentElement.querySelectorAll(".modal-vertical-item.active").forEach(el => {
                        el.classList.remove("active");
                        el.querySelector(".modal-vertical-submenu").style.display = "none";
                    });

                    // Alternar el submenú actual
                    parent.classList.toggle("active", !isActive);
                    submenu.style.display = isActive ? "none" : "block";
                }
            });
        });


    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const openLanguageModal = document.getElementById("openLanguageModal");
        const closeLanguageModal = document.getElementById("closeLanguageModal");
        const languageModal = document.getElementById("languageModal");

        if (openLanguageModal && closeLanguageModal && languageModal) {
            openLanguageModal.addEventListener("click", function () {
                languageModal.classList.add("show");
            });

            closeLanguageModal.addEventListener("click", function () {
                languageModal.classList.remove("show");
            });

            // Cerrar modal si se hace clic fuera del contenido
            document.addEventListener("click", function (event) {
                if (!languageModal.contains(event.target) && !openLanguageModal.contains(event.target)) {
                    languageModal.classList.remove("show");
                }
            });
        }
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const openCurrencyModal = document.getElementById("openCurrencyModal");
        const closeCurrencyModal = document.getElementById("closeCurrencyModal");
        const currencyModal = document.getElementById("currencyModal");

        if (openCurrencyModal && closeCurrencyModal && currencyModal) {
            openCurrencyModal.addEventListener("click", function () {
                currencyModal.classList.add("show");
            });

            closeCurrencyModal.addEventListener("click", function () {
                currencyModal.classList.remove("show");
            });

            // Cerrar modal si se hace clic fuera del contenido
            document.addEventListener("click", function (event) {
                if (!currencyModal.contains(event.target) && !openCurrencyModal.contains(event.target)) {
                    currencyModal.classList.remove("show");
                }
            });
        }
    });
</script>
</body>
</html>


