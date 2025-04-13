@extends('layouts.app')
@section('title', 'Fichas Médicas')
@section('content')

<!-- Estilos personalizados para el index dinámico -->
<style>
  /* Estilos para las tarjetas de ficha */
  .card-ficha {
    border: none;
    border-radius: 0.75rem;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    margin-bottom: 1.5rem;
    transition: transform 0.2s, box-shadow 0.2s;
  }
  .card-ficha:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
  }
  .card-ficha .card-header {
    background-color: #0d6efd;
    color: #fff;
    font-size: 1.1rem;
    text-align: center;
    padding: 1rem 1.5rem;
    border-top-left-radius: 0.75rem;
    border-top-right-radius: 0.75rem;
  }
  .card-ficha .card-body {
    padding: 1rem 1.5rem;
    font-size: 0.9rem;
  }
  .card-ficha .detail-item {
    margin-bottom: 0.5rem;
  }
  .card-ficha .detail-item i {
    margin-right: 0.5rem;
    color: #0d6efd;
  }
  .card-ficha .card-footer {
    background-color: #f8f9fa;
    padding: 0.75rem;
    border-bottom-left-radius: 0.75rem;
    border-bottom-right-radius: 0.75rem;
  }
  .action-btns a,
  .action-btns form {
    display: inline-block;
    margin-right: 0.25rem;
  }
  /* Botón para crear ficha */
  .btn-create {
    background-color: #fff;
    border: 2px solid #0d6efd;
    color: #0d6efd;
    transition: background-color 0.2s, color 0.2s;
  }
  .btn-create:hover {
    background-color: #0d6efd;
    color: #fff;
  }
</style>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="text-primary fw-bold">
      <i class="fa-solid fa-file-medical"></i> Fichas Médicas
    </h1>
    <a href="{{ route('fichas.create') }}" class="btn btn-create px-4">
      <i class="fa-solid fa-plus"></i> Crear Nueva Ficha
    </a>
  </div>

  <div class="row">
    @foreach($fichas as $ficha)
      <div class="col-md-6 col-lg-4">
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
          <div class="card-footer text-center">
            <div class="action-btns">
              <a href="{{ route('fichas.show', $ficha) }}" class="btn btn-info btn-sm" title="Ver">
                <i class="fa-solid fa-eye"></i>
              </a>
              <a href="{{ route('fichas.edit', $ficha) }}" class="btn btn-warning btn-sm" title="Editar">
                <i class="fa-solid fa-edit"></i>
              </a>
              <form action="{{ route('fichas.destroy', $ficha) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('¿Está seguro de eliminar esta ficha?');" class="btn btn-danger btn-sm" title="Eliminar">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

@endsection
