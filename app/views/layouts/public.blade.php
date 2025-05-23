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
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('resources')
</head>
@php
    $usuario = session()->get('usuario');
@endphp

<body>
    <div class="header" id="principal-nav">
        <div class="header-container">
            <a href="/" class="logo-container nav-link">
                <img src="{{ assets("img/visas_travel_logo.png") }}" alt="" style="height: 50px">
            </a>

            <div class="menu-container">
                <nav class="nav-container">
                    <a href="/" class="nav-link">
                        <span class="dropdown-custom dropdown-toggle-custom">Inicio</span>
                    </a>
                    <a href="/about-us" class="nav-link ms-4">
                        <span class="dropdown-custom dropdown-toggle-custom">Nosotros</span>
                    </a>
                    <a href="/blog" class="nav-link ms-4">
                        <span class="dropdown-custom dropdown-toggle-custom">Blog</span>
                    </a>
                    <a href="/contact" class="nav-link ms-4">
                        <span class="dropdown-custom dropdown-toggle-custom">Contactanos</span>
                    </a>
                </nav>
                <div class="country-container ms-4">
                    <span>ES</span>
                    <span class="mx-2 vr" style="height: 16px; margin-top: 2px;"></span>
                    <span>$ USD</span>
                </div>
                @if (!$usuario)
                    <div class="ms-4">
                        <a href="{{route('iniciar-sesion')}}">
                            <button class="button-login">Iniciar sesión</button>
                        </a>
                    </div>
                @else
                    <div class="dropdown ms-4">
                        <span class="dropdown-custom dropdown-toggle-custom" data-bs-toggle="dropdown"
                            aria-expanded="false">
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
                                <a class="dropdown-item" href="{{route('account-mis-pedidos')}}">Mis pedidos
                                </a>
                            </li>
                            <hr>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item" style="cursor: pointer" onclick="logout()">Cerrar Sesion
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
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="currencySelect" class="form-label">Divisa</label>
                            <select class="form-select" id="currencySelect">
                                <option selected>USD $</option>
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
                <li class="modal-vertical-item modal-vertical-has-submenu">
                    <a href="/" class="nav-link">
                        <span class="dropdown-custom dropdown-toggle-custom">Inicio</span>
                    </a>
                </li>

                <li class="modal-vertical-item modal-vertical-has-submenu mt-3">
                    <a href="/about-us" class="nav-link">
                        <span class="dropdown-custom dropdown-toggle-custom">Nosotros</span>
                    </a>
                </li>

                <li class="modal-vertical-item modal-vertical-has-submenu mt-3">
                    <a href="/blog" class="nav-link">
                        <span class="dropdown-custom dropdown-toggle-custom">Blog</span>
                    </a>
                </li>

                <li class="modal-vertical-item modal-vertical-has-submenu mt-3">
                    <a href="/contact" class="nav-link">
                        <span class="dropdown-custom dropdown-toggle-custom">Contactanos</span>
                    </a>
                </li>
            </ul>

            <div class="configurations-modal-vertical mt-4">Ajustes</div>
            <ul class="menu-list">
                <li id="openLanguageModal">
                    <i class="fa-solid fa-globe"></i> Español - ES
                </li>
                <li id="openCurrencyModal">
                    <i class="fa-solid fa-dollar-sign"></i> United States Dollar
                </li>
            </ul>
            @if (!$usuario)
                <a href="{{route('iniciar-sesion')}}">
                    <button class="btn-login">Iniciar sesión</button>
                </a>
            @else
                <button class="btn-login" onclick="logout()">Cerrar sesión</button>
            @endif


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

    <!-- Footer con Tailwind CSS -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-6xl mx-auto mb-8 px-4">
            <!-- Sección de logotipos superior -->
            <div class="mx-auto px-4 flex flex-col sm:flex-row justify-between items-center mb-8 gap-4 md:gap-8">
                <div class="w-1/3">
                    <img src="{{ assets('img/visas_travel_logo.png') }}" alt="Visas Travel" class="h-16" />
                </div>
                <div class="md:w-2/3 flex md:justify-end space-x-8">
                    <div>
                        <img src="{{ assets('img/camara_de_comercio.png') }}" alt="Cámara de Comercio de Lima" class="h-14" onerror="this.src='https://www.camaralima.org.pe/wp-content/uploads/2020/07/ccl_logo.png'; this.onerror=null;" />
                    </div>
                    <div>
                        <img src="{{ assets('img/ministerio_de_comercio_exterior_y_turismo.png') }}" alt="Ministerio de Comercio Exterior y Turismo" class="h-14" onerror="this.src='https://cdn.www.gob.pe/uploads/document/file/505717/mincetur_logo.png'; this.onerror=null;" />
                    </div>
                </div>
            </div>

            <!-- Contenido principal del footer -->
            <div class="mx-auto px-4 grid grid-cols-1 md:grid-cols-4 md:gap-4 gap-6">
                <!-- Columna 1: Información de contacto -->
                <div class="space-y-2 md:!text-left text-center text-xl md:text-base">
                    <p class="font-medium">Calle Monitor Huascar 165</p>
                    <p class="font-medium">Santiago de Surco</p>
                    <p class="font-medium">Lima, Perú</p>

                    <!-- Iconos de redes sociales -->
                    <div class="flex md:justify-start justify-center space-x-2 mt-4">
                        <a href="#" class="bg-red-600 hover:bg-red-700 rounded-full p-2 inline-flex items-center justify-center w-8 h-8">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="bg-red-600 hover:bg-red-700 rounded-full p-2 inline-flex items-center justify-center w-8 h-8">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="bg-red-600 hover:bg-red-700 rounded-full p-2 inline-flex items-center justify-center w-8 h-8">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="#" class="bg-red-600 hover:bg-red-700 rounded-full p-2 inline-flex items-center justify-center w-8 h-8">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <div class="col-span-2 w-full mx-auto grid grid-cols-2 md:gap-4 gap-6">
                    <!-- Columna 2: Botones de contacto y reclamos -->
                    <div class="space-y-4">
                        <a href="tel:+51923647947" class="text-white px-4 flex items-center">
                            <div class="bg-red-600 rounded-full flex items-center justify-center w-8 h-8 mr-3">
                                <i class="fas fa-phone text-white"></i>
                            </div>
                            <span class="uppercase font-bold text-xl md:text-base">LLÁMANOS</span>
                        </a>

                        <a href="mailto:contacto@visastraveltours.com" class="text-white px-4 flex items-center">
                            <div class="bg-red-600 rounded-full flex items-center justify-center w-8 h-8 mr-3">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                            <span class="uppercase font-bold text-xl md:text-base">ESCRÍBENOS</span>
                        </a>

                        <a href="{{route('libro-reclamaciones')}}" class="text-white px-4 flex items-center">
                            <div class="flex-shrink-0">
                                <img src="{{ assets('img/libro_de_reclamaciones.jpg') }}" alt="Libro de Reclamaciones" class="h-16 sm:h-18 rounded-xl"/>
                            </div>
                        </a>
                    </div>

                    <!-- Columna 3: Enlaces -->
                    <div>
                        <h3 class="font-bold md:text-xl text-2xl mb-3">Enlaces</h3>
                        <ul class="space-y-2">
                            <li><a href="/" class="hover:text-red-400 text-xl md:text-base">INICIO</a></li>
                            <li><a href="/about-us" class="hover:text-red-400 text-xl md:text-base">NOSOTROS</a></li>
                            <li><a href="/blog" class="hover:text-red-400 text-xl md:text-base">BLOG</a></li>
                            <li><a href="/contact" class="hover:text-red-400 text-xl md:text-base">CONTACTO</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Columna 4: Mapa -->
                <div>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3900.8356217684604!2d-77.00781908509946!3d-12.126869891407335!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c7e2b04d70b7%3A0x60c9d537af0c98e6!2sVisas%20Travel%20-%20Tr%C3%A1mites%20de%20Visas!5e0!3m2!1ses-419!2spe!4v1653332342217!5m2!1ses-419!2spe" class="w-full h-40 rounded" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <!-- Descripción -->
            <div class="mx-auto px-4 text-center my-6">
                <p class="text-sm">Más que una VISA, es ir por lo que amas. Somos una organización que brinda asesoramiento a nuestros clientes en la obtención de la Visa a los USA, Canadá, Reino Unido, Australia, Nueva Zelanda, China, India, Japón.</p>
            </div>

            <!-- Línea divisoria -->
            <hr class="border-gray-700 my-4 mx-4">

            <!-- Footer inferior con copyright y políticas -->
            <div class="mx-auto px-4 text-center text-xs text-gray-400">
                <p>© 2010 - 2024 Visas Travel & tours Todos los derechos reservados</p>
                <div class="flex justify-center space-x-4 mt-1">
                    <a href="#" class="hover:text-white">POLÍTICAS DE PRIVACIDAD Y PROTECCIÓN DE DATOS</a>
                    <a href="#" class="hover:text-white">DESCARGO DE RESPONSABILIDADES</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('js')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
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

            document.addEventListener("click", function (event) {
                document.querySelectorAll(".dropdown-toggle-custom").forEach((dropdownButton) => {
                    const dropdownMenu = dropdownButton.nextElementSibling;
                    const iconDown = dropdownButton.querySelector(".fa-angle-down");
                    const iconUp = dropdownButton.querySelector(".fa-angle-up");

                    if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                        dropdownButton.setAttribute("aria-expanded", "false");
                        dropdownMenu.classList.remove("show");

                        // Restaurar iconos
                        iconDown.hidden = false;
                        iconUp.hidden = true;
                    }
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
