<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="neubar">
    <div class="container">
        <h1 class="navbar-brand text-decoration-none" href="#">Kamus Indonesia - Muna</h1>

        <div class=" collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav m-auto">
            <li class="nav-item">
            <a class="nav-link mx-2 {{Request::is("translate") || Request::is("/") ? 'active' : ''}}" href="/translate">Kamus & Terjemahan</a>
            </li>
            <li class="nav-item">
            <a class="nav-link mx-2 {{Request::is("tentang") ? 'active' : ''}}" href="/tentang">Tentang-Kami</a>
            </li>
        </ul>
        @auth
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown ">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Hallo, {{ auth()->user()->name }}
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="/dashboardKamus">Dashboard</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <form action="/translate/logoutAdmin" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item">Log-out</button>
                    </form>
                </ul>
            </li>
        </ul>
        @endauth
        </div>
    </div>
</nav>