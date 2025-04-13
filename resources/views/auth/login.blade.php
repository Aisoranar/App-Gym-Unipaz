@extends('layouts.app')
@section('title', 'Iniciar Sesión')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <h2>Iniciar Sesión</h2>
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="form-group">
        <label for="email">Correo Electrónico</label>
        <input type="email" name="email" id="email" class="form-control" required autofocus>
      </div>
      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" class="form-control" required>
      </div>
      <div class="form-check">
        <input type="checkbox" name="remember" id="remember" class="form-check-input">
        <label for="remember" class="form-check-label">Recordarme</label>
      </div>
      <button type="submit" class="btn btn-primary mt-2">Ingresar</button>
    </form>

    <!-- Enlace para registrarse si no tiene cuenta -->
    <div class="mt-3 text-center">
      <p>¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
    </div>
  </div>
</div>
@endsection
