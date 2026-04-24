@extends('layouts.app')
@section('title', 'Mis Asistencias')
@section('content')

<!-- Header de página -->
<div class="page-header">
  <div>
    <h1>
      <i class="fas fa-list-check"></i>
      Mis Asistencias
    </h1>
    <p>Historial de tus registros de asistencia</p>
  </div>
</div>

@if($scans->isEmpty())
  <div class="text-center py-5">
    <div class="mb-3">
      <i class="fas fa-clipboard-list fa-3x text-muted"></i>
    </div>
    <h5 class="text-muted">Sin asistencias registradas</h5>
    <p class="text-muted mb-3">¡Es hora de ponerte en movimiento!</p>
    <a href="{{ route('qr-sessions.enter-code') }}" class="btn-primary-gym">
      <i class="fas fa-camera me-2"></i>Registrar Asistencia
    </a>
  </div>
@else
  <!-- Desktop: tabla -->
  <div class="gym-table-container d-none d-md-block">
    <table class="gym-table">
      <thead>
        <tr>
          <th>Sesión</th>
          <th>Fecha</th>
          <th>Carrera</th>
          <th>Actividad</th>
          <th>Registrado</th>
        </tr>
      </thead>
      <tbody>
        @foreach($scans as $scan)
          <tr>
            <td class="fw-semibold">{{ optional($scan->session)->nombre ?? 'N/A' }}</td>
            <td>{{ \Carbon\Carbon::parse($scan->fecha)->format('d/m/Y') }}</td>
            <td>{{ $scan->carrera }}</td>
            <td>{{ optional($scan->session)->actividad ?? 'No definida' }}</td>
            <td><small class="text-muted">{{ \Carbon\Carbon::parse($scan->created_at)->diffForHumans() }}</small></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- Mobile: tarjetas -->
  <div class="d-md-none">
    @foreach($scans as $scan)
      <div class="gym-card mb-3">
        <div class="gym-card-icon blue mb-2">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="gym-card-title">{{ optional($scan->session)->nombre ?? 'Sin sesión' }}</div>
        <div class="gym-card-text">
          <div class="mb-1"><i class="fas fa-calendar text-muted me-2"></i><small>{{ \Carbon\Carbon::parse($scan->fecha)->format('d/m/Y') }}</small></div>
          <div class="mb-1"><i class="fas fa-running text-muted me-2"></i><small>{{ $scan->carrera }}</small></div>
          <div class="mb-1"><i class="fas fa-dumbbell text-muted me-2"></i><small>{{ optional($scan->session)->actividad ?? 'No definida' }}</small></div>
          <div class="mt-2"><small class="text-muted"><i class="fas fa-clock me-1"></i> {{ \Carbon\Carbon::parse($scan->created_at)->diffForHumans() }}</small></div>
        </div>
      </div>
    @endforeach
  </div>
@endif

@endsection
