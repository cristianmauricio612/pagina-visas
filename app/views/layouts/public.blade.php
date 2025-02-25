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
<body>
    <div class="header">
        <div class="header-container">
            <div class="logo-container">
                <img src="{{ assets("img/av.png") }}" alt="" style="height: 32px">
                <span>Visa Asesores</span>
            </div>

            <div class="menu-container">
                <nav class="nav-container">
                    <div class="dropdown">
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
                                    <li><a class="dropdown-item" href="#">Opción 1</a></li>
                                    <li><a class="dropdown-item" href="#">Opción 2</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item sub-dropdown-toggle" href="#">Documentación y visados más comunes
                                    <i class="fa-solid fa-angle-down sub-icon"></i>
                                </a>
                                <ul class="submenu">
                                    <li><a class="dropdown-item" href="#">Opción 3</a></li>
                                    <li><a class="dropdown-item" href="#">Opción 4</a></li>
                                </ul>
                            </li>
                            <li><a class="dropdown-item" href="#">Lo más destacado</a></li>
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
                                    <li><a class="dropdown-item" href="#">Opción 1</a></li>
                                    <li><a class="dropdown-item" href="#">Opción 2</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item sub-dropdown-toggle" href="#">Documentación y visados más comunes
                                    <i class="fa-solid fa-angle-down sub-icon"></i>
                                </a>
                                <ul class="submenu">
                                    <li><a class="dropdown-item" href="#">Opción 3</a></li>
                                    <li><a class="dropdown-item" href="#">Opción 4</a></li>
                                </ul>
                            </li>
                            <li><a class="dropdown-item" href="#">Lo más destacado</a></li>
                        </ul>
                    </div>
                </nav>
                <div class="country-container ms-4">
                    <span>ES</span>
                    <span class="mx-2 vr" style="height: 16px; margin-top: 2px;"></span>
                    <span>S/. PEN</span>
                </div>
                <div class="ms-4">
                    <a href="">
                        <button class="button-login">Iniciar sesión</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

@yield('content')
@stack('js')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Manejar el cambio de flecha en todos los dropdowns
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

        // Manejar los submenús sin cerrar el dropdown principal
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

        // Evitar que el menú principal se cierre al hacer clic en un submenú
        document.querySelectorAll(".dropdown-menu").forEach((menu) => {
            menu.addEventListener("click", function (e) {
                e.stopPropagation();
            });
        });
    });
</script>
</body>
</html>


