<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Maneja una petición entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles  // recibirá 'entrenador','superadmin', etc.
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Si no está autenticado, redirige a login
        if (! $request->user()) {
            return redirect()->route('login');
        }

        // Comprueba si su role está en la lista
        if (! in_array($request->user()->role, $roles)) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
