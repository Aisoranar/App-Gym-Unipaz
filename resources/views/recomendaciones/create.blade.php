@extends('layouts.app')
@section('title', 'Crear Recomendación')
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
        <i class="fa-solid fa-lightbulb"></i> Crear Nueva Recomendación
    </h1>
    <form method="POST" action="{{ route('recomendaciones.store') }}">
      @csrf
      
      <div class="form-section">
          <h5><i class="fa-solid fa-info-circle"></i> Contenido, Fecha y Destinatario</h5>
          <div class="row g-3">
              <div class="col-12">
                  <label for="contenido">Contenido</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-align-left"></i></span>
                      <textarea name="contenido" id="contenido" class="form-control" required></textarea>
                  </div>
              </div>
              <div class="col-md-6">
                  <label for="fecha">Fecha</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-calendar-check"></i></span>
                      <input type="date" name="fecha" id="fecha" class="form-control" required>
                  </div>
              </div>
              <div class="col-md-6">
                  <label for="user_id">Asignar a Usuario</label>
                  <select name="user_id" id="user_id" class="form-select" required>
                      <option value="">Selecciona un usuario</option>
                      @foreach($usuarios as $usuario)
                          <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                      @endforeach
                  </select>
              </div>
          </div>
      </div>
      
      <div class="text-end">
          <button type="submit" class="btn btn-primary btn-lg">
              <i class="fa-solid fa-check"></i> Crear Recomendación
          </button>
      </div>
    </form>
</div>

@endsection
