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
<div class="bg-body-tertiary">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Brand</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav"  aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="main_nav">
                <ul class="navbar-nav">
                    <li class="nav-item active"> <a class="nav-link" href="#">Home </a> </li>
                    <li class="nav-item"><a class="nav-link" href="#"> About </a></li>
                    <li class="nav-item dropdown" id="myDropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">  Treeview menu  </a>
                        <ul class="dropdown-menu">
                            <li> <a class="dropdown-item" href="#"> Dropdown item 1 </a></li>
                            <li> <a class="dropdown-item" href="#"> Dropdown item 2 &raquo; </a>
                                <ul class="submenu dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Submenu item 1</a></li>
                                    <li><a class="dropdown-item" href="#">Submenu item 2</a></li>
                                    <li><a class="dropdown-item" href="#">Submenu item 3 &raquo; </a>
                                        <ul class="submenu dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Multi level 1</a></li>
                                            <li><a class="dropdown-item" href="#">Multi level 2</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Submenu item 4</a></li>
                                    <li><a class="dropdown-item" href="#">Submenu item 5</a></li>
                                </ul>
                            </li>
                            <li><a class="dropdown-item" href="#"> Dropdown item 3 </a></li>
                            <li><a class="dropdown-item" href="#"> Dropdown item 4 </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- navbar-collapse.// -->
        </div>
        <!-- container-fluid.// -->
    </nav>
</div>


@yield('content')
@stack('js')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script>
    document.addEventListener("DOMContentLoaded", function(){
// make it as accordion for smaller screens
        if (window.innerWidth < 992) {

            // close all inner dropdowns when parent is closed
            document.querySelectorAll('.navbar .dropdown').forEach(function(everydropdown){
                everydropdown.addEventListener('hidden.bs.dropdown', function () {
                    // after dropdown is hidden, then find all submenus
                    this.querySelectorAll('.submenu').forEach(function(everysubmenu){
                        // hide every submenu as well
                        everysubmenu.style.display = 'none';
                    });
                })
            });

            document.querySelectorAll('.dropdown-menu a').forEach(function(element){
                element.addEventListener('click', function (e) {
                    let nextEl = this.nextElementSibling;
                    if(nextEl && nextEl.classList.contains('submenu')) {
                        // prevent opening link if link needs to open dropdown
                        e.preventDefault();
                        if(nextEl.style.display == 'block'){
                            nextEl.style.display = 'none';
                        } else {
                            nextEl.style.display = 'block';
                        }

                    }
                });
            })
        }
// end if innerWidth
    });
</script>
</body>
</html>


