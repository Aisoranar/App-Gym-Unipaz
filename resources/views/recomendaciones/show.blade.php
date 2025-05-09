@extends('layouts.app')
@section('title', 'Detalle de Recomendación')
@section('content')

<!-- Estilos personalizados con fondo blanco y diseño consistente -->
<style>
  :root {
    --primary: #001f3f;   /* Azul oscuro */
    --secondary: #013220; /* Verde oscuro */
    --white: #ffffff;
  }
  body {
    background: var(--white);
    color: var(--primary);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  /* Hero Section con gradiente y título en blanco */
  .hero {
    position: relative;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--white);
    text-shadow: 0 0 10px rgba(0,0,0,0.5);
  }
  .hero h1 {
    font-size: 3rem;
    font-weight: bold;
  }
  .hero p.lead {
    font-size: 1.25rem;
    text-shadow: 0 0 8px rgba(0,0,0,0.5);
  }
  /* Tarjeta de detalles con fondo blanco y sombra */
  .card-detail {
    background: var(--white);
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    color: var(--primary);
  }
  .card-detail h4 {
    margin-bottom: 1rem;
  }
  /* Botón de volver con diseño primario */
  .btn-back {
    background: var(--primary);
    color: var(--white);
    border: none;
    border-radius: 5px;
    padding: 0.75rem 1.5rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
  }
  .btn-back:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
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
  <div class="card-detail">
    <h4><i class="fa-solid fa-info-circle"></i> Detalles de la Recomendación</h4>
    <p><strong>Contenido:</strong> {{ $recomendacion->contenido }}</p>
    <p><strong>Fecha:</strong> {{ $recomendacion->fecha }}</p>
  </div>
  <div class="text-end">
    <a href="{{ route('recomendaciones.index') }}" class="btn-back btn-lg">
      <i class="fa-solid fa-arrow-left"></i> Volver a la lista
    </a>
  </div>
</div>
@endsection
