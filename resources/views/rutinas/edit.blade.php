@extends('layouts.app')
@section('title', 'Editar Rutina')
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
        <i class="fa-solid fa-running"></i> Editar Rutina
    </h1>
    <form method="POST" action="{{ route('rutinas.update', $rutina) }}">
      @csrf
      @method('PUT')
      
      <div class="form-section">
          <h5><i class="fa-solid fa-info-circle"></i> Detalles de la Rutina</h5>
          <div class="row g-3">
              <div class="col-12">
                  <label for="nombre">Nombre de la Rutina</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-tag"></i></span>
                      <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $rutina->nombre }}" required>
                  </div>
              </div>
              <div class="col-12">
                  <label for="descripcion">Descripción</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-align-left"></i></span>
                      <textarea name="descripcion" id="descripcion" class="form-control">{{ $rutina->descripcion }}</textarea>
                  </div>
              </div>
              <div class="col-md-6">
                  <label for="dias_por_semana">Días por Semana</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-calendar-day"></i></span>
                      <input type="number" name="dias_por_semana" id="dias_por_semana" class="form-control" value="{{ $rutina->dias_por_semana }}">
                  </div>
              </div>
              <div class="col-12">
                  <label for="ejercicios">Selecciona Ejercicios (Ctrl para múltiples selección)</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-dumbbell"></i></span>
                      <select name="ejercicios[]" id="ejercicios" class="form-select" multiple>
                        @foreach($ejercicios as $ejercicio)
                          <option value="{{ $ejercicio->id }}" {{ in_array($ejercicio->id, $rutina->ejercicios->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $ejercicio->nombre_ejercicio }}
                          </option>
                        @endforeach
                      </select>
                  </div>
              </div>
          </div>
      </div>
      
      <div class="text-end mt-4">
          <button type="submit" class="btn btn-primary btn-lg shadow-sm px-5">
              <i class="fa-solid fa-floppy-disk"></i> Actualizar Rutina
          </button>
          <a href="{{ route('rutinas.index') }}" class="btn btn-secondary ms-2">
              <i class="fa-solid fa-arrow-left"></i> Volver a la lista
          </a>
      </div>
    </form>
</div>

@endsection
