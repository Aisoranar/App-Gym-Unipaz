@extends('layouts.app')
@section('title', 'Rutinas')
@section('content')
    <h1>Rutinas</h1>
    <a href="{{ route('rutinas.create') }}" class="btn btn-primary mb-3">Crear Nueva Rutina</a>
    <table class="table">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Días por Semana</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($rutinas as $rutina)
          <tr>
            <td>{{ $rutina->nombre }}</td>
            <td>{{ $rutina->dias_por_semana }}</td>
            <td>
              <a href="{{ route('rutinas.show', $rutina) }}" class="btn btn-info btn-sm">Ver</a>
              <a href="{{ route('rutinas.edit', $rutina) }}" class="btn btn-warning btn-sm">Editar</a>
              <form action="{{ route('rutinas.destroy', $rutina) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
@endsection
