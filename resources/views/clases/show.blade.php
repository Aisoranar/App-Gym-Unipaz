@extends('layouts.app')
@section('title', 'Detalle de Clase')
@section('content')
<style>
  :root {
    --primary: #001f3f;   /* Azul oscuro */
    --secondary: #013220; /* Verde oscuro */
    --bg-dark: #000814;   /* Fondo muy oscuro */
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
    overflow: hidden;
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
    <h1><i class="fa-solid fa-chalkboard-teacher"></i> {{ $clase->titulo }}</h1>
    <p class="lead">¡Entrena con pasión!</p>
  </div>
</div>

<!-- Contenido -->
<div class="container my-5">
  <div class="card-neon">
    <h4 class="mb-3"><i class="fa-solid fa-info-circle"></i> Detalles de la Clase</h4>
    <div class="row">
      <div class="col-md-6">
        <p><strong>Descripción:</strong> {{ $clase->descripcion }}</p>
        <p><strong>Fecha:</strong> {{ $clase->fecha }}</p>
      </div>
      <div class="col-md-6">
        <p><strong>Hora de Inicio:</strong> {{ $clase->hora_inicio }}</p>
        @if($clase->hora_fin)
          <p><strong>Hora de Fin:</strong> {{ $clase->hora_fin }}</p>
        @endif
      </div>
    </div>
  </div>
  <div class="text-end">
    <a href="{{ route('clases.index') }}" class="btn btn-neon btn-lg">
      <i class="fa-solid fa-arrow-left"></i> Volver a la lista
    </a>
  </div>
</div>
@endsection
