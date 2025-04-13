@extends('layouts.app')
@section('title', 'Detalle de Rutina')
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
    <h1><i class="fa-solid fa-running"></i> {{ $rutina->nombre }}</h1>
    <p class="lead">Diseña tu rutina perfecta</p>
  </div>
</div>

<!-- Contenido -->
<div class="container my-5">
  <div class="card-neon">
    <h4 class="mb-3"><i class="fa-solid fa-info-circle"></i> Detalles de la Rutina</h4>
    <div class="row">
      <div class="col-md-6">
        <p><strong>Descripción:</strong> {{ $rutina->descripcion }}</p>
        <p><strong>Días por Semana:</strong> {{ $rutina->dias_por_semana }}</p>
      </div>
      <div class="col-md-6">
        <h5 class="mb-3"><i class="fa-solid fa-dumbbell"></i> Ejercicios</h5>
        @if($rutina->ejercicios->isNotEmpty())
          <ul class="list-group">
            @foreach($rutina->ejercicios as $ejercicio)
              <li class="list-group-item" style="background: var(--card-bg); border: none; color: var(--neon);">
                {{ $ejercicio->nombre_ejercicio }}
              </li>
            @endforeach
          </ul>
        @else
          <p>No se han asignado ejercicios.</p>
        @endif
      </div>
    </div>
  </div>
  <div class="text-end">
    <a href="{{ route('rutinas.index') }}" class="btn btn-neon btn-lg">
      <i class="fa-solid fa-arrow-left"></i> Volver a la lista
    </a>
  </div>
</div>
@endsection
