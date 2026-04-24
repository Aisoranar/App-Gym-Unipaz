@extends('layouts.app')
@section('title', $ejercicio->nombre_ejercicio)
@section('content')

<style>
  /* Hero Section con imagen de fondo */
  .exercise-hero {
    position: relative;
    border-radius: 24px;
    padding: 3rem 2rem;
    margin-bottom: 2rem;
    overflow: hidden;
    min-height: 280px;
    display: flex;
    align-items: flex-end;
  }
  
  .exercise-hero-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    @if($ejercicio->foto)
    background: linear-gradient(135deg, rgba(0,51,121,0.95) 0%, rgba(0,86,168,0.85) 100%), 
                url('{{ asset('storage/' . $ejercicio->foto) }}');
    background-size: cover;
    background-position: top;
    @else
    background: linear-gradient(135deg, #003379 0%, #0056a8 50%, #001a3d 100%);
    @endif
  }
  
  .exercise-hero-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.5;
  }
  
  .exercise-hero-content {
    position: relative;
    z-index: 2;
    color: white;
    width: 100%;
  }
  
  .exercise-hero h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    text-shadow: 0 2px 10px rgba(0,0,0,0.3);
  }
  
  .exercise-badges {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
  }
  
  .exercise-badge {
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    backdrop-filter: blur(10px);
  }
  
  .badge-muscle {
    background: rgba(255,255,255,0.2);
    color: white;
    border: 1px solid rgba(255,255,255,0.3);
  }
  
  .badge-level-baja {
    background: rgba(40,167,69,0.9);
    color: white;
  }
  
  .badge-level-media {
    background: rgba(255,193,7,0.9);
    color: #333;
  }
  
  .badge-level-alta {
    background: rgba(220,53,69,0.9);
    color: white;
  }
  
  .hero-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
  }
  
  .btn-hero {
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    border: none;
  }
  
  .btn-hero-light {
    background: white;
    color: #003379;
  }
  
  .btn-hero-light:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
  }
  
  .btn-hero-warning {
    background: #ffc107;
    color: #333;
  }
  
  .btn-hero-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255,193,7,0.3);
  }
  
  /* Main Content Grid */
  .exercise-main {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
  }
  
  @media (min-width: 992px) {
    .exercise-main {
      grid-template-columns: 1.2fr 0.8fr;
    }
  }
  
  /* Video Section */
  .video-section {
    background: #000;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    position: relative;
  }
  
  .video-section video {
    width: 100%;
    display: block;
    max-height: 500px;
  }
  
  .video-overlay {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  
  /* Stats Bar */
  .stats-bar {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 2rem;
  }
  
  @media (min-width: 576px) {
    .stats-bar {
      grid-template-columns: repeat(4, 1fr);
    }
  }
  
  .stat-chip {
    background: white;
    border-radius: 16px;
    padding: 1.25rem;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    border: 2px solid transparent;
    transition: all 0.3s ease;
  }
  
  .stat-chip:hover {
    border-color: #003379;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,51,121,0.15);
  }
  
  .stat-chip-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.75rem;
    font-size: 1.25rem;
  }
  
  .stat-chip-value {
    font-size: 1.75rem;
    font-weight: 800;
    color: #003379;
    line-height: 1;
    margin-bottom: 0.25rem;
  }
  
  .stat-chip-label {
    font-size: 0.8rem;
    color: #6c757d;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  /* Info Cards */
  .info-card {
    background: white;
    border-radius: 20px;
    padding: 1.75rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    margin-bottom: 1.5rem;
    border: 1px solid #f0f0f0;
  }
  
  .info-card-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f8f9fa;
  }
  
  .info-card-icon {
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, #003379, #0056a8);
    color: white;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
  }
  
  .info-card-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #003379;
    margin: 0;
  }
  
  .info-card-body {
    color: #495057;
    font-size: 1rem;
    line-height: 1.7;
  }
  
  /* Details Grid */
  .details-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
  }
  
  @media (min-width: 576px) {
    .details-grid {
      grid-template-columns: repeat(3, 1fr);
    }
  }
  
  .detail-block {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1rem;
    text-align: center;
  }
  
  .detail-block-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.5rem;
    font-size: 1rem;
  }
  
  .detail-block-label {
    font-size: 0.75rem;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.25rem;
  }
  
  .detail-block-value {
    font-size: 1rem;
    font-weight: 700;
    color: #003379;
  }
  
  /* Creator Card */
  .creator-card {
    display: flex;
    align-items: center;
    gap: 1rem;
  }
  
  .creator-avatar {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #003379, #0056a8);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
  }
  
  .creator-info h5 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #003379;
    margin-bottom: 0.25rem;
  }
  
  .creator-info p {
    font-size: 0.9rem;
    color: #6c757d;
    margin: 0;
  }
  
  /* Image Gallery */
  .exercise-gallery {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    background: #f8f9fa;
  }
  
  .exercise-gallery img {
    width: 100%;
    height: auto;
    display: block;
  }
  
  /* Hero background position top */
  .exercise-hero-bg {
    background-position: top !important;
  }
  
  /* No Media State */
  .no-media-state {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 20px;
    padding: 4rem 2rem;
    text-align: center;
    border: 2px dashed #dee2e6;
  }
  
  .no-media-state i {
    font-size: 4rem;
    color: #adb5bd;
    margin-bottom: 1rem;
  }
  
  .no-media-state h4 {
    color: #6c757d;
    margin-bottom: 0.5rem;
  }
  
  .no-media-state p {
    color: #adb5bd;
    margin: 0;
  }
</style>

<!-- Hero Section -->
<div class="exercise-hero">
  <div class="exercise-hero-bg"></div>
  <div class="exercise-hero-pattern"></div>
  <div class="exercise-hero-content">
    <div class="row align-items-end">
      <div class="col-lg-8">
        <h1>{{ $ejercicio->nombre_ejercicio }}</h1>
        <div class="exercise-badges">
          @if($ejercicio->grupo_muscular)
            <span class="exercise-badge badge-muscle">
              <i class="fas fa-layer-group"></i>
              {{ $ejercicio->grupo_muscular }}
            </span>
          @endif
          <span class="exercise-badge badge-level-{{ strtolower($ejercicio->nivel_dificultad) }}">
            <i class="fas fa-signal"></i>
            {{ $ejercicio->nivel_dificultad }}
          </span>
          <span class="exercise-badge badge-muscle">
            <i class="fas fa-calendar"></i>
            {{ $ejercicio->fecha }}
          </span>
        </div>
        <div class="hero-actions">
          <a href="{{ route('ejercicios.index') }}" class="btn-hero btn-hero-light">
            <i class="fas fa-arrow-left"></i>
            Volver
          </a>
          @if(Auth::user()->role === 'entrenador' || Auth::user()->role === 'superadmin')
            <a href="{{ route('ejercicios.edit', $ejercicio) }}" class="btn-hero btn-hero-warning">
              <i class="fas fa-edit"></i>
              Editar
            </a>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Stats Bar -->
<div class="stats-bar">
  <div class="stat-chip">
    <div class="stat-chip-icon bg-primary bg-opacity-10 text-primary">
      <i class="fas fa-redo"></i>
    </div>
    <div class="stat-chip-value">{{ $ejercicio->series !== null ? $ejercicio->series : '-' }}</div>
    <div class="stat-chip-label">Series</div>
  </div>
  <div class="stat-chip">
    <div class="stat-chip-icon bg-success bg-opacity-10 text-success">
      <i class="fas fa-hashtag"></i>
    </div>
    <div class="stat-chip-value">{{ $ejercicio->repeticiones !== null ? $ejercicio->repeticiones : '-' }}</div>
    <div class="stat-chip-label">Repeticiones</div>
  </div>
  <div class="stat-chip">
    <div class="stat-chip-icon bg-warning bg-opacity-10 text-warning">
      <i class="fas fa-clock"></i>
    </div>
    <div class="stat-chip-value">{{ $ejercicio->duracion !== null ? $ejercicio->duracion : '-' }}</div>
    <div class="stat-chip-label">Minutos</div>
  </div>
  <div class="stat-chip">
    <div class="stat-chip-icon bg-danger bg-opacity-10 text-danger">
      <i class="fas fa-fire"></i>
    </div>
    <div class="stat-chip-value">{{ $ejercicio->calorias_aprox !== null ? $ejercicio->calorias_aprox : '-' }}</div>
    <div class="stat-chip-label">Calorías</div>
  </div>
</div>

<!-- Main Content -->
<div class="exercise-main">
  <!-- Left Column: Media -->
  <div>
    @if($ejercicio->video)
      <div class="video-section mb-4">
        <div class="video-overlay">
          <i class="fas fa-play-circle"></i>
          Video Tutorial
        </div>
        <video controls poster="{{ $ejercicio->foto ? asset('storage/' . $ejercicio->foto) : '' }}">
          <source src="{{ asset('storage/' . $ejercicio->video) }}" type="video/mp4">
          Tu navegador no soporta el video.
        </video>
      </div>
    @endif
    
    @if($ejercicio->foto)
      <div class="exercise-gallery mb-4">
        <img src="{{ asset('storage/' . $ejercicio->foto) }}" alt="{{ $ejercicio->nombre_ejercicio }}">
      </div>
    @endif
    
    @if(!$ejercicio->video && !$ejercicio->foto)
      <div class="no-media-state mb-4">
        <i class="fas fa-dumbbell"></i>
        <h4>Sin multimedia</h4>
        <p>Este ejercicio aún no tiene video o imagen</p>
      </div>
    @endif
    
    <!-- Descripción -->
    @if($ejercicio->descripcion)
      <div class="info-card">
        <div class="info-card-header">
          <div class="info-card-icon">
            <i class="fas fa-align-left"></i>
          </div>
          <h3 class="info-card-title">Descripción del Ejercicio</h3>
        </div>
        <div class="info-card-body">
          {{ $ejercicio->descripcion }}
        </div>
      </div>
    @endif
  </div>
  
  <!-- Right Column: Details -->
  <div>
    <!-- Detalles Técnicos -->
    <div class="info-card">
      <div class="info-card-header">
        <div class="info-card-icon">
          <i class="fas fa-cogs"></i>
        </div>
        <h3 class="info-card-title">Detalles Técnicos</h3>
      </div>
      <div class="details-grid">
        <div class="detail-block">
          <div class="detail-block-icon bg-primary bg-opacity-10 text-primary">
            <i class="fas fa-layer-group"></i>
          </div>
          <div class="detail-block-label">Grupo</div>
          <div class="detail-block-value">{{ $ejercicio->grupo_muscular ?? 'N/A' }}</div>
        </div>
        <div class="detail-block">
          <div class="detail-block-icon 
            @if($ejercicio->nivel_dificultad == 'Baja') bg-success bg-opacity-10 text-success
            @elseif($ejercicio->nivel_dificultad == 'Media') bg-warning bg-opacity-10 text-warning
            @else bg-danger bg-opacity-10 text-danger @endif">
            <i class="fas fa-signal"></i>
          </div>
          <div class="detail-block-label">Nivel</div>
          <div class="detail-block-value">{{ $ejercicio->nivel_dificultad }}</div>
        </div>
        <div class="detail-block">
          <div class="detail-block-icon bg-info bg-opacity-10 text-info">
            <i class="fas fa-calendar"></i>
          </div>
          <div class="detail-block-label">Fecha</div>
          <div class="detail-block-value">{{ $ejercicio->fecha }}</div>
        </div>
      </div>
    </div>
    
    <!-- Creador -->
    <div class="info-card">
      <div class="info-card-header">
        <div class="info-card-icon">
          <i class="fas fa-user"></i>
        </div>
        <h3 class="info-card-title">Instructor</h3>
      </div>
      <div class="creator-card">
        <div class="creator-avatar">
          <i class="fas fa-user"></i>
        </div>
        <div class="creator-info">
          <h5>{{ $ejercicio->user->name ?? 'Entrenador' }}</h5>
          <p>{{ $ejercicio->user->role ?? 'Entrenador Certificado' }}</p>
        </div>
      </div>
    </div>
    
    <!-- Tips -->
    <div class="info-card" style="background: linear-gradient(135deg, #fff9e6, #fff3cd); border: none;">
      <div class="info-card-header" style="border-bottom-color: rgba(0,0,0,0.1);">
        <div class="info-card-icon" style="background: linear-gradient(135deg, #ffc107, #ff9800);">
          <i class="fas fa-lightbulb"></i>
        </div>
        <h3 class="info-card-title" style="color: #856404;">Consejos</h3>
      </div>
      <div class="info-card-body" style="color: #856404;">
        <ul style="padding-left: 1.25rem; margin: 0;">
          <li>Mantén una postura correcta durante todo el ejercicio</li>
          <li>Respira de forma controlada</li>
          <li>Realiza el movimiento de forma lenta y controlada</li>
          <li>No uses momentum para levantar el peso</li>
        </ul>
      </div>
    </div>
  </div>
</div>

@endsection
