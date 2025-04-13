@extends('layouts.app')
@section('title', 'Lista de Fichas Médicas')
@section('content')

<style>
    :root {
        --primary: #001f3f;
        --secondary: #013220;
        --bg-dark: #000814;
        --white: #ffffff;
    }

    body {
        background-color: var(--bg-dark);
        color: var(--white);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .animated-bg {
        background: linear-gradient(45deg, var(--primary), var(--secondary));
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .header-index {
        padding: 2rem 1rem;
        text-align: center;
    }

    .header-index h1 {
        font-size: 2rem;
        font-weight: bold;
    }

    .btn-create {
        background-color: var(--white);
        border: 2px solid var(--primary);
        color: var(--primary);
        transition: all 0.2s ease-in-out;
    }

    .btn-create:hover {
        background-color: var(--primary);
        color: var(--white);
    }

    .search-form {
        margin: 1rem auto 2rem;
        max-width: 500px;
        padding: 0 1rem;
    }

    .search-form .form-control,
    .search-form .btn {
        border-radius: 0;
    }

    .card-ficha {
        background-color: #001529;
        border: 1px solid var(--secondary);
        padding: 1.5rem;
        border-radius: 1rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s, background 0.3s;
    }

    .card-ficha:hover {
        transform: translateY(-8px);
        background-color: var(--secondary);
    }

    .card-ficha h5 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: bold;
        color: var(--white);
        text-transform: uppercase;
    }

    .card-ficha p {
        margin: 0.3rem 0;
        font-size: 0.95rem;
    }

    .btn-ver {
        background-color: var(--secondary);
        color: var(--white);
        border: none;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        border-radius: 0;
        transition: background 0.3s ease-in-out;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-ver:hover {
        background-color: #026c3b;
        color: var(--white);
    }
</style>

<div class="animated-bg header-index">
    <h1><i class="fa-solid fa-file-medical"></i> Lista de Fichas Médicas</h1>
    <a href="{{ route('fichas.create') }}" class="btn btn-create mt-3 px-4">
        <i class="fa-solid fa-plus"></i> Crear Nueva Ficha
    </a>
</div>

<div class="container pb-4">
    <!-- Filtro de búsqueda -->
    <form method="GET" action="{{ route('fichas.index') }}" class="search-form">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o apellidos..." value="{{ request()->get('search') }}">
            <button class="btn btn-create" type="submit">
                <i class="fa-solid fa-search"></i> Buscar
            </button>
        </div>
    </form>

    <!-- Lista de fichas como tarjetas -->
    @forelse($fichas as $ficha)
        <div class="card-ficha">
            <h5>{{ $ficha->nombre }} {{ $ficha->apellidos }}</h5>
            <p><strong>ID:</strong> {{ $ficha->id }}</p>
            <p><strong>Fecha de nacimiento:</strong> {{ $ficha->fecha_nacimiento }}</p>
            <p><strong>Edad:</strong> {{ $ficha->edad }} años</p>
            <p><strong>Sexo:</strong> {{ $ficha->sexo }}</p>
            <a href="{{ route('fichas.show', $ficha->id) }}" class="btn-ver mt-3">
                <i class="fa-solid fa-eye"></i> Ver Detalles
            </a>
        </div>
    @empty
        <div class="text-center mt-4">
            <p>No se encontraron fichas médicas.</p>
        </div>
    @endforelse
</div>

@endsection
