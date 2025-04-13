@extends('layouts.app')
@section('title', 'Editar Recomendación')
@section('content')

<style>
    .form-section {
        background: #f8f9fa;
        border-radius: 0.5rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
        border-left: 4px solid #0d6efd;
    }
    .form-section h5 {
        margin-bottom: 1.5rem;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 0.5rem;
    }
    label {
        font-weight: 500;
        margin-bottom: 0.3rem;
    }
</style>

<div class="container py-4">
    <h1 class="mb-4 text-primary fw-bold">
        <i class="fa-solid fa-lightbulb"></i> Editar Recomendación
    </h1>
    <form method="POST" action="{{ route('recomendaciones.update', $recomendacion) }}">
      @csrf
      @method('PUT')
      
      <div class="form-section">
          <h5><i class="fa-solid fa-info-circle"></i> Contenido, Fecha y Destinatario</h5>
          <div class="row g-3">
              <div class="col-12">
                  <label for="contenido">Contenido</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-align-left"></i></span>
                      <textarea name="contenido" id="contenido" class="form-control" required>{{ $recomendacion->contenido }}</textarea>
                  </div>
              </div>
              <div class="col-md-6">
                  <label for="fecha">Fecha</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-calendar-check"></i></span>
                      <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $recomendacion->fecha }}" required>
                  </div>
              </div>
              <div class="col-md-6">
                  <label for="user_id">Asignar a Usuario</label>
                  <select name="user_id" id="user_id" class="form-select" required>
                      <option value="">Selecciona un usuario</option>
                      @foreach($usuarios as $usuario)
                          <option value="{{ $usuario->id }}" {{ $recomendacion->user_id == $usuario->id ? 'selected' : '' }}>
                              {{ $usuario->name }}
                          </option>
                      @endforeach
                  </select>
              </div>
          </div>
      </div>
      
      <div class="text-end mt-4">
          <button type="submit" class="btn btn-primary btn-lg shadow-sm px-5">
              <i class="fa-solid fa-floppy-disk"></i> Actualizar Recomendación
          </button>
          <a href="{{ route('recomendaciones.index') }}" class="btn btn-secondary ms-2">
              <i class="fa-solid fa-arrow-left"></i> Volver a la lista
          </a>
      </div>
    </form>
</div>

@endsection
