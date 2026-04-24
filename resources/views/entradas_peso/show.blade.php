@extends('layouts.app')
@section('title', 'Detalle de Entrada de Peso')
@section('content')

<!-- Header -->
<div class="show-header">
  <h1>
    <i class="fas fa-weight-scale"></i>
    Registro de Peso
  </h1>
  <p class="mb-0 mt-2 opacity-75">{{ $entrada->fecha->format('d/m/Y') }}</p>
</div>

<!-- Estadísticas principales -->
<div class="row mb-3">
  <div class="col-6 col-md-3">
    <div class="gym-card text-center">
      <div class="h3 mb-1 text-primary">{{ $entrada->peso_actual_kg }} <small>kg</small></div>
      <small class="text-muted">Peso Actual</small>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="gym-card text-center">
      <div class="h3 mb-1 text-success">{{ $entrada->peso_ideal_kg ? $entrada->peso_ideal_kg.' kg' : '-' }}</div>
      <small class="text-muted">Peso Ideal</small>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="gym-card text-center">
      <div class="h3 mb-1">{{ $entrada->imc }}</div>
      <small class="text-muted">IMC</small>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="gym-card text-center">
      <span class="badge {{ $entrada->estado_peso == 'Normal' ? 'bg-success' : ($entrada->estado_peso == 'Bajo peso' ? 'bg-info' : ($entrada->estado_peso == 'Sobrepeso' ? 'bg-warning text-dark' : 'bg-danger')) }} fs-6">
        {{ $entrada->estado_peso }}
      </span>
      <small class="text-muted d-block mt-1">Estado</small>
    </div>
  </div>
</div>

<!-- Detalles -->
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-info-circle"></i> Detalles del Registro
  </div>
  <div class="row">
    <div class="col-md-4 show-field">
      <div class="show-label">Fecha</div>
      <div class="show-value">{{ $entrada->fecha->format('d/m/Y') }}</div>
    </div>
    <div class="col-md-4 show-field">
      <div class="show-label">Altura</div>
      <div class="show-value">{{ $entrada->altura_cm }} cm</div>
    </div>
    <div class="col-md-4 show-field">
      <div class="show-label">Registrado</div>
      <div class="show-value">{{ $entrada->created_at->diffForHumans() }}</div>
    </div>
  </div>
</div>

<!-- Análisis IMC -->
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-chart-line"></i> Análisis IMC
  </div>
  <div class="row">
    <div class="col-md-6 show-field">
      <div class="show-label">Tu IMC</div>
      <div class="show-value h4">{{ $entrada->imc }}</div>
    </div>
    <div class="col-md-6 show-field">
      <div class="show-label">Clasificación</div>
      <div class="show-value">
        <span class="badge {{ $entrada->estado_peso == 'Normal' ? 'bg-success' : ($entrada->estado_peso == 'Bajo peso' ? 'bg-info' : ($entrada->estado_peso == 'Sobrepeso' ? 'bg-warning text-dark' : 'bg-danger')) }} fs-6">
          {{ $entrada->estado_peso }}
        </span>
      </div>
    </div>
  </div>
  <div class="mt-3 p-3 bg-light rounded">
    <small class="text-muted">
      <i class="fas fa-info-circle me-2"></i>
      El IMC (Índice de Masa Corporal) es una medida que relaciona el peso con la altura. 
      Un IMC normal está entre 18.5 y 24.9.
    </small>
  </div>
</div>

<!-- Acciones -->
<div class="show-actions">
  <a href="{{ route('entradas-peso.index') }}" class="btn-back">
    <i class="fas fa-arrow-left"></i> Volver
  </a>
  <a href="{{ route('entradas-peso.edit', $entrada) }}" class="btn-edit">
    <i class="fas fa-edit"></i> Editar
  </a>
</div>

@endsection
