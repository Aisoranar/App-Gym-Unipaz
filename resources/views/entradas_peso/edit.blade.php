@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="fas fa-edit"></i> Editar registro de peso</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('entradas-peso.update', $entrada) }}" method="POST" class="shadow-sm p-4 bg-white rounded">
        @csrf
        @method('PUT')

        @include('entradas_peso._form', ['entrada' => $entrada])

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Actualizar
            </button>
            <a href="{{ route('entradas-peso.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
