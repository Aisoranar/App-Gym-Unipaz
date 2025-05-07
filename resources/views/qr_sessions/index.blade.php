@extends('layouts.app')

@section('content')
@push('styles')
<style>
/* Pulsing green for active */
@keyframes pulse-green {
  0%   { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
  70%  { box-shadow: 0 0 0 10px rgba(40, 167, 69, 0); }
  100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
}
/* Fading gray for inactive */
@keyframes fade-gray {
  0%,100% { opacity: 1; }
  50%      { opacity: 0.6; }
}
.pulse-active   { animation: pulse-green 2s infinite; }
.pulse-inactive { animation: fade-gray   2s infinite; }
.qr-thumb       { width: 100%; max-width: 150px; height: auto; margin-bottom: .5rem; }
</style>
@endpush

<div class="container px-2">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4">Sesiones QR</h1>
        <a href="{{ route('qr-sessions.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nueva Sesión
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success animate__animated animate__fadeIn">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-3">
        @forelse ($sessions as $session)
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100 {{ $session->activo ? 'border-success pulse-active' : 'border-secondary bg-light pulse-inactive' }}" style="max-width: 20rem;">
                    <img src="{{ $session->qr_image ? asset('storage/'.$session->qr_image) : '' }}"
                         alt="QR {{ $session->codigo }}"
                         class="card-img-top qr-thumb mx-auto mt-3">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">{{ $session->nombre }}</h5>
                            <span class="badge {{ $session->activo ? 'bg-success' : 'bg-secondary' }}">
                                {{ $session->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                        <p class="card-text mb-2 text-truncate">
                            <strong>Código:</strong> {{ $session->codigo }}
                        </p>
                        <a href="{{ route('qr-sessions.scan-form', ['codigo' => $session->codigo]) }}"
                           class="btn btn-outline-primary btn-sm mb-2">
                            <i class="fas fa-qrcode me-1"></i> Escanear Código
                        </a>
                        <div class="mt-auto d-flex gap-1">
                            <a href="{{ route('qr-sessions.show', $session->id) }}"
                               class="btn btn-info btn-sm flex-grow-1"
                               title="Detalle">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('qr-sessions.edit', $session->id) }}"
                               class="btn btn-warning btn-sm flex-grow-1"
                               title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button"
                                    class="btn btn-danger btn-sm flex-grow-1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal-{{ $session->id }}"
                                    title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form action="{{ route('qr-sessions.toggle', $session->id) }}" method="POST" class="flex-grow-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="btn btn-sm w-100 {{ $session->activo ? 'btn-secondary' : 'btn-success' }}"
                                        title="{{ $session->activo ? 'Desactivar' : 'Activar' }}">
                                    <i class="fas {{ $session->activo ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de Confirmación para Eliminar -->
            <div class="modal fade" id="deleteModal-{{ $session->id }}" tabindex="-1"
                 aria-labelledby="deleteModalLabel-{{ $session->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="deleteModalLabel-{{ $session->id }}">
                                Eliminar "{{ $session->nombre }}"
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            ¿Seguro que deseas eliminar esta sesión QR?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                                Cancelar
                            </button>
                            <form action="{{ route('qr-sessions.destroy', $session->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    No hay sesiones QR creadas.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
