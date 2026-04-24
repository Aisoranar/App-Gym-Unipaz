@extends('layouts.app')
@section('title', 'Detalle del Ejercicio')
@section('content')

<!-- Header -->
<div class="show-header">
  <h1>
    <i class="fas fa-dumbbell"></i>
    {{ $ejercicio->nombre_ejercicio }}
  </h1>
</div>

<!-- Detalles -->
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-info-circle"></i> Información del Ejercicio
  </div>
  <div class="row">
    <div class="col-md-6 show-field">
      <div class="show-label">Descripción</div>
      <div class="show-value">{{ $ejercicio->descripcion ?? 'Sin descripción' }}</div>
    </div>
    <div class="col-md-6 show-field">
      <div class="show-label">Fecha</div>
      <div class="show-value">{{ $ejercicio->fecha }}</div>
    </div>
    <div class="col-md-4 show-field">
      <div class="show-label">Series</div>
      <div class="show-value">{{ $ejercicio->series }}</div>
    </div>
    <div class="col-md-4 show-field">
      <div class="show-label">Repeticiones</div>
      <div class="show-value">{{ $ejercicio->repeticiones }}</div>
    </div>
    <div class="col-md-4 show-field">
      <div class="show-label">Duración</div>
      <div class="show-value">{{ $ejercicio->duracion }} minutos</div>
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
