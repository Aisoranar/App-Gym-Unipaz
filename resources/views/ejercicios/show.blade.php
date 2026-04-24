@extends('layouts.app')
@section('title', 'Detalle del Ejercicio')
@section('content')

<!-- Header -->
<div class="show-header">
  <h1>
    <i class="fas fa-dumbbell"></i>
    {{ $ejercicio->nombre_ejercicio }}
  </h1>
  <p class="mb-0 mt-2 opacity-75">{{ $ejercicio->fecha }}</p>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
  <div class="col-6 col-md-4">
    <div class="gym-card text-center" style="border-left: 4px solid #003379;">
      <div class="h2 mb-1 text-primary">{{ $ejercicio->series }}</div>
      <small class="text-muted">Series</small>
    </div>
  </div>
  <div class="col-6 col-md-4">
    <div class="gym-card text-center" style="border-left: 4px solid #28a745;">
      <div class="h2 mb-1 text-success">{{ $ejercicio->repeticiones }}</div>
      <small class="text-muted">Repeticiones</small>
    </div>
  </div>
  <div class="col-12 col-md-4 mt-3 mt-md-0">
    <div class="gym-card text-center" style="border-left: 4px solid #ffc107;">
      <div class="h2 mb-1 text-warning">{{ $ejercicio->duracion }} <small class="fs-6">min</small></div>
      <small class="text-muted">Duración</small>
    </div>
  </div>
</div>

<!-- Descripción -->
@if($ejercicio->descripcion)
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-align-left"></i> Descripción
  </div>
  <p class="mb-0" style="font-size: 1.05rem; line-height: 1.7;">{{ $ejercicio->descripcion }}</p>
</div>
@endif

<!-- Detalles Técnicos -->
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-cogs"></i> Detalles Técnicos
  </div>
  <div class="row">
    <div class="col-md-3 show-field">
      <div class="show-label">Nombre</div>
      <div class="show-value fw-bold">{{ $ejercicio->nombre_ejercicio }}</div>
    </div>
    <div class="col-md-3 show-field">
      <div class="show-label">Series</div>
      <div class="show-value">{{ $ejercicio->series }}</div>
    </div>
    <div class="col-md-3 show-field">
      <div class="show-label">Repeticiones</div>
      <div class="show-value">{{ $ejercicio->repeticiones }}</div>
    </div>
    <div class="col-md-3 show-field">
      <div class="show-label">Duración</div>
      <div class="show-value">{{ $ejercicio->duracion }} minutos</div>
    </div>
    <div class="col-md-3 show-field">
      <div class="show-label">Fecha</div>
      <div class="show-value">{{ $ejercicio->fecha }}</div>
    </div>
  </div>
</div>

<!-- Cálculo Total -->
<div class="show-section" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef);">
  <div class="show-section-title">
    <i class="fas fa-calculator"></i> Resumen de la Sesión
  </div>
  <div class="row text-center">
    <div class="col-4">
      <div class="h4 text-primary">{{ $ejercicio->series * $ejercicio->repeticiones }}</div>
      <small class="text-muted">Repeticiones totales</small>
    </div>
    <div class="col-4">
      <div class="h4 text-success">{{ $ejercicio->series }}</div>
      <small class="text-muted">Series completadas</small>
    </div>
    <div class="col-4">
      <div class="h4 text-warning">{{ $ejercicio->duracion }} min</div>
      <small class="text-muted">Tiempo estimado</small>
    </div>
  </div>
</div>

<!-- Acciones -->
<div class="show-actions">
  <a href="{{ route('ejercicios.index') }}" class="btn-back">
    <i class="fas fa-arrow-left"></i> Volver
  </a>
  @if(Auth::user()->role === 'entrenador' || Auth::user()->role === 'superadmin')
    <a href="{{ route('ejercicios.edit', $ejercicio) }}" class="btn-edit">
      <i class="fas fa-edit"></i> Editar
    </a>
  @endif
</div>

@endsection
