@extends('layouts.app')

@section('title', 'Mis Asistencias')

@section('content')
<div class="container-fluid px-3 py-4">
  <h1 class="mb-3 text-center">Mis Asistencias</h1>

  @if($scans->isEmpty())
    <div class="alert alert-info text-center">
      No tienes asistencias registradas.
    </div>
  @else
    {{-- Vista móvil: tarjetas --}}
    <div class="d-block d-md-none">
      @foreach($scans as $scan)
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title mb-2">{{ optional($scan->session)->nombre ?? 'Sin sesión' }}</h5>
            <p class="card-text mb-1"><strong>Fecha Asistencia:</strong> {{ \Carbon\Carbon::parse($scan->fecha)->format('d/m/Y') }}</p>
            <p class="card-text mb-1"><strong>Carrera:</strong> {{ $scan->carrera }}</p>
            <p class="card-text mb-1"><strong>Actividad:</strong> {{ $scan->actividad }}</p>
            <p class="card-text text-muted small">Registrado {{ \Carbon\Carbon::parse($scan->created_at)->diffForHumans() }}</p>
          </div>
        </div>
      @endforeach
    </div>

    {{-- Vista escritorio: tabla --}}
    <div class="table-responsive d-none d-md-block">
      <table class="table table-hover table-sm">
        <thead class="table-light">
          <tr>
            <th>Sesión</th>
            <th>Fecha Asistencia</th>
            <th>Carrera</th>
            <th>Actividad</th>
            <th>Registrado en</th>
          </tr>
        </thead>
        <tbody>
          @foreach($scans as $scan)
            <tr>
              <td>{{ optional($scan->session)->nombre ?? 'N/A' }}</td>
              <td>{{ \Carbon\Carbon::parse($scan->fecha)->format('d/m/Y') }}</td>
              <td>{{ $scan->carrera }}</td>
              <td>{{ $scan->actividad }}</td>
              <td>{{ \Carbon\Carbon::parse($scan->created_at)->format('d/m/Y H:i') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
@endsection
