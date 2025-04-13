@extends('layouts.app')
@section('title', 'Planes Nutricionales')
@section('content')
    <h1>Planes Nutricionales</h1>
    <a href="{{ route('planes.create') }}" class="btn btn-primary mb-3">Crear Nuevo Plan</a>
    <table class="table">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Calorías Diarias</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($planes as $plan)
          <tr>
            <td>{{ $plan->nombre }}</td>
            <td>{{ $plan->calorias_diarias }}</td>
            <td>
              <a href="{{ route('planes.show', $plan) }}" class="btn btn-info btn-sm">Ver</a>
              <a href="{{ route('planes.edit', $plan) }}" class="btn btn-warning btn-sm">Editar</a>
              <form action="{{ route('planes.destroy', $plan) }}" method="POST" style="display:inline;">
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
