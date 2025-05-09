@extends('layouts.app')

@section('title', 'Mis Asistencias')

@section('content')
<div class="container-fluid px-3 py-4">
  <h1 class="mb-4 text-center animate__animated animate__fadeInDown">📅 Mis Asistencias</h1>

  @if($scans->isEmpty())
    <div class="alert alert-info text-center animate__animated animate__fadeInUp">
      😅 Aún no tienes asistencias registradas. ¡Es hora de ponerte en movimiento!
    </div>
  @else
    {{-- Mobile: tarjetas --}}
    <div class="d-block d-md-none">
      @foreach($scans as $scan)
        <div class="card mb-3 shadow-sm animate__animated animate__zoomIn">
          <div class="card-body p-3">
            <h5 class="card-title mb-2 fw-bold">🎯 {{ optional($scan->session)->nombre ?? 'Sin sesión' }}</h5>
            <p class="card-text mb-1">📆 <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($scan->fecha)->format('d/m/Y') }}</p>
            <p class="card-text mb-1">🏃 <strong>Carrera:</strong> {{ $scan->carrera }}</p>
            <p class="card-text mb-1">⚙️ <strong>Actividad:</strong> {{ optional($scan->session)->actividad ?? 'No definida' }}</p>
            <p class="card-text text-muted small">⏱ Registrado {{ \Carbon\Carbon::parse($scan->created_at)->diffForHumans() }}</p>
          </div>
        </div>
      @endforeach
    </div>

    {{-- Desktop: tabla --}}
    <div class="d-none d-md-block animate__animated animate__fadeInUp">
      <div class="card shadow-sm rounded-4">
        <div class="card-body p-4">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-primary">
                <tr>
                  <th scope="col">🎯 Sesión</th>
                  <th scope="col">📆 Fecha</th>
                  <th scope="col">🏃 Carrera</th>
                  <th scope="col">⚙️ Actividad</th>
                  <th scope="col">⏱ Registrado</th>
                </tr>
              </thead>
              <tbody>
                @foreach($scans as $scan)
                  <tr style="cursor: default;">
                    <td class="fw-medium">{{ optional($scan->session)->nombre ?? 'N/A' }}</td>
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
  @media (min-width: 768px) {
    .table-primary th {
      background-color: var(--bs-primary);
      color: #fff;
      border-bottom: none;
    }
    .table-hover tbody tr:hover {
      background-color: rgba(13,37,63,0.05);
    }
    .table-responsive {
      border-radius: 1rem;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    table.table {
      margin-bottom: 0;
    }
    .fw-medium {
      font-weight: 500;
    }
  }
</style>
@endsection

@section('scripts')
<script>
  // Placeholder for future interactividad
</script>
@endsection
