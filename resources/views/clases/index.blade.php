@extends('layouts.app')
@section('title', 'Clases')
@section('content')
    <h1>Clases Grupales</h1>
    <a href="{{ route('clases.create') }}" class="btn btn-primary mb-3">Crear Nueva Clase</a>
    <table class="table">
      <thead>
        <tr>
          <th>Título</th>
          <th>Fecha</th>
          <th>Hora de Inicio</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($clases as $clase)
          <tr>
            <td>{{ $clase->titulo }}</td>
            <td>{{ $clase->fecha }}</td>
            <td>{{ $clase->hora_inicio }}</td>
            <td>
              <a href="{{ route('clases.show', $clase) }}" class="btn btn-info btn-sm">Ver</a>
              <a href="{{ route('clases.edit', $clase) }}" class="btn btn-warning btn-sm">Editar</a>
              <form action="{{ route('clases.destroy', $clase) }}" method="POST" style="display:inline;">
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
