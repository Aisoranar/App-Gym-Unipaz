@extends('layouts.app')
@section('title', 'Historial de Clases')
@section('content')

<style>
  :root {
    --primary: #0a192f;
    --secondary: #112240;
    --accent: #64ffda;
    --bg-dark: #020c1b;
    --white: #ccd6f6;
  }

  body {
    background-color: var(--bg-dark);
    color: var(--white);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .historial-container {
    padding: 2rem;
    background-color: var(--secondary);
    border-radius: 0.75rem;
    margin: 2rem auto;
    max-width: 900px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
  }

  .historial-container h1 {
    text-align: center;
    margin-bottom: 2rem;
    color: var(--accent);
    font-weight: 700;
  }

  .historial-table {
    width: 100%;
    border-collapse: collapse;
    background-color: var(--primary);
    border-radius: 0.5rem;
    overflow: hidden;
  }

  .historial-table thead {
    background-color: var(--accent);
    color: var(--primary);
  }

  .historial-table th, .historial-table td {
    padding: 1rem;
    border: 1px solid var(--white);
    text-align: center;
    font-size: 1rem;
  }

  .estado-activa {
    color: #28a745;
    font-weight: bold;
  }

  .estado-inactiva {
    color: #dc3545;
    font-weight: bold;
  }

  .clase-link {
    color: var(--white);
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s;
  }

  .clase-link:hover {
    color: var(--accent);
    text-decoration: underline;
  }

  .no-data {
    text-align: center;
    font-size: 1.1rem;
    margin-top: 1.5rem;
    color: #bbb;
  }
</style>

<div class="historial-container">
  <h1><i class="fa-solid fa-clock-rotate-left"></i> Historial de Clases</h1>

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
            <td>
              <a href="{{ route('clases.show', $clase) }}" class="clase-link">
                {{ $clase->titulo }}
              </a>
            </td>
            <td>{{ \Carbon\Carbon::parse($clase->fecha)->format('d/m/Y') }}</td>
            <td>
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

@endsection
