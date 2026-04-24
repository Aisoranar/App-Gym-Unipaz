@extends('layouts.app')
@section('title', 'Editar Rutina')
@section('content')
<div class="container py-4">
    <h1 class="mb-4">Editar Rutina</h1>
    <form method="POST" action="{{ route('rutinas.update', $rutina) }}">
        @csrf
        @method('PUT')
        
        <!-- Nombre y Descripción -->
        <div class="form-group mb-3">
            <label for="nombre">Nombre de la Rutina</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $rutina->nombre }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control">{{ $rutina->descripcion }}</textarea>
        </div>
        
        <!-- Fechas y Horas -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="fecha_inicio">Fecha de inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ $rutina->fecha_inicio ? $rutina->fecha_inicio->format('Y-m-d') : '' }}">
            </div>
            <div class="col-md-6">
                <label for="fecha_fin">Fecha de fin</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ $rutina->fecha_fin ? $rutina->fecha_fin->format('Y-m-d') : '' }}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="hora_inicio">Hora de inicio</label>
                <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" value="{{ $rutina->hora_inicio ? $rutina->hora_inicio->format('H:i') : '' }}">
            </div>
            <div class="col-md-6">
                <label for="hora_fin">Hora de fin</label>
                <input type="time" name="hora_fin" id="hora_fin" class="form-control" value="{{ $rutina->hora_fin ? $rutina->hora_fin->format('H:i') : '' }}">
            </div>
        </div>
        
        <!-- Selección de Días -->
        <div class="form-group mb-3">
            <label>Selecciona los días en los que realizarás la rutina:</label>
            @php
                $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                $diasSeleccionados = $rutina->dias ?? [];
                if (is_string($diasSeleccionados)) {
                    $diasSeleccionados = json_decode($diasSeleccionados, true) ?? [];
                }
                if (!is_array($diasSeleccionados)) {
                    $diasSeleccionados = [];
                }
            @endphp
            @foreach($diasSemana as $dia)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="dias[]" value="{{ $dia }}" id="{{ strtolower($dia) }}"
                {{ in_array($dia, $diasSeleccionados) ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ strtolower($dia) }}">{{ $dia }}</label>
            </div>
            @endforeach
        </div>
        
        <!-- Estado, Objetivo e Intensidad -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="estado">Estado</label>
                <select name="estado" id="estado" class="form-select">
                    <option value="pendiente" {{ $rutina->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="en curso" {{ $rutina->estado == 'en curso' ? 'selected' : '' }}>En curso</option>
                    <option value="finalizada" {{ $rutina->estado == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="objetivo">Objetivo</label>
                <input type="text" name="objetivo" id="objetivo" class="form-control" value="{{ $rutina->objetivo }}" placeholder="Ej. Ganar masa muscular">
            </div>
            <div class="col-md-4">
                <label for="intensidad">Intensidad</label>
                <select name="intensidad" id="intensidad" class="form-select">
                    <option value="">-- Seleccione --</option>
                    <option value="baja" {{ $rutina->intensidad == 'baja' ? 'selected' : '' }}>Baja</option>
                    <option value="media" {{ $rutina->intensidad == 'media' ? 'selected' : '' }}>Media</option>
                    <option value="alta" {{ $rutina->intensidad == 'alta' ? 'selected' : '' }}>Alta</option>
                </select>
            </div>
        </div>
        
        <!-- Notas adicionales -->
        <div class="form-group mb-3">
            <label for="notas">Notas</label>
            <textarea name="notas" id="notas" class="form-control" placeholder="Agrega comentarios o detalles adicionales">{{ $rutina->notas }}</textarea>
        </div>
        
        <!-- Selección de ejercicios (opcional) -->
        @if(isset($ejercicios) && $ejercicios->count())
        <div class="form-group mb-3">
            <label for="ejercicios">Selecciona los ejercicios que formarán parte de la rutina:</label>
            <select name="ejercicios[]" id="ejercicios" class="form-select" multiple>
                @foreach($ejercicios as $ejercicio)
                    <option value="{{ $ejercicio->id }}" 
                        {{ in_array($ejercicio->id, $rutina->ejercicios->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $ejercicio->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif
        
        <button type="submit" class="btn btn-primary">Actualizar Rutina</button>
    </form>
</div>
@endsection
