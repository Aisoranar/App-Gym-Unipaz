@extends('layouts.app')
@section('title', 'Fichas Médicas')
@section('content')

<!-- Header de página -->
<div class="page-header">
  <div>
    <h1>
      <i class="fas fa-file-medical"></i>
      Fichas Médicas
    </h1>
    <p>Gestiona la información médica de los usuarios</p>
  </div>
  <div class="page-actions">
    <a href="{{ route('fichas.create') }}" class="btn-primary-gym">
      <i class="fas fa-plus"></i>
      <span class="d-none d-sm-inline">Nueva Ficha</span>
    </a>
  </div>
</div>

<!-- Búsqueda -->
<div class="gym-search">
  <i class="fas fa-search"></i>
  <input type="text" id="searchFichas" placeholder="Buscar por nombre, apellido o documento...">
</div>

<!-- Grid de tarjetas -->
<div class="cards-grid">
  @forelse($fichas as $ficha)
    <div class="gym-card">
      <div class="d-flex align-items-start justify-content-between mb-3">
        <div class="gym-card-icon blue">
          <i class="fas fa-user"></i>
        </div>
        <span class="badge bg-light text-dark border">
          {{ $ficha->tipo_documento }} {{ $ficha->numero_documento }}
        </span>
      </div>
      
      <div class="gym-card-title">
        {{ $ficha->nombre }} {{ $ficha->apellidos }}
      </div>
      
      <div class="gym-card-text">
        <div class="mb-1">
          <i class="fas fa-calendar text-muted me-2"></i>
          <small>{{ $ficha->fecha_nacimiento }} · {{ $ficha->edad }} años</small>
        </div>
        <div class="mb-1">
          <i class="fas fa-venus-mars text-muted me-2"></i>
          <small>{{ $ficha->sexo }}</small>
        </div>
        <div>
          <i class="fas fa-map-marker-alt text-muted me-2"></i>
          <small class="text-truncate">{{ Str::limit($ficha->domicilio, 30) }}</small>
        </div>
      </div>
      
      <div class="gym-card-actions">
        <a href="{{ route('fichas.show', $ficha) }}" class="btn btn-sm btn-outline-primary">
          <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('fichas.edit', $ficha) }}" class="btn btn-sm btn-outline-warning">
          <i class="fas fa-edit"></i>
        </a>
        <form action="{{ route('fichas.destroy', $ficha) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta ficha?');">
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
        <i class="fas fa-folder-open fa-3x text-muted"></i>
      </div>
      <h5 class="text-muted">No hay fichas médicas</h5>
      <p class="text-muted mb-3">Comienza creando una nueva ficha</p>
      <a href="{{ route('fichas.create') }}" class="btn-primary-gym">
        <i class="fas fa-plus me-2"></i>Crear Ficha
      </a>
    </div>
  @endforelse
</div>

<script>
  // Búsqueda en tiempo real
  document.getElementById('searchFichas')?.addEventListener('input', function() {
    const term = this.value.toLowerCase();
    document.querySelectorAll('.gym-card').forEach(card => {
      const text = card.textContent.toLowerCase();
      card.style.display = text.includes(term) ? '' : 'none';
    });
  });
</script>

@endsection
