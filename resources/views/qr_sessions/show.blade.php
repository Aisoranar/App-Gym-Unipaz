@extends('layouts.app')

@section('content')
<div class="container py-4 bg-dark-overlay rounded">
    <h2 class="text-center mb-4">Escaneos QR por Fecha</h2>
    <div class="row row-cols-1 row-cols-md-2 g-4">
        @php $count = 0; @endphp
        @foreach ($scansByDate as $date => $scans)
            @php $count++; $collapseId = 'collapse'.$count; @endphp
            <div class="col">
                <div class="card border-0 bg-transparent">
                    <div class="card-header d-flex justify-content-between align-items-center"
                         data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="true"
                         style="cursor: pointer; background-color: #0d1b2a;">
                        <h5 class="mb-0" style="color: #fff;">
                            {{ \Carbon\Carbon::parse($date)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                        </h5>
                        <button class="btn btn-sm btn-outline-light">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>
                    <div id="{{ $collapseId }}" class="collapse show">
                        <div class="card-body p-3" style="background-color: #1b4332;">
                            @foreach ($scans as $scan)
                                <div class="record-item animate__animated animate__fadeInUp mt-3 p-3 rounded shadow-sm"
                                     style="background-color: #276749;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong style="color: #fff;">
                                                <i class="bi bi-person-circle"></i>
                                                {{ $scan->user->name }}
                                            </strong><br>
                                            <small style="color:rgb(255, 255, 255);">
                                                <i class="bi bi-activity"></i>
                                                Actividad: {{ $scan->actividad }}
                                            </small><br>
                                            <small style="color:rgb(255, 255, 255);">
                                                <i class="bi bi-briefcase"></i>
                                                Carrera: {{ $scan->carrera }}
                                            </small>
                                        </div>
                                        <div class="text-end">
                                        <small style="color:rgb(255, 255, 255);">
                                        <i class="bi bi-clock"></i>
                                                {{ \Carbon\Carbon::parse($scan->time)->format('H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

<style>
    /* Degradado de fondo */
    body {
        background: linear-gradient(135deg, #0d1b2a, #1b4332);
    }

    /* Overlay oscuro para el contenedor */
    .bg-dark-overlay {
        background: rgba(13, 27, 42, 0.9);
    }

    /* Espaciado interno del contenedor */
    .container {
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    /* Giro suave del icono */
    .rotate-180 {
        transform: rotate(180deg);
        transition: transform 0.3s;
    }
</style>
@endpush

@push('scripts')
<script>
    // Giro del icono al colapsar/expandir
    document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(function(header) {
        header.addEventListener('click', function() {
            var icon = this.querySelector('i');
            icon.classList.toggle('rotate-180');
        });
    });
</script>
@endpush
