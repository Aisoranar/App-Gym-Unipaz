@extends('layouts.app')
@section('title', 'Lista de Fichas Médicas')
@section('content')

<div class="container py-4">
    <h1 class="mb-4">Lista de Fichas Médicas</h1>
    <table class="table table-bordered">
         <thead>
             <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Fecha de Nacimiento</th>
                <th>Edad</th>
                <th>Sexo</th>
                <th>Acciones</th>
             </tr>
         </thead>
         <tbody>
         @foreach($fichas as $ficha)
             <tr>
                 <td>{{ $ficha->id }}</td>
                 <td>{{ $ficha->nombre }}</td>
                 <td>{{ $ficha->apellidos }}</td>
                 <td>{{ $ficha->fecha_nacimiento }}</td>
                 <td>{{ $ficha->edad }}</td>
                 <td>{{ $ficha->sexo }}</td>
                 <td>
                     <a href="{{ route('fichas.show', $ficha->id) }}" class="btn btn-primary btn-sm">Ver</a>
                 </td>
             </tr>
         @endforeach
         </tbody>
    </table>
</div>

@endsection
