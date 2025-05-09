@extends('layouts.app')

@section('content')
<div class="container px-2">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4">Editar Sesión QR</h1>
        <a href="{{ route('qr-sessions.index') }}" class="btn btn-secondary btn-sm">Cancelar</a>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit Form Card -->
    <div class="card mx-auto" style="max-width: 24rem;">
        <div class="card-body">
            <form action="{{ route('qr-sessions.update', $session->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nombre -->
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre de la sesión</label>
                    <input type="text" name="nombre" id="nombre"
                           class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre', $session->nombre) }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Actividad -->
                <div class="mb-3">
                    <label for="actividad" class="form-label">Actividad</label>
                    <input type="text" name="actividad" id="actividad"
                           class="form-control @error('actividad') is-invalid @enderror"
                           value="{{ old('actividad', $session->actividad) }}" required>
                    @error('actividad')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Activo -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="activo" id="activo"
                           {{ old('activo', $session->activo) ? 'checked' : '' }}>
                    <label class="form-check-label" for="activo">
                        Activar esta sesión
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
