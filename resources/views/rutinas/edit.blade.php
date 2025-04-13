@extends('layouts.app')
@section('title', 'Editar Rutina')
@section('content')
    <h1>Editar Rutina</h1>
    <form method="POST" action="{{ route('rutinas.update', $rutina) }}">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label for="nombre">Nombre de la Rutina</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $rutina->nombre }}" required>
      </div>
      <div class="form-group">
        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" class="form-control">{{ $rutina->descripcion }}</textarea>
      </div>
      <div class="form-group">
        <label for="dias_por_semana">Días por Semana</label>
        <input type="number" name="dias_por_semana" id="dias_por_semana" class="form-control" value="{{ $rutina->dias_por_semana }}">
      </div>
      <div class="form-group">
        <label for="ejercicios">Selecciona Ejercicios (Ctrl para múltiples selección)</label>
        <select name="ejercicios[]" id="ejercicios" class="form-control" multiple>
          @foreach($ejercicios as $ejercicio)
            <option value="{{ $ejercicio->id }}" {{ in_array($ejercicio->id, $rutina->ejercicios->pluck('id')->toArray()) ? 'selected' : '' }}>
              {{ $ejercicio->nombre_ejercicio }}
            </option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Actualizar Rutina</button>
    </form>
@endsection
