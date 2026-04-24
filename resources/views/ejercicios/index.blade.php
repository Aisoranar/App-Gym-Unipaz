@extends('layouts.app')
@section('title', 'Ejercicios')
@section('content')

<!-- Header de página -->
<div class="page-header">
  <div>
    <h1>
      <i class="fas fa-dumbbell"></i>
      Ejercicios
    </h1>
    <p>Catálogo de ejercicios para tus rutinas</p>
  </div>
  <div class="page-actions">
    @if(Auth::user()->role === 'entrenador' || Auth::user()->role === 'superadmin')
      <a href="{{ route('ejercicios.create') }}" class="btn-primary-gym">
        <i class="fas fa-plus"></i>
        <span class="d-none d-sm-inline">Nuevo Ejercicio</span>
      </a>
    @endif
  </div>
</div>

<!-- Búsqueda -->
<div class="gym-search">
  <i class="fas fa-search"></i>
  <input type="text" id="searchEjercicios" placeholder="Buscar ejercicio...">
</div>

<!-- Grid de tarjetas -->
<div class="cards-grid">
  @forelse($ejercicios as $ejercicio)
    <div class="gym-card">
      <div class="gym-card-icon green">
        <i class="fas fa-dumbbell"></i>
      </div>
      
      <div class="gym-card-title">
        {{ $ejercicio->nombre_ejercicio }}
      </div>
      
      <div class="gym-card-text">
        <div class="mb-1">
          <i class="fas fa-calendar text-muted me-2"></i>
          <small>{{ $ejercicio->fecha }}</small>
        </div>
        <div class="mb-1">
          <i class="fas fa-chart-line text-muted me-2"></i>
          <small>{{ $ejercicio->series }} series</small>
        </div>
        <div>
          <i class="fas fa-repeat text-muted me-2"></i>
          <small>{{ $ejercicio->repeticiones }} repeticiones</small>
        </div>
      </div>
      
      <div class="gym-card-actions">
        <a href="{{ route('ejercicios.show', $ejercicio) }}" class="btn btn-sm btn-outline-primary">
          <i class="fas fa-eye"></i>
        </a>
        @if(Auth::user()->role === 'entrenador' || Auth::user()->role === 'superadmin')
          <a href="{{ route('ejercicios.edit', $ejercicio) }}" class="btn btn-sm btn-outline-warning">
            <i class="fas fa-edit"></i>
          </a>
          <form action="{{ route('ejercicios.destroy', $ejercicio) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este ejercicio?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger">
              <i class="fas fa-trash"></i>
            </button>
          </form>
        @endif
      </div>
    </div>
  @empty
    <div class="col-12 text-center py-5">
      <div class="mb-3">
        <i class="fas fa-dumbbell fa-3x text-muted"></i>
      </div>
      <h5 class="text-muted">No hay ejercicios</h5>
      @if(Auth::user()->role === 'entrenador' || Auth::user()->role === 'superadmin')
        <p class="text-muted mb-3">Comienza creando un nuevo ejercicio</p>
        <a href="{{ route('ejercicios.create') }}" class="btn-primary-gym">
          <i class="fas fa-plus me-2"></i>Crear Ejercicio
        </a>
      @endif
    </div>
  @endforelse
</div>

<script>
  document.getElementById('searchEjercicios')?.addEventListener('input', function() {
    const term = this.value.toLowerCase();
    document.querySelectorAll('.gym-card').forEach(card => {
      const text = card.textContent.toLowerCase();
      card.style.display = text.includes(term) ? '' : 'none';
    });
  });
</script>

@endsection
