@extends('layouts.app')
@section('content')
<!-- Encabezado animado -->
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
  .header-create h1 {
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
    max-width: 24rem;
    margin: auto;
  }
  .form-label {
    font-weight: 600;
    color: var(--primary);
  }
  .btn-primary, .btn-secondary {
    border-radius: 0.5rem;
    padding: 0.75rem;
    font-weight: bold;
    transition: transform 0.3s, box-shadow 0.3s;
  }
  .btn-primary {
    background: var(--primary);
    color: var(--white);
    box-shadow: 0 4px 10px var(--shadow);
  }
  .btn-primary:hover { transform: scale(1.03); box-shadow: 0 6px 15px var(--shadow); }
  .btn-secondary {
    background: var(--secondary);
    color: var(--white);
    box-shadow: 0 4px 10px var(--shadow);
  }
  .btn-secondary:hover { transform: scale(1.03); box-shadow: 0 6px 15px var(--shadow); }
</style>

<!-- Encabezado -->
<div class="container-fluid animated-bg">
  <div class="container header-create">
    <h1>Crear Sesión QR</h1>
  </div>
</div>

<div class="container py-4">
  <div class="d-flex justify-content-end mb-4">
    <a href="{{ route('qr-sessions.index') }}" class="btn btn-secondary btn-sm">Cancelar</a>
  </div>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="form-card">
    <form action="{{ route('qr-sessions.store') }}" method="POST" class="animate__animated animate__fadeIn">
      @csrf

      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre de la sesión</label>
        <input type="text" name="nombre" id="nombre"
               class="form-control @error('nombre') is-invalid @enderror"
               value="{{ old('nombre') }}" required>
        @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="mb-3">
        <label for="actividad" class="form-label">Actividad</label>
        <input type="text" name="actividad" id="actividad"
               class="form-control @error('actividad') is-invalid @enderror"
               value="{{ old('actividad') }}" required>
        @error('actividad')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" name="activo" id="activo" checked>
        <label class="form-check-label form-label" for="activo">Activar esta sesión</label>
      </div>

      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-qrcode me-1"></i> Crear y Generar QR
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
