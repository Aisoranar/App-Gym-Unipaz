@extends('layouts.app')
@section('title', 'Detalle del Plan Nutricional')
@section('content')

<!-- Header -->
<div class="show-header">
  <h1>
    <i class="fas fa-apple-alt"></i>
    {{ $plan->nombre }}
  </h1>
</div>

<!-- Información Principal -->
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-info-circle"></i> Información del Plan
  </div>
  <div class="row">
    <div class="col-md-6 show-field">
      <div class="show-label">Calorías diarias</div>
      <div class="show-value h4 text-primary">{{ $plan->calorias_diarias }} <small class="text-muted">kcal</small></div>
    </div>
    <div class="col-md-6 show-field">
      <div class="show-label">Objetivo</div>
      <div class="show-value">{{ $plan->objetivo ?? 'No definido' }}</div>
    </div>
  </div>
</div>

<!-- Descripción -->
@if($plan->descripcion)
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-align-left"></i> Descripción
  </div>
  <p class="mb-0">{{ $plan->descripcion }}</p>
</div>
@endif

<!-- Recomendaciones -->
@if($plan->recomendaciones)
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-clipboard-list"></i> Recomendaciones
  </div>
  <p class="mb-0">{{ $plan->recomendaciones }}</p>
</div>
@endif

<!-- Acciones -->
<div class="show-actions">
  <a href="{{ route('planes.index') }}" class="btn-back">
    <i class="fas fa-arrow-left"></i> Volver
  </a>
  <a href="{{ route('planes.edit', $plan) }}" class="btn-edit">
    <i class="fas fa-edit"></i> Editar
  </a>
</div>

@endsection
