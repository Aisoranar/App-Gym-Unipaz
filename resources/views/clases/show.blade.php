@extends('layouts.app')
@section('title', 'Detalle de la Clase')
@section('content')

<style>
  .clase-card {
    background: linear-gradient(135deg, #0a192f, #112240);
    border-radius: 1.5rem;
    padding: 2rem;
    color: #ccd6f6;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
    max-width: 800px;
    margin: 2rem auto;
    position: relative;
  }

  .clase-card img {
    width: 100%;
    max-height: 300px;
    object-fit: cover;
    border-radius: 1rem;
    margin-bottom: 1.5rem;
  }

  .clase-info p {
    margin-bottom: 0.8rem;
    font-size: 1.1rem;
  }

  .actions {
    margin-top: 2rem;
    display: flex;
    justify-content: space-between;
    gap: 1rem;
  }

  .btn-custom {
    background-color: #64ffda;
    color: #0a192f;
    font-weight: bold;
    padding: 0.7rem 1.5rem;
    border-radius: 1rem;
    text-decoration: none;
    transition: background 0.3s;
  }

  .btn-custom:hover {
    background-color: #52e0c4;
  }
</style>

<div class="clase-card">
    @if($clase->imagen)
    <img src="{{ asset('storage/' . $clase->imagen) }}" alt="Imagen de {{ $clase->titulo }}">
    @endif

    <div class="clase-info">
        <h1 class="mb-4">{{ $clase->titulo }}</h1>

        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($clase->fecha)->format('d/m/Y') }}</p>

        <p><strong>Hora de Inicio:</strong> {{ \Carbon\Carbon::parse($clase->hora_inicio)->format('h:i A') }}</p>

        @if($clase->hora_fin)
            <p><strong>Hora de Fin:</strong> {{ \Carbon\Carbon::parse($clase->hora_fin)->format('h:i A') }}</p>
        @endif

        <p><strong>Descripción:</strong> {{ $clase->descripcion }}</p>

        @if($clase->objetivos)
            <p><strong>Objetivos:</strong> {{ $clase->objetivos }}</p>
        @endif

        @if($clase->nivel)
            <p><strong>Nivel:</strong> {{ ucfirst($clase->nivel) }}</p>
        @endif

        @if($clase->max_participantes)
            <p><strong>Máximo de Participantes:</strong> {{ $clase->max_participantes }}</p>
        @endif

        <p><strong>Entrenador:</strong> {{ $clase->user ? $clase->user->name : 'No asignado' }}</p>

        <p><strong>Estado:</strong> 
            @if($clase->is_active)
                <span class="text-success">Activa</span>
            @else
                <span class="text-danger">Inactiva</span>
            @endif
        </p>
    </div>

    <div class="actions">
        {{-- Opciones para usuario: unirse o salirse --}}
        @if(auth()->user()->role === 'usuario')
            @if($clase->participants->contains(auth()->user()->id))
                <form method="POST" action="{{ route('clases.leave', $clase) }}">
                    @csrf
                    <button type="submit" class="btn-custom">Salir de la Clase</button>
                </form>
            @else
                <form method="POST" action="{{ route('clases.join', $clase) }}">
                    @csrf
                    <button type="submit" class="btn-custom">Unirse a la Clase</button>
                </form>
            @endif
        @endif

        {{-- Opciones para el creador o superadmin: editar y eliminar --}}
        @if(auth()->id() === $clase->user_id || auth()->user()->role === 'superadmin')
            <div class="d-flex gap-2">
                <a href="{{ route('clases.edit', $clase) }}" class="btn-custom">Editar Clase</a>

                <form method="POST" action="{{ route('clases.destroy', $clase) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-custom" onclick="return confirm('¿Seguro que quieres eliminar esta clase?')">Eliminar Clase</button>
                </form>
            </div>
        @endif
    </div>
</div>

@endsection
