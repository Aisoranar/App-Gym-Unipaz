@extends('layouts.app')
@section('title', 'Sesiones QR')
@section('content')

<!-- Header de página -->
<div class="page-header">
  <div>
    <h1>
      <i class="fas fa-qrcode"></i>
      Sesiones QR
    </h1>
    <p>Gestiona códigos de asistencia</p>
  </div>
  <div class="page-actions">
    <a href="{{ route('qr-sessions.create') }}" class="btn-primary-gym">
      <i class="fas fa-plus"></i>
      <span class="d-none d-sm-inline">Nueva Sesión</span>
    </a>
  </div>
</div>

@if (session('success'))
  <div class="gym-alert success mb-4">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
  </div>
@endif

<!-- Grid de tarjetas -->
<div class="cards-grid">
  @forelse ($sessions as $session)
    <div class="gym-card {{ $session->activo ? 'border-success' : 'border-secondary' }}" style="border: 2px solid {{ $session->activo ? '#28a745' : '#6c757d' }}40;">
      <div class="text-center mb-3">
        @if($session->qr_image)
          <img src="{{ asset('storage/'.$session->qr_image) }}" alt="QR" class="img-fluid" style="max-width: 120px; border-radius: 8px;">
        @else
          <div class="bg-light rounded p-3 d-inline-block">
            <i class="fas fa-qrcode fa-4x text-muted"></i>
          </div>
        @endif
      </div>
      
      <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="fw-bold">{{ $session->nombre }}</span>
        <span class="badge {{ $session->activo ? 'bg-success' : 'bg-secondary' }}">
          {{ $session->activo ? 'Activo' : 'Inactivo' }}
        </span>
      </div>
      
      <p class="text-muted small mb-1"><i class="fas fa-running me-1"></i> {{ $session->actividad }}</p>
      <p class="text-muted small mb-3"><i class="fas fa-hashtag me-1"></i> {{ $session->codigo }}</p>
      
      <div class="gym-card-actions">
        <a href="{{ route('qr-sessions.show', $session->id) }}" class="btn btn-sm btn-outline-primary">
          <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('qr-sessions.edit', $session->id) }}" class="btn btn-sm btn-outline-warning">
          <i class="fas fa-edit"></i>
        </a>
        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $session->id }}">
          <i class="fas fa-trash"></i>
        </button>
      </div>
      
      <form action="{{ route('qr-sessions.toggle', $session->id) }}" method="POST" class="mt-2">
        @csrf @method('PATCH')
        <button type="submit" class="btn btn-sm w-100 {{ $session->activo ? 'btn-outline-secondary' : 'btn-outline-success' }}">
          <i class="fas {{ $session->activo ? 'fa-toggle-off' : 'fa-toggle-on' }} me-1"></i>
          {{ $session->activo ? 'Desactivar' : 'Activar' }}
        </button>
      </form>
    </div>

    <!-- Modal Confirmación -->
    <div class="modal fade" id="deleteModal-{{ $session->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title">Eliminar "{{ $session->nombre }}"</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            ¿Seguro que deseas eliminar esta sesión QR?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
            <form action="{{ route('qr-sessions.destroy', $session->id) }}" method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  @empty
    <div class="col-12 text-center py-5">
      <div class="mb-3">
        <i class="fas fa-qrcode fa-3x text-muted"></i>
      </div>
      <h5 class="text-muted">No hay sesiones QR</h5>
      <p class="text-muted mb-3">Crea tu primera sesión</p>
      <a href="{{ route('qr-sessions.create') }}" class="btn-primary-gym">
        <i class="fas fa-plus me-2"></i>Crear Sesión
      </a>
    </div>
  @endforelse
</div>

@endsection
