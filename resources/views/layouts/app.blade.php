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
    :root { 
      --primary-color: #003379; 
      --primary-light: #0056a8; 
      --primary-lighter: #e6f0ff;
      --secondary-color: #fff; 
      --text-color: #333; 
      --bg-color: #f8f9fa; 
      --sidebar-width: 280px; 
      --sidebar-collapsed: 80px;
      --accent-green: #1a472a;
      --hover-bg: rgba(255,255,255,0.15);
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; background: var(--bg-color); color: var(--text-color); line-height: 1.6; }
    
    /* ===== SIDEBAR MODERNO ===== */
    #sidebar { 
      position: fixed; 
      top: 0; 
      left: -100%; 
      width: var(--sidebar-width); 
      height: 100vh; 
      background: linear-gradient(180deg, var(--primary-color) 0%, #001a3d 100%); 
      color: var(--secondary-color); 
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
      overflow-y: auto; 
      z-index: 1500;
      box-shadow: 4px 0 20px rgba(0,0,0,0.15);
    }
    #sidebar.mobile-active { left: 0; }
    @media (min-width: 768px) { #sidebar { left: 0; } }
    #sidebar.collapsed { width: var(--sidebar-collapsed); }
    
    /* Header del Sidebar - Sticky y Mejorado */
    #sidebar .sidebar-header { 
      position: sticky;
      top: 0;
      z-index: 1700;
      display: flex; 
      align-items: center; 
      justify-content: center; 
      padding: 1.25rem 1rem; 
      border-bottom: 1px solid rgba(255,255,255,0.15);
      background: linear-gradient(135deg, rgba(0,51,121,0.95) 0%, rgba(0,26,61,0.98) 100%);
      backdrop-filter: blur(10px);
    }
    #sidebar .sidebar-header i { 
      margin-right: 0.75rem; 
      font-size: 1.4rem; 
      width: 42px;
      height: 42px;
      background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.1) 100%);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      transition: all 0.3s ease;
    }
    #sidebar .sidebar-header:hover i {
      transform: scale(1.05) rotate(-5deg);
      background: linear-gradient(135deg, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0.15) 100%);
    }
    #sidebar .sidebar-header span { 
      font-size: 1.15rem; 
      font-weight: 700;
      letter-spacing: 0.5px;
      transition: opacity 0.3s ease; 
    }
    #sidebar.collapsed .sidebar-header span { opacity: 0; visibility: hidden; }
    #sidebar.collapsed .sidebar-header { justify-content: flex-start; padding: 1.25rem 0.75rem; }
    #sidebar.collapsed .sidebar-header i { 
      margin-right: 0;
      width: 36px;
      height: 36px;
      font-size: 1.1rem;
      background: rgba(255,255,255,0.08);
      border-radius: 10px;
    }
    
    /* Scrollbar personalizada */
    #sidebar::-webkit-scrollbar { width: 5px; }
    #sidebar::-webkit-scrollbar-track { background: transparent; }
    #sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 3px; }
    
    /* Menú */
    #sidebar ul.components { 
      list-style: none; 
      padding: 1rem 0.75rem; 
      padding-bottom: 100px; 
    }
    #sidebar ul li { margin: 0.25rem 0; }
    
    /* Items del menú */
    #sidebar ul li > a { 
      display: flex; 
      align-items: center; 
      padding: 0.875rem 1rem; 
      color: rgba(255,255,255,0.85); 
      text-decoration: none; 
      border-radius: 12px; 
      transition: all 0.25s ease;
      position: relative;
      overflow: hidden;
      margin-bottom: 0.25rem;
    }
    
    /* Indicador activo */
    #sidebar ul li > a.active,
    #sidebar ul li > a:hover { 
      background: var(--hover-bg); 
      color: #fff;
      transform: translateX(3px);
    }
    
    #sidebar ul li > a.active::before,
    #sidebar ul li > a:hover::before {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 4px;
      height: 60%;
      background: #fff;
      border-radius: 0 3px 3px 0;
    }
    
    /* Iconos consistentes */
    #sidebar ul li > a > i { 
      width: 36px;
      height: 36px;
      min-width: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 0.875rem;
      font-size: 1.1rem;
      background: rgba(255,255,255,0.08);
      border-radius: 10px;
      transition: all 0.25s ease;
    }
    
    #sidebar ul li > a:hover > i,
    #sidebar ul li > a.active > i {
      background: rgba(255,255,255,0.2);
      transform: scale(1.1);
    }
    
    .menu-text { 
      font-size: 0.95rem;
      font-weight: 500;
      transition: opacity 0.3s; 
      white-space: nowrap;
    }
    #sidebar.collapsed .menu-text { opacity: 0; visibility: hidden; }
    
    /* Submenú mejorado */
    .submenu { 
      list-style: none; 
      display: none; 
      background: rgba(0,0,0,0.2);
      border-radius: 10px;
      margin: 0.25rem 0.5rem 0.5rem;
      padding: 0.5rem;
    }
    li:hover > .submenu { display: block; animation: slideDown 0.25s ease; }
    
    @keyframes slideDown {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .submenu li { margin: 0.15rem 0 !important; }
    .submenu li a { 
      padding: 0.6rem 0.75rem !important; 
      font-size: 0.85rem;
      border-radius: 8px !important;
    }
    .submenu li a::before { display: none !important; }
    
    /* Badge para notificaciones */
    .menu-badge {
      background: #dc3545;
      color: white;
      font-size: 0.7rem;
      padding: 0.15rem 0.4rem;
      border-radius: 10px;
      margin-left: auto;
    }
    /* Top navbar - ajustado al sidebar */
    .top-navbar { position: fixed; top: 0; width: 100%; height: 60px; background: var(--secondary-color); border-bottom: 1px solid #e0e0e0; display: flex; align-items: center; padding: 0 1.5rem; z-index: 1600; transition: margin-left 0.3s, width 0.3s; }
    .top-navbar .btn-hamburger { background: none; border: none; font-size: 1.8rem; color: var(--text-color); margin-right: 1rem; display: inline-block; }
    .top-navbar .desktop-toggle { display: none; font-size: 1.8rem; margin-right: 1rem; cursor: pointer; transition: transform 0.3s; }
    @media (min-width: 768px) { 
      .top-navbar .desktop-toggle { display: inline-block; }
      .top-navbar { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); }
      #sidebar.collapsed ~ .top-navbar { margin-left: var(--sidebar-collapsed); width: calc(100% - var(--sidebar-collapsed)); }
    }

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
    /* Footer móvil mejorado */
    .mobile-tabs { 
      position: fixed; 
      bottom: 0; 
      width: 100%; 
      background: white; 
      border-top: 1px solid #e9ecef; 
      display: flex; 
      justify-content: space-around; 
      padding: 0.5rem 0; 
      z-index: 1500;
      box-shadow: 0 -4px 20px rgba(0,0,0,0.08);
    }
    .mobile-tabs a { 
      color: #6c757d; 
      font-size: 1.15rem; 
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.25rem;
      padding: 0.4rem 0.75rem;
      border-radius: 12px;
      transition: all 0.2s ease;
      text-decoration: none;
    }
    .mobile-tabs a span {
      font-size: 0.65rem;
      font-weight: 500;
    }
    .mobile-tabs a.active,
    .mobile-tabs a:hover { 
      color: var(--primary-color); 
      background: var(--primary-lighter);
    }
    @media (min-width: 768px) { .mobile-tabs { display: none; } }

    /* ===== ESTILOS ESTÁNDAR PARA PÁGINAS ===== */
    
    /* Header de página */
    .page-header {
      background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
      border-radius: 16px;
      padding: 2rem;
      margin-bottom: 1.5rem;
      color: white;
      position: relative;
      overflow: hidden;
    }
    
    .page-header::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -10%;
      width: 200px;
      height: 200px;
      background: rgba(255,255,255,0.1);
      border-radius: 50%;
      z-index: 0;
    }
    
    .page-header h1 {
      font-size: 1.5rem;
      font-weight: 700;
      margin: 0;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      position: relative;
      z-index: 1;
    }
    
    .page-header h1 i {
      width: 44px;
      height: 44px;
      background: rgba(255,255,255,0.2);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
    }
    
    @media (min-width: 768px) {
      .page-header h1 { font-size: 1.75rem; }
      .page-header h1 i { width: 50px; height: 50px; font-size: 1.5rem; }
    }
    
    .page-header p {
      margin: 0.5rem 0 0 0;
      opacity: 0.9;
      font-size: 0.95rem;
      padding-left: 3.5rem;
    }
    
    /* Botones de acción en header */
    .page-actions {
      display: flex;
      gap: 0.75rem;
      flex-wrap: wrap;
      margin-top: 1rem;
      position: relative;
      z-index: 2;
    }
    
    @media (min-width: 768px) {
      .page-header { display: flex; align-items: center; justify-content: space-between; }
      .page-header > div:first-child { flex: 1; }
      .page-actions { margin-top: 0; }
    }
    
    /* Botón primario */
    .btn-primary-gym {
      background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
      color: white;
      border: none;
      padding: 0.75rem 1.25rem;
      border-radius: 10px;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.3s ease;
      text-decoration: none;
      font-size: 0.9rem;
    }
    
    .btn-primary-gym:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0,51,121,0.3);
      color: white;
    }
    
    /* Botón secundario */
    .btn-secondary-gym {
      background: white;
      color: var(--primary-color);
      border: 2px solid var(--primary-color);
      padding: 0.75rem 1.25rem;
      border-radius: 10px;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.3s ease;
      text-decoration: none;
      font-size: 0.9rem;
    }
    
    .btn-secondary-gym:hover {
      background: var(--primary-color);
      color: white;
    }
    
    /* Contenedor de tarjetas */
    .cards-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 1rem;
    }
    
    @media (min-width: 576px) {
      .cards-grid { grid-template-columns: repeat(2, 1fr); }
    }
    
    @media (min-width: 992px) {
      .cards-grid { grid-template-columns: repeat(3, 1fr); }
    }
    
    @media (min-width: 1200px) {
      .cards-grid { grid-template-columns: repeat(4, 1fr); }
    }
    
    /* Tarjeta estándar */
    .gym-card {
      background: white;
      border-radius: 14px;
      padding: 1.25rem;
      box-shadow: 0 4px 15px rgba(0,0,0,0.06);
      transition: all 0.3s ease;
      border: 1px solid #e9ecef;
      position: relative;
      overflow: hidden;
    }
    
    .gym-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 30px rgba(0,0,0,0.1);
      border-color: var(--primary-lighter);
    }
    
    .gym-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
      opacity: 0;
      transition: opacity 0.3s;
    }
    
    .gym-card:hover::before { opacity: 1; }
    
    /* Título de tarjeta */
    .gym-card-title {
      font-size: 1.1rem;
      font-weight: 700;
      color: #333;
      margin-bottom: 0.5rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    
    /* Descripción de tarjeta */
    .gym-card-text {
      color: #6c757d;
      font-size: 0.9rem;
      line-height: 1.5;
      margin-bottom: 1rem;
    }
    
    /* Acciones de tarjeta */
    .gym-card-actions {
      display: flex;
      gap: 0.5rem;
      flex-wrap: wrap;
    }
    
    .gym-card-actions .btn {
      padding: 0.4rem 0.75rem;
      font-size: 0.8rem;
      border-radius: 8px;
      font-weight: 600;
    }
    
    /* Icono de tarjeta */
    .gym-card-icon {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
      margin-bottom: 1rem;
    }
    
    .gym-card-icon.blue { background: var(--primary-lighter); color: var(--primary-color); }
    .gym-card-icon.green { background: #d4edda; color: #155724; }
    .gym-card-icon.orange { background: #fff3cd; color: #856404; }
    .gym-card-icon.red { background: #f8d7da; color: #721c24; }
    .gym-card-icon.purple { background: #e2d4f0; color: #4a148c; }
    .gym-card-icon.teal { background: #d1f2eb; color: #0e6251; }
    
    /* Formularios */
    .gym-form-group {
      margin-bottom: 1.25rem;
    }
    
    .gym-form-label {
      display: block;
      font-weight: 600;
      font-size: 0.9rem;
      color: #495057;
      margin-bottom: 0.5rem;
    }
    
    .gym-form-control {
      width: 100%;
      padding: 0.875rem 1rem;
      border: 2px solid #e9ecef;
      border-radius: 10px;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      background: #f8f9fa;
    }
    
    .gym-form-control:focus {
      outline: none;
      border-color: var(--primary-color);
      background: white;
      box-shadow: 0 0 0 4px rgba(0,51,121,0.1);
    }
    
    /* Alertas */
    .gym-alert {
      padding: 1rem 1.25rem;
      border-radius: 12px;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    
    .gym-alert.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .gym-alert.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    .gym-alert.warning { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
    
    /* Tabla responsive */
    .gym-table-container {
      background: white;
      border-radius: 14px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.06);
      overflow: hidden;
    }
    
    .gym-table {
      width: 100%;
      border-collapse: collapse;
    }
    
    .gym-table th {
      background: var(--primary-color);
      color: white;
      padding: 1rem;
      text-align: left;
      font-weight: 600;
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    
    .gym-table td {
      padding: 1rem;
      border-bottom: 1px solid #e9ecef;
      font-size: 0.9rem;
    }
    
    .gym-table tr:last-child td { border-bottom: none; }
    .gym-table tr:hover { background: #f8f9fa; }
    
    @media (max-width: 767px) {
      .gym-table th,
      .gym-table td { padding: 0.75rem; font-size: 0.85rem; }
    }
    
    /* Paginación */
    .gym-pagination {
      display: flex;
      justify-content: center;
      gap: 0.5rem;
      margin-top: 1.5rem;
    }
    
    .gym-pagination a,
    .gym-pagination span {
      padding: 0.5rem 1rem;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 500;
      font-size: 0.9rem;
      transition: all 0.2s;
    }
    
    .gym-pagination a { background: white; color: var(--primary-color); border: 1px solid #e9ecef; }
    .gym-pagination a:hover { background: var(--primary-color); color: white; border-color: var(--primary-color); }
    .gym-pagination .active { background: var(--primary-color); color: white; }
    
    /* Búsqueda */
    .gym-search {
      position: relative;
      margin-bottom: 1.5rem;
    }
    
    .gym-search input {
      width: 100%;
      padding: 0.875rem 1rem 0.875rem 2.75rem;
      border: 2px solid #e9ecef;
      border-radius: 12px;
      font-size: 0.95rem;
      transition: all 0.3s;
    }
    
    .gym-search i {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: #adb5bd;
    }
    
    .gym-search input:focus {
      outline: none;
      border-color: var(--primary-color);
    }
    
    /* ===== ESTILOS PARA PÁGINAS SHOW ===== */
    .show-header {
      background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
      border-radius: 16px;
      padding: 2rem;
      margin-bottom: 1.5rem;
      color: white;
      position: relative;
      overflow: hidden;
    }
    
    .show-header::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -20%;
      width: 300px;
      height: 300px;
      background: rgba(255,255,255,0.1);
      border-radius: 50%;
    }
    
    .show-header h1 {
      font-size: 1.5rem;
      font-weight: 700;
      margin: 0;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      position: relative;
      z-index: 1;
    }
    
    .show-header h1 i {
      width: 44px;
      height: 44px;
      background: rgba(255,255,255,0.2);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
    }
    
    .show-section {
      background: white;
      border-radius: 14px;
      padding: 1.5rem;
      margin-bottom: 1rem;
      box-shadow: 0 4px 15px rgba(0,0,0,0.06);
      border: 1px solid #e9ecef;
    }
    
    .show-section-title {
      font-size: 1.1rem;
      font-weight: 700;
      color: var(--primary-color);
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding-bottom: 0.75rem;
      border-bottom: 2px solid #e9ecef;
    }
    
    .show-field {
      margin-bottom: 1rem;
    }
    
    .show-field:last-child {
      margin-bottom: 0;
    }
    
    .show-label {
      font-size: 0.8rem;
      font-weight: 600;
      color: #6c757d;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 0.25rem;
    }
    
    .show-value {
      font-size: 1rem;
      color: #212529;
    }
    
    .show-actions {
      display: flex;
      gap: 0.75rem;
      flex-wrap: wrap;
      margin-top: 1.5rem;
    }
    
    .btn-back {
      background: #6c757d;
      color: white;
      border: none;
      padding: 0.75rem 1.25rem;
      border-radius: 10px;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.3s ease;
      text-decoration: none;
    }
    
    .btn-back:hover {
      background: #5a6268;
      color: white;
      transform: translateY(-2px);
    }
    
    .btn-edit {
      background: #ffc107;
      color: #000;
      border: none;
      padding: 0.75rem 1.25rem;
      border-radius: 10px;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.3s ease;
      text-decoration: none;
    }
    
    .btn-edit:hover {
      background: #e0a800;
      color: #000;
      transform: translateY(-2px);
    }
    
    .btn-delete {
      background: #dc3545;
      color: white;
      border: none;
      padding: 0.75rem 1.25rem;
      border-radius: 10px;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.3s ease;
      text-decoration: none;
    }
    
    .btn-delete:hover {
      background: #c82333;
      color: white;
      transform: translateY(-2px);
    }
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
    @php $currentRoute = Route::currentRouteName(); @endphp
    
    <li>
      <a href="{{ route('fichas.index') }}" class="{{ str_starts_with($currentRoute, 'fichas') ? 'active' : '' }}">
        <i class="fas fa-file-medical"></i>
        <span class="menu-text">Ficha Médica</span>
      </a>
    </li>
    <li>
      <a href="{{ route('ejercicios.index') }}" class="{{ str_starts_with($currentRoute, 'ejercicios') ? 'active' : '' }}">
        <i class="fas fa-dumbbell"></i>
        <span class="menu-text">Ejercicios</span>
      </a>
    </li>
    <li>
      <a href="{{ route('recomendaciones.index') }}" class="{{ str_starts_with($currentRoute, 'recomendaciones') ? 'active' : '' }}">
        <i class="fas fa-notes-medical"></i>
        <span class="menu-text">Recomendaciones</span>
      </a>
    </li>
    <li>
      <a href="{{ route('rutinas.index') }}" class="{{ str_starts_with($currentRoute, 'rutinas') ? 'active' : '' }}">
        <i class="fas fa-running"></i>
        <span class="menu-text">Rutinas</span>
      </a>
    </li>
    <li>
      <a href="{{ route('planes.index') }}" class="{{ str_starts_with($currentRoute, 'planes') ? 'active' : '' }}">
        <i class="fas fa-apple-alt"></i>
        <span class="menu-text">Nutrición</span>
      </a>
    </li>
    <li>
      <a href="{{ route('clases.index') }}" class="{{ str_starts_with($currentRoute, 'clases') ? 'active' : '' }}">
        <i class="fas fa-chalkboard-teacher"></i>
        <span class="menu-text">Clases</span>
      </a>
      <ul class="submenu">
        <li><a href="{{ route('clases.index') }}">Lista de Clases</a></li>
        <li><a href="{{ route('clases.historial') }}">Historial</a></li>
      </ul>
    </li>
    <li>
      <a href="{{ route('asistencias.calendario') }}" class="{{ str_starts_with($currentRoute, 'asistencias') ? 'active' : '' }}">
        <i class="fas fa-calendar-check"></i>
        <span class="menu-text">Calendario</span>
      </a>
    </li>
    @if(in_array(auth()->user()->role, ['entrenador','superadmin']))
      <li>
        <a href="{{ route('qr-sessions.index') }}" class="{{ str_starts_with($currentRoute, 'qr-sessions') && !str_contains($currentRoute, 'enter-code') && !str_contains($currentRoute, 'scan') && !str_contains($currentRoute, 'my-attendances') ? 'active' : '' }}">
          <i class="fas fa-qrcode"></i>
          <span class="menu-text">Sesiones QR</span>
        </a>
        <ul class="submenu">
          <li><a href="{{ route('qr-sessions.index') }}">Ver Sesiones</a></li>
          <li><a href="{{ route('qr-sessions.create') }}">Crear</a></li>
        </ul>
      </li>
    @endif
    <li>
      <a href="{{ route('qr-sessions.enter-code') }}" class="{{ str_contains($currentRoute, 'enter-code') || str_contains($currentRoute, 'scan') ? 'active' : '' }}">
        <i class="fas fa-camera"></i>
        <span class="menu-text">Escanear QR</span>
      </a>
    </li>
    <li>
      <a href="{{ route('qr-sessions.my-attendances') }}" class="{{ str_contains($currentRoute, 'my-attendances') ? 'active' : '' }}">
        <i class="fas fa-list-check"></i>
        <span class="menu-text">Mis Asistencias</span>
      </a>
    </li>
    <li>
      <a href="{{ route('entradas-peso.index') }}" class="{{ str_starts_with($currentRoute, 'entradas-peso') ? 'active' : '' }}">
        <i class="fas fa-weight-scale"></i>
        <span class="menu-text">Peso</span>
      </a>
    </li>
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
      @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
      @yield('content')
    </div>
  </div>

  <!-- Footer móvil mejorado -->
  <div class="mobile-tabs d-md-none">
    @php $currentRoute = Route::currentRouteName(); @endphp
    <a href="{{ route('home') }}" class="{{ $currentRoute === 'home' ? 'active' : '' }}">
      <i class="fas fa-home"></i>
      <span>Inicio</span>
    </a>
    <a href="{{ route('fichas.index') }}" class="{{ str_starts_with($currentRoute, 'fichas') ? 'active' : '' }}">
      <i class="fas fa-file-medical"></i>
      <span>Ficha</span>
    </a>
    <a href="{{ route('ejercicios.index') }}" class="{{ str_starts_with($currentRoute, 'ejercicios') ? 'active' : '' }}">
      <i class="fas fa-dumbbell"></i>
      <span>Ejercicios</span>
    </a>
    <a href="{{ route('qr-sessions.enter-code') }}" class="{{ str_contains($currentRoute, 'enter-code') || str_contains($currentRoute, 'scan') ? 'active' : '' }}">
      <i class="fas fa-camera"></i>
      <span>Escanear</span>
    </a>
    <a href="{{ route('asistencias.calendario') }}" class="{{ str_starts_with($currentRoute, 'asistencias') ? 'active' : '' }}">
      <i class="fas fa-calendar-check"></i>
      <span>Calendario</span>
    </a>
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
