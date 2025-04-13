@extends('layouts.app')
@section('title', 'Crear Clase')
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
        <i class="fa-solid fa-calendar-plus"></i> Crear Nueva Clase
    </h1>
    <!-- Se añade enctype para subir archivos -->
    <form method="POST" action="{{ route('clases.store') }}" enctype="multipart/form-data">
      @csrf
      
      <div class="form-section">
          <h5><i class="fa-solid fa-book-open"></i> Información de la Clase</h5>
          <div class="row g-3">
              <div class="col-md-6">
                  <label for="titulo">Título</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-heading"></i></span>
                      <input type="text" name="titulo" id="titulo" class="form-control" required>
                  </div>
              </div>
              <div class="col-md-6">
                  <label for="fecha">Fecha</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-calendar-check"></i></span>
                      <input type="date" name="fecha" id="fecha" class="form-control" required>
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
                  <label for="objetivos">Objetivos de la Clase</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-bullseye"></i></span>
                      <textarea name="objetivos" id="objetivos" class="form-control" placeholder="Ej: Mejorar flexibilidad y técnica de respiración"></textarea>
                  </div>
              </div>
              <div class="col-md-4">
                  <label for="hora_inicio">Hora de Inicio</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-clock"></i></span>
                      <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" required>
                  </div>
              </div>
              <div class="col-md-4">
                  <label for="hora_fin">Hora de Fin (opcional)</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-clock-rotate-left"></i></span>
                      <input type="time" name="hora_fin" id="hora_fin" class="form-control">
                  </div>
              </div>
              <div class="col-md-4">
                  <label for="nivel">Nivel de la Clase</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-signal"></i></span>
                      <input type="text" name="nivel" id="nivel" class="form-control" placeholder="Ej: Principiante">
                  </div>
              </div>
              <div class="col-md-6">
                  <label for="max_participantes">Máximo de Participantes</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-users"></i></span>
                      <input type="number" name="max_participantes" id="max_participantes" class="form-control" min="1">
                  </div>
              </div>
              <div class="col-md-6">
                  <label for="imagen">Imagen</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-image"></i></span>
                      <input type="file" name="imagen" id="imagen" class="form-control">
                  </div>
              </div>
              <div class="col-md-6">
                  <label for="is_active">Estado de la Clase</label>
                  <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-toggle-on"></i></span>
                      <select name="is_active" id="is_active" class="form-select" required>
                          <option value="1" selected>Activa</option>
                          <option value="0">Inactiva</option>
                      </select>
                  </div>
              </div>
          </div>
      </div>
      
      <div class="text-end">
          <button type="submit" class="btn btn-primary btn-lg">
              <i class="fa-solid fa-check"></i> Crear Clase
          </button>
      </div>
    </form>
</div>

@endsection
