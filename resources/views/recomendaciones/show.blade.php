@extends('layouts.app')
@section('title', 'Detalle de Recomendación')
@section('content')

<!-- Header -->
<div class="show-header">
  <h1>
    <i class="fas fa-notes-medical"></i>
    Recomendación
  </h1>
  <p class="mb-0 mt-2 opacity-75">Para: {{ $recomendacion->user->name ?? 'Usuario' }}</p>
</div>

<!-- Contenido -->
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-comment-medical"></i> Contenido de la Recomendación
  </div>
  <div class="show-field">
    <div class="show-value" style="font-size: 1.1rem; line-height: 1.8;">
      {{ $recomendacion->contenido }}
    </div>
  </div>
</div>

<!-- Detalles -->
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-info-circle"></i> Detalles
  </div>
  <div class="row">
    <div class="col-md-4 show-field">
      <div class="show-label">Fecha</div>
      <div class="show-value">{{ $recomendacion->fecha ?? ($recomendacion->created_at ? $recomendacion->created_at->format('d/m/Y') : 'Sin fecha') }}</div>
    </div>
    <div class="col-md-4 show-field">
      <div class="show-label">Creado por</div>
      <div class="show-value">{{ optional($recomendacion->creador)->name ?? 'Entrenador' }}</div>
    </div>
    <div class="col-md-4 show-field">
      <div class="show-label">Para</div>
      <div class="show-value">{{ optional($recomendacion->user)->name ?? 'Usuario' }}</div>
    </div>
  </div>
</div>

<!-- Acciones -->
<div class="show-actions">
  <a href="{{ route('recomendaciones.index') }}" class="btn-back">
    <i class="fas fa-arrow-left"></i> Volver
  </a>
  @if(in_array(Auth::user()->role, ['entrenador', 'superadmin']) && (Auth::user()->role === 'superadmin' || Auth::id() == $recomendacion->creado_por))
    <a href="{{ route('recomendaciones.edit', ['recomendacion' => $recomendacion->id]) }}" class="btn-edit">
      <i class="fas fa-edit"></i> Editar
    </a>
  @endif
</div>

@endsection
