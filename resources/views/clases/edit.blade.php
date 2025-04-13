@extends('layouts.app')
@section('title', 'Editar Clase')
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
        <i class="fa-solid fa-calendar-plus"></i> Editar Clase
    </h1>

    <form method="POST" action="{{ route('clases.update', $clase) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-section">
            <h5><i class="fa-solid fa-book-open"></i> Información de la Clase</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="titulo">Título</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-heading"></i></span>
                        <input type="text" name="titulo" id="titulo" class="form-control @error('titulo') is-invalid @enderror" value="{{ old('titulo', $clase->titulo) }}" required>
                    </div>
                    @error('titulo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="fecha">Fecha</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-calendar-check"></i></span>
                        <input type="date" name="fecha" id="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha', $clase->fecha) }}" required>
                    </div>
                    @error('fecha')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="descripcion">Descripción</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-align-left"></i></span>
                        <textarea name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $clase->descripcion) }}</textarea>
                    </div>
                    @error('descripcion')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="objetivos">Objetivos</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-bullseye"></i></span>
                        <textarea name="objetivos" id="objetivos" class="form-control @error('objetivos') is-invalid @enderror">{{ old('objetivos', $clase->objetivos) }}</textarea>
                    </div>
                    @error('objetivos')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="hora_inicio">Hora de Inicio</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-clock"></i></span>
                        <input type="time" name="hora_inicio" id="hora_inicio" class="form-control @error('hora_inicio') is-invalid @enderror" value="{{ old('hora_inicio', $clase->hora_inicio) }}" required>
                    </div>
                    @error('hora_inicio')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="hora_fin">Hora de Fin (opcional)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-clock-rotate-left"></i></span>
                        <input type="time" name="hora_fin" id="hora_fin" class="form-control @error('hora_fin') is-invalid @enderror" value="{{ old('hora_fin', $clase->hora_fin) }}">
                    </div>
                    @error('hora_fin')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="nivel">Nivel (opcional)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-layer-group"></i></span>
                        <input type="text" name="nivel" id="nivel" class="form-control @error('nivel') is-invalid @enderror" value="{{ old('nivel', $clase->nivel) }}">
                    </div>
                    @error('nivel')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="max_participantes">Máximo de Participantes (opcional)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-users"></i></span>
                        <input type="number" name="max_participantes" id="max_participantes" min="1" class="form-control @error('max_participantes') is-invalid @enderror" value="{{ old('max_participantes', $clase->max_participantes) }}">
                    </div>
                    @error('max_participantes')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="imagen">Imagen (opcional)</label>
                    <input type="file" name="imagen" id="imagen" class="form-control @error('imagen') is-invalid @enderror">
                    @error('imagen')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                    @if ($clase->imagen)
                        <div class="mt-2">
                            <strong>Imagen actual:</strong><br>
                            <img src="{{ asset('storage/' . $clase->imagen) }}" alt="Imagen actual" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    @endif
                </div>

                <div class="col-md-6">
                    <label for="is_active">¿Clase Activa?</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-toggle-on"></i></span>
                        <select name="is_active" id="is_active" class="form-select @error('is_active') is-invalid @enderror">
                            <option value="1" {{ old('is_active', $clase->is_active) == 1 ? 'selected' : '' }}>Sí</option>
                            <option value="0" {{ old('is_active', $clase->is_active) == 0 ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                    @error('is_active')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
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
