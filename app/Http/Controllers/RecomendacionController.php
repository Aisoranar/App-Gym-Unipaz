<?php

namespace App\Http\Controllers;

use App\Models\Recomendacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecomendacionController extends Controller
{
    /**
     * Muestra la lista de recomendaciones del usuario, ordenadas por fecha descendente.
     */
    public function index()
    {
        $recomendaciones = Recomendacion::where('user_id', Auth::id())
            ->orderBy('fecha', 'desc')
            ->get();
        return view('recomendaciones.index', compact('recomendaciones'));
    }

    /**
     * Muestra el formulario para crear una recomendación.
     */
    public function create()
    {
        return view('recomendaciones.create');
    }

    /**
     * Guarda una nueva recomendación.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'contenido' => 'required|string',
            'fecha'     => 'required|date',
        ]);
        $validated['user_id'] = Auth::id();
        Recomendacion::create($validated);
        return redirect()->route('recomendaciones.index')->with('success', 'Recomendación creada correctamente.');
    }

    /**
     * Muestra los detalles de una recomendación.
     */
    public function show(Recomendacion $recomendacion)
    {
        if ($recomendacion->user_id != Auth::id()) {
            abort(403);
        }
        return view('recomendaciones.show', compact('recomendacion'));
    }

    /**
     * Muestra el formulario para editar una recomendación.
     */
    public function edit(Recomendacion $recomendacion)
    {
        if ($recomendacion->user_id != Auth::id()) {
            abort(403);
        }
        return view('recomendaciones.edit', compact('recomendacion'));
    }

    /**
     * Actualiza la recomendación.
     */
    public function update(Request $request, Recomendacion $recomendacion)
    {
        if ($recomendacion->user_id != Auth::id()) {
            abort(403);
        }
        $validated = $request->validate([
            'contenido' => 'required|string',
            'fecha'     => 'required|date',
        ]);
        $recomendacion->update($validated);
        return redirect()->route('recomendaciones.index')->with('success', 'Recomendación actualizada correctamente.');
    }

    /**
     * Elimina una recomendación.
     */
    public function destroy(Recomendacion $recomendacion)
    {
        if ($recomendacion->user_id != Auth::id()) {
            abort(403);
        }
        $recomendacion->delete();
        return redirect()->route('recomendaciones.index')->with('success', 'Recomendación eliminada correctamente.');
    }
}
