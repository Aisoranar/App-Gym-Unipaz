@extends('layouts.app')

@section('content')
<div class="container py-4" style="padding-top: 80px;">

    <!-- Contenido principal simulando la pantalla del celular -->
    <div class="main-content" style="background-color: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        
        <!-- Encabezado con botón de menú hamburguesa -->
        <div class="header d-flex align-items-center mb-3">
            <button id="menu-toggle" class="hamburger btn btn-outline-secondary me-3">
                <i class="fa fa-bars"></i>
            </button>
            <h1 class="h4 mb-0">Home</h1>
        </div>

        <!-- Área de contenido principal -->
        <div class="content">
            <p>
                Bienvenido al Home. Aquí puedes gestionar tus asistencias, clases, ejercicios, fichas, planes, recomendaciones y rutinas.
            </p>
        </div>

    </div>
    
</div>
@endsection
