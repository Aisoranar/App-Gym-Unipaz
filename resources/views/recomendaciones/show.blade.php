@extends('layouts.app')
@section('title', 'Detalle de Recomendación')
@section('content')
    <h1>Recomendación</h1>
    <p><strong>Contenido:</strong> {{ $recomendacion->contenido }}</p>
    <p><strong>Fecha:</strong> {{ $recomendacion->fecha }}</p>
    <a href="{{ route('recomendaciones.index') }}" class="btn btn-secondary">Volver a la lista</a>
@endsection
