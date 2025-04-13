@extends('layouts.app')
@section('title', 'Recomendaciones')
@section('content')
    <h1>Recomendaciones</h1>
    <a href="{{ route('recomendaciones.create') }}" class="btn btn-primary mb-3">Crear Nueva Recomendación</a>
    <table class="table">
      <thead>
        <tr>
          <th>Contenido</th>
          <th>Fecha</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($recomendaciones as $recomendacion)
          <tr>
            <td>{{ Str::limit($recomendacion->contenido, 50) }}</td>
            <td>{{ $recomendacion->fecha }}</td>
            <td>
              <a href="{{ route('recomendaciones.show', $recomendacion) }}" class="btn btn-info btn-sm">Ver</a>
              <a href="{{ route('recomendaciones.edit', $recomendacion) }}" class="btn btn-warning btn-sm">Editar</a>
              <form action="{{ route('recomendaciones.destroy', $recomendacion) }}" method="POST" style="display:inline;">
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
