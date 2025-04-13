<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider; // Aseguramos el uso de la constante HOME
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Muestra la vista de login.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Procesa la solicitud de autenticación.
     */
    public function store(Request $request)
    {
        // Validación básica de campos
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Intentamos la autenticación con el recordatorio si corresponde
        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Regeneramos la sesión para evitar ataques de fijación
        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Cierra la sesión autenticada.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
