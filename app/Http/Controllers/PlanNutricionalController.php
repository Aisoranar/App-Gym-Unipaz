<?php

namespace App\Http\Controllers;

use App\Models\PlanNutricional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanNutricionalController extends Controller
{
    /**
     * Muestra la lista de planes nutricionales del usuario.
     */
    public function index()
    {
        $planes = PlanNutricional::where('user_id', Auth::id())->get();
        return view('planes.index', compact('planes'));
    }

    /**
     * Muestra el formulario para crear un plan nutricional.
     */
    public function create()
    {
        return view('planes.create');
    }

    /**
     * Guarda un nuevo plan nutricional.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'           => 'required|string|max:255',
            'descripcion'      => 'nullable|string',
            'calorias_diarias' => 'nullable|integer',
            'recomendaciones'  => 'nullable|string',
        ]);
        $validated['user_id'] = Auth::id();
        PlanNutricional::create($validated);
        return redirect()->route('planes.index')->with('success', 'Plan Nutricional creado correctamente.');
    }

    /**
     * Muestra los detalles de un plan nutricional.
     */
    public function show(PlanNutricional $plan)
    {
        if ($plan->user_id != Auth::id()) {
            abort(403);
        }
        return view('planes.show', compact('plan'));
    }

    /**
     * Muestra el formulario para editar un plan nutricional.
     */
    public function edit(PlanNutricional $plan)
    {
        if ($plan->user_id != Auth::id()) {
            abort(403);
        }
        return view('planes.edit', compact('plan'));
    }

    /**
     * Actualiza el plan nutricional.
     */
    public function update(Request $request, PlanNutricional $plan)
    {
        if ($plan->user_id != Auth::id()) {
            abort(403);
        }
        $validated = $request->validate([
            'nombre'           => 'required|string|max:255',
            'descripcion'      => 'nullable|string',
            'calorias_diarias' => 'nullable|integer',
            'recomendaciones'  => 'nullable|string',
        ]);
        $plan->update($validated);
        return redirect()->route('planes.index')->with('success', 'Plan Nutricional actualizado correctamente.');
    }

    /**
     * Elimina un plan nutricional.
     */
    public function destroy(PlanNutricional $plan)
    {
        if ($plan->user_id != Auth::id()) {
            abort(403);
        }
        $plan->delete();
        return redirect()->route('planes.index')->with('success', 'Plan Nutricional eliminado correctamente.');
    }
}
