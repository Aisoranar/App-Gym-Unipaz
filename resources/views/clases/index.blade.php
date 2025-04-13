@extends('layouts.app')
@section('title', 'Clases')
@section('content')

<style>
  :root {
    --primary: #0a192f;
    --secondary: #112240;
    --accent: #64ffda;
    --bg-dark: #020c1b;
    --white: #ccd6f6;
    --card-gradient-start: #112240;
    --card-gradient-end: #0a192f;
  }
  
  body {
    background: var(--bg-dark);
    color: var(--white);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
  }
  
  /* Header animado */
  .animated-bg {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    background-size: 200% 200%;
    animation: bgAnimation 8s ease infinite;
    padding: 2.5rem 1rem;
    text-align: center;
    border-bottom: 2px solid var(--accent);
    margin-bottom: 2rem;
  }
  
  @keyframes bgAnimation {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
  
  .header-index h1 {
    font-size: 2.8rem;
    margin-bottom: 0.5rem;
    color: var(--white);
    letter-spacing: 2px;
  }
  
  .header-index a {
    background-color: var(--accent);
    padding: 0.8rem 1.5rem;
    color: var(--bg-dark);
    text-decoration: none;
    border-radius: 30px;
    font-weight: bold;
    box-shadow: 0 4px 10px rgba(100, 255, 218, 0.3);
    transition: background-color 0.3s, transform 0.3s;
    display: inline-block;
  }
  
  .header-index a:hover {
    background-color: #52ffd3;
    transform: translateY(-3px);
  }
  
  /* Grid de tarjetas: 3 columnas fijas */
  .card-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    padding: 0 1rem;
  }
  
  /* Tarjeta estilo invitación */
  .card-item {
    background: linear-gradient(135deg, var(--card-gradient-start), var(--card-gradient-end));
    border-radius: 16px;
    padding: 1.5rem 1rem;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    border: 1px solid rgba(100, 255, 218, 0.3);
  }
  
  .card-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.7);
  }
  
  .card-item header {
    text-align: center;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid rgba(204, 214, 246, 0.2);
    margin-bottom: 1rem;
  }
  
  .card-item header h5 {
    margin: 0;
    font-size: 1.3rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--accent);
  }
  
  .clase-img-container {
    text-align: center;
    margin: 0 auto 1rem;
  }
  
  .clase-imagen {
    width: 110px;
    height: 70px;
    object-fit: cover;
    border: 2px solid var(--accent);
    border-radius: 8px;
  }
  
  .detalle {
    font-size: 0.85rem;
    line-height: 1.4;
    text-align: center;
    margin-bottom: 0.8rem;
  }
  
  .detalle p {
    margin: 0.3rem 0;
    color: var(--white);
  }
  
  .card-actions {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 0.8rem;
  }
  
  .btn-custom, .btn-danger {
    padding: 0.35rem 0.75rem;
    font-size: 0.75rem;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s;
    border-radius: 4px;
  }
  
  .btn-custom {
    background-color: var(--accent);
    color: var(--bg-dark);
  }
  
  .btn-custom:hover {
    background-color: #52ffd3;
    transform: translateY(-2px);
  }
  
  .btn-danger {
    background-color: #e63946;
    color: var(--white);
  }
  
  .btn-danger:hover {
    background-color: #d62828;
    transform: translateY(-2px);
  }
  
  /* Responsive: 2 columnas en tablets, 1 en móviles */
  @media (max-width: 768px) {
    .card-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }
  
  @media (max-width: 480px) {
    .card-grid {
      grid-template-columns: 1fr;
    }
  }
</style>

<div class="animated-bg header-index">
  <h1>Clases Grupales</h1>
  @if(in_array(auth()->user()->role, ['entrenador', 'superadmin']))
    <a href="{{ route('clases.create') }}">
      <i class="fa-solid fa-plus"></i> Crear Nueva Clase
    </a>
  @endif
</div>

<div class="container py-4">
  <div class="card-grid">
    @foreach($clases as $clase)
      <div class="card-item">
        <header>
          <h5>{{ $clase->titulo }}</h5>
        </header>
        <div class="clase-img-container">
          @if($clase->imagen)
            <img src="{{ asset('storage/' . $clase->imagen) }}" alt="{{ $clase->titulo }}" class="clase-imagen">
          @else
            <img src="{{ asset('images/default-clase.jpg') }}" alt="Imagen por defecto" class="clase-imagen">
          @endif
        </div>
        <div class="detalle">
          <p><strong>Fecha:</strong> {{ $clase->fecha }}</p>
          <p><strong>Inicio:</strong> {{ $clase->hora_inicio }}</p>
          @if($clase->nivel)
            <p><strong>Nivel:</strong> {{ $clase->nivel }}</p>
          @endif
          @if($clase->objetivos)
            <p><strong>Objetivos:</strong> {{ \Illuminate\Support\Str::limit($clase->objetivos, 50) }}</p>
          @endif
          @if($clase->max_participantes)
            <p><strong>Máx:</strong> {{ $clase->max_participantes }}</p>
          @endif
          <p>
            <strong>Estado:</strong> 
            <span style="color: {{ $clase->is_active ? 'green' : 'red' }}">
              {{ $clase->is_active ? 'Activa' : 'Inactiva' }}
            </span>
          </p>
        </div>
        <div class="card-actions">
          <a href="{{ route('clases.show', $clase) }}" class="btn-custom" title="Ver">
            <i class="fa-solid fa-eye"></i> Ver
          </a>
          @if(auth()->user()->role === 'usuario')
            @if($clase->participants->contains(auth()->user()->id))
              <form action="{{ route('clases.leave', $clase) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-danger" title="Salir">
                  <i class="fa-solid fa-right-from-bracket"></i> Salir
                </button>
              </form>
            @else
              <form action="{{ route('clases.join', $clase) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-custom" title="Unirse">
                  <i class="fa-solid fa-user-plus"></i> Unirse
                </button>
              </form>
            @endif
          @endif
          @if(in_array(auth()->user()->role, ['entrenador', 'superadmin']) && $clase->user_id == auth()->user()->id)
            <a href="{{ route('clases.edit', $clase) }}" class="btn-custom" title="Editar">
              <i class="fa-solid fa-pen-to-square"></i> Editar
            </a>
            <form action="{{ route('clases.destroy', $clase) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar esta clase?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn-danger" title="Eliminar">
                <i class="fa-solid fa-trash"></i> Eliminar
              </button>
            </form>
          @endif
        </div>
      </div>
    @endforeach
  </div>
</div>

@endsection
