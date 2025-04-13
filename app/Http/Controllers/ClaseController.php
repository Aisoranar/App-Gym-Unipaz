<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaseController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'usuario') {
            $clases = Clase::where('is_active', true)
                ->orderBy('fecha', 'desc')
                ->get();
        } else {
            $clases = Clase::where('user_id', $user->id)
                ->orderBy('fecha', 'desc')
                ->get();
        }

        foreach ($clases as $clase) {
            $clase->updateStatusIfExpired();
        }

        return view('clases.index', compact('clases'));
    }

    public function create()
    {
        if (!in_array(Auth::user()->role, ['entrenador', 'superadmin'])) {
            abort(403);
        }
        return view('clases.create');
    }

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
            'is_active'         => 'required|boolean',
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')
                                     ->store('images', 'public');
        }

        $validated['user_id']   = Auth::id();
        $validated['is_active'] = $request->boolean('is_active');

        Clase::create($validated);

        return redirect()->route('clases.index')
                         ->with('success', 'Clase creada correctamente.');
    }

    public function show(Clase $clase)
    {
        $clase->updateStatusIfExpired();
        return view('clases.show', compact('clase'));
    }

    public function edit(Clase $clase)
    {
        if (!in_array(Auth::user()->role, ['entrenador', 'superadmin'])
            || $clase->user_id !== Auth::id()) {
            abort(403);
        }
        return view('clases.edit', compact('clase'));
    }

    public function update(Request $request, Clase $clase)
    {
        if (!in_array(Auth::user()->role, ['entrenador', 'superadmin'])
            || $clase->user_id !== Auth::id()) {
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
            'is_active'         => 'required|boolean',
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')
                                     ->store('images', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $clase->update($validated);

        return redirect()->route('clases.index')
                         ->with('success', 'Clase actualizada correctamente.');
    }

    public function destroy(Clase $clase)
    {
        if (!in_array(Auth::user()->role, ['entrenador', 'superadmin'])
            || $clase->user_id !== Auth::id()) {
            abort(403);
        }
        $clase->delete();
        return redirect()->route('clases.index')
                         ->with('success', 'Clase eliminada correctamente.');
    }

    public function join(Clase $clase)
    {
        if (Auth::user()->role !== 'usuario') {
            abort(403);
        }
        if (!$clase->participants->contains(Auth::id())) {
            $clase->participants()->attach(Auth::id());
        }
        return redirect()->back()->with('success', 'Te has unido a la clase.');
    }

    public function leave(Clase $clase)
    {
        if (Auth::user()->role !== 'usuario') {
            abort(403);
        }
        $clase->participants()->detach(Auth::id());
        return redirect()->back()->with('success', 'Te has salido de la clase.');
    }

    public function historial()
    {
        $historial = Auth::user()
                          ->participaciones()
                          ->orderBy('fecha', 'desc')
                          ->get();
        return view('clases.historialclases', compact('historial'));
    }
}