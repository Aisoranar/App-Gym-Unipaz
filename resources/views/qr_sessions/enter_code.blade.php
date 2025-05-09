@extends('layouts.app')

@section('title', 'Escanear QR')

@section('content')
<div class="container py-5">
  <h1 class="mb-4 text-center animate__animated animate__fadeInDown">Escanear Código QR</h1>

  @if(session('error'))
    <div class="alert alert-danger animate__animated animate__fadeIn">{{ session('error') }}</div>
  @endif
  @if(session('success'))
    <div class="alert alert-success animate__animated animate__fadeIn">{{ session('success') }}</div>
  @endif

  <!-- Formulario manual -->
  <form action="{{ route('qr-sessions.redirect-code') }}" method="GET" id="manual-form" class="mb-4 d-flex justify-content-center animate__animated animate__fadeIn">
    <input type="text" name="codigo" id="codigo" class="form-control w-50 me-2" placeholder="Ingresa código QR" required>

    <button type="submit" class="btn btn-primary animate__animated animate__pulse animate__infinite">
      Ir a Escaneo
    </button>
  </form>

  <div class="text-center mb-4">
    <!-- Botón animado para iniciar escaneo -->
    <button id="btn-scan" class="btn btn-secondary btn-lg animate__animated animate__bounceIn">
      <i class="bi bi-camera-fill"></i> Cámara / Escanear
    </button>
  </div>

  <!-- Escaneo inline -->
  <div id="scan-container" class="text-center" style="display:none;">
    <div id="reader-wrapper"
         class="position-relative mx-auto animate__animated animate__zoomIn"
         style="width:100%; max-width:480px; border:5px dashed #6c757d; border-radius:1rem; padding:1rem;">
      <div id="reader" style="width:100%;"></div>
      <div id="scan-overlay"
           class="position-absolute top-0 start-0 w-100 h-100"
           style="pointer-events:none;">
        <div class="scanner-line animate__animated animate__heartBeat animate__infinite"></div>
      </div>
    </div>
    <p id="scan-msg" class="mt-3 animate__animated animate__fadeInUp">
      Apunta tu cámara al código QR...
    </p>
  </div>
</div>
@endsection

@push('styles')
  <!-- Animate.css -->
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <!-- Bootstrap Icons -->
  <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>
  <style>
    .scanner-line {
      position: absolute;
      top: 50%;
      left: 0;
      width: 100%;
      height: 4px;
      background: rgba(220,53,69,0.8);
      animation-duration: 1.5s;
    }
    .animate__heartBeat {
      animation-duration: 2s;
      animation-delay: 0.5s;
    }
  </style>
@endpush

@push('scripts')
  <!-- Biblioteca HTML5 QR Code -->
  <script src="https://unpkg.com/html5-qrcode"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // 1) Lógica del formulario manual
      const manualForm = document.getElementById('manual-form');
      manualForm.addEventListener('submit', e => {
        e.preventDefault();
        const code = document.getElementById('codigo').value.trim();
        if (code) {
          // Redirige a /qr/scan/{codigo}
          window.location.href = `/qr/scan/${encodeURIComponent(code)}`;
        }
      });

      // 2) Lógica del escáner de cámara
      const btnScan = document.getElementById('btn-scan');
      const container = document.getElementById('scan-container');
      let scanner;

      btnScan.addEventListener('click', () => {
        btnScan.classList.add('animate__zoomOut');
        setTimeout(() => btnScan.style.display = 'none', 500);

        container.style.display = 'block';
        container.classList.add('animate__fadeIn');

        scanner = new Html5Qrcode("reader");
        scanner.start(
          { facingMode: "environment" },
          { fps: 15, qrbox: { width: 250, height: 250 } },
          qrCodeMessage => {
            scanner.stop().then(() => {
              window.location.href = `/qr/scan/${encodeURIComponent(qrCodeMessage)}`;
            });
          },
          errorMessage => {
            // Ignora errores leves
          }
        ).catch(err => {
          alert('No se pudo iniciar la cámara: ' + err);
        });
      });
    });
  </script>
@endpush
