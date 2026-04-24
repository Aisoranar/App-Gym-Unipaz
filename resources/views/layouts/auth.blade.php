<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GymApp - @yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />

    <style>
        :root {
            --primary: #003379;
            --primary-light: #0056a8;
            --secondary: #1a472a;
            --accent: #00d4ff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            height: 100vh;
            overflow-x: hidden;
        }

        /* Layout principal - Split design */
        .auth-container {
            display: flex;
            min-height: 100vh;
            height: 100vh;
        }

        /* Lado izquierdo - Imagen (solo desktop) */
        .auth-image-side {
            flex: 1;
            background: linear-gradient(135deg, rgba(0,51,121,0.8), rgba(0,86,168,0.9)),
                        url('{{ asset('images/images/im1.jpeg') }}');
            background-size: cover;
            background-position: top;
            display: none;
            position: relative;
            overflow: hidden;
        }

        @media (min-width: 992px) {
            .auth-image-side {
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                padding: 3rem;
            }
        }

        /* Overlay animado */
        .auth-image-side::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, rgba(0,51,121,0.95), transparent 60%);
            z-index: 1;
        }

        /* Contenido sobre la imagen */
        .image-content {
            position: relative;
            z-index: 2;
            color: white;
            animation: fadeUp 1s ease-out;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .image-content h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .image-content p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 400px;
        }

        /* Badge de características */
        .feature-badges {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .badge-item {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            animation: fadeUp 1s ease-out;
            animation-delay: 0.3s;
            animation-fill-mode: both;
        }

        /* Lado derecho - Formulario */
        .auth-form-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            position: relative;
        }

        /* Fondo móvil con imagen difuminada */
        @media (max-width: 991px) {
            .auth-form-side {
                background: linear-gradient(135deg, rgba(0,51,121,0.95), rgba(0,86,168,0.95)),
                            url('{{ asset('images/images/im1.jpeg') }}');
                background-size: cover;
                background-position: top;
            }
        }

        /* Círculos decorativos animados */
        .auth-form-side::before,
        .auth-form-side::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
        }

        .auth-form-side::before {
            width: 300px;
            height: 300px;
            background: var(--primary);
            top: -100px;
            right: -100px;
            animation: float 6s ease-in-out infinite;
        }

        .auth-form-side::after {
            width: 200px;
            height: 200px;
            background: var(--secondary);
            bottom: -50px;
            left: -50px;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        /* Card del formulario */
        .auth-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
            animation: cardSlide 0.8s ease-out;
        }

        @keyframes cardSlide {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* Header del formulario */
        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-logo {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            color: white;
            box-shadow: 0 10px 30px rgba(0,51,121,0.3);
            animation: bounce 2s ease infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .auth-header h2 {
            font-weight: 700;
            color: #333;
            font-size: 1.5rem;
            margin-bottom: 0.25rem;
        }

        .auth-header p {
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Inputs interactivos */
        .form-group {
            margin-bottom: 1.25rem;
            position: relative;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
            transition: all 0.3s ease;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(0,51,121,0.1);
            outline: none;
        }

        .form-control:focus + .input-icon,
        .input-wrapper:focus-within .input-icon {
            color: var(--primary);
        }

        /* Toggle password */
        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #adb5bd;
            cursor: pointer;
            transition: color 0.3s;
        }

        .toggle-password:hover {
            color: var(--primary);
        }

        /* Checkbox estilizado */
        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            border: 2px solid #dee2e6;
            cursor: pointer;
            transition: all 0.3s;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .form-check-label {
            font-size: 0.9rem;
            color: #6c757d;
            cursor: pointer;
        }

        /* Botón principal */
        .btn-auth {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            margin-top: 0.5rem;
        }

        .btn-auth::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn-auth:hover::before {
            left: 100%;
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,51,121,0.3);
        }

        .btn-auth:active {
            transform: translateY(0);
        }

        /* Link de registro */
        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e9ecef;
        }

        .auth-footer p {
            color: #6c757d;
            font-size: 0.9rem;
            margin: 0;
        }

        .auth-footer a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            position: relative;
        }

        .auth-footer a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s;
        }

        .auth-footer a:hover::after {
            width: 100%;
        }

        /* Responsive móvil mejorado */
        @media (max-width: 991px) {
            .auth-container {
                height: 100vh;
                min-height: 100vh;
            }

            .auth-form-side {
                padding: 1.5rem;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                height: 100vh;
            }

            .auth-card {
                background: white;
                border-radius: 20px;
                padding: 2rem;
                box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            }

            .auth-header {
                margin-bottom: 1.5rem;
            }

            .auth-logo {
                width: 65px;
                height: 65px;
                font-size: 1.85rem;
                margin-bottom: 0.75rem;
            }

            .auth-header h2 {
                font-size: 1.35rem;
            }

            .form-control {
                padding: 1rem 1rem 1rem 3rem;
                font-size: 1rem;
            }

            .input-icon {
                font-size: 1.1rem;
            }

            .btn-auth {
                padding: 1rem;
                font-size: 1.05rem;
            }
        }

        @media (max-width: 480px) {
            .auth-form-side {
                padding: 1rem;
                padding-top: 2rem;
            }

            .auth-card {
                padding: 1.5rem;
                border-radius: 16px;
            }

            .auth-logo {
                width: 55px;
                height: 55px;
                font-size: 1.6rem;
            }

            .auth-header h2 {
                font-size: 1.25rem;
            }

            .form-group {
                margin-bottom: 1rem;
            }

            .form-control {
                padding: 0.875rem 1rem 0.875rem 2.75rem;
            }
        }

        /* Efecto de carga */
        .loading {
            position: relative;
            pointer-events: none;
        }

        .loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>

    @yield('styles')
</head>
<body>
    <div class="auth-container">
        <!-- Lado izquierdo: Imagen (desktop) -->
        <div class="auth-image-side">
            <div class="image-content">
                <h1>Transforma tu Cuerpo,<br>Transforma tu Vida</h1>
                <p>Únete a GymApp y comienza tu viaje hacia una versión más fuerte y saludable de ti mismo.</p>
                <div class="feature-badges">
                    <span class="badge-item"><i class="fas fa-dumbbell"></i> Entrenamientos</span>
                    <span class="badge-item"><i class="fas fa-fire"></i> Rutinas</span>
                    <span class="badge-item"><i class="fas fa-chart-line"></i> Progreso</span>
                </div>
            </div>
        </div>

        <!-- Lado derecho: Formulario -->
        <div class="auth-form-side">
            <div class="auth-card">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <script>
        // Toggle password visibility
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.querySelector('.toggle-password');
            const passwordInput = document.getElementById('password');

            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.querySelector('i').classList.toggle('fa-eye');
                    this.querySelector('i').classList.toggle('fa-eye-slash');
                });
            }

            // Efecto ripple en el botón
            const btn = document.querySelector('.btn-auth');
            if (btn) {
                btn.addEventListener('click', function(e) {
                    this.classList.add('loading');
                });
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
