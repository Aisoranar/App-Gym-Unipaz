@extends('layouts.app')
@section('title', 'Historial de Clases')
@section('content')
<!-- Estilos globales y personalizados -->
<style>
  :root {
    --primary: #001f3f;
    --secondary: #013220;
    --white: #ffffff;
    --shadow: rgba(0, 0, 0, 0.1);
  }
  body {
    background: var(--white);
    color: var(--primary);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  /* Encabezado animado */
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
  .header-hist h1 {
    font-size: 2.5rem;
    color: var(--white);
    text-shadow: 0 0 10px rgba(0,0,0,0.3);
  }
  .historial-container {
    background: var(--white);
    border-radius: 1rem;
    box-shadow: 0 4px 15px var(--shadow);
    padding: 2rem;
    margin: 2rem auto;
    max-width: 900px;
  }
  .historial-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 1.5rem;
  }
  .historial-table thead {
    background: var(--primary);
  }
  .historial-table thead th {
    color: var(--white);
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 1rem;
  }
  .historial-table th,
  .historial-table td {
    padding: 0.75rem;
    border: 1px solid rgba(0,0,0,0.05);
    text-align: center;
  }
  .estado-activa { color: green; font-weight: bold; }
  .estado-inactiva { color: red; font-weight: bold; }
  /* Nombre de la clase destacado en secondary */
  .clase-link {
    color: var(--secondary);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s;
  }
  .clase-link:hover { color: var(--primary); text-decoration: underline; }
  .no-data { text-align: center; font-size: 1.1rem; color: rgba(0,0,0,0.4); }
  .btn-secondary {
    background: var(--secondary);
    color: var(--white);
    border: none;
    border-radius: 0.5rem;
    padding: 0.7rem 1.5rem;
    box-shadow: 0 4px 10px var(--shadow);
    transition: transform 0.3s;
    font-weight: bold;
  }
  .btn-secondary:hover { transform: scale(1.05); box-shadow: 0 6px 15px var(--shadow); }
  /* Mobile: cada fila como tarjeta */
  @media (max-width: 768px) {
    .historial-container {
      padding: 1rem;
    }
    .historial-table, .historial-table thead, .historial-table tbody, .historial-table th, .historial-table td, .historial-table tr {
      display: block;
      width: 100%;
    }
    .historial-table thead tr { display: none; }
    .historial-table tbody tr {
      background: #f9f9f9;
      border-radius: 0.75rem;
      box-shadow: 0 4px 12px var(--shadow);
      margin-bottom: 1rem;
      padding: 1rem;
      border: 1px solid rgba(0,0,0,0.05);
    }
    .historial-table td {
      padding: 0.5rem 0;
      border: none;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .historial-table td::before {
      content: attr(data-label) ":";
      font-weight: bold;
      color: var(--primary);
      width: 40%;
      flex-shrink: 0;
    }
    .historial-table td a.clase-link {
      color: var(--secondary);
    }
    .historial-table td span {
      flex-grow: 1;
      text-align: right;
    }
}
</style>

<!-- Encabezado -->
<div class="container-fluid animated-bg">
  <div class="container header-hist">
    <h1><i class="fa-solid fa-clock-rotate-left"></i> Historial de Clases</h1>
  </div>
</div>

<!-- Contenedor -->
<div class="historial-container">
  @if($historial->isNotEmpty())
    <table class="historial-table">
      <thead>
        <tr>
          <th>Título</th>
          <th>Fecha</th>
          <th>Estado</th>
        </tr>
      </thead>
      <tbody>
        @foreach($historial as $clase)
          <tr>
            <td data-label="Título"><a href="{{ route('clases.show', $clase) }}" class="clase-link">{{ $clase->titulo }}</a></td>
            <td data-label="Fecha">{{ \Carbon\Carbon::parse($clase->fecha)->format('d/m/Y') }}</td>
            <td data-label="Estado">
              @if($clase->is_active)
                <span class="estado-activa">Activa</span>
              @else
                <span class="estado-inactiva">Inactiva</span>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p class="no-data">No has participado en ninguna clase aún.</p>
  @endif
</div>

<!-- Botón Volver -->
<div class="container text-center mb-5">
  <a href="{{ route('clases.index') }}" class="btn-secondary">&larr; Volver a Clases</a>
</div>
@endsection
