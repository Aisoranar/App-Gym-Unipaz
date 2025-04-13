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
    background: var(--bg-dark);
    color: var(--white);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
  }
  
  .historial-container {
    padding: 2rem;
    background: #112240;
    border-radius: 0.5rem;
    margin: 2rem auto;
    max-width: 800px;
  }
  
  .historial-container h1 {
    text-align: center;
    margin-bottom: 1.5rem;
    color: var(--accent);
  }
  
  .historial-table {
    width: 100%;
    border-collapse: collapse;
  }
  
  .historial-table thead tr {
    background: var(--accent);
    color: var(--bg-dark);
  }
  
  .historial-table th, .historial-table td {
    padding: 0.75rem;
    border: 1px solid var(--white);
    text-align: center;
  }
  
  .estado-activa {
    color: green;
    font-weight: bold;
  }
  
  .estado-inactiva {
    color: red;
    font-weight: bold;
  }

  /* Estilo para el enlace del título de clase */
  .clase-link {
    color: var(--white);
    text-decoration: none;
    font-weight: bold;
  }
  
  .clase-link:hover {
    text-decoration: underline;
    color: var(--accent);
  }
</style>

<div class="historial-container">
  <h1>Historial de Clases</h1>
  
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
    <p style="text-align: center;">No has participado en ninguna clase aún.</p>
  @endif
</div>

@endsection
