<nav class="navbar top-navbar navbar-expand-lg">
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-hamburger">
            <i class="fas fa-bars"></i>
        </button>
        <a class="navbar-brand ml-3" href="#">GymApp</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                @auth
                    <li class="nav-item">
                        <span class="nav-link">Bienvenido, {{ auth()->user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">Cerrar sesión</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
