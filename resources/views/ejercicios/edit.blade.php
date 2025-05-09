@extends('layouts.app')
@section('title', 'Editar Ejercicio')
@section('content')

<!-- Estilos personalizados con fondo blanco y sección destacada -->
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
        <i class="fa-solid fa-dumbbell"></i> Editar Ejercicio
    </h1>
    <form method="POST" action="{{ route('ejercicios.update', $ejercicio) }}">
      @csrf
      @method('PUT')
      
      <div class="form-section">
          <h5><i class="fa-solid fa-info-circle"></i> Detalles del Ejercicio</h5>
          <div class="row g-3">
              <div class="col-12">
                  <label for="nombre_ejercicio">Nombre del Ejercicio</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-running"></i></span>
                      <input type="text" name="nombre_ejercicio" id="nombre_ejercicio" class="form-control" value="{{ $ejercicio->nombre_ejercicio }}" required>
                  </div>
              </div>
              <div class="col-12">
                  <label for="descripcion">Descripción</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-align-left"></i></span>
                      <textarea name="descripcion" id="descripcion" class="form-control">{{ $ejercicio->descripcion }}</textarea>
                  </div>
              </div>
              <div class="col-md-4">
                  <label for="series">Series</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-chart-line"></i></span>
                      <input type="number" name="series" id="series" class="form-control" value="{{ $ejercicio->series }}">
                  </div>
              </div>
              <div class="col-md-4">
                  <label for="repeticiones">Repeticiones</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-repeat"></i></span>
                      <input type="number" name="repeticiones" id="repeticiones" class="form-control" value="{{ $ejercicio->repeticiones }}">
                  </div>
              </div>
              <div class="col-md-4">
                  <label for="duracion">Duración (minutos)</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-hourglass-half"></i></span>
                      <input type="number" name="duracion" id="duracion" class="form-control" value="{{ $ejercicio->duracion }}">
                  </div>
              </div>
              <div class="col-md-6">
                  <label for="fecha">Fecha</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-calendar-check"></i></span>
                      <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $ejercicio->fecha }}" required>
                  </div>
              </div>
          </div>
      </div>
      
      <div class="text-end">
          <button type="submit" class="btn btn-primary btn-lg">
              <i class="fa-solid fa-check"></i> Actualizar Ejercicio
          </button>
      </div>
    </form>
</div>

@endsection
