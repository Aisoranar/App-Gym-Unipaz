@extends('layouts.app')
@section('title', 'Rutinas')
@section('content')

<!-- Header de página -->
<div class="page-header">
  <div>
    <h1>
      <i class="fas fa-running"></i>
      Rutinas
    </h1>
    <p>Planifica tus entrenamientos semanales</p>
  </div>
  <div class="page-actions">
    <a href="{{ route('rutinas.create') }}" class="btn-primary-gym">
      <i class="fas fa-plus"></i>
      <span class="d-none d-sm-inline">Nueva Rutina</span>
    </a>
  </div>
</div>

<!-- Búsqueda -->
<div class="gym-search">
  <i class="fas fa-search"></i>
  <input type="text" id="searchRutinas" placeholder="Buscar rutina...">
</div>

<!-- Grid de tarjetas -->
<div class="cards-grid">
  @forelse($rutinas as $rutina)
    <div class="gym-card">
      <div class="d-flex align-items-start justify-content-between mb-3">
        <div class="gym-card-icon purple">
          <i class="fas fa-calendar-week"></i>
        </div>
        @if($rutina->activa)
          <span class="badge bg-success">Activa</span>
        @endif
      </div>
      
      <div class="gym-card-title">
        {{ $rutina->nombre }}
      </div>
      
      <div class="gym-card-text">
        <div class="mb-1">
          <i class="fas fa-play-circle text-muted me-2"></i>
          <small>{{ $rutina->fecha_inicio ? $rutina->fecha_inicio->format('d/m/Y') : 'Sin fecha' }}</small>
        </div>
        <div class="mb-1">
          <i class="fas fa-flag-checkered text-muted me-2"></i>
          <small>{{ $rutina->fecha_fin ? $rutina->fecha_fin->format('d/m/Y') : 'Sin fin' }}</small>
        </div>
        <div>
          @if($rutina->dias && is_array($rutina->dias))
            @foreach($rutina->dias as $dia)
              <span class="badge bg-light text-dark border me-1" style="font-size: 0.7rem;">{{ $dia }}</span>
            @endforeach
          @else
            <small class="text-muted">Sin días</small>
          @endif
        </div>
      </div>
      
      <div class="gym-card-actions">
        <a href="{{ route('rutinas.show', $rutina) }}" class="btn btn-sm btn-outline-primary">
          <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('rutinas.edit', $rutina) }}" class="btn btn-sm btn-outline-warning">
          <i class="fas fa-edit"></i>
        </a>
        <form action="{{ route('rutinas.destroy', $rutina) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta rutina?');">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-trash"></i>
          </button>
        </form>
      </div>
    </div>
  @empty
    <div class="col-12 text-center py-5">
      <div class="mb-3">
        <i class="fas fa-calendar-plus fa-3x text-muted"></i>
      </div>
      <h5 class="text-muted">No hay rutinas</h5>
      <p class="text-muted mb-3">Crea tu primera rutina de entrenamiento</p>
      <a href="{{ route('rutinas.create') }}" class="btn-primary-gym">
        <i class="fas fa-plus me-2"></i>Crear Rutina
      </a>
    </div>
  @endforelse
</div>

<script>
  document.getElementById('searchRutinas')?.addEventListener('input', function() {
    const term = this.value.toLowerCase();
    document.querySelectorAll('.gym-card').forEach(card => {
      const text = card.textContent.toLowerCase();
      card.style.display = text.includes(term) ? '' : 'none';
    });
  });
</script>

@endsection
