@extends('layouts.app')
@section('title', 'Escanear QR')
@section('content')

<!-- Header de página -->
<div class="page-header">
  <div>
    <h1>
      <i class="fas fa-camera"></i>
      Escanear QR
    </h1>
    <p>Registra tu asistencia escaneando el código</p>
  </div>
</div>

@if(session('error'))
  <div class="gym-alert error mb-4">
    <i class="fas fa-exclamation-circle"></i>
    {{ session('error') }}
  </div>
@endif
@if(session('success'))
  <div class="gym-alert success mb-4">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
  </div>
@endif

<div class="gym-card" style="max-width: 500px; margin: 0 auto;">
  <!-- Formulario manual -->
  <form id="manual-form" class="d-flex gap-2 mb-4">
    <input type="text" name="codigo" id="codigo" class="gym-form-control flex-grow-1" placeholder="Ingresa código manualmente" required>
    <button type="submit" class="btn-primary-gym" style="white-space: nowrap;">
      <i class="fas fa-arrow-right d-md-none"></i>
      <span class="d-none d-md-inline">Ir</span>
    </button>
  </form>

  <div class="text-center mb-3">
    <span class="text-muted">— o —</span>
  </div>

  <!-- Botón de cámara -->
  <div class="text-center">
    <button id="btn-scan" class="btn-primary-gym">
      <i class="fas fa-camera me-2"></i>
      <span>Escanear con Cámara</span>
    </button>
  </div>

  <!-- Contenedor del escaneo QR -->
  <div id="scan-container" class="text-center mt-4" style="display:none;">
    <div id="reader-wrapper" class="position-relative mx-auto" style="width:100%; max-width:400px; border:3px dashed var(--primary-color); border-radius:1rem; padding:1rem; background: #f8f9fa;">
      <div id="reader" style="width:100%;"></div>
      <div id="scan-overlay" class="position-absolute top-0 start-0 w-100 h-100" style="pointer-events:none;">
        <div class="scanner-line"></div>
      </div>
    </div>
    <p id="scan-msg" class="mt-3 text-muted">
      <i class="fas fa-qrcode me-2"></i>Apunta tu cámara al código QR...
    </p>
  </div>
</div>

<style>
  .scanner-line {
    position: absolute;
    top: 40%;
    left: 10%;
    width: 80%;
    height: 3px;
    background: linear-gradient(90deg, transparent, #dc3545, transparent);
    animation: scan 2s linear infinite;
  }
  @keyframes scan {
    0% { top: 10%; opacity: 0; }
    10% { opacity: 1; }
    90% { opacity: 1; }
    100% { top: 90%; opacity: 0; }
  }
</style>

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const manualForm = document.getElementById('manual-form');
    manualForm.addEventListener('submit', e => {
      e.preventDefault();
      const code = document.getElementById('codigo').value.trim();
      if (code) {
        window.location.href = `/qr/scan/${encodeURIComponent(code)}`;
      }
    });

    const btnScan = document.getElementById('btn-scan');
    const container = document.getElementById('scan-container');
    let scanner;

    btnScan.addEventListener('click', () => {
      btnScan.style.display = 'none';
      container.style.display = 'block';

      scanner = new Html5Qrcode("reader");
      scanner.start(
        { facingMode: "environment" },
        { fps: 15, qrbox: { width: 250, height: 250 } },
        qrCodeMessage => {
          scanner.stop().then(() => {
            window.location.href = `/qr/scan/${encodeURIComponent(qrCodeMessage)}`;
          });
        },
        errorMessage => { /* Ignorar errores menores */ }
      ).catch(err => {
        alert('No se pudo iniciar la cámara: ' + err);
      });
    });
  });
</script>
@endpush

@endsection
