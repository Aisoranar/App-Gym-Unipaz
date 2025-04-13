<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <!-- Aseguramos un comportamiento responsive -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GymApp - @yield('title')</title>

  <!-- Archivo CSS principal -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <!-- Incluye FontAwesome para los íconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- Bootstrap Bundle JS (incluye Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-HoA1X6VjOeiBQ8tM0Hn7GZ0eU56fnq9Y4GEqAXe1l49QK3HiT0S6HDy8Fq1GL4G9" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Estilos en línea: Mobile-first, variables y transiciones -->
  <style>
    :root {
      --primary-color: #003379;
      --primary-light: #0056a8;
      --secondary-color: #fff;
      --text-color: #333;
      --bg-color: #f0f2f5;
      --sidebar-width: 250px;
      --sidebar-collapsed: 70px;
    }
    *, *::before, *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      background: var(--bg-color);
      color: var(--text-color);
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
    }

    /* --------------------------------- */
    /* Sidebar: Para mobile, queda oculto por defecto y se muestra al togglear (con la clase mobile-active) */
    /* --------------------------------- */
    #sidebar {
      position: fixed;
      top: 0;
      left: -100%;
      width: var(--sidebar-width);
      height: 100vh;
      background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-light) 100%);
      color: var(--secondary-color);
      transition: all 0.3s ease;
      overflow-y: auto;
      box-shadow: 2px 0 15px rgba(0, 0, 0, 0.2);
      z-index: 1500;
    }
    /* Cuando se activa en móvil */
    #sidebar.mobile-active {
      left: 0;
    }
    /* En escritorio el sidebar se muestra siempre */
    @media (min-width: 768px) {
      #sidebar {
        left: 0;
      }
    }
    /* Estado colapsado (para escritorio) */
    #sidebar.collapsed {
      width: var(--sidebar-collapsed);
    }

    /* Header del Sidebar */
    #sidebar .sidebar-header {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem 1rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }
    #sidebar .sidebar-header i {
      font-size: 1.8rem;
      margin-right: 0.5rem;
    }
    #sidebar .sidebar-header span {
      font-size: 1.2rem;
      font-weight: bold;
      transition: opacity 0.3s ease;
    }
    /* Oculta el texto del header al colapsar (en escritorio) */
    #sidebar.collapsed .sidebar-header span {
      opacity: 0;
      visibility: hidden;
    }

    /* Opciones del menú */
    #sidebar ul.components {
      list-style: none;
      padding: 1rem 0;
    }
    #sidebar ul li {
      margin: 0.3rem 0;
    }
    #sidebar ul li a {
      display: flex;
      align-items: center;
      padding: 0.9rem 1.5rem;
      color: rgba(255, 255, 255, 0.9);
      text-decoration: none;
      font-size: 1rem;
      border-radius: 4px;
      transition: all 0.3s ease;
      margin: 0 0.5rem;
    }
    #sidebar ul li a:hover,
    #sidebar ul li a:focus {
      background: rgba(255, 255, 255, 0.2);
      color: var(--secondary-color);
    }
    #sidebar ul li a i {
      min-width: 25px;
      text-align: center;
      font-size: 1.2rem;
      margin-right: 1rem;
      transition: transform 0.3s ease;
    }
    #sidebar ul li a:hover i,
    #sidebar ul li a:focus i {
      transform: scale(1.1) rotate(5deg);
    }
    .menu-text {
      transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    /* Oculta texto en estado colapsado (escritorio) */
    #sidebar.collapsed .menu-text {
      opacity: 0;
      visibility: hidden;
    }
    /* Estilos para el submenu */
.submenu {
  list-style: none;
  margin: 0;
  padding: 0;
  display: none; /* oculto por defecto */
  background-color: #112240;
}

li:hover > .submenu {
  display: block; /* se muestra al posicionarse sobre el elemento padre */
}

.submenu li {
  margin: 0;
}

.submenu li a {
  display: block;
  padding: 0.5rem 1rem;
  color: var(--white);
  text-decoration: none;
}

.submenu li a:hover {
  background-color: #64ffda;
  color: var(--bg-dark);
}

    /* --------------------------------- */
    /* Top Navbar: Mobile-first */
    /* --------------------------------- */
    .top-navbar {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 60px;
      background: var(--secondary-color);
      border-bottom: 1px solid #e0e0e0;
      display: flex;
      align-items: center;
      padding: 0 1.5rem;
      z-index: 1600;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .top-navbar .btn-hamburger {
      background: none;
      border: none;
      font-size: 1.8rem;
      color: var(--text-color);
      margin-right: 1rem;
      cursor: pointer;
      transition: transform 0.3s ease;
    }
    .top-navbar .btn-hamburger:hover {
      transform: rotate(90deg);
    }
    .top-navbar h4 {
      font-size: 1.3rem;
      color: var(--text-color);
      margin: 0;
    }
    .top-navbar .logout-form button {
      border: none;
      background: none;
      color: red;
      font-weight: bold;
      cursor: pointer;
    }

    /* --------------------------------- */
    /* Contenido Principal: Mobile-first */
    /* --------------------------------- */
    #content {
      margin-top: 60px;
      padding: 1.5rem;
      transition: margin-left 0.3s ease;
    }
    @media (min-width: 768px) {
      #content {
        margin-left: var(--sidebar-width);
      }
      /* Si el sidebar está colapsado (desktop), ajustar el contenido */
      #sidebar.collapsed ~ #content {
        margin-left: var(--sidebar-collapsed);
      }
    }

    /* --------------------------------- */
    /* Footer de mobile (Mobile Tabs) */
    /* --------------------------------- */
    .mobile-tabs {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      background: var(--secondary-color);
      border-top: 1px solid #ddd;
      display: flex;
      justify-content: space-around;
      padding: 0.7rem 0;
      z-index: 1500;
    }
    .mobile-tabs a {
      color: var(--primary-color);
      font-size: 1.4rem;
      transition: transform 0.3s ease;
    }
    .mobile-tabs a:hover {
      transform: translateY(-3px);
    }

    /* --------------------------------- */
    /* Media Queries: Desktop */
    /* --------------------------------- */
    @media (min-width: 768px) {
      /* Oculta el botón de móvil en desktop */
      #mobileToggle {
        display: none;
      }
      /* Muestra el botón para colapsar/expandir el sidebar en escritorio */
      .top-navbar .desktop-toggle {
        display: inline-block;
        margin-right: 1rem;
        font-size: 1.8rem;
        cursor: pointer;
        color: var(--text-color);
        transition: transform 0.3s ease;
      }
      .top-navbar .desktop-toggle:hover {
        transform: rotate(90deg);
      }
      /* Oculta el Mobile Tabs en escritorio */
      .mobile-tabs {
        display: none;
      }
    }

    @yield('styles')
  </style>
</head>
<body>
  @php
    // Se obtiene el nombre de la ruta actual.
    $currentRoute = Route::currentRouteName();
  @endphp

  @if(!in_array($currentRoute, ['login', 'register']))
    <!-- Sidebar: Menú lateral -->
    <nav id="sidebar" aria-label="Menú de navegación">
      <div class="sidebar-header">
        <i class="fas fa-dumbbell" aria-hidden="true"></i>
        <span>Menú</span>
      </div>
      <ul class="components">
        <li>
          <a href="{{ route('fichas.index') }}">
            <i class="fas fa-file-medical" aria-hidden="true"></i>
            <span class="menu-text">Ficha Médica</span>
          </a>
        </li>
        <li>
          <a href="{{ route('ejercicios.index') }}">
            <i class="fas fa-dumbbell" aria-hidden="true"></i>
            <span class="menu-text">Ejercicios</span>
          </a>
        </li>
        <li>
          <a href="{{ route('recomendaciones.index') }}">
            <i class="fas fa-notes-medical" aria-hidden="true"></i>
            <span class="menu-text">Recomendaciones</span>
          </a>
        </li>
        <li>
          <a href="{{ route('rutinas.index') }}">
            <i class="fas fa-running" aria-hidden="true"></i>
            <span class="menu-text">Rutinas</span>
          </a>
        </li>
        <li>
          <a href="{{ route('planes.index') }}">
            <i class="fas fa-apple-alt" aria-hidden="true"></i>
            <span class="menu-text">Plan Nutricional</span>
          </a>
        </li>

        <li>
          <a href="{{ route('clases.index') }}">
            <i class="fas fa-chalkboard-teacher" aria-hidden="true"></i>
            <span class="menu-text">Clases</span>
          </a>
          <ul class="submenu">
            <li>
              <a href="{{ route('clases.index') }}">Lista de Clases</a>
            </li>
            <li>
              <a href="{{ route('clases.historial') }}">Historial de Clases</a>
            </li>
          </ul>
        </li>


        <li>
          <a href="{{ route('asistencias.calendario') }}">
            <i class="fas fa-calendar-check" aria-hidden="true"></i>
            <span class="menu-text">Calendario Gym</span>
          </a>
        </li>
      </ul>
    </nav>

    <!-- Contenido Principal -->
    <div id="content">
      <nav class="top-navbar d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <!-- Botón para móviles: muestra/oculta el sidebar móvil -->
          <button type="button" id="mobileToggle" class="btn-hamburger" aria-label="Abrir menú">
            <i class="fas fa-bars"></i>
          </button>
          <!-- Botón para escritorio: colapsar/expandir el sidebar -->
          <span id="desktopToggle" class="desktop-toggle" aria-label="Colapsar menú">
            <i class="fas fa-angle-double-left"></i>
          </span>
          <h4 class="mb-0">GymApp</h4>
        </div>
        @if(Auth::check())
          <div class="logout-form">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit">Cerrar Sesión</button>
            </form>
          </div>
        @endif
      </nav>

      <div class="container" style="padding-top: 1rem;">
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
      </div>
    </div>

    <!-- Footer para móviles (Mobile Tabs) -->
    <div class="mobile-tabs d-md-none">
      <a href="{{ route('fichas.index') }}"><i class="fas fa-user"></i></a>
      <a href="{{ route('ejercicios.index') }}"><i class="fas fa-dumbbell"></i></a>
      <a href="{{ route('rutinas.index') }}"><i class="fas fa-running"></i></a>
      <a href="{{ route('asistencias.calendario') }}"><i class="fas fa-calendar-alt"></i></a>
    </div>
  @else
    <!-- Si la ruta es login o register, se omite el menú -->
    <div class="container" style="padding-top: 1rem;">
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @yield('content')
    </div>
  @endif

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script>
    // Función para gestionar el botón de desktop según ancho
    function updateDesktopToggle() {
      var desktopToggle = document.getElementById('desktopToggle');
      if(window.innerWidth >= 768){
        desktopToggle.style.display = 'inline-block';
      } else {
        desktopToggle.style.display = 'none';
      }
    }
    window.addEventListener('resize', updateDesktopToggle);
    updateDesktopToggle();

    // Toggle para móviles: alterna la clase "mobile-active" para mostrar u ocultar el sidebar
    document.getElementById('mobileToggle').addEventListener('click', function(e) {
      var sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('mobile-active');
      e.stopPropagation();
    });

    // Toggle para escritorio: colapsa o expande el sidebar (añadiendo la clase collapsed)
    document.getElementById('desktopToggle').addEventListener('click', function() {
      var sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('collapsed');
      var icon = this.querySelector('i');
      if(sidebar.classList.contains('collapsed')){
        icon.classList.remove('fa-angle-double-left');
        icon.classList.add('fa-angle-double-right');
      } else {
        icon.classList.remove('fa-angle-double-right');
        icon.classList.add('fa-angle-double-left');
      }
    });

    // Ocultar el sidebar móvil al hacer clic fuera (solo si tiene la clase mobile-active)
    document.addEventListener('click', function(e) {
      var sidebar = document.getElementById('sidebar');
      if(sidebar && sidebar.classList.contains('mobile-active')){
        if(!sidebar.contains(e.target) && !document.getElementById('mobileToggle').contains(e.target)) {
          sidebar.classList.remove('mobile-active');
        }
      }
    });

    // Oculta el sidebar móvil al hacer clic en alguno de sus enlaces
    document.querySelectorAll('#sidebar ul li a').forEach(function(link) {
      link.addEventListener('click', function() {
        if(document.getElementById('sidebar').classList.contains('mobile-active')) {
          document.getElementById('sidebar').classList.remove('mobile-active');
        }
      });
    });
  </script>
  @yield('scripts')
</body>
</html>
