@extends('layouts.app')
@section('title', 'Planes Nutricionales')
@section('content')

<!-- Header de página -->
<div class="page-header">
  <div>
    <h1>
      <i class="fas fa-apple-alt"></i>
      Nutrición
    </h1>
    <p>Planes alimenticios personalizados</p>
  </div>
  <div class="page-actions">
    <a href="{{ route('planes.create') }}" class="btn-primary-gym">
      <i class="fas fa-plus"></i>
      <span class="d-none d-sm-inline">Nuevo Plan</span>
    </a>
  </div>
</div>

<!-- Búsqueda -->
<div class="gym-search">
  <i class="fas fa-search"></i>
  <input type="text" id="searchPlanes" placeholder="Buscar plan nutricional...">
</div>

<!-- Grid de tarjetas -->
<div class="cards-grid">
  @forelse($planes as $plan)
    <div class="gym-card">
      <div class="gym-card-icon teal">
        <i class="fas fa-carrot"></i>
      </div>
      
      <div class="gym-card-title">
        {{ $plan->nombre }}
      </div>
      
      <div class="gym-card-text">
        <div class="mb-1">
          <i class="fas fa-fire text-muted me-2"></i>
          <strong>{{ $plan->calorias_diarias ?? '0' }}</strong> kcal/día
        </div>
        @if($plan->objetivo)
          <div class="mb-1">
            <i class="fas fa-bullseye text-muted me-2"></i>
            <small>{{ $plan->objetivo }}</small>
          </div>
        @endif
      </div>
      
      <div class="gym-card-actions">
        <a href="{{ route('planes.show', $plan) }}" class="btn btn-sm btn-outline-primary">
          <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('planes.edit', $plan) }}" class="btn btn-sm btn-outline-warning">
          <i class="fas fa-edit"></i>
        </a>
        <form action="{{ route('planes.destroy', $plan) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este plan?');">
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
        <i class="fas fa-utensils fa-3x text-muted"></i>
      </div>
      <h5 class="text-muted">No hay planes nutricionales</h5>
      <p class="text-muted mb-3">Crea tu primer plan alimenticio</p>
      <a href="{{ route('planes.create') }}" class="btn-primary-gym">
        <i class="fas fa-plus me-2"></i>Crear Plan
      </a>
    </div>
  @endforelse
</div>

<script>
  document.getElementById('searchPlanes')?.addEventListener('input', function() {
    const term = this.value.toLowerCase();
    document.querySelectorAll('.gym-card').forEach(card => {
      const text = card.textContent.toLowerCase();
      card.style.display = text.includes(term) ? '' : 'none';
    });
  });
</script>

@endsection
