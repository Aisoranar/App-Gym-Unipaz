@extends('layouts.app')
@section('title', 'Editar Recomendación')
@section('content')
    <h1>Editar Recomendación</h1>
    <form method="POST" action="{{ route('recomendaciones.update', $recomendacion) }}">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label for="contenido">Contenido</label>
        <textarea name="contenido" id="contenido" class="form-control" required>{{ $recomendacion->contenido }}</textarea>
      </div>
      <div class="form-group">
        <label for="fecha">Fecha</label>
        <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $recomendacion->fecha }}" required>
      </div>
      <button type="submit" class="btn btn-primary">Actualizar Recomendación</button>
    </form>
@endsection
