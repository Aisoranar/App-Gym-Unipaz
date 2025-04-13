<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaseController extends Controller
{
    /**
     * Muestra las clases disponibles.
     * - Si el usuario es "usuario", se muestran todas las clases activas.
     * - Si el usuario es "entrenador" o "superadmin", se muestran solo las creadas por ellos.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'usuario') {
            $clases = Clase::where('is_active', true)->orderBy('fecha', 'desc')->get();
        } else {
            $clases = Clase::where('user_id', $user->id)
                ->orderBy('fecha', 'desc')
                ->get();
        }

        return view('clases.index', compact('clases'));
    }

    /**
     * Muestra el formulario de creación de clase.
     * Solo accesible para entrenadores y superadmin.
     */
    public function create()
    {
        if (!in_array(Auth::user()->role, ['entrenador', 'superadmin'])) {
            abort(403);
        }
        return view('clases.create');
    }

    /**
     * Almacena una nueva clase en la base de datos.
     */
    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, ['entrenador', 'superadmin'])) {
            abort(403);
        }

        $validated = $request->validate([
            'titulo'            => 'required|string|max:255',
            'descripcion'       => 'nullable|string',
            'objetivos'         => 'nullable|string',
            'fecha'             => 'required|date',
            'hora_inicio'       => 'required',
            'hora_fin'          => 'nullable',
            'nivel'             => 'nullable|string|max:100',
            'max_participantes' => 'nullable|integer|min:1',
            'imagen'            => 'nullable|image|max:2048',
            'is_active'         => 'required|in:0,1',
        ]);

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $path = $file->store('images', 'public');
            $validated['imagen'] = $path;
        }

        $validated['user_id'] = Auth::id();
        // Convertir el valor recibido a booleano (1 => true, 0 => false)
        $validated['is_active'] = $request->input('is_active') == "1";

        Clase::create($validated);
        return redirect()->route('clases.index')->with('success', 'Clase creada correctamente.');
    }

    /**
     * Muestra los detalles de una clase.
     * Se muestran todos los detalles, y si el usuario es "usuario"
     * se visualizan opciones para unirse o salirse (según su inscripción).
     */
    public function show(Clase $clase)
    {
        // En este caso se permite ver la clase a cualquier usuario;
        // se puede agregar validación adicional según sea necesario
        return view('clases.show', compact('clase'));
    }

    /**
     * Muestra el formulario para editar una clase existente.
     */
    public function edit(Clase $clase)
    {
        if (!in_array(Auth::user()->role, ['entrenador', 'superadmin']) || $clase->user_id !== Auth::id()) {
            abort(403);
        }
        return view('clases.edit', compact('clase'));
    }

    /**
     * Actualiza los datos de una clase.
     */
    public function update(Request $request, Clase $clase)
    {
        if (!in_array(Auth::user()->role, ['entrenador', 'superadmin']) || $clase->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'titulo'            => 'required|string|max:255',
            'descripcion'       => 'nullable|string',
            'objetivos'         => 'nullable|string',
            'fecha'             => 'required|date',
            'hora_inicio'       => 'required',
            'hora_fin'          => 'nullable',
            'nivel'             => 'nullable|string|max:100',
            'max_participantes' => 'nullable|integer|min:1',
            'imagen'            => 'nullable|image|max:2048',
            'is_active'         => 'required|in:0,1',
        ]);

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $path = $file->store('images', 'public');
            $validated['imagen'] = $path;
        }

        // Convertir el valor de is_active a booleano
        $validated['is_active'] = $request->input('is_active') == "1";

        $clase->update($validated);
        return redirect()->route('clases.index')->with('success', 'Clase actualizada correctamente.');
    }

    /**
     * Elimina una clase.
     */
    public function destroy(Clase $clase)
    {
        if (!in_array(Auth::user()->role, ['entrenador', 'superadmin']) || $clase->user_id !== Auth::id()) {
            abort(403);
        }
        $clase->delete();
        return redirect()->route('clases.index')->with('success', 'Clase eliminada correctamente.');
    }

    /**
     * Permite a un usuario unirse a una clase.
     * Solo usuarios con rol "usuario" pueden unirse.
     */
    public function join(Clase $clase)
    {
        if (Auth::user()->role !== 'usuario') {
            abort(403);
        }
        // Evitar que el usuario se inscriba dos veces
        if (!$clase->participants->contains(Auth::id())) {
            $clase->participants()->attach(Auth::id());
        }
        return redirect()->back()->with('success', 'Te has unido a la clase.');
    }

    /**
     * Permite a un usuario salirse de una clase en la que ya está inscrito.
     */
    public function leave(Clase $clase)
    {
        if (Auth::user()->role !== 'usuario') {
            abort(403);
        }
        $clase->participants()->detach(Auth::id());
        return redirect()->back()->with('success', 'Te has salido de la clase.');
    }
}
