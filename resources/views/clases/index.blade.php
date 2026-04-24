@extends('layouts.app')
@section('title', 'Clases Grupales')
@section('content')

<!-- Header de página -->
<div class="page-header">
  <div>
    <h1>
      <i class="fas fa-chalkboard-teacher"></i>
      Clases
    </h1>
    <p>Grupos de entrenamiento y actividades</p>
  </div>
  <div class="page-actions">
    @if(in_array(auth()->user()->role, ['entrenador', 'superadmin']))
      <a href="{{ route('clases.create') }}" class="btn-primary-gym">
        <i class="fas fa-plus"></i>
        <span class="d-none d-sm-inline">Nueva Clase</span>
      </a>
    @endif
  </div>
</div>

<!-- Búsqueda -->
<div class="gym-search">
  <i class="fas fa-search"></i>
  <input type="text" id="searchClases" placeholder="Buscar clase...">
</div>

<!-- Grid de tarjetas -->
<div class="cards-grid">
  @forelse($clases as $clase)
    <div class="gym-card">
      <div class="d-flex align-items-start justify-content-between mb-3">
        <div class="gym-card-icon red">
          <i class="fas fa-users"></i>
        </div>
        <span class="badge {{ $clase->is_active ? 'bg-success' : 'bg-secondary' }}">
          {{ $clase->is_active ? 'Activa' : 'Inactiva' }}
        </span>
      </div>
      
      <div class="gym-card-title">
        {{ $clase->titulo }}
      </div>
      
      <div class="gym-card-text">
        <div class="mb-1">
          <i class="fas fa-calendar text-muted me-2"></i>
          <small>{{ $clase->fecha }} · {{ $clase->hora_inicio }}</small>
        </div>
        @if($clase->nivel)
          <div class="mb-1">
            <i class="fas fa-layer-group text-muted me-2"></i>
            <small>{{ $clase->nivel }}</small>
          </div>
        @endif
        <div class="mb-1">
          <i class="fas fa-user-check text-muted me-2"></i>
          <small>{{ $clase->participants->count() }} {{ $clase->max_participantes ? '/ '.$clase->max_participantes : '' }} inscritos</small>
        </div>
        @if($clase->objetivos)
          <div class="mt-2 text-truncate">
            <small class="text-muted">{{ Str::limit($clase->objetivos, 50) }}</small>
          </div>
        @endif
      </div>
      
      <div class="gym-card-actions">
        <a href="{{ route('clases.show', $clase) }}" class="btn btn-sm btn-outline-primary">
          <i class="fas fa-eye"></i>
        </a>
        @if(in_array(auth()->user()->role, ['entrenador', 'superadmin']))
          <a href="{{ route('clases.edit', $clase) }}" class="btn btn-sm btn-outline-warning">
            <i class="fas fa-edit"></i>
          </a>
          <form action="{{ route('clases.destroy', $clase) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta clase?');">
            @csrf @method('DELETE')
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
        <i class="fas fa-users-slash fa-3x text-muted"></i>
      </div>
      <h5 class="text-muted">No hay clases</h5>
      @if(in_array(auth()->user()->role, ['entrenador', 'superadmin']))
        <p class="text-muted mb-3">Crea la primera clase grupal</p>
        <a href="{{ route('clases.create') }}" class="btn-primary-gym">
          <i class="fas fa-plus me-2"></i>Crear Clase
        </a>
      @endif
    </div>
  @endforelse
</div>

<script>
  document.getElementById('searchClases')?.addEventListener('input', function() {
    const term = this.value.toLowerCase();
    document.querySelectorAll('.gym-card').forEach(card => {
      const text = card.textContent.toLowerCase();
      card.style.display = text.includes(term) ? '' : 'none';
    });
  });
</script>

@endsection
