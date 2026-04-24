@extends('layouts.app')
@section('title', 'Control de Peso')
@section('content')

<!-- Header de página -->
<div class="page-header">
  <div>
    <h1>
      <i class="fas fa-weight-scale"></i>
      Entradas de Peso
    </h1>
    <p>Seguimiento de tu progreso físico</p>
  </div>
  <div class="page-actions">
    <a href="{{ route('entradas-peso.create') }}" class="btn-primary-gym">
      <i class="fas fa-plus"></i>
      <span class="d-none d-sm-inline">Nuevo Registro</span>
    </a>
  </div>
</div>

{{-- Estadísticas --}}
<div class="cards-grid mb-4">
  <div class="gym-card text-center">
    <div class="gym-card-icon blue">
      <i class="fas fa-list"></i>
    </div>
    <div class="h4 mb-1">{{ $total }}</div>
    <small class="text-muted">Total registros</small>
  </div>
  <div class="gym-card text-center">
    <div class="gym-card-icon green">
      <i class="fas fa-chart-line"></i>
    </div>
    <div class="h4 mb-1">{{ number_format($promedioImc, 1) }}</div>
    <small class="text-muted">IMC promedio</small>
  </div>
  <div class="gym-card text-center">
    <div class="gym-card-icon orange">
      <i class="fas fa-lightbulb"></i>
    </div>
    <div class="small">{{ $sugerencia ?? 'Sin datos' }}</div>
    <small class="text-muted">Sugerencia</small>
  </div>
</div>

{{-- Tabla para desktop --}}
<div class="gym-table-container d-none d-md-block">
  <table class="gym-table">
    <thead>
      <tr>
        <th>Fecha</th>
        <th>Actual</th>
        <th>Ideal</th>
        <th>Altura</th>
        <th>IMC</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($entradas as $entrada)
        <tr>
          <td>{{ $entrada->fecha->format('d/m/Y') }}</td>
          <td><strong>{{ $entrada->peso_actual_kg }} kg</strong></td>
          <td>{{ $entrada->peso_ideal_kg ?? '-' }} kg</td>
          <td>{{ $entrada->altura_cm }} cm</td>
          <td>{{ $entrada->imc }}</td>
          <td>
            <span class="badge {{ $entrada->estado_peso == 'Normal' ? 'bg-success' : ($entrada->estado_peso == 'Bajo peso' ? 'bg-info' : ($entrada->estado_peso == 'Sobrepeso' ? 'bg-warning text-dark' : 'bg-danger')) }}">
              {{ $entrada->estado_peso }}
            </span>
          </td>
          <td class="text-nowrap">
            <a href="{{ route('entradas-peso.show', $entrada) }}" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-eye"></i></a>
            <a href="{{ route('entradas-peso.edit', $entrada) }}" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-edit"></i></a>
            <form action="{{ route('entradas-peso.destroy', $entrada) }}" method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar?')"><i class="fas fa-trash"></i></button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="7" class="text-center py-4">No hay registros</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

{{-- Tarjetas para móvil --}}
<div class="d-md-none">
  @forelse($entradas as $entrada)
    <div class="gym-card mb-3">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <small class="text-muted"><i class="fas fa-calendar me-1"></i> {{ $entrada->fecha->format('d/m/Y') }}</small>
        <span class="badge {{ $entrada->estado_peso == 'Normal' ? 'bg-success' : ($entrada->estado_peso == 'Bajo peso' ? 'bg-info' : ($entrada->estado_peso == 'Sobrepeso' ? 'bg-warning text-dark' : 'bg-danger')) }}">
          {{ $entrada->estado_peso }}
        </span>
      </div>
      <div class="row mb-2">
        <div class="col-6"><i class="fas fa-weight text-muted me-1"></i> <strong>{{ $entrada->peso_actual_kg }} kg</strong></div>
        <div class="col-6"><i class="fas fa-bullseye text-muted me-1"></i> {{ $entrada->peso_ideal_kg ?? '-' }} kg ideal</div>
      </div>
      <div class="row mb-3">
        <div class="col-6"><i class="fas fa-ruler text-muted me-1"></i> {{ $entrada->altura_cm }} cm</div>
        <div class="col-6"><i class="fas fa-heartbeat text-muted me-1"></i> IMC: {{ $entrada->imc }}</div>
      </div>
      <div class="gym-card-actions">
        <a href="{{ route('entradas-peso.show', $entrada) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
        <a href="{{ route('entradas-peso.edit', $entrada) }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
        <form action="{{ route('entradas-peso.destroy', $entrada) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar?')"><i class="fas fa-trash"></i></button>
        </form>
      </div>
    </div>
  @empty
    <div class="text-center py-5">
      <i class="fas fa-scale-balanced fa-3x text-muted mb-3"></i>
      <p class="text-muted">No hay registros de peso</p>
      <a href="{{ route('entradas-peso.create') }}" class="btn-primary-gym">
        <i class="fas fa-plus me-2"></i>Primer Registro
      </a>
    </div>
  @endforelse
</div>

@endsection
