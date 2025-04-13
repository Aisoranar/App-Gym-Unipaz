@extends('layouts.app')
@section('title', 'Detalle del Ejercicio')
@section('content')
    <h1>{{ $ejercicio->nombre_ejercicio }}</h1>
    <p><strong>Descripción:</strong> {{ $ejercicio->descripcion }}</p>
    <p><strong>Series:</strong> {{ $ejercicio->series }}</p>
    <p><strong>Repeticiones:</strong> {{ $ejercicio->repeticiones }}</p>
    <p><strong>Duración:</strong> {{ $ejercicio->duracion }} minutos</p>
    <p><strong>Fecha:</strong> {{ $ejercicio->fecha }}</p>
    <a href="{{ route('ejercicios.index') }}" class="btn btn-secondary">Volver a la lista</a>
@endsection
