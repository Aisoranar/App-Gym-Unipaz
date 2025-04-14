@extends('layouts.app')
@section('title', 'Fichas Médicas')
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
  }
  .header-index h1 {
    font-weight: bold;
    font-size: 2.5rem;
  }
  .btn-create {
    background-color: var(--white);
    border: 2px solid var(--primary);
    color: var(--primary);
    transition: background-color 0.2s, color 0.2s;
  }
  .btn-create:hover {
    background-color: var(--primary);
    color: var(--white);
  }
  .card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
  }
  .card-ficha {
    border: none;
    border-radius: 0.75rem;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s, box-shadow 0.2s;
    background: var(--primary);
  }
  .card-ficha:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
    background: var(--secondary);
  }
  .card-ficha .card-header {
    background-color: var(--secondary);
    color: var(--white);
    font-size: 1.1rem;
    text-align: center;
    padding: 1rem;
    border-top-left-radius: 0.75rem;
    border-top-right-radius: 0.75rem;
  }
  .card-ficha .card-body {
    padding: 1rem;
    font-size: 0.9rem;
    color: #d1d1d1;
  }
  .detail-item {
    margin-bottom: 0.5rem;
  }
  .detail-item i {
    margin-right: 0.5rem;
    color: var(--white);
  }
  .card-ficha .card-footer {
    background-color: var(--bg-dark);
    padding: 0.75rem;
    border-bottom-left-radius: 0.75rem;
    border-bottom-right-radius: 0.75rem;
    text-align: center;
  }
  .action-btns {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
  }
  .action-btns a,
  .action-btns form {
    display: inline-block;
  }
</style>

<div class="animated-bg header-index">
  <h1>
    <i class="fa-solid fa-file-medical"></i> Fichas Médicas
  </h1>
  <a href="{{ route('fichas.create') }}" class="btn btn-create px-4 mt-3">
    <i class="fa-solid fa-plus"></i> Crear Nueva Ficha
  </a>
</div>

<div class="container py-4">
  <div class="card-grid">
    @foreach($fichas as $ficha)
      <div class="card card-ficha">
        <div class="card-header">
          <i class="fa-solid fa-user"></i> {{ $ficha->nombre }} {{ $ficha->apellidos }}
        </div>
        <div class="card-body">
          <div class="detail-item">
            <i class="fa-solid fa-calendar-check"></i>
            <strong>Fecha Nac.:</strong> {{ $ficha->fecha_nacimiento }}
          </div>
          <div class="detail-item">
            <i class="fa-solid fa-hourglass-half"></i>
            <strong>Edad:</strong> {{ $ficha->edad }}
          </div>
          <div class="detail-item">
            <i class="fa-solid fa-venus-mars"></i>
            <strong>Sexo:</strong> {{ $ficha->sexo }}
          </div>
          <div class="detail-item">
            <i class="fa-solid fa-house"></i>
            <strong>Domicilio:</strong> {{ $ficha->domicilio }}
          </div>
        </div>
        <div class="card-footer">
          <div class="action-btns">
            <a href="{{ route('fichas.show', $ficha) }}" class="btn btn-info btn-sm" title="Ver">
              <i class="fa-solid fa-eye"></i>
            </a>
            <a href="{{ route('fichas.edit', $ficha) }}" class="btn btn-warning btn-sm" title="Editar">
              <i class="fa-solid fa-edit"></i>
            </a>
            <form action="{{ route('fichas.destroy', $ficha) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar esta ficha?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                <i class="fa-solid fa-trash"></i>
              </button>
            </form>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

@endsection
