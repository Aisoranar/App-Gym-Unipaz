<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Muestra el formulario de registro.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Procesa la solicitud de registro.
     */
    public function store(Request $request)
    {
        // Validación de los campos del formulario
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // Si deseas permitir la selección de rol, descomenta la siguiente línea:
            // 'role'  => 'required|in:usuario,entrenador,superadmin',
        ]);

        // Creación del usuario. Si no se selecciona rol, se asigna por defecto "usuario".
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role ?? 'usuario',
        ]);

        // Disparamos el evento de registro y logueamos al usuario
        event(new Registered($user));
        auth()->login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
