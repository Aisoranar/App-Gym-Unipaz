@extends('layouts.app')
@section('title', 'Editar Plan Nutricional')
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
        <i class="fa-solid fa-apple-whole"></i> Editar Plan Nutricional
    </h1>
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
      
      <div class="text-end mt-4">
          <button type="submit" class="btn btn-primary btn-lg shadow-sm px-5">
              <i class="fa-solid fa-floppy-disk"></i> Actualizar Plan
          </button>
          <a href="{{ route('planes.index') }}" class="btn btn-secondary ms-2">
              <i class="fa-solid fa-arrow-left"></i> Volver a la lista
          </a>
      </div>
    </form>
</div>

@endsection
