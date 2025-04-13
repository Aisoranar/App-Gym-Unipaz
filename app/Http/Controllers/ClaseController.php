<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaseController extends Controller
{
    /**
     * Muestra todas las clases ordenadas por fecha descendente.
     */
    public function index()
    {
        $clases = Clase::where('user_id', Auth::id())
            ->orderBy('fecha', 'desc')
            ->get();
        return view('clases.index', compact('clases'));
    }

    /**
     * Muestra el formulario de creación de clase.
     */
    public function create()
    {
        return view('clases.create');
    }

    /**
     * Almacena una nueva clase en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha'       => 'required|date',
            'hora_inicio' => 'required', // Puedes agregar validación de formato (date_format) si se requiere
            'hora_fin'    => 'nullable',
        ]);
        $validated['user_id'] = Auth::id();
        Clase::create($validated);
        return redirect()->route('clases.index')->with('success', 'Clase creada correctamente.');
    }

    /**
     * Muestra los detalles de una clase.
     */
    public function show(Clase $clase)
    {
        if ($clase->user_id != Auth::id()) {
            abort(403);
        }
        return view('clases.show', compact('clase'));
    }

    /**
     * Muestra el formulario para editar una clase existente.
     */
    public function edit(Clase $clase)
    {
        if ($clase->user_id != Auth::id()) {
            abort(403);
        }
        return view('clases.edit', compact('clase'));
    }

    /**
     * Actualiza los datos de la clase.
     */
    public function update(Request $request, Clase $clase)
    {
        if ($clase->user_id != Auth::id()) {
            abort(403);
        }
        $validated = $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha'       => 'required|date',
            'hora_inicio' => 'required',
            'hora_fin'    => 'nullable',
        ]);
        $clase->update($validated);
        return redirect()->route('clases.index')->with('success', 'Clase actualizada correctamente.');
    }

    /**
     * Elimina una clase.
     */
    public function destroy(Clase $clase)
    {
        if ($clase->user_id != Auth::id()) {
            abort(403);
        }
        $clase->delete();
        return redirect()->route('clases.index')->with('success', 'Clase eliminada correctamente.');
    }
}
