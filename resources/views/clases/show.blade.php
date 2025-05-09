@extends('layouts.app')
@section('title', 'Detalle de la Clase')
@section('content')
<!-- Estilos globales y personalizados -->
<style>
  :root {
    --primary: #001f3f;
    --secondary: #013220;
    --white: #ffffff;
  }
  body {
    background: var(--white);
    color: var(--primary);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  /* Encabezado con gradiente animado */
  .animated-bg {
    background: linear-gradient(45deg, var(--primary), var(--secondary));
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
    padding: 2rem 0;
    text-align: center;
  }
  @keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
  .header-show h1 {
    font-size: 2.5rem;
    font-weight: bold;
    color: var(--white);
    text-shadow: 0 0 10px rgba(0,0,0,0.3);
  }
  /* Tarjeta principal */
  .clase-card {
    background: var(--white);
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    max-width: 800px;
    margin: 2rem auto;
  }
  .clase-card img { width: 100%; max-height: 300px; object-fit: cover; border-radius: 0.5rem; margin-bottom: 1.5rem; }
  .clase-info p { margin-bottom: 0.8rem; font-size: 1.1rem; }
  .lista-participantes {
    margin-top: 1.5rem;
    border-left: 4px solid var(--primary);
    border-radius: 0.5rem;
    padding: 1rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    background: var(--white);
  }
  .lista-participantes h4 { margin-bottom: 0.5rem; color: var(--primary); }
  .actions { margin-top: 2rem; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
  .btn-primary, .btn-secondary {
    padding: 0.7rem 1.5rem;
    border-radius: 0.5rem;
    border: none;
    color: var(--white);
    transition: transform 0.3s, box-shadow 0.3s;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    font-weight: bold;
  }
  .btn-primary { background: var(--primary); }
  .btn-primary:hover { transform: scale(1.05); box-shadow: 0 6px 15px rgba(0,0,0,0.15); }
  .btn-secondary { background: var(--secondary); }
  .btn-secondary:hover { transform: scale(1.05); box-shadow: 0 6px 15px rgba(0,0,0,0.15); }
</style>

<!-- Encabezado con fondo animado -->
<div class="container-fluid animated-bg">
  <div class="container header-show">
    <h1>Detalle de la Clase</h1>
  </div>
</div>

<!-- Contenido principal -->
<div class="clase-card">
    @if($clase->imagen)
      <img src="{{ asset('storage/' . $clase->imagen) }}" alt="Imagen de {{ $clase->titulo }}">
    @endif

    <div class="clase-info">
        <h2 class="mb-4">{{ $clase->titulo }}</h2>
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
            <p><strong>Inscritos:</strong> {{ $clase->participants->count() }} / {{ $clase->max_participantes }}</p>
        @else
            <p><strong>Inscritos:</strong> {{ $clase->participants->count() }}</p>
        @endif
        <p><strong>Entrenador:</strong> {{ $clase->user ? $clase->user->name : 'No asignado' }}</p>
        <p><strong>Estado:</strong> <span class=\"text-{{ $clase->is_active ? 'success' : 'danger' }}\">{{ $clase->is_active ? 'Activa' : 'Inactiva' }}</span></p>
    </div>

    <div class="lista-participantes">
        <h4>Participantes Inscritos:</h4>
        @if($clase->participants->isNotEmpty())
            <ul>
                @foreach($clase->participants as $participant)
                    <li>{{ $participant->name }}</li>
                @endforeach
            </ul>
        @else
            <p>No hay participantes inscritos.</p>
        @endif
    </div>

    <div class="actions">
        @if(auth()->user()->role === 'usuario')
            @if($clase->participants->contains(auth()->user()->id))
                <form method="POST" action="{{ route('clases.leave', $clase) }}">
                    @csrf
                    <button type="submit" class="btn-primary">Salir de la Clase</button>
                </form>
            @else
                <form method="POST" action="{{ route('clases.join', $clase) }}">
                    @csrf
                    <button type="submit" class="btn-primary">Unirse a la Clase</button>
                </form>
            @endif
        @endif

        @if(in_array(auth()->user()->role, ['entrenador', 'superadmin']))
            <div class="d-flex gap-2">
                <a href="{{ route('clases.edit', $clase) }}" class="btn-secondary">Editar Clase</a>
                <form method="POST" action="{{ route('clases.destroy', $clase) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-secondary" onclick="return confirm('¿Seguro que quieres eliminar esta clase?')">Eliminar Clase</button>
                </form>
            </div>
        @endif
    </div>
</div>

<!-- Botón Volver -->
<div class="container text-center mb-5">
  <a href="{{ route('clases.index') }}" class="btn-secondary">&larr; Volver a Clases</a>
</div>
@endsection
