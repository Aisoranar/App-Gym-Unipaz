<?php

namespace App\Http\Controllers;

use App\Models\Rutina;
use App\Models\Ejercicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RutinaController extends Controller
{
    /**
     * Muestra la lista de rutinas del usuario.
     */
    public function index()
    {
        $rutinas = Rutina::where('user_id', Auth::id())->get();
        return view('rutinas.index', compact('rutinas'));
    }

    /**
     * Muestra el formulario para crear una rutina.
     * Se incluye la lista de ejercicios disponibles para asignar a la rutina.
     */
    public function create()
    {
        $ejercicios = Ejercicio::where('user_id', Auth::id())->get();
        return view('rutinas.create', compact('ejercicios'));
    }

    /**
     * Almacena una nueva rutina y asigna los ejercicios si se han seleccionado.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'          => 'required|string|max:255',
            'descripcion'     => 'nullable|string',
            'dias_por_semana' => 'nullable|integer',
            'ejercicios'      => 'nullable|array'
        ]);
        $validated['user_id'] = Auth::id();

        $rutina = Rutina::create($validated);

        if (isset($validated['ejercicios'])) {
            // Se asocian los ejercicios seleccionados a través de la tabla pivote
            $rutina->ejercicios()->attach($validated['ejercicios']);
        }
        return redirect()->route('rutinas.index')->with('success', 'Rutina creada correctamente.');
    }

    /**
     * Muestra los detalles de la rutina.
     */
    public function show(Rutina $rutina)
    {
        if ($rutina->user_id != Auth::id()) {
            abort(403);
        }
        return view('rutinas.show', compact('rutina'));
    }

    /**
     * Muestra el formulario para editar una rutina.
     * Se pasan los ejercicios disponibles además de la rutina actual.
     */
    public function edit(Rutina $rutina)
    {
        if ($rutina->user_id != Auth::id()) {
            abort(403);
        }
        $ejercicios = Ejercicio::where('user_id', Auth::id())->get();
        return view('rutinas.edit', compact('rutina', 'ejercicios'));
    }

    /**
     * Actualiza la rutina y sincroniza los ejercicios asignados.
     */
    public function update(Request $request, Rutina $rutina)
    {
        if ($rutina->user_id != Auth::id()) {
            abort(403);
        }
        $validated = $request->validate([
            'nombre'          => 'required|string|max:255',
            'descripcion'     => 'nullable|string',
            'dias_por_semana' => 'nullable|integer',
            'ejercicios'      => 'nullable|array'
        ]);
        $rutina->update($validated);
        $rutina->ejercicios()->sync($validated['ejercicios'] ?? []);
        return redirect()->route('rutinas.index')->with('success', 'Rutina actualizada correctamente.');
    }

    /**
     * Elimina una rutina.
     */
    public function destroy(Rutina $rutina)
    {
        if ($rutina->user_id != Auth::id()) {
            abort(403);
        }
        $rutina->delete();
        return redirect()->route('rutinas.index')->with('success', 'Rutina eliminada correctamente.');
    }
}
