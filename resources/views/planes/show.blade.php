@extends('layouts.app')
@section('title', 'Detalle del Plan Nutricional')
@section('content')
    <h1>{{ $plan->nombre }}</h1>
    <p><strong>Descripción:</strong> {{ $plan->descripcion }}</p>
    <p><strong>Calorías Diarias:</strong> {{ $plan->calorias_diarias }}</p>
    <p><strong>Recomendaciones:</strong> {{ $plan->recomendaciones }}</p>
    <a href="{{ route('planes.index') }}" class="btn btn-secondary">Volver a la lista</a>
@endsection
