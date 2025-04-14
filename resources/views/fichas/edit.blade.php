@extends('layouts.app')
@section('title', 'Editar Ficha Médica')
@section('content')

<style>
    .form-section {
        background: #f8f9fa;
        border-radius: 0.5rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
        border-left: 4px solid #0d6efd;
    }
    .form-section h5 {
        margin-bottom: 1.5rem;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 0.5rem;
    }
    label {
        font-weight: 500;
        margin-bottom: 0.3rem;
    }
</style>

<div class="container py-4">
    <h1 class="mb-4 text-primary fw-bold">
        <i class="fa-solid fa-file-medical"></i> Editar Ficha Médica
    </h1>
    <form method="POST" action="{{ route('fichas.update', $ficha) }}">
      @csrf
      @method('PUT')
      
      {{-- Datos Personales --}}
      <div class="form-section">
         <h5><i class="fa-solid fa-user"></i> Datos Personales</h5>
         <div class="row g-3">
              <div class="col-md-6 col-lg-4">
                <label for="apellidos">Apellidos</label>
                <div class="input-group">
                   <span class="input-group-text"><i class="fa-solid fa-user-tag"></i></span>
                   <input type="text" name="apellidos" id="apellidos" class="form-control" value="{{ $ficha->apellidos }}" required>
                </div>
              </div>
              <div class="col-md-6 col-lg-4">
                <label for="nombre">Nombre</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa-solid fa-id-badge"></i></span>
                  <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $ficha->nombre }}" required>
                </div>
              </div>
              <div class="col-md-4 col-lg-2">
                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa-solid fa-calendar-check"></i></span>
                  <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{ $ficha->fecha_nacimiento }}" required>
                </div>
              </div>
              <div class="col-md-4 col-lg-2">
                <label for="edad">Edad</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa-solid fa-hourglass-half"></i></span>
                  <input type="number" name="edad" id="edad" class="form-control" value="{{ $ficha->edad }}" required>
                </div>
              </div>
              <div class="col-md-4 col-lg-2">
                <label for="sexo">Sexo</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa-solid fa-venus-mars"></i></span>
                  <select name="sexo" id="sexo" class="form-select" required>
                    <option value="F" {{ $ficha->sexo == 'F' ? 'selected' : '' }}>Femenino</option>
                    <option value="M" {{ $ficha->sexo == 'M' ? 'selected' : '' }}>Masculino</option>
                  </select>
                </div>
              </div>
         </div>
      </div>

      {{-- Dirección y Contacto --}}
      <div class="form-section">
         <h5><i class="fa-solid fa-address-book"></i> Dirección y Contacto</h5>
         <div class="row g-3">
              <div class="col-md-6 col-lg-4">
                  <label for="domicilio">Domicilio</label>
                  <div class="input-group">
                     <span class="input-group-text"><i class="fa-solid fa-house"></i></span>
                     <input type="text" name="domicilio" id="domicilio" class="form-control" value="{{ $ficha->domicilio }}" required>
                  </div>
              </div>
              <div class="col-md-6 col-lg-4">
                  <label for="barrio">Barrio</label>
                  <div class="input-group">
                     <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
                     <input type="text" name="barrio" id="barrio" class="form-control" value="{{ $ficha->barrio }}">
                  </div>
              </div>
              <div class="col-md-6 col-lg-4">
                  <label for="telefonos">Teléfonos</label>
                  <div class="input-group">
                     <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                     <input type="text" name="telefonos" id="telefonos" class="form-control" value="{{ $ficha->telefonos }}">
                  </div>
              </div>
         </div>
      </div>

      {{-- Información Médica --}}
      <div class="form-section">
         <h5><i class="fa-solid fa-user-md"></i> Información Médica</h5>
         <div class="row g-3">
              <div class="col-md-4 col-lg-3">
                  <label for="tipo_sangre">Tipo de Sangre</label>
                  <div class="input-group">
                     <span class="input-group-text"><i class="fa-solid fa-tint"></i></span>
                     <input type="text" name="tipo_sangre" id="tipo_sangre" class="form-control" value="{{ $ficha->tipo_sangre }}" required>
                  </div>
              </div>
              <div class="col-md-4 col-lg-3">
                  <label for="factor_rh">Factor RH</label>
                  <div class="input-group">
                     <span class="input-group-text"><i class="fa-solid fa-droplet"></i></span>
                     <select name="factor_rh" id="factor_rh" class="form-select" required>
                        <option value="">-- Seleccione --</option>
                        <option value="Positivo" {{ $ficha->factor_rh == 'Positivo' ? 'selected' : '' }}>Positivo</option>
                        <option value="Negativo" {{ $ficha->factor_rh == 'Negativo' ? 'selected' : '' }}>Negativo</option>
                     </select>
                  </div>
              </div>
              <div class="col-md-4 col-lg-3">
                  <label for="lateralidad">Lateralidad</label>
                  <div class="input-group">
                     <span class="input-group-text"><i class="fa-solid fa-hand-paper"></i></span>
                     <select name="lateralidad" id="lateralidad" class="form-select" required>
                        <option value="">-- Seleccione --</option>
                        <option value="Diestro" {{ $ficha->lateralidad == 'Diestro' ? 'selected' : '' }}>Diestro</option>
                        <option value="Zurdo" {{ $ficha->lateralidad == 'Zurdo' ? 'selected' : '' }}>Zurdo</option>
                     </select>
                  </div>
              </div>
         </div>
      </div>

      {{-- Botón de envío --}}
      <div class="text-end mt-4">
          <button type="submit" class="btn btn-primary btn-lg shadow-sm px-5">
              <i class="fa-solid fa-floppy-disk"></i> Actualizar Ficha Médica
          </button>

          <a href="{{ route('fichas.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Volver a la lista
          </a>
      </div>

    </form>
</div>

@endsection
