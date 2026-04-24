@extends('layouts.app')
@section('title', 'Detalle de la Clase')
@section('content')

<!-- Header -->
<div class="show-header">
  <h1>
    <i class="fas fa-chalkboard-teacher"></i>
    {{ $clase->titulo }}
  </h1>
  <span class="badge {{ $clase->is_active ? 'bg-success' : 'bg-secondary' }} mt-2">
    {{ $clase->is_active ? 'Activa' : 'Inactiva' }}
  </span>
</div>

<!-- Imagen -->
@if($clase->imagen)
<div class="show-section text-center">
  <img src="{{ asset('storage/' . $clase->imagen) }}" alt="{{ $clase->titulo }}" class="img-fluid rounded" style="max-height: 300px; object-fit: cover;">
</div>
@endif

<!-- Información General -->
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-info-circle"></i> Información General
  </div>
  <div class="row">
    <div class="col-md-6 show-field">
      <div class="show-label">Fecha y Hora</div>
      <div class="show-value">{{ \Carbon\Carbon::parse($clase->fecha)->format('d/m/Y') }} · {{ \Carbon\Carbon::parse($clase->hora_inicio)->format('H:i') }}</div>
    </div>
    <div class="col-md-6 show-field">
      <div class="show-label">Entrenador</div>
      <div class="show-value">{{ $clase->user ? $clase->user->name : 'No asignado' }}</div>
    </div>
    @if($clase->hora_fin)
    <div class="col-md-6 show-field">
      <div class="show-label">Hora de fin</div>
      <div class="show-value">{{ \Carbon\Carbon::parse($clase->hora_fin)->format('H:i') }}</div>
    </div>
    @endif
    @if($clase->nivel)
    <div class="col-md-6 show-field">
      <div class="show-label">Nivel</div>
      <div class="show-value">{{ ucfirst($clase->nivel) }}</div>
    </div>
    @endif
    <div class="col-md-6 show-field">
      <div class="show-label">Cupos</div>
      <div class="show-value">{{ $clase->participants->count() }} {{ $clase->max_participantes ? '/ '.$clase->max_participantes : '' }} inscritos</div>
    </div>
  </div>
</div>

<!-- Descripción -->
@if($clase->descripcion)
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-align-left"></i> Descripción
  </div>
  <p class="mb-0">{{ $clase->descripcion }}</p>
</div>
@endif

<!-- Objetivos -->
@if($clase->objetivos)
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-bullseye"></i> Objetivos
  </div>
  <p class="mb-0">{{ $clase->objetivos }}</p>
</div>
@endif

<!-- Participantes -->
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-users"></i> Participantes ({{ $clase->participants->count() }})
  </div>
  @if($clase->participants->isNotEmpty())
    <div class="row">
      @foreach($clase->participants as $participant)
        <div class="col-md-6 col-lg-4 mb-2">
          <span class="badge bg-light text-dark border p-2 w-100 text-start">
            <i class="fas fa-user me-2"></i>{{ $participant->name }}
          </span>
        </div>
      @endforeach
    </div>
  @else
    <p class="text-muted mb-0">No hay participantes inscritos.</p>
  @endif
</div>

<!-- Acciones -->
<div class="show-actions">
  <a href="{{ route('clases.index') }}" class="btn-back">
    <i class="fas fa-arrow-left"></i> Volver
  </a>
  
  @if(auth()->user()->role === 'usuario')
    @if($clase->participants->contains(auth()->user()->id))
      <form method="POST" action="{{ route('clases.leave', $clase) }}" class="d-inline">
        @csrf
        <button type="submit" class="btn-delete">
          <i class="fas fa-sign-out-alt"></i> Salir
        </button>
      </form>
    @else
      <form method="POST" action="{{ route('clases.join', $clase) }}" class="d-inline">
        @csrf
        <button type="submit" class="btn-primary-gym">
          <i class="fas fa-sign-in-alt"></i> Unirse
        </button>
      </form>
    @endif
  @endif
  
  @if(in_array(auth()->user()->role, ['entrenador', 'superadmin']))
    <a href="{{ route('clases.edit', $clase) }}" class="btn-edit">
      <i class="fas fa-edit"></i> Editar
    </a>
  @endif
</div>

@endsection
