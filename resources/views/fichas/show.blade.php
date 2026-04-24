@extends('layouts.app')
@section('title', 'Detalle de Ficha Médica')
@section('content')

<!-- Header -->
<div class="show-header">
  <h1>
    <i class="fas fa-file-medical"></i>
    Ficha Médica
  </h1>
  <p class="mb-0 mt-2 opacity-75">{{ $ficha->nombre }} {{ $ficha->apellidos }}</p>
</div>

<!-- Datos Personales -->
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-user"></i> Datos Personales
  </div>
  <div class="row">
    <div class="col-md-4 show-field">
      <div class="show-label">Nombre completo</div>
      <div class="show-value">{{ $ficha->nombre }} {{ $ficha->apellidos }}</div>
    </div>
    <div class="col-md-4 show-field">
      <div class="show-label">Documento</div>
      <div class="show-value">{{ $ficha->tipo_documento }} {{ $ficha->numero_documento }}</div>
    </div>
    <div class="col-md-4 show-field">
      <div class="show-label">Fecha de nacimiento</div>
      <div class="show-value">{{ $ficha->fecha_nacimiento }} ({{ $ficha->edad }} años)</div>
    </div>
    <div class="col-md-4 show-field">
      <div class="show-label">Sexo</div>
      <div class="show-value">{{ $ficha->sexo }}</div>
    </div>
    <div class="col-md-4 show-field">
      <div class="show-label">Teléfonos</div>
      <div class="show-value">{{ $ficha->telefonos ?? 'No especificado' }}</div>
    </div>
    <div class="col-md-4 show-field">
      <div class="show-label">Email</div>
      <div class="show-value">{{ $ficha->user->email ?? 'No disponible' }}</div>
    </div>
  </div>
</div>

<!-- Dirección -->
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-map-marker-alt"></i> Dirección
  </div>
  <div class="row">
    <div class="col-md-6 show-field">
      <div class="show-label">Domicilio</div>
      <div class="show-value">{{ $ficha->domicilio }}</div>
    </div>
    <div class="col-md-6 show-field">
      <div class="show-label">Barrio</div>
      <div class="show-value">{{ $ficha->barrio ?? 'No especificado' }}</div>
    </div>
  </div>
</div>

<!-- Información Médica -->
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-heartbeat"></i> Información Médica
  </div>
  <div class="row">
    <div class="col-md-3 show-field">
      <div class="show-label">Tipo de sangre</div>
      <div class="show-value">{{ $ficha->tipo_sangre }} {{ $ficha->factor_rh }}</div>
    </div>
    <div class="col-md-3 show-field">
      <div class="show-label">Lateralidad</div>
      <div class="show-value">{{ $ficha->lateralidad }}</div>
    </div>
    <div class="col-md-3 show-field">
      <div class="show-label">Actividad física</div>
      <div class="show-value">{{ $ficha->actividad_fisica ?? 'No especificado' }}</div>
    </div>
    <div class="col-md-3 show-field">
      <div class="show-label">Frecuencia</div>
      <div class="show-value">{{ $ficha->frecuencia_semanal ?? 'No especificado' }}</div>
    </div>
    <div class="col-md-6 show-field">
      <div class="show-label">Lesiones</div>
      <div class="show-value">{{ $ficha->lesiones ?? 'Ninguna registrada' }}</div>
    </div>
    <div class="col-md-6 show-field">
      <div class="show-label">Alergias</div>
      <div class="show-value">{{ $ficha->alergias ?? 'Ninguna registrada' }}</div>
    </div>
    @if($ficha->padece_enfermedad)
    <div class="col-12 show-field">
      <div class="show-label">Enfermedad</div>
      <div class="show-value text-danger">{{ $ficha->enfermedad }}</div>
    </div>
    @endif
  </div>
</div>

<!-- Contacto de Emergencia -->
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-phone-alt"></i> Contacto de Emergencia
  </div>
  <div class="row">
    <div class="col-md-4 show-field">
      <div class="show-label">Padre</div>
      <div class="show-value">{{ $ficha->nombre_padre ?? 'No especificado' }}</div>
    </div>
    <div class="col-md-4 show-field">
      <div class="show-label">Madre</div>
      <div class="show-value">{{ $ficha->nombre_madre ?? 'No especificado' }}</div>
    </div>
    <div class="col-md-4 show-field">
      <div class="show-label">Acudiente ({{ $ficha->parentesco ?? 'Parentesco no especificado' }})</div>
      <div class="show-value">{{ $ficha->nombre_acudiente ?? 'No especificado' }}</div>
    </div>
  </div>
</div>

<!-- Acciones -->
<div class="show-actions">
  <a href="{{ route('fichas.index') }}" class="btn-back">
    <i class="fas fa-arrow-left"></i> Volver
  </a>
  @if(Auth::id() === $ficha->user_id || Auth::user()->role === 'superadmin' || Auth::user()->role === 'entrenador')
    <a href="{{ route('fichas.edit', $ficha) }}" class="btn-edit">
      <i class="fas fa-edit"></i> Editar
    </a>
  @endif
</div>

@endsection
