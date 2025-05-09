@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="fas fa-info-circle"></i> Detalle del registro de peso</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row gy-3">
                <div class="col-6 col-md-4">
                    <strong><i class="fas fa-calendar-alt"></i> Fecha:</strong><br>
                    {{ $entrada->fecha->format('d/m/Y') }}
                </div>
                <div class="col-6 col-md-4">
                    <strong><i class="fas fa-weight-hanging"></i> Peso Actual:</strong><br>
                    {{ $entrada->peso_actual_kg }} kg
                </div>
                <div class="col-6 col-md-4">
                    <strong><i class="fas fa-bullseye"></i> Peso Ideal:</strong><br>
                    {{ $entrada->peso_ideal_kg ? $entrada->peso_ideal_kg . ' kg' : '-' }}
                </div>
                <div class="col-6 col-md-4">
                    <strong><i class="fas fa-ruler-vertical"></i> Altura:</strong><br>
                    {{ $entrada->altura_cm }} cm
                </div>
                <div class="col-6 col-md-4">
                    <strong><i class="fas fa-heartbeat"></i> IMC:</strong><br>
                    {{ $entrada->imc }}
                </div>
                <div class="col-6 col-md-4">
                    <strong><i class="fas fa-clipboard-list"></i> Estado:</strong><br>
                    <span class="badge 
                        {{ $entrada->estado_peso == 'Normal' ? 'bg-success' : 
                           ($entrada->estado_peso == 'Bajo peso' ? 'bg-info' : 
                           ($entrada->estado_peso == 'Sobrepeso' ? 'bg-warning text-dark' : 'bg-danger')) }}">
                        {{ $entrada->estado_peso }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('entradas-peso.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <a href="{{ route('entradas-peso.edit', $entrada) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Editar
        </a>
    </div>
</div>
@endsection
