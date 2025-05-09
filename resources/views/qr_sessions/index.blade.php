@extends('layouts.app')

@section('content')
<!-- Estilos globales y personalizados -->
<style>
  :root {
    --primary: #001f3f;
    --secondary: #013220;
    --white: #ffffff;
    --shadow: rgba(0,0,0,0.1);
  }
  body {
    background: var(--white);
    color: var(--primary);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  /* Gradiente animado en encabezado */
  .animated-bg {
    background: linear-gradient(45deg, var(--primary), var(--secondary));
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
    padding: 2rem 0;
    text-align: center;
  }
  @keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
  /* Pulse animations */
  @keyframes pulse-green {
    0%   { box-shadow: 0 0 0 0 rgba(40,167,69,0.7); }
    70%  { box-shadow: 0 0 0 10px rgba(40,167,69,0); }
    100% { box-shadow: 0 0 0 0 rgba(40,167,69,0); }
  }
  @keyframes fade-gray {
    0%,100% { opacity: 1; }
    50%      { opacity: 0.6; }
  }
  .pulse-active   { animation: pulse-green 2s infinite; }
  .pulse-inactive { animation: fade-gray 2s infinite; }
  /* Tarjetas de sesión */
  .card-session {
    background: var(--white);
    border: none;
    border-radius: 1rem;
    box-shadow: 0 4px 15px var(--shadow);
    transition: transform 0.3s, box-shadow 0.3s;
    max-width: 20rem;
    margin: auto;
    display: flex;
    flex-direction: column;
  }
  .card-session:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
  }
  .qr-thumb {
    width: 100%;
    height: auto;
    max-width: 150px;
    margin: 1rem auto;
  }
  .card-title {
    font-size: 1.25rem;
    font-weight: bold;
    color: var(--primary);
  }
  .badge-status {
    font-weight: bold;
  }
  .btn-session {
    border-radius: 0.5rem;
    font-size: 0.875rem;
  }
</style>

<!-- Encabezado -->
<div class="container-fluid animated-bg">
  <div class="container header-session text-center">
    <h1 class="text-white">Sesiones QR</h1>
  </div>
</div>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h5">Mis Sesiones QR</h2>
    <a href="{{ route('qr-sessions.create') }}" class="btn btn-primary btn-sm btn-session">
      <i class="fas fa-plus me-1"></i> Nueva Sesión
    </a>
  </div>

  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <div class="row g-4">
    @forelse ($sessions as $session)
      <div class="col-12 col-sm-6 col-md-4">
        <div class="card-session {{ $session->activo ? 'pulse-active border border-2 border-success' : 'pulse-inactive border border-2 border-secondary' }} h-100">
          <img src="{{ $session->qr_image ? asset('storage/'.$session->qr_image) : '' }}"
               alt="QR {{ $session->codigo }}"
               class="qr-thumb">
          <div class="card-body d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="card-title">{{ $session->nombre }}</span>
              <span class="badge {{ $session->activo ? 'bg-success' : 'bg-secondary' }} badge-status">
                {{ $session->activo ? 'Activo' : 'Inactivo' }}
              </span>
            </div>
            <p class="mb-1"><strong>Actividad:</strong> {{ $session->actividad }}</p>
            <p class="mb-3 text-truncate"><strong>Código:</strong> {{ $session->codigo }}</p>

            <a href="{{ route('qr-sessions.scan-form', ['codigo'=>$session->codigo]) }}"
               class="btn btn-outline-primary btn-sm btn-session mb-3">
              <i class="fas fa-qrcode me-1"></i> Escanear
            </a>

            <div class="mt-auto d-flex gap-2">
              <a href="{{ route('qr-sessions.show', $session->id) }}" class="btn btn-info btn-sm flex-grow-1 btn-session">
                <i class="fas fa-eye"></i>
              </a>
              <a href="{{ route('qr-sessions.edit', $session->id) }}" class="btn btn-warning btn-sm flex-grow-1 btn-session">
                <i class="fas fa-edit"></i>
              </a>
              <button type="button" class="btn btn-danger btn-sm flex-grow-1 btn-session" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $session->id }}">
                <i class="fas fa-trash"></i>
              </button>
            </div>

            <form action="{{ route('qr-sessions.toggle', $session->id) }}" method="POST" class="mt-3">
              @csrf @method('PATCH')
              <button type="submit" class="btn btn-sm w-100 {{ $session->activo ? 'btn-secondary' : 'btn-success' }} btn-session">
                <i class="fas {{ $session->activo ? 'fa-toggle-off' : 'fa-toggle-on' }} me-1"></i>
                {{ $session->activo ? 'Desactivar' : 'Activar' }}
              </button>
            </form>
          </div>
        </div>
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
              <form action="{{ route('qr-sessions.destroy', $session->id) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
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
