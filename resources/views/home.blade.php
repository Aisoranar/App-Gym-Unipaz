@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
<style>
    /* Dashboard Styles */
    .dashboard-header {
        background: linear-gradient(135deg, #003379 0%, #0056a8 100%);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
        animation: slideDown 0.6s ease-out;
    }

    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        animation: pulse 4s ease-in-out infinite;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.3; }
        50% { transform: scale(1.1); opacity: 0.5; }
    }

    .welcome-text {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .welcome-subtext {
        font-size: 0.95rem;
        opacity: 0.9;
        position: relative;
        z-index: 1;
    }

    /* Stats Cards */
    .stats-row {
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        animation: fadeUp 0.5s ease-out;
        animation-fill-mode: both;
        border-left: 4px solid;
    }

    .stat-card:nth-child(1) { animation-delay: 0.1s; border-color: #003379; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; border-color: #1a472a; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; border-color: #d63384; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; border-color: #fd7e14; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 0.75rem;
        transition: transform 0.3s ease;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1);
    }

    .stat-icon.blue { background: rgba(0,51,121,0.1); color: #003379; }
    .stat-icon.green { background: rgba(26,71,42,0.1); color: #1a472a; }
    .stat-icon.pink { background: rgba(214,51,132,0.1); color: #d63384; }
    .stat-icon.orange { background: rgba(253,126,20,0.1); color: #fd7e14; }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #6c757d;
        font-weight: 500;
    }

    /* Quick Access Menu */
    .menu-section {
        margin-bottom: 1.5rem;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    @media (min-width: 768px) {
        .menu-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (min-width: 992px) {
        .menu-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    .menu-item {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        animation: scaleIn 0.4s ease-out;
        animation-fill-mode: both;
        text-align: center;
        border: 2px solid transparent;
    }

    .menu-item:nth-child(1) { animation-delay: 0.1s; }
    .menu-item:nth-child(2) { animation-delay: 0.15s; }
    .menu-item:nth-child(3) { animation-delay: 0.2s; }
    .menu-item:nth-child(4) { animation-delay: 0.25s; }
    .menu-item:nth-child(5) { animation-delay: 0.3s; }
    .menu-item:nth-child(6) { animation-delay: 0.35s; }
    .menu-item:nth-child(7) { animation-delay: 0.4s; }
    .menu-item:nth-child(8) { animation-delay: 0.45s; }

    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    .menu-item:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 12px 30px rgba(0,0,0,0.15);
        border-color: #003379;
        text-decoration: none;
        color: inherit;
    }

    .menu-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin: 0 auto 0.75rem;
        transition: all 0.3s ease;
    }

    .menu-item:hover .menu-icon {
        transform: rotate(10deg) scale(1.1);
    }

    .menu-icon.primary { background: linear-gradient(135deg, #003379, #0056a8); color: white; }
    .menu-icon.success { background: linear-gradient(135deg, #1a472a, #2d5a3d); color: white; }
    .menu-icon.info { background: linear-gradient(135deg, #0dcaf0, #0aa2c0); color: white; }
    .menu-icon.warning { background: linear-gradient(135deg, #fd7e14, #e56b0a); color: white; }
    .menu-icon.danger { background: linear-gradient(135deg, #dc3545, #b02a37); color: white; }
    .menu-icon.purple { background: linear-gradient(135deg, #6f42c1, #5a35a0); color: white; }
    .menu-icon.teal { background: linear-gradient(135deg, #20c997, #1ba87e); color: white; }
    .menu-icon.pink { background: linear-gradient(135deg, #d63384, #b02a6f); color: white; }

    .menu-title {
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.25rem;
    }

    .menu-desc {
        font-size: 0.75rem;
        color: #6c757d;
    }

    /* Recent Activity */
    .activity-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        animation: fadeUp 0.5s ease-out;
        animation-delay: 0.5s;
        animation-fill-mode: both;
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        background: rgba(0,51,121,0.1);
        color: #003379;
    }

    .activity-text {
        flex: 1;
    }

    .activity-title {
        font-weight: 500;
        font-size: 0.9rem;
        margin-bottom: 0.15rem;
    }

    .activity-time {
        font-size: 0.75rem;
        color: #6c757d;
    }

    /* CTA Button */
    .cta-section {
        background: linear-gradient(135deg, #003379 0%, #0056a8 100%);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        color: white;
        margin-top: 1.5rem;
        animation: fadeUp 0.5s ease-out;
        animation-delay: 0.6s;
        animation-fill-mode: both;
    }

    .cta-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .cta-text {
        font-size: 0.9rem;
        opacity: 0.9;
        margin-bottom: 1rem;
    }

    .cta-button {
        background: white;
        color: #003379;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 25px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .cta-button:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        text-decoration: none;
        color: #003379;
    }

    /* Floating Action Button (Mobile) */
    .fab-mobile {
        position: fixed;
        bottom: 80px;
        right: 20px;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #003379, #0056a8);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,51,121,0.4);
        z-index: 1000;
        animation: bounceIn 0.5s ease-out;
    }

    @keyframes bounceIn {
        0% { transform: scale(0); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    @media (min-width: 768px) {
        .fab-mobile {
            display: none;
        }
    }

    /* Hero Banner Image */
    .hero-banner {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        animation: fadeUp 0.6s ease-out;
        animation-delay: 0.1s;
        animation-fill-mode: both;
    }

    .hero-banner img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }

    @media (min-width: 768px) {
        .hero-banner img {
            height: 280px;
        }
    }

    @media (min-width: 992px) {
        .hero-banner img {
            height: 350px;
        }
    }

    .hero-banner:hover img {
        transform: scale(1.03);
    }

    .hero-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,51,121,0.8), transparent);
        padding: 2rem 1.5rem 1.5rem;
        color: white;
    }

    .hero-title {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    @media (min-width: 768px) {
        .hero-title {
            font-size: 1.8rem;
        }
    }

    .hero-subtitle {
        font-size: 0.9rem;
        opacity: 0.95;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }

    @media (min-width: 768px) {
        .hero-subtitle {
            font-size: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container py-4" style="padding-top: 80px;">

    <!-- Welcome Header -->
    <div class="dashboard-header">
        <div class="welcome-text">
            ¡Hola, {{ auth()->user()->name }}! 👋
        </div>
        <div class="welcome-subtext">
            Listo para entrenar hoy? Consulta tu progreso y mantén tu racha activa.
        </div>
    </div>

    <!-- Hero Banner Image -->
    <div class="hero-banner">
        <img src="{{ asset('images/home/gymmapp.jpeg') }}" alt="GymApp - Tu compañero de entrenamiento">
        <div class="hero-overlay">
            <div class="hero-title">💪 Transforma tu Vida</div>
            <div class="hero-subtitle">Cada entrenamiento cuenta. ¡Sigue adelante!</div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row stats-row g-3">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-value">12</div>
                <div class="stat-label">Asistencias este mes</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-fire"></i>
                </div>
                <div class="stat-value">5</div>
                <div class="stat-label">Días de racha</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon pink">
                    <i class="fas fa-dumbbell"></i>
                </div>
                <div class="stat-value">8</div>
                <div class="stat-label">Ejercicios hoy</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-weight"></i>
                </div>
                <div class="stat-value">72<span style="font-size:0.6em">kg</span></div>
                <div class="stat-label">Peso actual</div>
            </div>
        </div>
    </div>

    <!-- Quick Access Menu -->
    <div class="menu-section">
        <div class="section-title">
            <i class="fas fa-th-large text-primary"></i>
            Acceso Rápido
        </div>
        <div class="menu-grid">
            <a href="{{ route('fichas.index') }}" class="menu-item">
                <div class="menu-icon primary">
                    <i class="fas fa-file-medical"></i>
                </div>
                <div class="menu-title">Ficha Médica</div>
                <div class="menu-desc">Tu información</div>
            </a>
            <a href="{{ route('ejercicios.index') }}" class="menu-item">
                <div class="menu-icon success">
                    <i class="fas fa-dumbbell"></i>
                </div>
                <div class="menu-title">Ejercicios</div>
                <div class="menu-desc">Catálogo completo</div>
            </a>
            <a href="{{ route('rutinas.index') }}" class="menu-item">
                <div class="menu-icon info">
                    <i class="fas fa-running"></i>
                </div>
                <div class="menu-title">Rutinas</div>
                <div class="menu-desc">Mis entrenamientos</div>
            </a>
            <a href="{{ route('planes.index') }}" class="menu-item">
                <div class="menu-icon warning">
                    <i class="fas fa-apple-alt"></i>
                </div>
                <div class="menu-title">Nutrición</div>
                <div class="menu-desc">Plan alimenticio</div>
            </a>
            <a href="{{ route('clases.index') }}" class="menu-item">
                <div class="menu-icon danger">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="menu-title">Clases</div>
                <div class="menu-desc">Horarios y reservas</div>
            </a>
            <a href="{{ route('asistencias.calendario') }}" class="menu-item">
                <div class="menu-icon purple">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="menu-title">Calendario</div>
                <div class="menu-desc">Registro diario</div>
            </a>
            <a href="{{ route('entradas-peso.index') }}" class="menu-item">
                <div class="menu-icon teal">
                    <i class="fas fa-weight-scale"></i>
                </div>
                <div class="menu-title">Peso</div>
                <div class="menu-desc">Seguimiento</div>
            </a>
            <a href="{{ route('recomendaciones.index') }}" class="menu-item">
                <div class="menu-icon pink">
                    <i class="fas fa-notes-medical"></i>
                </div>
                <div class="menu-title">Recomendaciones</div>
                <div class="menu-desc">Consejos saludables</div>
            </a>
        </div>
    </div>

    <div class="row g-3">
        <!-- Recent Activity -->
        <div class="col-md-6">
            <div class="activity-card">
                <div class="section-title mb-3">
                    <i class="fas fa-history text-primary"></i>
                    Actividad Reciente
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="activity-text">
                        <div class="activity-title">Asistencia registrada</div>
                        <div class="activity-time">Hoy, 8:30 AM</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-dumbbell"></i>
                    </div>
                    <div class="activity-text">
                        <div class="activity-title">Rutina de Pecho completada</div>
                        <div class="activity-time">Ayer, 6:00 PM</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-weight"></i>
                    </div>
                    <div class="activity-text">
                        <div class="activity-title">Peso actualizado: 72kg</div>
                        <div class="activity-time">Hace 3 días</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Motivational CTA -->
        <div class="col-md-6">
            <div class="cta-section">
                <div class="cta-title">💪 ¿Ya entrenaste hoy?</div>
                <div class="cta-text">Registra tu asistencia y mantén viva tu racha de {{ $currentStreak ?? '0' }} días</div>
                <a href="{{ route('asistencias.calendario') }}" class="cta-button">
                    <i class="fas fa-plus-circle me-2"></i>Registrar Asistencia
                </a>
            </div>
        </div>
    </div>

    <!-- Floating Action Button (Mobile Only) -->
    <a href="{{ route('asistencias.calendario') }}" class="fab-mobile d-md-none">
        <i class="fas fa-plus"></i>
    </a>

</div>
@endsection
