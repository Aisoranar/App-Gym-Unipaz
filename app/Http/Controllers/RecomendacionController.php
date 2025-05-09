<?php

namespace App\Http\Controllers;

use App\Models\Recomendacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecomendacionController extends Controller
{
    public function __construct()
    {
        // Requiere autenticación para todas las acciones
        $this->middleware('auth');

        // Solo entrenadores y superadmin/admin pueden crear, editar y eliminar
        $this->middleware('role:entrenador|superadmin|admin')
             ->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of recommendations.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $user   = Auth::user();

        if ($user->role === 'usuario') {
            $query = Recomendacion::where('user_id', $user->id);
        } elseif ($user->role === 'entrenador') {
            $query = Recomendacion::where('creado_por', $user->id);
        } elseif (in_array($user->role, ['superadmin', 'admin'])) {
            $query = Recomendacion::query();
        } else {
            abort(403);
        }

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $recomendaciones = $query->orderBy('fecha', 'desc')->get();
        return view('recomendaciones.index', compact('recomendaciones', 'search'));
    }

    /**
     * Show the form for creating a new recommendation.
     */
    public function create()
    {
        $usuarios = User::where('role', 'usuario')->get();
        return view('recomendaciones.create', compact('usuarios'));
    }

    /**
     * Store a newly created recommendation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'contenido' => 'required|string',
            'fecha'     => 'required|date',
            'user_id'   => 'required|exists:users,id',
        ]);

        $dest = User::findOrFail($validated['user_id']);
        if ($dest->role !== 'usuario') {
            return back()->withErrors('El destinatario debe ser de rol usuario.');
        }

        $validated['creado_por'] = Auth::id();
        Recomendacion::create($validated);

        return redirect()->route('recomendaciones.index')
                         ->with('success', 'Recomendación creada correctamente.');
    }

    /**
     * Display the specified recommendation.
     */
    public function show(Recomendacion $recomendacion)
    {
        $this->authorizeView($recomendacion);
        return view('recomendaciones.show', compact('recomendacion'));
    }

    /**
     * Show the form for editing the specified recommendation.
     */
    public function edit(Recomendacion $recomendacion)
    {
        $this->authorizeXmanage($recomendacion);
        $usuarios = User::where('role', 'usuario')->get();
        return view('recomendaciones.edit', compact('recomendacion', 'usuarios'));
    }

    /**
     * Update the specified recommendation in storage.
     */
    public function update(Request $request, Recomendacion $recomendacion)
    {
        $this->authorizeXmanage($recomendacion);

        $validated = $request->validate([
            'contenido' => 'required|string',
            'fecha'     => 'required|date',
            'user_id'   => 'required|exists:users,id',
        ]);

        $dest = User::findOrFail($validated['user_id']);
        if ($dest->role !== 'usuario') {
            return back()->withErrors('El destinatario debe ser usuario.');
        }

        $recomendacion->update($validated);
        return redirect()->route('recomendaciones.index')
                         ->with('success', 'Recomendación actualizada correctamente.');
    }

    /**
     * Remove the specified recommendation from storage.
     */
    public function destroy(Recomendacion $recomendacion)
    {
        $this->authorizeXmanage($recomendacion);
        $recomendacion->delete();
        return redirect()->route('recomendaciones.index')
                         ->with('success', 'Recomendación eliminada correctamente.');
    }

    /**
     * Autoriza la vista/show para usuarios y entrenadores/admin.
     */
    private function authorizeView(Recomendacion $rec)
    {
        $user = Auth::user();
        if ($user->role === 'usuario' && $rec->user_id != $user->id) {
            abort(403);
        }
        if ($user->role === 'entrenador' && $rec->creado_por != $user->id) {
            abort(403);
        }
        // superadmin/admin pueden ver todo
    }

    /**
     * Autoriza edición, actualización y eliminación para entrenadores/admin.
     */
    private function authorizeXmanage(Recomendacion $rec)
    {
        $user = Auth::user();
        if ($user->role === 'entrenador' && $rec->creado_por != $user->id) {
            abort(403);
        }
        // superadmin/admin pueden editar/borrar cualquiera
    }
}
