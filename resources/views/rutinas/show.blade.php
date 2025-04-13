@extends('layouts.app')
@section('title', 'Detalle de Rutina')
@section('content')
    <h1>{{ $rutina->nombre }}</h1>
    <p><strong>Descripción:</strong> {{ $rutina->descripcion }}</p>
    <p><strong>Días por Semana:</strong> {{ $rutina->dias_por_semana }}</p>
    <h3>Ejercicios</h3>
    @if($rutina->ejercicios->isNotEmpty())
      <ul>
        @foreach($rutina->ejercicios as $ejercicio)
          <li>{{ $ejercicio->nombre_ejercicio }}</li>
        @endforeach
      </ul>
    @else
      <p>No se han asignado ejercicios.</p>
    @endif
    <a href="{{ route('rutinas.index') }}" class="btn btn-secondary">Volver a la lista</a>
@endsection
