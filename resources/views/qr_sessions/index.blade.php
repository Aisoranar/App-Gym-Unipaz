@extends('layouts.app')

@section('content')
<style>
/* Pulsing green for active */
@keyframes pulse-green {
  0% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
  70% { box-shadow: 0 0 0 10px rgba(40, 167, 69, 0); }
  100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
}

/* Fading gray for inactive */
@keyframes fade-gray {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.6; }
}

.pulse-active {
  animation: pulse-green 2s infinite;
}

.pulse-inactive {
  animation: fade-gray 2s infinite;
}
</style>

<div class="container px-2">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4">Sesiones QR</h1>
        <a href="{{ route('qr-sessions.create') }}" class="btn btn-primary btn-sm">Crear Nueva Sesión QR</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    <div class="row g-3">
        @forelse ($sessions as $session)
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100 {{ $session->activo ? 'border-success pulse-active' : 'border-secondary bg-light pulse-inactive' }}" style="max-width: 20rem;">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">{{ $session->nombre }}</h5>
                            @if ($session->activo)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-secondary">Inactivo</span>
                            @endif
                        </div>
                        <p class="card-text mb-3 text-truncate"><strong>Código:</strong> {{ $session->codigo }}</p>
                        <div class="mt-auto">
                            <div class="d-flex gap-1">
                                <a href="{{ route('qr-sessions.show', $session->id) }}" class="btn btn-info btn-sm flex-grow-1" title="Detalle">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('qr-sessions.edit', $session->id) }}" class="btn btn-warning btn-sm flex-grow-1" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <!-- Botón Eliminar con Modal -->
                                <button type="button" class="btn btn-danger btn-sm flex-grow-1" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $session->id }}" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form action="{{ route('qr-sessions.toggle', $session->id) }}" method="POST" class="flex-grow-1">
                                    @csrf
                                    @method('PATCH')
                                    @if ($session->activo)
                                        <button type="submit" class="btn btn-secondary btn-sm w-100" title="Desactivar">
                                            <i class="fas fa-toggle-off"></i>
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-success btn-sm w-100" title="Activar">
                                            <i class="fas fa-toggle-on"></i>
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de Confirmación para Eliminar -->
            <div class="modal fade" id="deleteModal-{{ $session->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $session->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="deleteModalLabel-{{ $session->id }}">Confirmar Eliminación</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            ¿Estás seguro de que deseas eliminar la sesión <strong>{{ $session->nombre }}</strong>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                            <form action="{{ route('qr-sessions.destroy', $session->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">No hay sesiones QR creadas.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
