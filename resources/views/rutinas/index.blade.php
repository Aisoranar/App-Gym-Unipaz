@extends('layouts.app')
@section('title', 'Rutinas')
@section('content')

<style>
  :root {
    --primary: #001f3f;   /* Azul oscuro */
    --secondary: #013220; /* Verde oscuro */
    --bg-dark: #000814;   /* Fondo muy oscuro */
    --white: #ffffff;
  }
  body {
    background: var(--bg-dark);
    color: var(--white);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  /* Fondo animado */
  .animated-bg {
    background: linear-gradient(45deg, var(--primary), var(--secondary));
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
  }
  @keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
  /* Encabezado */
  .header-index {
    padding: 2rem 0;
    text-align: center;
    position: relative;
  }
  .header-index h1 {
    font-weight: bold;
    font-size: 2.5rem;
  }
  /* Grilla para las tarjetas */
  .card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
  }
  /* Tarjeta individual */
  .card-item {
    background: var(--primary);
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    transition: transform 0.3s, background 0.3s;
  }
  .card-item:hover {
    transform: translateY(-10px);
    background: var(--secondary);
  }
  .card-item h5 {
    font-size: 1.2rem;
    font-weight: bold;
    margin-bottom: 1rem;
    text-transform: uppercase;
  }
  .card-item p {
    color: #d1d1d1;
    font-size: 0.95rem;
    margin-bottom: 1rem;
  }
  /* Acciones de los botones */
  .card-actions {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
  }
  .btn-custom {
    background-color: var(--secondary);
    color: var(--white);
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 0;
    transition: background 0.3s;
  }
  .btn-custom:hover {
    background-color: #026c3b;
  }
  .btn-danger {
    padding: 0.5rem 1rem;
    border-radius: 0;
  }
</style>

<!-- Encabezado con fondo animado -->
<div class="animated-bg header-index">
  <h1>Rutinas</h1>
  <a href="{{ route('rutinas.create') }}" class="btn btn-custom mt-3">
    <i class="fa-solid fa-plus"></i> Crear Nueva Rutina
  </a>
</div>

<!-- Contenedor organizado en columnas -->
<div class="container py-4">
  <div class="card-grid">
    @foreach($rutinas as $rutina)
      <div class="card-item">
        <h5>{{ $rutina->nombre }}</h5>
        <p><strong>Días por Semana:</strong> {{ $rutina->dias_por_semana }}</p>
        <div class="card-actions">
          <a href="{{ route('rutinas.show', $rutina) }}" class="btn btn-custom btn-sm" title="Ver">
            <i class="fa-solid fa-eye"></i> Ver
          </a>
          <a href="{{ route('rutinas.edit', $rutina) }}" class="btn btn-custom btn-sm" title="Editar">
            <i class="fa-solid fa-pen-to-square"></i> Editar
          </a>
          <form action="{{ route('rutinas.destroy', $rutina) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar esta rutina?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
              <i class="fa-solid fa-trash"></i> Eliminar
            </button>
          </form>
        </div>
      </div>
    @endforeach
  </div>
</div>

@endsection
