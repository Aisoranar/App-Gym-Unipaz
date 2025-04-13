@extends('layouts.app')
@section('title', 'Editar Plan Nutricional')
@section('content')
    <h1>Editar Plan Nutricional</h1>
    <form method="POST" action="{{ route('planes.update', $plan) }}">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $plan->nombre }}" required>
      </div>
      <div class="form-group">
        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" class="form-control">{{ $plan->descripcion }}</textarea>
      </div>
      <div class="form-group">
        <label for="calorias_diarias">Calorías Diarias</label>
        <input type="number" name="calorias_diarias" id="calorias_diarias" class="form-control" value="{{ $plan->calorias_diarias }}">
      </div>
      <div class="form-group">
        <label for="recomendaciones">Recomendaciones</label>
        <textarea name="recomendaciones" id="recomendaciones" class="form-control">{{ $plan->recomendaciones }}</textarea>
      </div>
      <button type="submit" class="btn btn-primary">Actualizar Plan</button>
    </form>
@endsection
