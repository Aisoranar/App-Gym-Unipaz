@extends('layouts.app')
@section('title', 'Planes Nutricionales')
@section('content')

<!-- Estilos personalizados con fondo blanco y tarjetas destacadas -->
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
  .header-index h1 {
    font-weight: bold;
    font-size: 2.5rem;
    color: var(--white);
    text-shadow: 0 0 5px rgba(0,0,0,0.3);
  }
  .header-index a.btn-custom {
    background-color: var(--secondary);
    color: var(--white);
    border: none;
    padding: 0.5rem 1rem;
    margin-top: 1rem;
    transition: transform 0.3s, box-shadow 0.3s;
  }
  .header-index a.btn-custom:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
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
    background: var(--white);
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    color: var(--primary);
  }
  .card-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  }
  .card-item h5 {
    font-size: 1.2rem;
    font-weight: bold;
    margin-bottom: 1rem;
    text-transform: uppercase;
  }
  .card-item p {
    font-size: 0.95rem;
    margin-bottom: 1rem;
  }
  /* Acciones de los botones */
  .card-actions {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
  }
  .btn-custom-sm {
    background-color: var(--secondary);
    color: var(--white);
    border: none;
    padding: 0.5rem 1rem;
    transition: transform 0.3s;
  }
  .btn-custom-sm:hover {
    transform: scale(1.05);
  }
  .btn-danger-sm {
    background-color: #dc3545;
    color: var(--white);
    border: none;
    padding: 0.5rem 1rem;
    transition: transform 0.3s;
  }
  .btn-danger-sm:hover {
    transform: scale(1.05);
  }
</style>

<!-- Encabezado con fondo animado -->
<div class="container-fluid animated-bg header-index">
  <h1>Planes Nutricionales</h1>
  <a href="{{ route('planes.create') }}" class="btn-custom btn-custom-sm">
    <i class="fa-solid fa-plus"></i> Crear Nuevo Plan
  </a>
</div>

<!-- Contenedor organizado en columnas -->
<div class="container py-4">
  <div class="card-grid">
    @foreach($planes as $plan)
      <div class="card-item">
        <h5>{{ $plan->nombre }}</h5>
        <p><strong>Calorías Diarias:</strong> {{ $plan->calorias_diarias }}</p>
        <div class="card-actions">
          <a href="{{ route('planes.show', $plan) }}" class="btn-custom-sm btn-sm">
            <i class="fa-solid fa-eye"></i>
          </a>
          <a href="{{ route('planes.edit', $plan) }}" class="btn-custom-sm btn-sm">
            <i class="fa-solid fa-pen-to-square"></i>
          </a>
          <form action="{{ route('planes.destroy', $plan) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar este plan?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger-sm btn-sm">
              <i class="fa-solid fa-trash"></i>
            </button>
          </form>
        </div>
      </div>
    @endforeach
  </div>
</div>

@endsection
