@extends('layouts.app')

@section('title', 'Editar Ejercicio')
@section('content')
    <h1>Editar Ejercicio</h1>
    <form method="POST" action="{{ route('ejercicios.update', $ejercicio) }}">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label for="nombre_ejercicio">Nombre del Ejercicio</label>
        <input type="text" name="nombre_ejercicio" id="nombre_ejercicio" class="form-control" value="{{ $ejercicio->nombre_ejercicio }}" required>
      </div>
      <div class="form-group">
        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" class="form-control">{{ $ejercicio->descripcion }}</textarea>
      </div>
      <div class="form-group">
        <label for="series">Series</label>
        <input type="number" name="series" id="series" class="form-control" value="{{ $ejercicio->series }}">
      </div>
      <div class="form-group">
        <label for="repeticiones">Repeticiones</label>
        <input type="number" name="repeticiones" id="repeticiones" class="form-control" value="{{ $ejercicio->repeticiones }}">
      </div>
      <div class="form-group">
        <label for="duracion">Duración (minutos)</label>
        <input type="number" name="duracion" id="duracion" class="form-control" value="{{ $ejercicio->duracion }}">
      </div>
      <div class="form-group">
        <label for="fecha">Fecha</label>
        <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $ejercicio->fecha }}" required>
      </div>
      <button type="submit" class="btn btn-primary">Actualizar Ejercicio</button>
    </form>
@endsection
