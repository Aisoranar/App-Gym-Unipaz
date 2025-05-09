@extends('layouts.app')
@section('content')
<!-- Estilos globales y personalizados -->
<style>
  :root {
    --primary: #001f3f; /* Azul oscuro */
    --secondary: #013220; /* Verde oscuro */
    --white: #ffffff;
    --shadow: rgba(0,0,0,0.1);
  }
  body {
    background: var(--white);
    color: var(--primary);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  /* Encabezado con gradiente animado */
  .animated-bg {
    background: linear-gradient(45deg, var(--primary), var(--secondary));
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
    padding: 2rem 0;
    text-align: center;
    margin-bottom: 1.5rem;
  }
  @keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
  .header-show h2 {
    color: var(--white);
    font-size: 2rem;
    font-weight: bold;
    text-shadow: 0 0 5px rgba(0,0,0,0.3);
  }
  .card-session-info {
    background: var(--white);
    border-radius: 1rem;
    box-shadow: 0 4px 15px var(--shadow);
    padding: 1.5rem;
    margin-bottom: 2rem;
    color: var(--primary);
  }
  .record-card {
    background: var(--white);
    border-radius: 0.75rem;
    box-shadow: 0 4px 12px var(--shadow);
    padding: 1rem;
    margin-bottom: 1rem;
  }
  .record-header {
    background: var(--primary);
    color: var(--white);
    padding: 0.75rem 1rem;
    border-radius: 0.75rem;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
  }
  .record-body {
    padding: 0 1rem 1rem;
    border-left: 4px solid var(--primary);
    border-radius: 0 0 0.75rem 0.75rem;
  }
  .record-item {
    background: var(--white);
    border: 1px solid var(--shadow);
    border-radius: 0.5rem;
    padding: 0.75rem;
    margin-bottom: 0.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .record-item strong {
    color: var(--primary);
  }
  .record-item small {
    color: rgba(0,0,0,0.6);
  }
</style>

<!-- Encabezado -->
<div class="container-fluid animated-bg">
  <div class="container header-show text-center">
    <h2><i class="fas fa-qrcode me-2"></i> {{ $session->nombre }}</h2>
  </div>
</div>

<div class="container py-4">
  <!-- Información de la sesión -->
  <div class="card-session-info">
    <p><strong>Actividad:</strong> {{ $session->actividad }}</p>
    <p><strong>Código:</strong> {{ $session->codigo }}</p>
    <p><strong>Estado:</strong> <span class="badge {{ $session->activo ? 'bg-success' : 'bg-secondary' }}">{{ $session->activo ? 'Activo' : 'Inactivo' }}</span></p>
    @if($session->qr_image)
      <div class="mt-3 text-center">
        <img src="{{ asset('storage/'.$session->qr_image) }}" alt="QR" style="max-width:200px;" class="img-fluid border border-2">
      </div>
    @endif
  </div>

  <!-- Escaneos por fecha -->
  <h3 class="mb-4">Escaneos QR por Fecha</h3>
  @php $count=0; @endphp
  @foreach($scansByDate as $date => $scans)
    @php $count++; $id='collapse'.$count; @endphp
    <div class="record-card">
      <div class="record-header" data-bs-toggle="collapse" data-bs-target="#{{ $id }}">
        <span>{{ \Carbon\Carbon::parse($date)->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}</span>
        <i class="bi bi-chevron-down"></i>
      </div>
      <div id="{{ $id }}" class="collapse show record-body">
        @foreach($scans as $scan)
          <div class="record-item">
            <div>
              <strong><i class="bi bi-person-circle me-1"></i>{{ $scan->user->name }}</strong><br>
              <small><i class="bi bi-briefcase me-1"></i>{{ $scan->carrera }}</small>
            </div>
            <div><small><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($scan->created_at)->format('H:i') }}</small></div>
          </div>
        @endforeach
      </div>
    </div>
  @endforeach
</div>
  <!-- Botón Volver -->
  <div class="container text-center mt-4">
    <a href="{{ route('qr-sessions.index') }}" class="btn btn-secondary btn-sm">&larr; Volver a Sesiones QR</a>
  </div>
@endsection
