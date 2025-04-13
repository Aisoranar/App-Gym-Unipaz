@extends('layouts.app')
@section('title', 'Crear Ficha Médica')
@section('content')

<!-- Estilos personalizados -->
<style>
    .form-section {
        background: #f8f9fa;
        border-radius: 0.5rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
        border-left: 4px solid #0d6efd;
    }
    .form-section h5 {
        margin-bottom: 1.5rem;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 0.5rem;
    }
    label {
        font-weight: 500;
        margin-bottom: 0.3rem;
    }
</style>

<div class="container py-4">
    <h1 class="mb-4 text-primary fw-bold">
        <i class="fa-solid fa-file-medical"></i> Crear Nueva Ficha Médica
    </h1>

    <form method="POST" action="{{ route('fichas.store') }}">
        @csrf

        {{-- 🧍 Datos Personales --}}
        <div class="form-section">
            <h5><i class="fa-solid fa-user"></i> Datos Personales</h5>
            <div class="row g-3">
                <div class="col-md-6 col-lg-4">
                    <label for="apellidos">Apellidos</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-user-tag"></i></span>
                        <input type="text" name="apellidos" id="apellidos" class="form-control" value="{{ old('apellidos') }}" required>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <label for="nombre">Nombre</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-id-badge"></i></span>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-calendar-check"></i></span>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}" required>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <label for="edad">Edad</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-hourglass-half"></i></span>
                        <input type="number" name="edad" id="edad" class="form-control" value="{{ old('edad') }}" required>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <label for="sexo">Sexo</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-venus-mars"></i></span>
                        <select name="sexo" id="sexo" class="form-select" required>
                            <option value="">-- Seleccione --</option>
                            <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
                            <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- 📍 Dirección y Contacto --}}
        <div class="form-section">
            <h5><i class="fa-solid fa-address-book"></i> Dirección y Contacto</h5>
            <div class="row g-3">
                <div class="col-md-6 col-lg-4">
                    <label for="domicilio">Domicilio</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-house"></i></span>
                        <input type="text" name="domicilio" id="domicilio" class="form-control" value="{{ old('domicilio') }}" required>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <label for="barrio">Barrio</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
                        <input type="text" name="barrio" id="barrio" class="form-control" value="{{ old('barrio') }}">
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <label for="telefonos">Teléfonos</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                        <input type="text" name="telefonos" id="telefonos" class="form-control" value="{{ old('telefonos') }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- 🩺 Información Médica --}}
        <div class="form-section">
            <h5><i class="fa-solid fa-user-md"></i> Información Médica</h5>
            <div class="row g-3">
                <div class="col-md-4 col-lg-3">
                    <label for="tipo_sangre">Tipo de Sangre</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-tint"></i></span>
                        <input type="text" name="tipo_sangre" id="tipo_sangre" class="form-control" value="{{ old('tipo_sangre') }}" required>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <label for="factor_rh">Factor RH</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-droplet"></i></span>
                        <select name="factor_rh" id="factor_rh" class="form-select" required>
                            <option value="">-- Seleccione --</option>
                            <option value="Positivo" {{ old('factor_rh') == 'Positivo' ? 'selected' : '' }}>Positivo</option>
                            <option value="Negativo" {{ old('factor_rh') == 'Negativo' ? 'selected' : '' }}>Negativo</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <label for="lateralidad">Lateralidad</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-hand-paper"></i></span>
                        <select name="lateralidad" id="lateralidad" class="form-select" required>
                            <option value="">-- Seleccione --</option>
                            <option value="Diestro" {{ old('lateralidad') == 'Diestro' ? 'selected' : '' }}>Diestro</option>
                            <option value="Zurdo" {{ old('lateralidad') == 'Zurdo' ? 'selected' : '' }}>Zurdo</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <label for="actividad_fisica">Actividad Física</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-dumbbell"></i></span>
                        <input type="text" name="actividad_fisica" id="actividad_fisica" class="form-control" value="{{ old('actividad_fisica') }}">
                    </div>
                </div>
                <div class="col-md-6 col-lg-2">
                    <label for="frecuencia_semanal">Frecuencia Semanal</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-running"></i></span>
                        <input type="number" name="frecuencia_semanal" id="frecuencia_semanal" class="form-control" value="{{ old('frecuencia_semanal') }}">
                    </div>
                </div>
                <div class="col-12">
                    <label for="lesiones"><i class="fa-solid fa-procedures"></i> Lesiones</label>
                    <textarea name="lesiones" id="lesiones" class="form-control" rows="2">{{ old('lesiones') }}</textarea>
                </div>
                <div class="col-12">
                    <label for="alergias"><i class="fa-solid fa-allergies"></i> Alergias</label>
                    <textarea name="alergias" id="alergias" class="form-control" rows="2">{{ old('alergias') }}</textarea>
                </div>
                <div class="col-12">
                    <div class="form-check mt-2">
                        <input type="checkbox" name="padece_enfermedad" id="padece_enfermedad" class="form-check-input" value="1" {{ old('padece_enfermedad') ? 'checked' : '' }}>
                        <label for="padece_enfermedad" class="form-check-label">
                            <i class="fa-solid fa-heart-crack"></i> ¿Padece alguna enfermedad?
                        </label>
                    </div>
                </div>
                <div class="col-12">
                    <label for="enfermedad">Nombre de la enfermedad (si aplica)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-notes-medical-alt"></i></span>
                        <input type="text" name="enfermedad" id="enfermedad" class="form-control" value="{{ old('enfermedad') }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- 👨‍👩‍👧 Información Familiar --}}
        <div class="form-section">
            <h5><i class="fa-solid fa-people-group"></i> Información Familiar</h5>
            <div class="row g-3">
                <div class="col-md-6 col-lg-4">
                    <label for="nombre_padre">Nombre del Padre</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-male"></i></span>
                        <input type="text" name="nombre_padre" id="nombre_padre" class="form-control" value="{{ old('nombre_padre') }}">
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <label for="nombre_madre">Nombre de la Madre</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-female"></i></span>
                        <input type="text" name="nombre_madre" id="nombre_madre" class="form-control" value="{{ old('nombre_madre') }}">
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <label for="nombre_acudiente">Nombre del Acudiente</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-user-friends"></i></span>
                        <input type="text" name="nombre_acudiente" id="nombre_acudiente" class="form-control" value="{{ old('nombre_acudiente') }}">
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <label for="parentesco">Parentesco</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-handshake"></i></span>
                        <input type="text" name="parentesco" id="parentesco" class="form-control" value="{{ old('parentesco') }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Botón de envío --}}
        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary btn-lg shadow-sm px-5">
                <i class="fa-solid fa-floppy-disk"></i> Guardar Ficha
            </button>
        </div>
        <a href="{{ route('fichas.index') }}" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Volver a la lista
    </a>

    </form>
    
</div>

@endsection
