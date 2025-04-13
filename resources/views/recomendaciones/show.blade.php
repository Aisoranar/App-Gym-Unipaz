@extends('layouts.app')
@section('title', 'Detalle de Recomendación')
@section('content')
<style>
  :root {
    --primary: #001f3f;
    --secondary: #013220;
    --bg-dark: #000814;
    --card-bg: rgba(255, 255, 255, 0.1);
    --neon: #ffffff;
  }
  body {
    background: var(--bg-dark);
    color: var(--neon);
  }
  .hero {
    position: relative;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .hero h1 {
    font-size: 3rem;
    text-shadow: 0 0 10px var(--neon);
  }
  .hero p.lead {
    font-size: 1.25rem;
    text-shadow: 0 0 8px var(--neon);
  }
  .card-neon {
    background: var(--card-bg);
    border: 1px solid var(--neon);
    border-radius: 15px;
    box-shadow: 0 0 15px var(--neon);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    backdrop-filter: blur(5px);
  }
  .btn-neon {
    background: var(--primary);
    border: none;
    box-shadow: 0 0 10px var(--primary);
    transition: transform 0.3s;
    color: var(--neon);
  }
  .btn-neon:hover {
    transform: scale(1.05);
  }
</style>

<!-- Hero Section -->
<div class="hero">
  <div class="text-center">
    <h1><i class="fa-solid fa-comment-dots"></i> Recomendación</h1>
    <p class="lead">Consejos para potenciar tu rendimiento</p>
  </div>
</div>

<!-- Contenido -->
<div class="container my-5">
  <div class="card-neon">
    <h4 class="mb-3"><i class="fa-solid fa-info-circle"></i> Detalles de la Recomendación</h4>
    <p><strong>Contenido:</strong> {{ $recomendacion->contenido }}</p>
    <p><strong>Fecha:</strong> {{ $recomendacion->fecha }}</p>
  </div>
  <div class="text-end">
    <a href="{{ route('recomendaciones.index') }}" class="btn btn-neon btn-lg">
      <i class="fa-solid fa-arrow-left"></i> Volver a la lista
    </a>
  </div>
</div>
@endsection
