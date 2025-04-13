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
    Route::resource('clases', ClaseController::class);

    // Asistencia (Calendario)
    Route::get('calendario', [AsistenciaController::class, 'index'])->name('asistencias.calendario');
    Route::get('asistencias/eventos', [AsistenciaController::class, 'eventos'])->name('asistencias.eventos');
    Route::post('asistencias', [AsistenciaController::class, 'store'])->name('asistencias.store');
});
