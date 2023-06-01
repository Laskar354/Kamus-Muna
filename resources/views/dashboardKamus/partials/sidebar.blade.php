<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Request::is("dashboardKamus") ? "active text-warning": "text-light" }}" aria-current="page" href="/dashboardKamus">
                <span data-feather="grid" class="text-warning"></span>
                Dashboard Kamus
                </a>
            </li>
        </ul>
    </div>
</nav>