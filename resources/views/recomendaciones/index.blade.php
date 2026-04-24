@extends('layouts.app')
@section('title', 'Recomendaciones')
@section('content')

<!-- Header de página -->
<div class="page-header">
  <div>
    <h1>
      <i class="fas fa-notes-medical"></i>
      Recomendaciones
    </h1>
    <p>Consejos personalizados para usuarios</p>
  </div>
  <div class="page-actions">
    @if(in_array(Auth::user()->role, ['entrenador', 'superadmin']))
      <a href="{{ route('recomendaciones.create') }}" class="btn-primary-gym">
        <i class="fas fa-plus"></i>
        <span class="d-none d-sm-inline">Nueva Recomendación</span>
      </a>
    @endif
  </div>
</div>

<!-- Búsqueda -->
<div class="gym-search">
  <i class="fas fa-search"></i>
  <input type="text" id="searchRecomendaciones" placeholder="Buscar por usuario o contenido...">
</div>

<!-- Grid de tarjetas -->
<div class="cards-grid">
  @forelse($recomendaciones as $recomendacion)
    <div class="gym-card">
      <div class="d-flex align-items-start justify-content-between mb-3">
        <div class="gym-card-icon orange">
          <i class="fas fa-comment-medical"></i>
        </div>
        <small class="text-muted">{{ $recomendacion->created_at->diffForHumans() }}</small>
      </div>
      
      <div class="gym-card-title">
        {{ $recomendacion->titulo ?? 'Recomendación' }}
      </div>
      
      <div class="gym-card-text">
        <p class="mb-2">{{ Str::limit($recomendacion->contenido, 120) }}</p>
        <div class="d-flex align-items-center gap-2">
          <i class="fas fa-user text-muted"></i>
          <small>{{ $recomendacion->user->name ?? 'Sin asignar' }}</small>
        </div>
      </div>
      
      <div class="gym-card-actions">
        <a href="{{ route('recomendaciones.show', $recomendacion) }}" class="btn btn-sm btn-outline-primary">
          <i class="fas fa-eye"></i>
        </a>
        @if(in_array(Auth::user()->role, ['entrenador', 'superadmin']) && (Auth::user()->role === 'superadmin' || Auth::id() == $recomendacion->creado_por))
          <a href="{{ route('recomendaciones.edit', $recomendacion) }}" class="btn btn-sm btn-outline-warning">
            <i class="fas fa-edit"></i>
          </a>
          <form action="{{ route('recomendaciones.destroy', $recomendacion) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta recomendación?');">
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
        <i class="fas fa-inbox fa-3x text-muted"></i>
      </div>
      <h5 class="text-muted">No hay recomendaciones</h5>
      @if(in_array(Auth::user()->role, ['entrenador', 'superadmin']))
        <p class="text-muted mb-3">Crea la primera recomendación</p>
        <a href="{{ route('recomendaciones.create') }}" class="btn-primary-gym">
          <i class="fas fa-plus me-2"></i>Crear Recomendación
        </a>
      @endif
    </div>
  @endforelse
</div>

<script>
  document.getElementById('searchRecomendaciones')?.addEventListener('input', function() {
    const term = this.value.toLowerCase();
    document.querySelectorAll('.gym-card').forEach(card => {
      const text = card.textContent.toLowerCase();
      card.style.display = text.includes(term) ? '' : 'none';
    });
  });
</script>

@endsection
