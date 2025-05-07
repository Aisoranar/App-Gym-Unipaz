@extends('layouts.app')

@section('title', 'Registro de Asistencia')

@section('content')
<div class="container py-5">
  <h1 class="mb-4 text-center">Registrar Asistencia: {{ $session->nombre }}</h1>

  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form action="{{ route('qr-sessions.scan-submit') }}" method="POST" class="animate__animated animate__fadeIn">
    @csrf
    <input type="hidden" name="qr_code_session_id" value="{{ $session->id }}">

    <div class="mb-3">
      <label for="carrera" class="form-label">Carrera</label>
      <input type="text" name="carrera" id="carrera" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="actividad" class="form-label">Actividad</label>
      <input type="text" name="actividad" id="actividad" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="fecha" class="form-label">Fecha</label>
      <input type="date" name="fecha" id="fecha" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
    </div>

    <button type="submit" class="btn btn-success w-100">
      Registrar Asistencia
    </button>
  </form>
</div>
@endsection
