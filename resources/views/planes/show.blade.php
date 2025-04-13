@extends('layouts.app')
@section('title', 'Detalle del Plan Nutricional')
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
    <h1><i class="fa-solid fa-apple-alt"></i> {{ $plan->nombre }}</h1>
    <p class="lead">Plan de nutrición para maximizar tu rendimiento</p>
  </div>
</div>

<!-- Contenido -->
<div class="container my-5">
  <div class="card-neon">
    <h4 class="mb-3"><i class="fa-solid fa-info-circle"></i> Detalles del Plan Nutricional</h4>
    <p><strong>Descripción:</strong> {{ $plan->descripcion }}</p>
    <p><strong>Calorías Diarias:</strong> {{ $plan->calorias_diarias }}</p>
    <p><strong>Recomendaciones:</strong> {{ $plan->recomendaciones }}</p>
  </div>
  <div class="text-end">
    <a href="{{ route('planes.index') }}" class="btn btn-neon btn-lg">
      <i class="fa-solid fa-arrow-left"></i> Volver a la lista
    </a>
  </div>
</div>
@endsection
