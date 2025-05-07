@extends('layouts.app')

@section('title','Escanear QR')
@section('content')
<div class="container">
  <h1>Escanear Código QR</h1>
  <form action="{{ url('/qr/scan') }}" method="GET">
    <div class="mb-3">
      <label for="codigo" class="form-label">Código QR</label>
      <input type="text" name="codigo" id="codigo" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Ir a Escaneo</button>
  </form>
</div>
@endsection
