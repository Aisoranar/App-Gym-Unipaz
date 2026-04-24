@extends('layouts.app')
@section('title', 'Detalle de la Clase')
@section('content')

<!-- Header -->
<div class="show-header" style="background: linear-gradient(135deg, #003379, #0056a8);">
  <div class="row align-items-center">
    <div class="col-md-8">
      <h1>
        <i class="fas fa-chalkboard-teacher"></i>
        {{ $clase->titulo }}
      </h1>
      <div class="d-flex gap-2 mt-2">
        <span class="badge {{ $clase->is_active ? 'bg-success' : 'bg-secondary' }} fs-6">
          {{ $clase->is_active ? 'Activa' : 'Inactiva' }}
        </span>
        @if($clase->nivel)
          <span class="badge bg-light text-dark fs-6">{{ ucfirst($clase->nivel) }}</span>
        @endif
      </div>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
      @if(auth()->user()->role === 'usuario')
        @if($clase->participants->contains(auth()->user()->id))
          <form method="POST" action="{{ route('clases.leave', $clase) }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger btn-lg">
              <i class="fas fa-sign-out-alt me-2"></i>Salir de la Clase
            </button>
          </form>
        @else
          <form method="POST" action="{{ route('clases.join', $clase) }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success btn-lg" {{ $clase->max_participantes && $clase->participants->count() >= $clase->max_participantes ? 'disabled' : '' }}>
              <i class="fas fa-sign-in-alt me-2"></i>{{ $clase->max_participantes && $clase->participants->count() >= $clase->max_participantes ? 'Cupos llenos' : 'Unirse a la Clase' }}
            </button>
          </form>
        @endif
      @endif
    </div>
  </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
  <div class="col-6 col-md-3">
    <div class="gym-card text-center" style="border-top: 4px solid #003379;">
      <i class="fas fa-calendar-day fa-2x text-primary mb-2"></i>
      <div class="h5 mb-0">{{ \Carbon\Carbon::parse($clase->fecha)->format('d/m') }}</div>
      <small class="text-muted">Fecha</small>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="gym-card text-center" style="border-top: 4px solid #28a745;">
      <i class="fas fa-clock fa-2x text-success mb-2"></i>
      <div class="h5 mb-0">{{ \Carbon\Carbon::parse($clase->hora_inicio)->format('H:i') }}</div>
      <small class="text-muted">Inicio</small>
    </div>
  </div>
  <div class="col-6 col-md-3 mt-3 mt-md-0">
    <div class="gym-card text-center" style="border-top: 4px solid #ffc107;">
      <i class="fas fa-hourglass-half fa-2x text-warning mb-2"></i>
      <div class="h5 mb-0">
        @if($clase->hora_fin)
          {{ \Carbon\Carbon::parse($clase->hora_inicio)->diffInMinutes(\Carbon\Carbon::parse($clase->hora_fin)) }} min
        @else
          --
        @endif
      </div>
      <small class="text-muted">Duración</small>
    </div>
  </div>
  <div class="col-6 col-md-3 mt-3 mt-md-0">
    <div class="gym-card text-center" style="border-top: 4px solid #dc3545;">
      <i class="fas fa-users fa-2x text-danger mb-2"></i>
      <div class="h5 mb-0">{{ $clase->participants->count() }}{{ $clase->max_participantes ? '/'.$clase->max_participantes : '' }}</div>
      <small class="text-muted">Cupos</small>
    </div>
  </div>
</div>

<div class="row">
  <!-- Columna izquierda -->
  <div class="col-lg-8">
    <!-- Imagen -->
    @if($clase->imagen)
    <div class="show-section p-0 overflow-hidden">
      <img src="{{ asset('storage/' . $clase->imagen) }}" alt="{{ $clase->titulo }}" class="img-fluid w-100" style="max-height: 350px; object-fit: cover;">
    </div>
    @endif
    
    <!-- Descripción -->
    @if($clase->descripcion)
    <div class="show-section">
      <div class="show-section-title">
        <i class="fas fa-align-left"></i> Descripción
      </div>
      <p class="mb-0" style="font-size: 1.05rem; line-height: 1.7;">{{ $clase->descripcion }}</p>
    </div>
    @endif
    
    <!-- Objetivos -->
    @if($clase->objetivos)
    <div class="show-section">
      <div class="show-section-title">
        <i class="fas fa-bullseye"></i> Objetivos
      </div>
      <div class="d-flex flex-wrap gap-2">
        @foreach(explode(',', $clase->objetivos) as $objetivo)
          <span class="badge bg-primary p-2">{{ trim($objetivo) }}</span>
        @endforeach
      </div>
    </div>
    @endif
  </div>
  
  <!-- Columna derecha -->
  <div class="col-lg-4">
    <!-- Info General -->
    <div class="show-section">
      <div class="show-section-title">
        <i class="fas fa-info-circle"></i> Detalles
      </div>
      <div class="show-field">
        <div class="show-label">Entrenador</div>
        <div class="show-value d-flex align-items-center">
          <i class="fas fa-user-circle me-2 text-primary"></i>
          {{ $clase->user ? $clase->user->name : 'No asignado' }}
        </div>
      </div>
      <div class="show-field">
        <div class="show-label">Fecha completa</div>
        <div class="show-value">{{ \Carbon\Carbon::parse($clase->fecha)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</div>
      </div>
      @if($clase->hora_fin)
      <div class="show-field">
        <div class="show-label">Hora de finalización</div>
        <div class="show-value">{{ \Carbon\Carbon::parse($clase->hora_fin)->format('H:i') }}</div>
      </div>
      @endif
    </div>
    
    <!-- Participantes -->
    <div class="show-section">
      <div class="show-section-title">
        <i class="fas fa-users"></i> Participantes
        <span class="badge bg-primary ms-2">{{ $clase->participants->count() }}</span>
      </div>
      @if($clase->participants->isNotEmpty())
        <div class="list-group list-group-flush">
          @foreach($clase->participants as $participant)
            <div class="list-group-item px-0 py-2 d-flex align-items-center">
              <i class="fas fa-user-circle text-muted me-2"></i>
              {{ $participant->name }}
            </div>
          @endforeach
        </div>
      @else
        <p class="text-muted mb-0"><i class="fas fa-info-circle me-2"></i>No hay inscritos aún.</p>
      @endif
    </div>
  </div>
</div>

<!-- Acciones Admin -->
@if(in_array(auth()->user()->role, ['entrenador', 'superadmin']))
<div class="show-actions mt-4 pt-3 border-top">
  <a href="{{ route('clases.index') }}" class="btn-back">
    <i class="fas fa-arrow-left"></i> Volver
  </a>
  <a href="{{ route('clases.edit', $clase) }}" class="btn-edit">
    <i class="fas fa-edit"></i> Editar Clase
  </a>
</div>
@else
<div class="mt-4 pt-3 border-top">
  <a href="{{ route('clases.index') }}" class="btn-back">
    <i class="fas fa-arrow-left"></i> Volver a Clases
  </a>
</div>
@endif

@endsection
