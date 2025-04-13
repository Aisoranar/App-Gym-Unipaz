@extends('layouts.auth')
@section('title', 'Iniciar Sesión')

@section('content')
    <i class="fas fa-sign-in-alt auth-icon"></i>
    <h2>Iniciar Sesión</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">
                <i class="fas fa-envelope"></i> Correo Electrónico
            </label>
            <input type="email" name="email" id="email" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">
                <i class="fas fa-lock"></i> Contraseña
            </label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="remember" id="remember" class="form-check-input">
            <label for="remember" class="form-check-label">Recordarme</label>
        </div>
        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
    </form>
    <div class="mt-3 text-center">
        <p>¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
    </div>
@endsection
