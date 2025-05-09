@extends('layouts.app')

@section('title', 'Registro de Asistencia')

@section('content')
<div class="container py-5">
  <h1 class="mb-4 text-center">Registrar Asistencia: {{ $session->nombre }}</h1>

  <form action="{{ route('qr-sessions.scan-submit') }}" method="POST" class="animate__animated animate__fadeIn">
    @csrf
    <input type="hidden" name="qr_code_session_id" value="{{ $session->id }}">

    <div class="mb-3">
      <label for="carrera" class="form-label">Carrera</label>
      <input type="text" name="carrera" id="carrera" class="form-control" required>
    </div>

    @php
      // Fecha y hora actual en Colombia
      $nowCO = \Carbon\Carbon::now('America/Bogota');
    @endphp

    <div class="mb-4">
      <label class="form-label">Fecha y Hora (COL)</label>
      <input type="text"
             class="form-control"
             value="{{ $nowCO->isoFormat('DD/MM/YYYY hh:mm A') }}"
             disabled>
      <!-- Campo oculto que se enviará al servidor -->
      <input type="hidden" name="fecha" value="{{ $nowCO->toDateTimeString() }}">
    </div>

    <button type="submit" class="btn btn-success w-100">
      Registrar Asistencia
    </button>
  </form>
</div>

<!-- Feedback Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-{{ session('success') ? 'success' : 'danger' }} text-white">
        <h5 class="modal-title" id="feedbackModalLabel">
          {{ session('success') ? '¡Éxito!' : 'Atención' }}
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
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
    @if(session('success') || session('error'))
      var feedbackModal = new bootstrap.Modal(document.getElementById('feedbackModal'));
      feedbackModal.show();
    @endif
  });
</script>
@endpush
