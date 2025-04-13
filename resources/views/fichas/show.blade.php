@extends('layouts.app')
@section('title', 'Detalle de Ficha Médica')
@section('content')

<div class="container py-4">
    <h1 class="mb-4 text-primary fw-bold">
        <i class="fa-solid fa-file-medical"></i> Ficha Médica de {{ $ficha->nombre }} {{ $ficha->apellidos }}
    </h1>
    
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fa-solid fa-user"></i> Datos Personales</h5>
        </div>
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $ficha->nombre }}</p>
            <p><strong>Apellidos:</strong> {{ $ficha->apellidos }}</p>
            <p><strong>Fecha de Nacimiento:</strong> {{ $ficha->fecha_nacimiento }}</p>
            <p><strong>Edad:</strong> {{ $ficha->edad }}</p>
            <p><strong>Sexo:</strong> {{ $ficha->sexo }}</p>
        </div>
    </div>
    
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fa-solid fa-address-book"></i> Dirección y Contacto</h5>
        </div>
        <div class="card-body">
            <p><strong>Domicilio:</strong> {{ $ficha->domicilio }}</p>
            <p><strong>Barrio:</strong> {{ $ficha->barrio ?? 'No especificado' }}</p>
            <p><strong>Teléfonos:</strong> {{ $ficha->telefonos ?? 'No especificado' }}</p>
        </div>
    </div>
    
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fa-solid fa-user-md"></i> Información Médica</h5>
        </div>
        <div class="card-body">
            <p><strong>Tipo de Sangre:</strong> {{ $ficha->tipo_sangre }}</p>
            <p><strong>Factor RH:</strong> {{ $ficha->factor_rh }}</p>
            <p><strong>Lateralidad:</strong> {{ $ficha->lateralidad }}</p>
            <p><strong>Actividad Física:</strong> {{ $ficha->actividad_fisica ?? 'No especificado' }}</p>
            <p><strong>Frecuencia Semanal:</strong> {{ $ficha->frecuencia_semanal ?? 'No especificado' }}</p>
            <p><strong>Lesiones:</strong> {{ $ficha->lesiones ?? 'No especificado' }}</p>
            <p><strong>Alergias:</strong> {{ $ficha->alergias ?? 'No especificado' }}</p>
            <p><strong>Padece alguna enfermedad:</strong> {{ $ficha->padece_enfermedad ? 'Sí' : 'No' }}</p>
            @if($ficha->enfermedad)
                <p><strong>Nombre de la enfermedad:</strong> {{ $ficha->enfermedad }}</p>
            @endif
        </div>
    </div>
    
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fa-solid fa-people-group"></i> Información Familiar</h5>
        </div>
        <div class="card-body">
            <p><strong>Nombre del Padre:</strong> {{ $ficha->nombre_padre ?? 'No especificado' }}</p>
            <p><strong>Nombre de la Madre:</strong> {{ $ficha->nombre_madre ?? 'No especificado' }}</p>
            <p><strong>Nombre del Acudiente:</strong> {{ $ficha->nombre_acudiente ?? 'No especificado' }}</p>
            <p><strong>Parentesco:</strong> {{ $ficha->parentesco ?? 'No especificado' }}</p>
        </div>
    </div>
    
    <!-- Botón para editar la ficha médica -->
    <a href="{{ route('fichas.edit', $ficha) }}" class="btn btn-warning mb-3">
        <i class="fa-solid fa-edit"></i> Editar Ficha Médica
    </a>
    
    <a href="{{ route('fichas.index') }}" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Volver a la lista
    </a>
</div>

@endsection
