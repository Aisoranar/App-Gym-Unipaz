@extends('layouts.app')
@section('title', 'Editar Clase')
@section('content')

<!-- Estilos personalizados compartidos -->
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
        <i class="fa-solid fa-calendar-plus"></i> Editar Clase
    </h1>
    <form method="POST" action="{{ route('clases.update', $clase) }}">
      @csrf
      @method('PUT')
      
      <div class="form-section">
          <h5><i class="fa-solid fa-book-open"></i> Información de la Clase</h5>
          <div class="row g-3">
              <div class="col-md-6">
                  <label for="titulo">Título</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-heading"></i></span>
                      <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $clase->titulo }}" required>
                  </div>
              </div>
              <div class="col-md-6">
                  <label for="fecha">Fecha</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-calendar-check"></i></span>
                      <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $clase->fecha }}" required>
                  </div>
              </div>
              <div class="col-12">
                  <label for="descripcion">Descripción</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-align-left"></i></span>
                      <textarea name="descripcion" id="descripcion" class="form-control">{{ $clase->descripcion }}</textarea>
                  </div>
              </div>
              <div class="col-md-6">
                  <label for="hora_inicio">Hora de Inicio</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-clock"></i></span>
                      <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" value="{{ $clase->hora_inicio }}" required>
                  </div>
              </div>
              <div class="col-md-6">
                  <label for="hora_fin">Hora de Fin (opcional)</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-clock-rotate-left"></i></span>
                      <input type="time" name="hora_fin" id="hora_fin" class="form-control" value="{{ $clase->hora_fin }}">
                  </div>
              </div>
          </div>
      </div>
      
      <div class="text-end mt-4">
          <button type="submit" class="btn btn-primary btn-lg shadow-sm px-5">
              <i class="fa-solid fa-floppy-disk"></i> Actualizar Clase
          </button>
          <a href="{{ route('clases.index') }}" class="btn btn-secondary ms-2">
              <i class="fa-solid fa-arrow-left"></i> Volver a la lista
          </a>
      </div>
    </form>
</div>

@endsection
