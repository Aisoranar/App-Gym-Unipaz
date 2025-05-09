@extends('layouts.app')

@section('content')
<div class="container py-4 bg-dark-overlay rounded">
    <!-- Información de la sesión QR -->
    <div class="mb-4 p-4 rounded shadow" style="background-color: #1b4332; color: #fff;">
        <h2 class="mb-2"><i class="fas fa-qrcode me-1"></i> {{ $session->nombre }}</h2>
        <p class="mb-1"><strong>Actividad:</strong> {{ $session->actividad }}</p>
        <p class="mb-1"><strong>Código:</strong> {{ $session->codigo }}</p>
        <p class="mb-1"><strong>Estado:</strong>
            <span class="badge {{ $session->activo ? 'bg-success' : 'bg-secondary' }}">
                {{ $session->activo ? 'Activo' : 'Inactivo' }}
            </span>
        </p>
        @if ($session->qr_image)
            <div class="mt-3">
                <img src="{{ asset('storage/' . $session->qr_image) }}" alt="QR generado"
                     style="max-width: 200px; height: auto;" class="img-thumbnail bg-white">
            </div>
        @endif
    </div>

    <!-- Escaneos por fecha -->
    <h3 class="text-center mb-4 text-white">Escaneos QR por Fecha</h3>
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
                                                <i class="bi bi-briefcase"></i>
                                                Carrera: {{ $scan->carrera }}
                                            </small>
                                        </div>
                                        <div class="text-end">
                                            <small style="color:rgb(255, 255, 255);">
                                                <i class="bi bi-clock"></i>
                                                {{ \Carbon\Carbon::parse($scan->created_at)->format('H:i') }}
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
    body {
        background: linear-gradient(135deg, #0d1b2a, #1b4332);
    }
    .bg-dark-overlay {
        background: rgba(13, 27, 42, 0.9);
    }
    .container {
        padding-top: 2rem;
        padding-bottom: 2rem;
    }
    .rotate-180 {
        transform: rotate(180deg);
        transition: transform 0.3s;
    }
</style>
@endpush

@push('scripts')
<script>
    document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(function(header) {
        header.addEventListener('click', function() {
            var icon = this.querySelector('i');
            icon.classList.toggle('rotate-180');
        });
    });
</script>
@endpush
