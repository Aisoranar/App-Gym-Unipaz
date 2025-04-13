@extends('layouts.app')
@section('title', 'Crear Nueva Rutina')
@section('content')

<div class="container py-4">
    <h1 class="mb-4">Crear Nueva Rutina</h1>

    <!-- Mensajes de éxito y errores de validación -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if($errors->any())
      <div class="alert alert-danger">
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('rutinas.store') }}">
        @csrf

        <div class="form-group mb-3">
            <label for="nombre">Nombre de la Rutina</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="fecha_inicio">Fecha de inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio') }}">
            </div>
            <div class="col-md-6">
                <label for="fecha_fin">Fecha de fin</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin') }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="hora_inicio">Hora de inicio</label>
                <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" value="{{ old('hora_inicio') }}">
            </div>
            <div class="col-md-6">
                <label for="hora_fin">Hora de fin</label>
                <input type="time" name="hora_fin" id="hora_fin" class="form-control" value="{{ old('hora_fin') }}">
            </div>
        </div>

        <div class="form-group mb-3">
            <label>Días de la Rutina:</label>
            @php
                $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
            @endphp
            @foreach($diasSemana as $dia)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="dias[]" value="{{ $dia }}" id="{{ strtolower($dia) }}"
                        {{ (is_array(old('dias')) && in_array($dia, old('dias'))) ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ strtolower($dia) }}">{{ $dia }}</label>
                </div>
            @endforeach
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="estado">Estado</label>
                <select name="estado" id="estado" class="form-select">
                    <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="en curso" {{ old('estado') == 'en curso' ? 'selected' : '' }}>En curso</option>
                    <option value="finalizada" {{ old('estado') == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="objetivo">Objetivo</label>
                <input type="text" name="objetivo" id="objetivo" class="form-control" placeholder="Ej. Ganar masa muscular" value="{{ old('objetivo') }}">
            </div>
            <div class="col-md-4">
                <label for="intensidad">Intensidad</label>
                <select name="intensidad" id="intensidad" class="form-select">
                    <option value="">-- Seleccione --</option>
                    <option value="baja" {{ old('intensidad') == 'baja' ? 'selected' : '' }}>Baja</option>
                    <option value="media" {{ old('intensidad') == 'media' ? 'selected' : '' }}>Media</option>
                    <option value="alta" {{ old('intensidad') == 'alta' ? 'selected' : '' }}>Alta</option>
                </select>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="notas">Notas adicionales</label>
            <textarea name="notas" id="notas" class="form-control" placeholder="Agrega comentarios o detalles adicionales">{{ old('notas') }}</textarea>
        </div>

        @if(isset($ejercicios) && $ejercicios->count())
            <div class="form-group mb-4">
                <label>Ejercicios de la rutina:</label>
                @foreach($ejercicios as $ejercicio)
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="ejercicios[]" id="ejercicio_{{ $ejercicio->id }}" value="{{ $ejercicio->id }}"
                          {{ (is_array(old('ejercicios')) && in_array($ejercicio->id, old('ejercicios'))) ? 'checked' : '' }}>
                        <label class="form-check-label" for="ejercicio_{{ $ejercicio->id }}">
                            {{ $ejercicio->nombre_ejercicio }}
                        </label>
                    </div>
                @endforeach
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Crear Rutina</button>
    </form>
</div>

@endsection
