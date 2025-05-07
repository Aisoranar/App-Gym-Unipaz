@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Asistencia</h1>

    @if (session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mt-2">{{ session('error') }}</div>
    @endif

    <form action="{{ route('qr-sessions.scan-submit') }}" method="POST">
        @csrf
        <input type="hidden" name="qr_code_session_id" value="{{ $session->id }}">

        <div class="mb-3">
            <label for="carrera" class="form-label">Carrera</label>
            <input type="text" name="carrera" class="form-control" id="carrera" required>
        </div>

        <div class="mb-3">
            <label for="actividad" class="form-label">Actividad</label>
            <input type="text" name="actividad" class="form-control" id="actividad" required>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control" id="fecha"
                   value="{{ date('Y-m-d') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Registrar Asistencia</button>
    </form>
</div>
@endsection
