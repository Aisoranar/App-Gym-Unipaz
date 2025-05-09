@extends('layouts.app')
@section('title', 'Registro de Asistencia')
@section('content')
<!-- Estilos globales y personalizados -->
<style>
  :root {
    --primary: #001f3f;
    --secondary: #013220;
    --white: #ffffff;
    --shadow: rgba(0,0,0,0.1);
  }
  .animated-bg {
    background: linear-gradient(45deg, var(--primary), var(--secondary));
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
    padding: 2rem 0;
    text-align: center;
    margin-bottom: 1.5rem;
  }
  @keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
  .header-scan h1 {
    color: var(--white);
    font-size: 2rem;
    font-weight: bold;
    text-shadow: 0 0 5px rgba(0,0,0,0.3);
  }
  .form-card {
    background: var(--white);
    border-left: 4px solid var(--primary);
    border-radius: 1rem;
    box-shadow: 0 4px 15px var(--shadow);
    padding: 2rem;
    max-width: 32rem;
    margin: auto;
  }
  .form-label {
    font-weight: 600;
    color: var(--primary);
  }
  .btn-success, .btn-secondary {
    border-radius: 0.5rem;
    padding: 0.75rem;
    font-weight: bold;
    transition: transform 0.3s, box-shadow 0.3s;
  }
  .btn-success {
    background: var(--secondary);
    color: var(--white);
    box-shadow: 0 4px 10px var(--shadow);
  }
  .btn-success:hover { transform: scale(1.03); box-shadow: 0 6px 15px var(--shadow); }
  .btn-secondary {
    background: var(--primary);
    color: var(--white);
    box-shadow: 0 4px 10px var(--shadow);
  }
  .btn-secondary:hover { transform: scale(1.03); box-shadow: 0 6px 15px var(--shadow); }
</style>

<!-- Encabezado animado -->
<div class="container-fluid animated-bg">
  <div class="container header-scan text-center">
    <h1>Registrar Asistencia</h1>
  </div>
</div>

<div class="container py-4">
  <div class="form-card animate__animated animate__fadeIn">
    <!-- Título sesión -->
    <h2 class="mb-4 text-primary">{{ $session->nombre }}</h2>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('qr-sessions.scan-submit') }}" method="POST">
      @csrf
      <input type="hidden" name="qr_code_session_id" value="{{ $session->id }}">

      <div class="mb-3">
        <label for="carrera" class="form-label">Carrera</label>
        <input type="text" name="carrera" id="carrera" class="form-control" required>
      </div>

      @php $nowCO = \Carbon\Carbon::now('America/Bogota'); @endphp
      <div class="mb-4">
        <label class="form-label">Fecha y Hora (COL)</label>
        <input type="text" class="form-control" value="{{ $nowCO->isoFormat('DD/MM/YYYY hh:mm A') }}" disabled>
        <input type="hidden" name="fecha" value="{{ $nowCO->toDateTimeString() }}">
      </div>

      <div class="d-grid gap-2 mb-3">
        <button type="submit" class="btn btn-success">Registrar Asistencia</button>
      </div>
      <a href="{{ route('qr-sessions.show', $session->id) }}" class="btn btn-secondary w-100">&larr; Volver a Sesión</a>
    </form>
  </div>
</div>

<!-- Feedback Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-{{ session('success') ? 'success' : 'danger' }} text-white">
        <h5 class="modal-title">{{ session('success') ? '¡Éxito!' : 'Atención' }}</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        {{ session('success') ?? session('error') }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endpush

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    if ({{ session()->has('success') || session()->has('error') ? 'true' : 'false' }}) {
      new bootstrap.Modal(document.getElementById('feedbackModal')).show();
    }
  });
</script>
@endpush