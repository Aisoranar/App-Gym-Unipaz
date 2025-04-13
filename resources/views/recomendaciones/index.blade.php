@extends('layouts.app')
@section('title', 'Recomendaciones')
@section('content')

<style>
  :root {
    --primary: #001f3f;
    --secondary: #013220;
    --bg-dark: #000814;
    --white: #ffffff;
  }
  body {
    background: var(--bg-dark);
    color: var(--white);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
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
  .header-index {
    padding: 2rem 0;
    text-align: center;
    position: relative;
  }
  .header-index h1 {
    font-weight: bold;
    font-size: 2.5rem;
  }
  .card-item {
    background: var(--primary);
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    margin-bottom: 1.5rem;
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
    min-height: 60px;
  }
  .card-actions {
    margin-top: 1rem;
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
  .no-recommendations {
    text-align: center;
    padding: 2rem;
    font-size: 1.2rem;
    color: #d1d1d1;
  }
  /* Estilo para el formulario de búsqueda */
  .search-form {
    margin: 1rem 0 2rem;
  }
  .search-form .form-control {
    border-radius: 0;
    border: 1px solid var(--secondary);
  }
  .search-form .btn-custom {
    border-radius: 0;
  }
</style>

<div class="animated-bg header-index">
  <h1>Recomendaciones</h1>
  @if(in_array(Auth::user()->role, ['entrenador', 'superadmin']))
    <a href="{{ route('recomendaciones.create') }}" class="btn btn-custom mt-3">
      <i class="fa-solid fa-plus"></i> Crear Nueva Recomendación
    </a>
  @endif
</div>

<div class="container py-4">
  <!-- Formulario de búsqueda -->
  <form method="GET" action="{{ route('recomendaciones.index') }}" class="search-form">
    <div class="input-group">
      <input type="text" name="search" class="form-control" placeholder="Buscar por usuario..." value="{{ $search }}">
      <button class="btn btn-custom" type="submit">
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
            <!-- Información del destinatario -->
            <p><strong>Para:</strong> {{ $recomendacion->user->name }} ({{ $recomendacion->user->email }})</p>
            <div class="card-actions">
              <a href="{{ route('recomendaciones.show', $recomendacion) }}" class="btn btn-custom btn-sm" title="Ver">
                <i class="fa-solid fa-eye"></i> Ver
              </a>
              @if(in_array(Auth::user()->role, ['entrenador', 'superadmin']) && (Auth::user()->role === 'superadmin' || Auth::id() == $recomendacion->creado_por))
                <a href="{{ route('recomendaciones.edit', $recomendacion) }}" class="btn btn-custom btn-sm" title="Editar">
                  <i class="fa-solid fa-pen-to-square"></i> Editar
                </a>
                <form action="{{ route('recomendaciones.destroy', $recomendacion) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar esta recomendación?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                    <i class="fa-solid fa-trash"></i> Eliminar
                  </button>
                </form>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    <div class="no-recommendations">
      No tienes recomendaciones todavía.
    </div>
  @endif
</div>

@endsection
