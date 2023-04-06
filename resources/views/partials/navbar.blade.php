<nav class="navbar navbar-expand-sm" id="neubar">
    <div class="container">
        <a class="navbar-brand" href="#"><img src="/img/sambirejo.jpg" height="50" /></a>

        <div class=" collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav m-auto ">
            <li class="nav-item">
            <a class="nav-link mx-2 {{Request::is("/") ? 'active' : ''}}" aria-current="page" href="/">Kamus</a>
            </li>
            <li class="nav-item">
            <a class="nav-link mx-2 {{Request::is("translate") ? 'active' : ''}}" href="/translate">Terjemahan</a>
            </li>
            <li class="nav-item">
            <a class="nav-link mx-2 {{Request::is("about") ? 'active' : ''}}" href="/about">About Us</a>
            </li>
            {{-- <li class="nav-item dropdown">
            <a class="nav-link mx-2 dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Company
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item" href="#">Blog</a></li>
                <li><a class="dropdown-item" href="#">About Us</a></li>
                <li><a class="dropdown-item" href="#">Contact us</a></li>
            </ul>
            </li> --}}
        </ul>
        </div>
    </div>
</nav>