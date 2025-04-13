<?php

namespace App\Http\Controllers;

use App\Models\Recomendacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecomendacionController extends Controller
{
    /**
     * Muestra la lista de recomendaciones.
     * - Si el usuario es de rol "usuario": se muestran las recomendaciones asignadas a él.
     * - Si el usuario es "entrenador": se muestran las recomendaciones creadas por él.
     * - Si es "superadmin": se muestran todas las recomendaciones.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $user = Auth::user();
        
        if ($user->role === 'usuario') {
            $query = Recomendacion::where('user_id', $user->id);
        } elseif ($user->role === 'entrenador') {
            $query = Recomendacion::where('creado_por', $user->id);
        } else { // superadmin
            $query = Recomendacion::query();
        }
        
        // Filtrar por el usuario destinatario (relación user)
        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        
        $recomendaciones = $query->orderBy('fecha', 'desc')->get();
        return view('recomendaciones.index', compact('recomendaciones', 'search'));
    }

    /**
     * Muestra el formulario para crear una recomendación.
     * Solo puede acceder un usuario con rol "entrenador" o "superadmin".
     */
    public function create()
    {
        if (!in_array(Auth::user()->role, ['entrenador', 'superadmin'])) {
            abort(403, 'No tienes permisos para crear una recomendación.');
        }
        // Obtiene todos los usuarios con rol "usuario" para asignarles la recomendación
        $usuarios = User::where('role', 'usuario')->get();
        return view('recomendaciones.create', compact('usuarios'));
    }

    /**
     * Guarda una nueva recomendación.
     * Solo los usuarios "entrenador" o "superadmin" pueden crear.
     */
    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, ['entrenador', 'superadmin'])) {
            abort(403, 'No tienes permisos para crear una recomendación.');
        }

        $validated = $request->validate([
            'contenido' => 'required|string',
            'fecha'     => 'required|date',
            'user_id'   => 'required|exists:users,id', // Usuario destinatario
        ]);

        // Verifica que el usuario seleccionado tenga rol "usuario"
        $usuario = User::find($validated['user_id']);
        if ($usuario->role !== 'usuario') {
            return redirect()->back()->withErrors('El usuario seleccionado no tiene el rol adecuado.');
        }

        // Asigna el creador
        $validated['creado_por'] = Auth::id();

        Recomendacion::create($validated);
        return redirect()->route('recomendaciones.index')->with('success', 'Recomendación creada correctamente.');
    }

    /**
     * Muestra los detalles de una recomendación.
     * El acceso se permite si:
     * - El usuario es "usuario" y la recomendación le fue asignada (user_id).
     * - El usuario es "entrenador" y la recomendación fue creada por él.
     * - El usuario es "superadmin" tiene acceso total.
     */
    public function show(Recomendacion $recomendacion)
    {
        $user = Auth::user();
        if ($user->role === 'usuario' && $recomendacion->user_id != $user->id) {
            abort(403);
        }
        if ($user->role === 'entrenador' && $recomendacion->creado_por != $user->id) {
            abort(403);
        }
        // Superadmin puede ver cualquier recomendación
        return view('recomendaciones.show', compact('recomendacion'));
    }

    /**
     * Muestra el formulario para editar una recomendación.
     * Solo el creador (entrenador o superadmin) podrá editar.
     */
    public function edit(Recomendacion $recomendacion)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['entrenador', 'superadmin'])) {
            abort(403, 'No tienes permisos para editar esta recomendación.');
        }
        if ($user->role === 'entrenador' && $recomendacion->creado_por != $user->id) {
            abort(403);
        }
        $usuarios = User::where('role', 'usuario')->get();
        return view('recomendaciones.edit', compact('recomendacion', 'usuarios'));
    }

    /**
     * Actualiza la recomendación.
     * Solo el creador (entrenador o superadmin) podrá actualizar.
     */
    public function update(Request $request, Recomendacion $recomendacion)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['entrenador', 'superadmin'])) {
            abort(403, 'No tienes permisos para actualizar esta recomendación.');
        }
        if ($user->role === 'entrenador' && $recomendacion->creado_por != $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'contenido' => 'required|string',
            'fecha'     => 'required|date',
            'user_id'   => 'required|exists:users,id',
        ]);

        $usuario = User::find($validated['user_id']);
        if ($usuario->role !== 'usuario') {
            return redirect()->back()->withErrors('El usuario seleccionado no tiene el rol adecuado.');
        }

        $recomendacion->update($validated);
        return redirect()->route('recomendaciones.index')->with('success', 'Recomendación actualizada correctamente.');
    }

    /**
     * Elimina una recomendación.
     * Solo el creador (entrenador o superadmin) podrá eliminar.
     */
    public function destroy(Recomendacion $recomendacion)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['entrenador', 'superadmin'])) {
            abort(403, 'No tienes permisos para eliminar esta recomendación.');
        }
        if ($user->role === 'entrenador' && $recomendacion->creado_por != $user->id) {
            abort(403);
        }
        $recomendacion->delete();
        return redirect()->route('recomendaciones.index')->with('success', 'Recomendación eliminada correctamente.');
    }
}
