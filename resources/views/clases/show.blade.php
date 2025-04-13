@extends('layouts.app')
@section('title', 'Detalle de Clase')
@section('content')
    <h1>{{ $clase->titulo }}</h1>
    <p><strong>Descripción:</strong> {{ $clase->descripcion }}</p>
    <p><strong>Fecha:</strong> {{ $clase->fecha }}</p>
    <p><strong>Hora de Inicio:</strong> {{ $clase->hora_inicio }}</p>
    @if($clase->hora_fin)
        <p><strong>Hora de Fin:</strong> {{ $clase->hora_fin }}</p>
    @endif
    <a href="{{ route('clases.index') }}" class="btn btn-secondary">Volver a la lista</a>
@endsection
