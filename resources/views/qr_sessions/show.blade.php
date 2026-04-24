@extends('layouts.app')
@section('title', 'Detalle de Sesión QR')
@section('content')

<!-- Header -->
<div class="show-header">
  <h1>
    <i class="fas fa-qrcode"></i>
    {{ $session->nombre }}
  </h1>
  <span class="badge {{ $session->activo ? 'bg-success' : 'bg-secondary' }} mt-2">
    {{ $session->activo ? 'Activo' : 'Inactivo' }}
  </span>
</div>

<!-- Información de la sesión -->
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-info-circle"></i> Información de la Sesión
  </div>
  <div class="row">
    <div class="col-md-4 show-field">
      <div class="show-label">Actividad</div>
      <div class="show-value">{{ $session->actividad }}</div>
    </div>
    <div class="col-md-4 show-field">
      <div class="show-label">Código</div>
      <div class="show-value"><code class="bg-light px-2 py-1 rounded">{{ $session->codigo }}</code></div>
    </div>
    <div class="col-md-4 show-field">
      <div class="show-label">Total asistencias</div>
      <div class="show-value h5">{{ $scans->count() ?? 0 }}</div>
    </div>
  </div>
  
  @if($session->qr_image)
    <div class="text-center mt-4">
      <div class="show-label mb-2">Código QR</div>
      <img src="{{ asset('storage/'.$session->qr_image) }}" alt="QR" style="max-width:180px;" class="img-fluid rounded shadow-sm">
    </div>
  @endif
</div>

<!-- Escaneos por fecha -->
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-list-check"></i> Registros de Asistencia
  </div>
  
  @if(count($scansByDate) > 0)
    @php $count=0; @endphp
    @foreach($scansByDate as $date => $scans)
      @php $count++; $id='collapse'.$count; @endphp
      <div class="gym-card mb-3">
        <div class="d-flex justify-content-between align-items-center mb-2" data-bs-toggle="collapse" data-bs-target="#{{ $id }}" style="cursor: pointer;">
          <span class="fw-bold">
            <i class="fas fa-calendar-day me-2 text-primary"></i>
            {{ \Carbon\Carbon::parse($date)->locale('es')->isoFormat('dddd, D [de] MMMM') }}
          </span>
          <span class="badge bg-primary">{{ count($scans) }}</span>
        </div>
        <div id="{{ $id }}" class="collapse {{ $count == 1 ? 'show' : '' }}">
          @foreach($scans as $scan)
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
              <div>
                <i class="fas fa-user-circle me-2 text-muted"></i>
                <strong>{{ $scan->user->name }}</strong>
                <small class="text-muted d-block ms-4">{{ $scan->carrera }}</small>
              </div>
              <small class="text-muted">{{ \Carbon\Carbon::parse($scan->created_at)->format('H:i') }}</small>
            </div>
          @endforeach
        </div>
      </div>
    @endforeach
  @else
    <p class="text-muted mb-0">No hay registros de asistencia.</p>
  @endif
</div>

<!-- Acciones -->
<div class="show-actions">
  <a href="{{ route('qr-sessions.index') }}" class="btn-back">
    <i class="fas fa-arrow-left"></i> Volver
  </a>
  <a href="{{ route('qr-sessions.edit', $session->id) }}" class="btn-edit">
    <i class="fas fa-edit"></i> Editar
  </a>
</div>

@endsection
