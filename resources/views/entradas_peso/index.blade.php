@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Estadísticas --}}
    <div class="row gy-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card shadow-sm text-center p-3">
                <i class="fas fa-list fa-2x mb-2 text-primary"></i>
                <h6>Total registros</h6>
                <p class="h3">{{ $total }}</p>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card shadow-sm text-center p-3">
                <i class="fas fa-chart-line fa-2x mb-2 text-success"></i>
                <h6>IMC promedio</h6>
                <p class="h3">{{ number_format($promedioImc, 2) }}</p>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card shadow-sm text-center p-3">
                <i class="fas fa-lightbulb fa-2x mb-2 text-warning"></i>
                <h6>Sugerencia</h6>
                <p>{{ $sugerencia }}</p>
            </div>
        </div>
    </div>

    {{-- Tabla para md en adelante --}}
    <div class="table-responsive d-none d-md-block">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th><i class="fas fa-calendar-alt"></i> Fecha</th>
                    <th><i class="fas fa-weight-hanging"></i> Actual</th>
                    <th><i class="fas fa-bullseye"></i> Ideal</th>
                    <th><i class="fas fa-ruler-vertical"></i> Altura</th>
                    <th><i class="fas fa-heartbeat"></i> IMC</th>
                    <th><i class="fas fa-clipboard-list"></i> Estado</th>
                    <th><i class="fas fa-cogs"></i> Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($entradas as $entrada)
                <tr>
                    <td>{{ $entrada->fecha->format('d/m/Y') }}</td>
                    <td>{{ $entrada->peso_actual_kg }} kg</td>
                    <td>{{ $entrada->peso_ideal_kg ?? '-' }} kg</td>
                    <td>{{ $entrada->altura_cm }} cm</td>
                    <td>{{ $entrada->imc }}</td>
                    <td>
                        <span class="badge 
                            {{ $entrada->estado_peso == 'Normal' ? 'bg-success' :
                               ($entrada->estado_peso == 'Bajo peso' ? 'bg-info' :
                               ($entrada->estado_peso == 'Sobrepeso' ? 'bg-warning text-dark' : 'bg-danger'))
                            }}">
                            {{ $entrada->estado_peso }}
                        </span>
                    </td>
                    <td class="text-nowrap">
                        <a href="{{ route('entradas-peso.show', $entrada) }}" class="btn btn-sm btn-info me-1"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('entradas-peso.edit', $entrada) }}" class="btn btn-sm btn-warning me-1"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('entradas-peso.destroy', $entrada) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este registro?')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No hay registros aún.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Tarjetas para móvil --}}
    <div class="d-block d-md-none">
        @forelse($entradas as $entrada)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="text-muted">
                        <i class="fas fa-calendar-alt"></i> {{ $entrada->fecha->format('d/m/Y') }}
                    </small>
                    <span class="badge 
                        {{ $entrada->estado_peso == 'Normal' ? 'bg-success' :
                           ($entrada->estado_peso == 'Bajo peso' ? 'bg-info' :
                           ($entrada->estado_peso == 'Sobrepeso' ? 'bg-warning text-dark' : 'bg-danger'))
                        }}">
                        {{ $entrada->estado_peso }}
                    </span>
                </div>
                <p class="mb-1"><i class="fas fa-weight-hanging"></i> Actual: {{ $entrada->peso_actual_kg }} kg</p>
                <p class="mb-1"><i class="fas fa-bullseye"></i> Ideal: {{ $entrada->peso_ideal_kg ?? '-' }} kg</p>
                <p class="mb-1"><i class="fas fa-ruler-vertical"></i> Altura: {{ $entrada->altura_cm }} cm</p>
                <p class="mb-3"><i class="fas fa-heartbeat"></i> IMC: {{ $entrada->imc }}</p>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('entradas-peso.show', $entrada) }}" class="btn btn-sm btn-info me-1"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('entradas-peso.edit', $entrada) }}" class="btn btn-sm btn-warning me-1"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('entradas-peso.destroy', $entrada) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este registro?')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center">No hay registros aún.</p>
        @endforelse
    </div>

    {{-- Botón agregar --}}
    <div class="d-grid mt-4">
        <a href="{{ route('entradas-peso.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle"></i> Agregar registro
        </a>
    </div>
</div>
@endsection
