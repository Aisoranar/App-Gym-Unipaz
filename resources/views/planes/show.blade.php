@extends('layouts.app')
@section('title', 'Detalle del Plan Nutricional')
@section('content')
<!-- Estilos globales y personalizados -->
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
  /* Gradiente animado en el encabezado */
  .animated-bg {
    background: linear-gradient(45deg, var(--primary), var(--secondary));
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
    padding: 2rem 0;
    text-align: center;
  }
  @keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
  .header-show h1 {
    font-size: 2.5rem;
    font-weight: bold;
    color: var(--white);
    text-shadow: 0 0 10px rgba(0,0,0,0.3);
  }
  /* Tarjeta de detalle con fondo blanco y sombra */
  .card-detail {
    background: var(--white);
    border: none;
    border-radius: 1rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    color: var(--primary);
  }
  .card-detail h4 {
    margin-bottom: 1rem;
    font-weight: 600;
  }
  /* Botón de volver estilizado */
  .btn-back {
    background: var(--primary);
    color: var(--white);
    border: none;
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
  }
  .btn-back:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
  }
</style>

<!-- Encabezado con fondo animado -->
<div class="container-fluid animated-bg">
  <div class="container header-show">
    <h1>Detalle del Plan Nutricional</h1>
  </div>
</div>

<!-- Contenido principal -->
<div class="container my-5">
  <div class="card-detail">
    <h4><i class="fa-solid fa-info-circle"></i> {{ $plan->nombre }}</h4>
    <p><strong>Descripción:</strong> {{ $plan->descripcion }}</p>
    <p><strong>Calorías Diarias:</strong> {{ $plan->calorias_diarias }}</p>
    <p><strong>Recomendaciones:</strong> {{ $plan->recomendaciones }}</p>
  </div>
  <div class="text-end">
    <a href="{{ route('planes.index') }}" class="btn-back btn-lg">
      <i class="fa-solid fa-arrow-left"></i> Volver a la lista
    </a>
  </div>
</div>
@endsection
