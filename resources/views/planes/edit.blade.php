@extends('layouts.app')
@section('title', 'Editar Plan Nutricional')
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
  /* Encabezado con gradiente animado */
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
  .header-edit h1 {
    font-size: 2.5rem;
    font-weight: bold;
    color: var(--white);
    text-shadow: 0 0 10px rgba(0,0,0,0.3);
  }
  /* Sección de formulario con fondo blanco y borde primario */
  .form-section {
    background: var(--white);
    border-left: 4px solid var(--primary);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  }
  .form-section h5 {
    margin-bottom: 1.5rem;
    font-weight: 600;
    color: var(--primary);
    border-bottom: 2px solid #dee2e6;
    padding-bottom: 0.5rem;
  }
  label {
    font-weight: 500;
    margin-bottom: 0.3rem;
  }
  /* Botones */
  .btn-primary {
    background: var(--primary);
    border-color: var(--primary);
    color: var(--white);
    transition: transform 0.3s, box-shadow 0.3s;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  }
  .btn-primary:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
  }
  .btn-secondary {
    background: var(--secondary);
    border-color: var(--secondary);
    color: var(--white);
    transition: transform 0.3s, box-shadow 0.3s;
  }
  .btn-secondary:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
  }
</style>

<!-- Encabezado con fondo animado -->
<div class="container-fluid animated-bg">
  <div class="container header-edit">
    <h1><i class="fa-solid fa-apple-whole"></i> Editar Plan Nutricional</h1>
  </div>
</div>

<!-- Contenido principal -->
<div class="container py-4">
  <form method="POST" action="{{ route('planes.update', $plan) }}">
    @csrf
    @method('PUT')

    <div class="form-section">
      <h5><i class="fa-solid fa-info-circle"></i> Datos del Plan</h5>
      <div class="row g-3">
        <div class="col-md-6">
          <label for="nombre">Nombre</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-tag"></i></span>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $plan->nombre }}" required>
          </div>
        </div>
        <div class="col-md-6">
          <label for="calorias_diarias">Calorías Diarias</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-fire"></i></span>
            <input type="number" name="calorias_diarias" id="calorias_diarias" class="form-control" value="{{ $plan->calorias_diarias }}">
          </div>
        </div>
        <div class="col-12">
          <label for="descripcion">Descripción</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-align-left"></i></span>
            <textarea name="descripcion" id="descripcion" class="form-control">{{ $plan->descripcion }}</textarea>
          </div>
        </div>
        <div class="col-12">
          <label for="recomendaciones">Recomendaciones</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-comments"></i></span>
            <textarea name="recomendaciones" id="recomendaciones" class="form-control">{{ $plan->recomendaciones }}</textarea>
          </div>
        </div>
      </div>
    </div>

    <div class="text-end">
      <button type="submit" class="btn btn-primary btn-lg px-5">
        <i class="fa-solid fa-floppy-disk"></i> Actualizar Plan
      </button>
      <a href="{{ route('planes.index') }}" class="btn btn-secondary ms-2">
        <i class="fa-solid fa-arrow-left"></i> Volver a la lista
      </a>
    </div>
  </form>
</div>
@endsection
