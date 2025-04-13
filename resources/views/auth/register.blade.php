@extends('layouts.auth')
@section('title', 'Registro')

@section('content')
    <i class="fas fa-user-plus auth-icon"></i>
    <h2>Registrarse</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">
                <i class="fas fa-user"></i> Nombre
            </label>
            <input type="text" name="name" id="name" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">
                <i class="fas fa-envelope"></i> Correo Electrónico
            </label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">
                <i class="fas fa-lock"></i> Contraseña
            </label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">
                <i class="fas fa-lock"></i> Confirmar Contraseña
            </label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
    </form>
    <div class="mt-3 text-center">
        <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a></p>
    </div>
@endsection
