<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <!-- Aseguramos un comportamiento responsive -->
 <meta name="viewport" content="width=device-width, initial-scale=1">
<title>GymApp - @yield('title')</title>

<!-- Archivo CSS principal (desactivado - no existe) -->
<!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1/font/bootstrap-icons.css" rel="stylesheet">

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />

<!-- FullCalendar estilos -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

  @yield('styles')

  <!-- Estilos en línea: variables y transiciones -->
  <style>
    :root { --primary-color: #003379; --primary-light: #0056a8; --secondary-color: #fff; --text-color: #333; --bg-color: #f0f2f5; --sidebar-width: 250px; --sidebar-collapsed: 70px; }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background: var(--bg-color); color: var(--text-color); line-height: 1.6; }
    /* Sidebar móvil y escritorio */
    #sidebar { position: fixed; top: 0; left: -100%; width: var(--sidebar-width); height: 100vh; background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-light) 100%); color: var(--secondary-color); transition: left 0.3s ease; overflow-y: auto; z-index: 1500; }
    #sidebar.mobile-active { left: 0; }
    @media (min-width: 768px) { #sidebar { left: 0; } }
    #sidebar.collapsed { width: var(--sidebar-collapsed); }
    /* Header del Sidebar */
    #sidebar .sidebar-header { display: flex; align-items: center; justify-content: center; padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.2); }
    #sidebar .sidebar-header i { margin-right: 0.5rem; font-size: 1.8rem; }
    #sidebar .sidebar-header span { font-size: 1.2rem; transition: opacity 0.3s ease; }
    #sidebar.collapsed .sidebar-header span { opacity: 0; visibility: hidden; }
    /* Menú */
    #sidebar ul.components { list-style: none; padding: 1rem 0; padding-bottom: 80px; }
    #sidebar ul li { margin: 0.3rem 0; }
    #sidebar ul li a { display: flex; align-items: center; padding: 0.9rem 1.5rem; color: rgba(255,255,255,0.9); text-decoration: none; border-radius: 4px; transition: background 0.3s; }
    #sidebar ul li a:hover { background: rgba(255,255,255,0.2); }
    #sidebar ul li a i { margin-right: 1rem; }
    .menu-text { transition: opacity 0.3s; }
    #sidebar.collapsed .menu-text { opacity: 0; visibility: hidden; }
    /* Submenú */
    .submenu { list-style: none; display: none; background: #112240; }
    li:hover > .submenu { display: block; }
    .submenu li a { padding: 0.5rem 1rem; color: #fff; text-decoration: none; }
    /* Top navbar */
    .top-navbar { position: fixed; top: 0; width: 100%; height: 60px; background: var(--secondary-color); border-bottom: 1px solid #e0e0e0; display: flex; align-items: center; padding: 0 1.5rem; z-index: 1600; }
    .top-navbar .btn-hamburger { background: none; border: none; font-size: 1.8rem; color: var(--text-color); margin-right: 1rem; display: inline-block; }
    .top-navbar .desktop-toggle { display: none; font-size: 1.8rem; margin-right: 1rem; cursor: pointer; transition: transform 0.3s; }
    @media (min-width: 768px) { .top-navbar .desktop-toggle { display: inline-block; } }

    /* Navbar Brand - Logo GymApp */
    .navbar-brand {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      text-decoration: none;
      transition: all 0.3s ease;
      padding: 0.25rem 0.5rem;
      border-radius: 8px;
    }

    .navbar-brand:hover {
      background: rgba(0, 51, 121, 0.05);
      transform: translateY(-1px);
    }

    .navbar-brand:hover .brand-text {
      color: var(--color-primary);
    }

    .navbar-brand:hover .brand-icon {
      transform: scale(1.1);
      color: var(--color-primary);
    }

    .brand-icon {
      font-size: 1.6rem;
      color: var(--color-primary);
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
    }

    .brand-icon i {
      filter: drop-shadow(0 2px 4px rgba(0, 51, 121, 0.2));
    }

    .brand-text {
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--color-primary);
      letter-spacing: -0.5px;
      transition: all 0.3s ease;
    }

    /* User name in navbar */
    .user-name {
      font-size: 0.85rem;
      max-width: 120px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    /* Logout button */
    .btn-outline-danger {
      border-radius: 6px;
      font-size: 0.8rem;
      padding: 0.375rem 0.75rem;
      transition: all 0.2s ease;
    }

    .btn-outline-danger:hover {
      transform: translateY(-1px);
      box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
    }
    /* Contenido */
    #content { margin-top: 60px; padding: 1.5rem; transition: margin-left 0.3s; }
    @media (min-width: 768px) { #content { margin-left: var(--sidebar-width); } #sidebar.collapsed ~ #content { margin-left: var(--sidebar-collapsed); } }
    /* Footer móvil */
    .mobile-tabs { position: fixed; bottom: 0; width: 100%; background: var(--secondary-color); border-top: 1px solid #ddd; display: flex; justify-content: space-around; padding: 0.7rem 0; z-index: 1500; }
    .mobile-tabs a { color: var(--primary-color); font-size: 1.4rem; }
    @media (min-width: 768px) { .mobile-tabs { display: none; } }
  </style>
</head>
<body>
  @php $currentRoute = Route::currentRouteName(); @endphp

  @if(!in_array($currentRoute, ['login','register']))
    <!-- Sidebar -->
    <nav id="sidebar">
  <div class="sidebar-header">
    <i class="fas fa-dumbbell"></i>
    <span>Menú</span>
  </div>
  <ul class="components">
    <li><a href="{{ route('fichas.index') }}"><i class="fas fa-file-medical"></i><span class="menu-text">Ficha Médica</span></a></li>
    <li><a href="{{ route('ejercicios.index') }}"><i class="fas fa-dumbbell"></i><span class="menu-text">Ejercicios</span></a></li>
    <li><a href="{{ route('recomendaciones.index') }}"><i class="fas fa-notes-medical"></i><span class="menu-text">Recomendaciones</span></a></li>
    <li><a href="{{ route('rutinas.index') }}"><i class="fas fa-running"></i><span class="menu-text">Rutinas</span></a></li>
    <li><a href="{{ route('planes.index') }}"><i class="fas fa-apple-alt"></i><span class="menu-text">Plan Nutricional</span></a></li>
    <li>
      <a href="{{ route('clases.index') }}"><i class="fas fa-chalkboard-teacher"></i><span class="menu-text">Clases</span></a>
      <ul class="submenu">
        <li><a href="{{ route('clases.index') }}">Lista de Clases</a></li>
        <li><a href="{{ route('clases.historial') }}">Historial de Clases</a></li>
      </ul>
    </li>
    <li><a href="{{ route('asistencias.calendario') }}"><i class="fas fa-calendar-check"></i><span class="menu-text">Calendario Gym</span></a></li>
    @if(in_array(auth()->user()->role, ['entrenador','superadmin']))
      <li>
        <a href="{{ route('qr-sessions.index') }}"><i class="fas fa-qrcode"></i><span class="menu-text">Sesiones QR</span></a>
        <ul class="submenu">
          <li><a href="{{ route('qr-sessions.index') }}">Ver Sesiones</a></li>
          <li><a href="{{ route('qr-sessions.create') }}">Crear Sesión QR</a></li>
        </ul>
      </li>
    @endif
    <li><a href="{{ route('qr-sessions.enter-code') }}"><i class="fas fa-camera"></i><span class="menu-text">Escanear QR</span></a></li>
    <li><a href="{{ route('qr-sessions.my-attendances') }}"><i class="fas fa-list-check"></i><span class="menu-text">Mis Asistencias</span></a></li>
    <li><a href="{{ route('entradas-peso.index') }}"><i class="fas fa-weight-scale"></i><span class="menu-text">Entradas de Peso</span></a></li>
  </ul>
</nav>


    <!-- Top Navbar -->
    <nav class="top-navbar d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center">
        <button id="mobileToggle" class="btn-hamburger d-md-none"><i class="fas fa-bars"></i></button>
        <span id="desktopToggle" class="desktop-toggle d-none d-md-inline"><i class="fas fa-angle-double-left"></i></span>

        {{-- Logo GymApp con icono - clickable para home --}}
        <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center gap-2 text-decoration-none">
          <div class="brand-icon">
            <i class="fas fa-dumbbell"></i>
          </div>
          <span class="brand-text">GymApp</span>
        </a>
      </div>

      @auth
      <form method="POST" action="{{ route('logout') }}" class="d-flex align-items-center gap-2">
        @csrf
        <span class="user-name d-none d-md-block text-muted small">{{ auth()->user()->name }}</span>
        <button type="submit" class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1">
          <i class="bi bi-box-arrow-right"></i>
          <span class="d-none d-md-inline">Salir</span>
        </button>
      </form>
      @endauth
    </nav>
  @endif

  <!-- Contenido Principal -->
  <div id="content">
    <div class="container-fluid pt-4">
      @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
      @yield('content')
    </div>
  </div>

  <!-- Footer móvil -->
  <div class="mobile-tabs d-md-none">
    <a href="{{ route('fichas.index') }}"><i class="fas fa-user"></i></a>
    <a href="{{ route('ejercicios.index') }}"><i class="fas fa-dumbbell"></i></a>
    <a href="{{ route('home') }}"><i class="fas fa-home"></i></a>
    @if(in_array(auth()->user()->role,['entrenador','superadmin']))<a href="{{ route('qr-sessions.index') }}"><i class="fas fa-tachometer-alt"></i></a>@endif
    <a href="{{ route('qr-sessions.enter-code') }}"><i class="fas fa-qrcode"></i></a>
    <a href="{{ route('asistencias.calendario') }}"><i class="fas fa-calendar-alt"></i></a>
  </div>

    <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- Scripts específicos de cada vista -->
  @yield('scripts')

<script>
  // Mostrar/ocultar toggle escritorio según ancho
  function updateDesktopToggle() {
    const desktopToggle = document.getElementById('desktopToggle');
    if (desktopToggle) {
      if (window.innerWidth >= 768) {
        desktopToggle.style.display = 'inline-block';
      } else {
        desktopToggle.style.display = 'none';
      }
    }
  }

  window.addEventListener('resize', updateDesktopToggle);
  updateDesktopToggle();

  // Toggle sidebar móvil
  const mobileToggle = document.getElementById('mobileToggle');
  if (mobileToggle) {
    mobileToggle.addEventListener('click', function(e) {
      const sidebar = document.getElementById('sidebar');
      if (sidebar) {
        sidebar.classList.toggle('mobile-active');
      }
      e.stopPropagation();
    });
  }

  // Toggle sidebar escritorio
  const desktopToggle = document.getElementById('desktopToggle');
  if (desktopToggle) {
    desktopToggle.addEventListener('click', function() {
      const sidebar = document.getElementById('sidebar');
      const icon = this.querySelector('i');
      if (sidebar && icon) {
        sidebar.classList.toggle('collapsed');
        icon.classList.toggle('fa-angle-double-left');
        icon.classList.toggle('fa-angle-double-right');
      }
    });
  }

  // Cerrar sidebar móvil al hacer clic fuera
  document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('sidebar');
    if (sidebar && sidebar.classList.contains('mobile-active') &&
        !sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
      sidebar.classList.remove('mobile-active');
    }
  });

  // Cerrar sidebar móvil al hacer clic en un enlace
  document.querySelectorAll('#sidebar ul li a').forEach(link => {
    link.addEventListener('click', function() {
      const sidebar = document.getElementById('sidebar');
      if (sidebar && sidebar.classList.contains('mobile-active')) {
        sidebar.classList.remove('mobile-active');
      }
    });
  });
</script>

@stack('scripts')

</body>
</html>
