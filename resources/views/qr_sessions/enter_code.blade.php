@extends('layouts.app')

@section('title', 'Escanear QR')

@section('content')
<!-- Encabezado animado -->
<div class="container-fluid animated-bg mb-4">
  <div class="container header-scan text-center">
    <h1>Escanear Código QR</h1>
  </div>
</div>

<div class="container py-3">
  @if(session('error'))
    <div class="alert alert-danger animate__animated animate__fadeIn">{{ session('error') }}</div>
  @endif
  @if(session('success'))
    <div class="alert alert-success animate__animated animate__fadeIn">{{ session('success') }}</div>
  @endif

  <div class="form-card animate__animated animate__fadeIn">
    <!-- Formulario manual -->
    <form id="manual-form" class="d-flex justify-content-center mb-4">
      <input type="text" name="codigo" id="codigo" class="form-control me-2" placeholder="Ingresa código QR" required>
      <button type="submit" class="btn btn-success animate__animated animate__pulse animate__infinite">
        Ir a Escaneo
      </button>
    </form>

    <!-- Botón de cámara -->
    <div class="text-center mb-4">
      <button id="btn-scan" class="btn btn-secondary btn-lg animate__animated animate__bounceIn">
        <i class="bi bi-camera-fill"></i> Cámara / Escanear
      </button>
    </div>

    <!-- Contenedor del escaneo QR -->
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
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>
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
    max-width: 36rem;
    margin: auto;
  }
  .btn-success, .btn-secondary {
    border-radius: 0.5rem;
    padding: 0.75rem 1.25rem;
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
          // Ignorar errores menores
        }
      ).catch(err => {
        alert('No se pudo iniciar la cámara: ' + err);
      });
    });
  });
</script>
@endpush
