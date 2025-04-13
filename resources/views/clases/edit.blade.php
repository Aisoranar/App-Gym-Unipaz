@extends('layouts.app')
@section('title', 'Editar Clase')
@section('content')
    <h1>Editar Clase</h1>
    <form method="POST" action="{{ route('clases.update', $clase) }}">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $clase->titulo }}" required>
      </div>
      <div class="form-group">
        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" class="form-control">{{ $clase->descripcion }}</textarea>
      </div>
      <div class="form-group">
        <label for="fecha">Fecha</label>
        <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $clase->fecha }}" required>
      </div>
      <div class="form-group">
        <label for="hora_inicio">Hora de Inicio</label>
        <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" value="{{ $clase->hora_inicio }}" required>
      </div>
      <div class="form-group">
        <label for="hora_fin">Hora de Fin (opcional)</label>
        <input type="time" name="hora_fin" id="hora_fin" class="form-control" value="{{ $clase->hora_fin }}">
      </div>
      <button type="submit" class="btn btn-primary">Actualizar Clase</button>
    </form>
@endsection
