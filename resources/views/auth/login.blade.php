@extends('layouts.auth')
@section('title', 'Iniciar Sesión')

@section('content')
    <!-- Header del formulario -->
    <div class="auth-header">
        <div class="auth-logo">
            <i class="fas fa-dumbbell"></i>
        </div>
        <h2>¡Bienvenido de vuelta!</h2>
        <p>Ingresa tus credenciales para continuar</p>
    </div>

    <!-- Formulario -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="form-group">
            <label for="email" class="form-label">
                <i class="fas fa-envelope"></i> Correo Electrónico
            </label>
            <div class="input-wrapper">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email" id="email" class="form-control" placeholder="usuario@gmail.com" required autofocus>
            </div>
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">
                <i class="fas fa-lock"></i> Contraseña
            </label>
            <div class="input-wrapper">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                <button type="button" class="toggle-password" tabindex="-1">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>

        <!-- Recordarme -->
        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label for="remember" class="form-check-label">Recordarme</label>
            </div>
        </div>

        <!-- Botón -->
        <button type="submit" class="btn-auth">
            <i class="fas fa-sign-in-alt me-2"></i>Ingresar
        </button>
    </form>

    <!-- Footer -->
    <div class="auth-footer">
        <p>¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
    </div>
@endsection
