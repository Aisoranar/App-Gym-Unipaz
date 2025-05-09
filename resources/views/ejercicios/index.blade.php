@extends('layouts.app')
@section('title', 'Ejercicios')
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
  /* Fondo animado sutil solo en el header */
  .animated-bg {
    background: linear-gradient(45deg, var(--primary), var(--secondary));
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
  }
  @keyframes gradientBG {
    0% {background-position: 0% 50%;}
    50% {background-position: 100% 50%;}
    100% {background-position: 0% 50%;}
  }
  /* Encabezado */
  .header-index {
    padding: 2rem 0;
    text-align: center;
    position: relative;
    overflow: hidden;
  }
  .header-index h1 {
    font-size: 3rem;
    font-weight: bold;
    color: var(--white); /* Título en blanco */
    text-shadow: 0 0 10px var(--primary);
  }
  .header-index a.btn {
    font-size: 1.1rem;
    padding: 0.75rem 1.5rem;
    transition: transform 0.3s, box-shadow 0.3s;
  }
  .header-index a.btn:hover {
    transform: scale(1.05);
  }
  /* Tarjetas de ejercicio con fondo blanco y sombra */
  .card-exercise {
    background: var(--white);
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    overflow: hidden;
    position: relative;
    padding: 1.5rem;
    color: var(--primary);
  }
  .card-exercise:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  }
  .card-exercise .card-body {
    position: relative;
    z-index: 2;
  }
  /* Botones de acción */
  .action-btn {
    transition: transform 0.3s, box-shadow 0.3s;
    margin: 0 0.25rem;
  }
  .action-btn:hover {
    transform: scale(1.1);
  }
</style>

<!-- Encabezado con fondo animado -->
<div class="container-fluid animated-bg">
  <div class="container header-index">
    <h1>Ejercicios</h1>
    <!-- Solo los entrenadores y superadmin tienen acceso a crear ejercicio -->
    @if(Auth::user()->role === 'entrenador' || Auth::user()->role === 'superadmin')
      <a href="{{ route('ejercicios.create') }}" class="btn btn-primary mt-3">
        <i class="fa-solid fa-plus"></i> Registrar Nuevo Ejercicio
      </a>
    @endif
  </div>
</div>

<!-- Listado en formato tarjetas -->
<div class="container py-4">
  <div class="row g-4">
    @foreach($ejercicios as $ejercicio)
      <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="card-exercise h-100">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title text-uppercase fw-bold">
              {{ $ejercicio->nombre_ejercicio }}
            </h5>
            <p class="card-text mb-1">
              <i class="fa-solid fa-calendar"></i>
              <strong>Fecha:</strong> {{ $ejercicio->fecha }}
            </p>
            <p class="card-text mb-1">
              <i class="fa-solid fa-chart-line"></i>
              <strong>Series:</strong> {{ $ejercicio->series }}
            </p>
            <p class="card-text mb-3">
              <i class="fa-solid fa-repeat"></i>
              <strong>Repeticiones:</strong> {{ $ejercicio->repeticiones }}
            </p>
            <div class="mt-auto d-flex justify-content-center">
              <a href="{{ route('ejercicios.show', $ejercicio) }}" class="btn btn-info btn-sm action-btn" title="Ver">
                <i class="fa-solid fa-eye"></i>
              </a>
              @if(Auth::user()->role === 'entrenador' || Auth::user()->role === 'superadmin')
                <a href="{{ route('ejercicios.edit', $ejercicio) }}" class="btn btn-warning btn-sm action-btn" title="Editar">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <form action="{{ route('ejercicios.destroy', $ejercicio) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este ejercicio?');" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm action-btn" title="Eliminar">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </form>
              @endif
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
