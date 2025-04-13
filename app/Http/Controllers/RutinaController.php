<?php

namespace App\Http\Controllers;

use App\Models\Rutina;
use App\Models\Ejercicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RutinaController extends Controller
{
    /**
     * Muestra la lista de rutinas personales del usuario.
     */
    public function index()
    {
        $rutinas = Rutina::where('user_id', Auth::id())->get();
        return view('rutinas.index', compact('rutinas'));
    }

    /**
     * Muestra el formulario para crear una nueva rutina.
     * Se incluye la lista de ejercicios disponibles para asignar (opcional).
     */
    public function create()
    {
        $ejercicios = Ejercicio::where('user_id', Auth::id())->get();
        return view('rutinas.create', compact('ejercicios'));
    }

    /**
     * Almacena una nueva rutina y, si se seleccionan, asigna los ejercicios a través de la tabla pivote.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'          => 'required|string|max:255',
            'descripcion'     => 'nullable|string',
            'fecha_inicio'    => 'nullable|date',
            'fecha_fin'       => 'nullable|date|after_or_equal:fecha_inicio',
            'hora_inicio'     => 'nullable|date_format:H:i',
            'hora_fin'        => 'nullable|date_format:H:i|after:hora_inicio',
            'dias'            => 'nullable|array',   // Array con los días seleccionados
            'estado'          => 'nullable|string|max:50',
            'objetivo'        => 'nullable|string|max:255',
            'intensidad'      => 'nullable|string|max:50',
            'notas'           => 'nullable|string',
            'ejercicios'      => 'nullable|array'
        ]);
    
        $validated['user_id'] = Auth::id();
    
        // Creación de la rutina
        $rutina = Rutina::create($validated);
    
        // Asignar ejercicios si se seleccionaron
        if (isset($validated['ejercicios'])) {
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
            abort(403, 'No tienes permiso para ver esta rutina.');
        }
        // Cargar los ejercicios asociados para mostrarlos en la vista
        $rutina->load('ejercicios');
        return view('rutinas.show', compact('rutina'));
    }

    /**
     * Muestra el formulario para editar la rutina.
     */
    public function edit(Rutina $rutina)
    {
        if ($rutina->user_id != Auth::id()) {
            abort(403, 'No tienes permiso para editar esta rutina.');
        }
        $ejercicios = Ejercicio::where('user_id', Auth::id())->get();
        return view('rutinas.edit', compact('rutina', 'ejercicios'));
    }

    /**
     * Actualiza la rutina y sincroniza los ejercicios asociados.
     */
    public function update(Request $request, Rutina $rutina)
    {
        if ($rutina->user_id != Auth::id()) {
            abort(403, 'No tienes permiso para actualizar esta rutina.');
        }
        $validated = $request->validate([
            'nombre'          => 'required|string|max:255',
            'descripcion'     => 'nullable|string',
            'fecha_inicio'    => 'nullable|date',
            'fecha_fin'       => 'nullable|date|after_or_equal:fecha_inicio',
            'hora_inicio'     => 'nullable|date_format:H:i',
            'hora_fin'        => 'nullable|date_format:H:i|after:hora_inicio',
            'dias'            => 'nullable|array',
            'estado'          => 'nullable|string|max:50',
            'objetivo'        => 'nullable|string|max:255',
            'intensidad'      => 'nullable|string|max:50',
            'notas'           => 'nullable|string',
            'ejercicios'      => 'nullable|array'
        ]);
        $rutina->update($validated);
        $rutina->ejercicios()->sync($validated['ejercicios'] ?? []);

        return redirect()->route('rutinas.index')->with('success', 'Rutina actualizada correctamente.');
    }

    /**
     * Elimina la rutina.
     */
    public function destroy(Rutina $rutina)
    {
        if ($rutina->user_id != Auth::id()) {
            abort(403, 'No tienes permiso para eliminar esta rutina.');
        }
        $rutina->delete();
        return redirect()->route('rutinas.index')->with('success', 'Rutina eliminada correctamente.');
    }
}
