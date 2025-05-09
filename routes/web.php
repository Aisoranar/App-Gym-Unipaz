<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\FichaMedicaController;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\RecomendacionController;
use App\Http\Controllers\RutinaController;
use App\Http\Controllers\PlanNutricionalController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QrCodeSessionController;
use App\Http\Controllers\EntradaPesoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí se definen las rutas de la aplicación.
|
*/

// Ruta principal: redirige al login si el usuario no está autenticado,
// o al home si ya se ha logueado
Route::get('/', function () {
    return auth()->check() ? redirect()->route('home') : view('auth.login');
})->name('welcome');

// Rutas para invitados (no autenticados)
Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Registro
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

// Rutas para usuarios autenticados
Route::middleware('auth')->group(function () {

    // Home del usuario autenticado
    Route::get('home', [HomeController::class, 'index'])->name('home');

    // Cerrar sesión
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Ficha Médica
    Route::resource('fichas', FichaMedicaController::class);

    // Ejercicios
    Route::resource('ejercicios', EjercicioController::class);

    // Recomendaciones
    Route::resource('recomendaciones', RecomendacionController::class);

    // Rutinas
    Route::resource('rutinas', RutinaController::class);

    // Plan Nutricional
    Route::resource('planes', PlanNutricionalController::class);

    // Clases grupales
    // Primero definimos la ruta para el historial de clases para que no
    // sea interpretada como un parámetro en el resource.
    Route::get('clases/historial', [ClaseController::class, 'historial'])->name('clases.historial');
    // Luego definimos las rutas resource y adicionales
    Route::resource('clases', ClaseController::class);
    Route::post('clases/{clase}/join', [ClaseController::class, 'join'])->name('clases.join');
    Route::post('clases/{clase}/leave', [ClaseController::class, 'leave'])->name('clases.leave');

    // Asistencia (Calendario)
    Route::get('calendario', [AsistenciaController::class, 'index'])->name('asistencias.calendario');
    Route::get('asistencias/eventos', [AsistenciaController::class, 'eventos'])->name('asistencias.eventos');
    Route::post('asistencias', [AsistenciaController::class, 'store'])->name('asistencias.store');

    // Administración de sesiones (solo entrenadores)
    Route::middleware('role:entrenador')->group(function () {
        Route::get('/qr-sessions', [QrCodeSessionController::class, 'index'])
             ->name('qr-sessions.index');
        Route::get('/qr-sessions/create', [QrCodeSessionController::class, 'create'])
             ->name('qr-sessions.create');
        Route::post('/qr-sessions', [QrCodeSessionController::class, 'store'])
             ->name('qr-sessions.store');
        Route::get('/qr-sessions/{id}/edit', [QrCodeSessionController::class, 'edit'])
             ->name('qr-sessions.edit');
        Route::put('/qr-sessions/{id}', [QrCodeSessionController::class, 'update'])
             ->name('qr-sessions.update');
        Route::delete('/qr-sessions/{id}', [QrCodeSessionController::class, 'destroy'])
             ->name('qr-sessions.destroy');
        Route::patch('/qr-sessions/{id}/toggle', [QrCodeSessionController::class, 'toggle'])
             ->name('qr-sessions.toggle');
        Route::get('/qr-sessions/{id}', [QrCodeSessionController::class, 'show'])
             ->name('qr-sessions.show');
    });

    Route::get('/mis-asistencias', [QrCodeSessionController::class, 'myAttendances'])
     ->middleware('auth')
     ->name('qr-sessions.my-attendances');


    // Escaneo de sesiones (todos los usuarios autenticados)
    // 1) Formulario donde el usuario ingresa el código QR manualmente
    Route::get('/qr/enter-code', [QrCodeSessionController::class, 'enterCode'])
         ->name('qr-sessions.enter-code');

    // 1b) Procesar el formulario manual y redirigir a la ruta de escaneo
    Route::get('/qr/redirect-code', [QrCodeSessionController::class, 'redirectCode'])
         ->name('qr-sessions.redirect-code');

    // 2) Una vez con el código, muestra el form de registro de asistencia
    Route::get('/qr/scan/{codigo}', [QrCodeSessionController::class, 'scanForm'])
         ->name('qr-sessions.scan-form');

    // 3) Procesa el registro de asistencia (POST)
    Route::post('/qr/scan', [QrCodeSessionController::class, 'scanSubmit'])
         ->name('qr-sessions.scan-submit');

    // Registro de pesos: ajustamos el parámetro para que sea {entrada}
    Route::resource('entradas-peso', EntradaPesoController::class)
         ->parameters(['entradas-peso' => 'entrada']);


});