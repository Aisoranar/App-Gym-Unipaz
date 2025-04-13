@extends('layouts.app')
@section('title', 'Registro')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <h2>Registrarse</h2>
    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="form-group">
        <label for="name">Nombre</label>
        <input type="text" name="name" id="name" class="form-control" required autofocus>
      </div>
      <div class="form-group">
        <label for="email">Correo Electrónico</label>
        <input type="email" name="email" id="email" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="password_confirmation">Confirmar Contraseña</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
      </div>
      <!-- Opcional: selección de rol -->
      <!--
      <div class="form-group">
        <label for="role">Rol</label>
        <select name="role" id="role" class="form-control">
          <option value="usuario" selected>Usuario</option>
          <option value="entrenador">Entrenador</option>
          <option value="superadmin">Superadmin</option>
        </select>
      </div>
      -->
      <button type="submit" class="btn btn-primary mt-2">Registrarse</button>
    </form>
  </div>
</div>
@endsection
