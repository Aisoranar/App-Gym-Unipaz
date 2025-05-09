@extends('layouts.app')
@section('title', 'Crear Plan Nutricional')
@section('content')

<!-- Estilos personalizados con fondo blanco y sección destacada -->
<style>
  :root {
    --primary: #001f3f;
    --secondary: #013220;
    --white: #ffffff;
  }
  body {
    background: var(--white);
    color: var(--primary);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  .form-section {
    background: var(--white);
    border-radius: 0.5rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    border-left: 4px solid var(--primary);
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
  h1.page-title {
    color: var(--primary);
    margin-bottom: 1.5rem;
  }
  .btn-primary {
    background: var(--primary);
    border-color: var(--primary);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
  }
  .btn-primary:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
  }
</style>

<div class="container py-4">
  <h1 class="page-title">
    <i class="fa-solid fa-apple-whole"></i> Crear Nuevo Plan Nutricional
  </h1>
  <form method="POST" action="{{ route('planes.store') }}">
    @csrf

    <div class="form-section">
      <h5><i class="fa-solid fa-info-circle"></i> Datos del Plan</h5>
      <div class="row g-3">
        <div class="col-md-6">
          <label for="nombre">Nombre</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-tag"></i></span>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
          </div>
        </div>
        <div class="col-md-6">
          <label for="calorias_diarias">Calorías Diarias</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-fire"></i></span>
            <input type="number" name="calorias_diarias" id="calorias_diarias" class="form-control">
          </div>
        </div>
        <div class="col-12">
          <label for="descripcion">Descripción</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-align-left"></i></span>
            <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
          </div>
        </div>
        <div class="col-12">
          <label for="recomendaciones">Recomendaciones</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-comments"></i></span>
            <textarea name="recomendaciones" id="recomendaciones" class="form-control"></textarea>
          </div>
        </div>
      </div>
    </div>

    <div class="text-end">
      <button type="submit" class="btn btn-primary btn-lg">
        <i class="fa-solid fa-check"></i> Crear Plan
      </button>
    </div>
  </form>
</div>

@endsection
