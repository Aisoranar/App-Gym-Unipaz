@extends('layouts.app')
@section('title', 'Recomendaciones')
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
  /* Formulario de búsqueda */
  .search-form {
    margin: 1rem 0 2rem;
  }
  .search-form .form-control {
    border-radius: 0;
    border: 1px solid var(--secondary);
  }
  .search-form .btn-custom {
    border-radius: 0;
    background-color: var(--secondary);
    color: var(--white);
    border: none;
    transition: background 0.3s;
  }
  .search-form .btn-custom:hover {
    background-color: #026c3b;
  }
  /* Tarjetas de recomendación */
  .card-item {
    background: var(--white);
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin-bottom: 1.5rem;
    transition: transform 0.3s, box-shadow 0.3s;
    color: var(--primary);
  }
  .card-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
  }
  .card-item h5 {
    font-size: 1.2rem;
    font-weight: bold;
    margin-bottom: 1rem;
    text-transform: uppercase;
  }
  .card-item p, .no-recommendations {
    color: var(--primary);
    font-size: 0.95rem;
  }
  .card-actions {
    margin-top: 1rem;
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

<!-- Encabezado -->
<div class="container-fluid animated-bg header-index">
  <h1>Recomendaciones</h1>
  @if(in_array(Auth::user()->role, ['entrenador', 'superadmin']))
    <a href="{{ route('recomendaciones.create') }}" class="btn-custom">
      <i class="fa-solid fa-plus"></i> Crear Nueva Recomendación
    </a>
  @endif
</div>

<div class="container py-4">
  <!-- Formulario de búsqueda -->
  <form method="GET" action="{{ route('recomendaciones.index') }}" class="search-form">
    <div class="input-group">
      <input type="text" name="search" class="form-control" placeholder="Buscar por usuario..." value="{{ $search }}">
      <button class="btn-custom" type="submit">
        <i class="fa-solid fa-search"></i> Buscar
      </button>
    </div>
  </form>

  @if($recomendaciones->count())
    <div class="row">
      @foreach($recomendaciones as $recomendacion)
        <div class="col-12 col-md-6 col-lg-4">
          <div class="card-item">
            <h5>Recomendación</h5>
            <p>{{ Str::limit($recomendacion->contenido, 100) }}</p>
            <p><strong>Para:</strong> {{ $recomendacion->user->name }} ({{ $recomendacion->user->email }})</p>
            <div class="card-actions">
              <a href="{{ route('recomendaciones.show', $recomendacion) }}" class="btn-custom-sm btn-sm">
                <i class="fa-solid fa-eye"></i>
              </a>
              @if(in_array(Auth::user()->role, ['entrenador', 'superadmin']) && (Auth::user()->role === 'superadmin' || Auth::id() == $recomendacion->creado_por))
                <a href="{{ route('recomendaciones.edit', $recomendacion) }}" class="btn-custom-sm btn-sm">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <form action="{{ route('recomendaciones.destroy', $recomendacion) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar esta recomendación?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-danger-sm btn-sm">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </form>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    <div class="no-recommendations text-center py-5">
      No tienes recomendaciones todavía.
    </div>
  @endif
</div>

@endsection
