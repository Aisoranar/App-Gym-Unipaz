@extends('layouts.app')
@section('title', 'Ejercicios')
@section('content')
    <h1>Ejercicios</h1>
    <a href="{{ route('ejercicios.create') }}" class="btn btn-primary mb-3">Registrar Nuevo Ejercicio</a>
    <table class="table">
      <thead>
        <tr>
          <th>Ejercicio</th>
          <th>Fecha</th>
          <th>Series</th>
          <th>Repeticiones</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($ejercicios as $ejercicio)
          <tr>
            <td>{{ $ejercicio->nombre_ejercicio }}</td>
            <td>{{ $ejercicio->fecha }}</td>
            <td>{{ $ejercicio->series }}</td>
            <td>{{ $ejercicio->repeticiones }}</td>
            <td>
              <a href="{{ route('ejercicios.show', $ejercicio) }}" class="btn btn-info btn-sm">Ver</a>
              <a href="{{ route('ejercicios.edit', $ejercicio) }}" class="btn btn-warning btn-sm">Editar</a>
              <form action="{{ route('ejercicios.destroy', $ejercicio) }}" method="POST" style="display:inline;">
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
