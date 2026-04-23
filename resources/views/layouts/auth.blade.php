<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GymApp - @yield('title')</title>
    <!-- Archivo CSS principal -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- FontAwesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Variables de color */
        :root {
            --dark-blue: #001f3f;
            --dark-green: #013220;
            --white: #ffffff;
        }
        body {
            background: var(--dark-blue);
            color: var(--white);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        /* Contenedor principal, mobile first */
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            /* Fondo degradado con animación */
            background: linear-gradient(135deg, var(--dark-blue), var(--dark-green));
            background-size: 400% 400%;
            animation: bgAnimation 10s ease infinite;
        }
        @keyframes bgAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        /* Tarjeta de autenticación */
        .auth-card {
            background: var(--white);
            color: var(--dark-blue);
            border-radius: 0.5rem;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            animation: cardFadeIn 1s ease-out;
        }
        @keyframes cardFadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .auth-card h2 {
            font-weight: bold;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        /* Icono principal */
        .auth-icon {
            font-size: 3rem;
            color: var(--dark-green);
            display: block;
            text-align: center;
            margin-bottom: 1rem;
        }
        /* Estilos para inputs y botones */
        .form-control {
            border-radius: 0.25rem;
            border: 1px solid var(--dark-blue);
        }
        .btn-primary {
            background: var(--dark-green);
            border: none;
            transition: background 0.3s;
        }
        .btn-primary:hover {
            background: var(--dark-blue);
        }
        a {
            color: var(--dark-green);
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>

    @yield('styles')
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap Bundle JS (con Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    @yield('scripts')
</body>
</html>
