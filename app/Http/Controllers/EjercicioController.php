<?php

namespace App\Http\Controllers;

use App\Models\Ejercicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EjercicioController extends Controller
{
    /**
     * Muestra la lista de ejercicios, ordenados por fecha descendente.
     */
    public function index()
    {
        $ejercicios = Ejercicio::where('user_id', Auth::id())
            ->orderBy('fecha', 'desc')
            ->get();
        return view('ejercicios.index', compact('ejercicios'));
    }

    /**
     * Muestra el formulario para crear un nuevo ejercicio.
     */
    public function create()
    {
        return view('ejercicios.create');
    }

    /**
     * Guarda un nuevo ejercicio.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_ejercicio' => 'required|string|max:255',
            'descripcion'      => 'nullable|string',
            'series'           => 'nullable|integer',
            'repeticiones'     => 'nullable|integer',
            'duracion'         => 'nullable|integer',
            'fecha'            => 'required|date',
        ]);
        $validated['user_id'] = Auth::id();
        Ejercicio::create($validated);
        return redirect()->route('ejercicios.index')->with('success', 'Ejercicio registrado correctamente.');
    }

    /**
     * Muestra los detalles de un ejercicio.
     */
    public function show(Ejercicio $ejercicio)
    {
        if ($ejercicio->user_id != Auth::id()) {
            abort(403);
        }
        return view('ejercicios.show', compact('ejercicio'));
    }

    /**
     * Muestra el formulario para editar un ejercicio.
     */
    public function edit(Ejercicio $ejercicio)
    {
        if ($ejercicio->user_id != Auth::id()) {
            abort(403);
        }
        return view('ejercicios.edit', compact('ejercicio'));
    }

    /**
     * Actualiza un ejercicio.
     */
    public function update(Request $request, Ejercicio $ejercicio)
    {
        if ($ejercicio->user_id != Auth::id()) {
            abort(403);
        }
        $validated = $request->validate([
            'nombre_ejercicio' => 'required|string|max:255',
            'descripcion'      => 'nullable|string',
            'series'           => 'nullable|integer',
            'repeticiones'     => 'nullable|integer',
            'duracion'         => 'nullable|integer',
            'fecha'            => 'required|date',
        ]);
        $ejercicio->update($validated);
        return redirect()->route('ejercicios.index')->with('success', 'Ejercicio actualizado correctamente.');
    }

    /**
     * Elimina un ejercicio.
     */
    public function destroy(Ejercicio $ejercicio)
    {
        if ($ejercicio->user_id != Auth::id()) {
            abort(403);
        }
        $ejercicio->delete();
        return redirect()->route('ejercicios.index')->with('success', 'Ejercicio eliminado correctamente.');
    }
}
