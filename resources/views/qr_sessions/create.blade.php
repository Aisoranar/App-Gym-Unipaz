@extends('layouts.app')

@section('content')
<div class="container px-2">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4">Crear Sesión QR</h1>
        <a href="{{ route('qr-sessions.index') }}" class="btn btn-secondary btn-sm">Cancelar</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mx-auto" style="max-width: 24rem;">
        <div class="card-body">
            <form action="{{ route('qr-sessions.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre de la sesión</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
