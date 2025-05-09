@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="fas fa-plus-circle"></i> Nuevo registro de peso</h2>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('entradas-peso.store') }}" method="POST">
        @csrf
        @include('entradas_peso._form', ['entrada' => null])
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
            <a href="{{ route('entradas-peso.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Cancelar</a>
        </div>
    </form>
</div>
@endsection