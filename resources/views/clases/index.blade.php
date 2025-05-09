@extends('layouts.app')
@section('title', 'Clases Grupales')
@section('content')
<!-- Estilos globales y personalizados -->
<style>
  :root {
    --primary: #001f3f;   /* Azul oscuro */
    --secondary: #013220; /* Verde oscuro */
    --white: #ffffff;
  }
  body {
    background: var(--white);
    color: var(--primary);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  /* Gradiente animado en el encabezado */
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
  .header-index h1 {
    font-size: 2.5rem;
    font-weight: bold;
    color: var(--white);
    text-shadow: 0 0 10px rgba(0,0,0,0.3);
  }
  .header-index a.btn-primary {
    background: var(--primary);
    color: var(--white);
    border: none;
    border-radius: 2rem;
    padding: 0.75rem 1.5rem;
    margin-top: 1rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    transition: transform 0.3s, box-shadow 0.3s;
  }
  .header-index a.btn-primary:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
  }
  /* Grilla de tarjetas fija 3x y alineada a la izquierda */
  .card-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin-top: 2rem;
    padding: 0;
    justify-items: start;
  }
  /* Tarjeta de clase */
  .card-item {
    background: var(--white);
    border-radius: 1rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    overflow: hidden;
    color: var(--primary);
    display: flex;
    flex-direction: column;
  }
  .card-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  }
  .card-item header {
    background: linear-gradient(45deg, var(--primary), var(--secondary));
    padding: 1rem;
    text-align: center;
  }
  .card-item header h5 {
    margin: 0;
    font-size: 1.3rem;
    color: var(--white);
    text-shadow: 0 0 5px rgba(0,0,0,0.3);
  }
  .clase-img-container {
    text-align: center;
    margin: 1rem 0;
  }
  .clase-imagen {
    width: 100px;
    height: 70px;
    object-fit: cover;
    border: 2px solid var(--primary);
    border-radius: 0.5rem;
  }
  .detalle {
    flex-grow: 1;
    padding: 0 1rem;
  }
  .detalle p {
    margin: 0.5rem 0;
  }
  .card-actions {
    padding: 1rem;
    display: flex;
    justify-content: flex-start;
    gap: 0.5rem;
  }
  .btn-info, .btn-warning, .btn-danger {
    padding: 0.5rem;
    border-radius: 0.5rem;
    transition: transform 0.3s;
  }
  .btn-info { background: var(--secondary); color: var(--white); border: none; }
  .btn-warning { background: #ffc107; color: var(--primary); border: none; }
  .btn-danger { background: #dc3545; color: var(--white); border: none; }
  .btn-info:hover, .btn-warning:hover, .btn-danger:hover {
    transform: scale(1.1);
  }
</style>

<!-- Encabezado con fondo animado -->
<div class="container-fluid animated-bg header-index">
  <h1>Clases Grupales</h1>
  @if(in_array(auth()->user()->role, ['entrenador', 'superadmin']))
    <a href="{{ route('clases.create') }}" class="btn-primary">
      <i class="fa-solid fa-plus"></i> Crear Nueva Clase
    </a>
  @endif
</div>

<!-- Listado de clases -->
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
            <p><strong>Inscritos:</strong> {{ $clase->participants->count() }} / {{ $clase->max_participantes }}</p>
          @else
            <p><strong>Inscritos:</strong> {{ $clase->participants->count() }}</p>
          @endif
          <p><strong>Estado:</strong>
            <span style="color: {{ $clase->is_active ? 'green' : 'red' }}">
              {{ $clase->is_active ? 'Activa' : 'Inactiva' }}
            </span>
          </p>
        </div>
        <div class="card-actions">
          <a href="{{ route('clases.show', $clase) }}" class="btn-info" title="Ver">
            <i class="fa-solid fa-eye"></i>
          </a>
          @if(in_array(auth()->user()->role, ['entrenador', 'superadmin']))
            <a href="{{ route('clases.edit', $clase) }}" class="btn-warning" title="Editar">
              <i class="fa-solid fa-pen-to-square"></i>
            </a>
            <form action="{{ route('clases.destroy', $clase) }}" method="POST" onsubmit="return confirm('¿Confirma eliminar esta clase?');" style="display:inline;">
              @csrf @method('DELETE')
              <button type="submit" class="btn-danger" title="Eliminar">
                <i class="fa-solid fa-trash"></i>
              </button>
            </form>
          @endif
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
