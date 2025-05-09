@extends('layouts.app')

@section('title', 'Mis Asistencias')

@section('content')
<!-- Encabezado animado -->
<div class="container-fluid animated-bg">
  <div class="container text-center py-4">
    <h1 class="text-white">📅 Mis Asistencias</h1>
  </div>
</div>

<div class="container my-4">
  @if($scans->isEmpty())
    <div class="alert alert-info text-center">
      😅 Aún no tienes asistencias registradas. ¡Es hora de ponerte en movimiento!
    </div>
  @else
    <!-- Mobile: tarjetas -->
    <div class="d-block d-md-none">
      @foreach($scans as $scan)
        <div class="card mb-3 shadow-sm rounded-2">
          <div class="card-body p-3">
            <h5 class="card-title text-secondary mb-2">🎯 {{ optional($scan->session)->nombre ?? 'Sin sesión' }}</h5>
            <p class="card-text mb-1"><strong>📆 Fecha:</strong> {{ \Carbon\Carbon::parse($scan->fecha)->format('d/m/Y') }}</p>
            <p class="card-text mb-1"><strong>🏃 Carrera:</strong> {{ $scan->carrera }}</p>
            <p class="card-text mb-1"><strong>⚙️ Actividad:</strong> {{ optional($scan->session)->actividad ?? 'No definida' }}</p>
            <p class="card-text text-muted small">⏱ Registrado {{ \Carbon\Carbon::parse($scan->created_at)->diffForHumans() }}</p>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Desktop: tabla dentro de tarjeta -->
    <div class="d-none d-md-block">
      <div class="card shadow-sm rounded-2">
        <div class="card-body p-4">
          <div class="table-responsive">
            <table class="table mb-0">
              <thead class="table-primary">
                <tr>
                  <th>🎯 Sesión</th>
                  <th>📆 Fecha</th>
                  <th>🏃 Carrera</th>
                  <th>⚙️ Actividad</th>
                  <th>⏱ Registrado</th>
                </tr>
              </thead>
              <tbody>
                @foreach($scans as $scan)
                  <tr>
                    <td class="text-secondary fw-semibold">{{ optional($scan->session)->nombre ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($scan->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $scan->carrera }}</td>
                    <td>{{ optional($scan->session)->actividad ?? 'No definida' }}</td>
                    <td>{{ \Carbon\Carbon::parse($scan->created_at)->format('d/m/Y H:i') }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
  :root {
    --primary: #001f3f;
    --secondary: #013220;
    --white: #ffffff;
  }
  body {
    background: var(--white);
    color: var(--primary);
  }
  .animated-bg {
    background: linear-gradient(45deg, var(--primary), var(--secondary));
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
  }
  @keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
  .card {
    border: none;
    border-radius: 1rem;
  }
  .card-title {
    font-size: 1.25rem;
  }
  .alert {
    border-radius: .5rem;
  }
  /* Tabla */
  .table-primary th {
    background: var(--primary);
    color: var(--white);
    border: none;
    text-transform: uppercase;
    letter-spacing: 1px;
  }
  .table-responsive {
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
  }
  table.tb table,
  .table td,
  .table th {
    vertical-align: middle;
  }
  .fw-semibold {
    font-weight: 600;
    color: var(--secondary);
  }
</style>
@endsection

@section('scripts')
<script>
  // Future scripts
</script>
@endsection
