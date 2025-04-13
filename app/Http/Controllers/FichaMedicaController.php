<?php

namespace App\Http\Controllers;

use App\Models\FichaMedica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FichaMedicaController extends Controller
{
    /**
     * Muestra la ficha médica:
     * - Si el usuario es superadmin o entrenador, muestra la lista completa (listaficha).
     * - Si el usuario es normal, muestra su ficha (o redirige a crear si aún no existe).
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'superadmin' || $user->role === 'entrenador') {
            $fichas = FichaMedica::orderBy('id', 'ASC')->get();
            return view('fichas.listaficha', compact('fichas'));
        }

        $ficha = FichaMedica::where('user_id', $user->id)->first();
        if ($ficha) {
            return view('fichas.show', compact('ficha'));
        }
        return redirect()->route('fichas.create')->with('error', 'No tienes ficha médica. Por favor, crea una.');
    }

    /**
     * Muestra el formulario para crear una ficha médica.
     * Solo se permite si el usuario aún no tiene una ficha.
     */
    public function create()
    {
        if (FichaMedica::where('user_id', Auth::id())->exists()) {
            $ficha = FichaMedica::where('user_id', Auth::id())->first();
            return redirect()->route('fichas.show', $ficha->id)
                ->with('error', 'Ya has creado tu ficha médica.');
        }
        return view('fichas.create');
    }

    /**
     * Almacena una nueva ficha médica.
     * Se establece el campo "nombre" automáticamente desde el usuario autenticado.
     */
    public function store(Request $request)
    {
        if (FichaMedica::where('user_id', Auth::id())->exists()) {
            $ficha = FichaMedica::where('user_id', Auth::id())->first();
            return redirect()->route('fichas.show', $ficha->id)
                ->with('error', 'Ya has creado tu ficha médica.');
        }

        $validated = $request->validate([
            'apellidos'         => 'required|string|max:255',
            // En creación, el campo 'nombre' se asigna automáticamente
            'fecha_nacimiento'  => 'required|date',
            'edad'              => 'required|integer',
            'sexo'              => 'required|in:F,M',
            'domicilio'         => 'required|string|max:255',
            'barrio'            => 'nullable|string|max:255',
            'telefonos'         => 'nullable|string|max:255',
            'tipo_sangre'       => 'required|string|max:10',
            'factor_rh'         => 'required|in:Positivo,Negativo',
            'lateralidad'       => 'required|in:Diestro,Zurdo',
            'actividad_fisica'  => 'nullable|string|max:255',
            'frecuencia_semanal'=> 'nullable|integer',
            'nombre_padre'      => 'nullable|string|max:255',
            'nombre_madre'      => 'nullable|string|max:255',
            'nombre_acudiente'  => 'nullable|string|max:255',
            'parentesco'        => 'nullable|string|max:255',
            'lesiones'          => 'nullable|string',
            'alergias'          => 'nullable|string',
            'padece_enfermedad' => 'nullable|boolean',
            'enfermedad'        => 'nullable|string|max:255',
        ]);

        // Asigna automáticamente el user_id y el campo "nombre" del usuario autenticado
        $validated['user_id'] = Auth::id();
        $validated['nombre'] = Auth::user()->name;

        FichaMedica::create($validated);
        $ficha = FichaMedica::where('user_id', Auth::id())->first();
        return redirect()->route('fichas.show', $ficha->id)
            ->with('success', 'Ficha Médica creada correctamente.');
    }

    /**
     * Muestra los detalles de una ficha médica.
     */
    public function show(FichaMedica $ficha)
    {
        if ($ficha->user_id != Auth::id() && !(Auth::user()->role === 'superadmin' || Auth::user()->role === 'entrenador')) {
            abort(403, 'No tienes permiso para ver esta ficha médica.');
        }
        return view('fichas.show', compact('ficha'));
    }

    /**
     * Muestra el formulario para editar la ficha médica.
     */
    public function edit(FichaMedica $ficha)
    {
        if ($ficha->user_id != Auth::id() && !(Auth::user()->role === 'superadmin' || Auth::user()->role === 'entrenador')) {
            abort(403, 'No tienes permiso para editar esta ficha médica.');
        }
        return view('fichas.edit', compact('ficha'));
    }

    /**
     * Actualiza la ficha médica.
     */
    public function update(Request $request, FichaMedica $ficha)
    {
        if ($ficha->user_id != Auth::id() && !(Auth::user()->role === 'superadmin' || Auth::user()->role === 'entrenador')) {
            abort(403, 'No tienes permiso para actualizar esta ficha médica.');
        }

        $validated = $request->validate([
            'apellidos'         => 'required|string|max:255',
            'nombre'            => 'required|string|max:255',
            'fecha_nacimiento'  => 'required|date',
            'edad'              => 'required|integer',
            'sexo'              => 'required|in:F,M',
            'domicilio'         => 'required|string|max:255',
            'barrio'            => 'nullable|string|max:255',
            'telefonos'         => 'nullable|string|max:255',
            'tipo_sangre'       => 'required|string|max:10',
            'factor_rh'         => 'required|in:Positivo,Negativo',
            'lateralidad'       => 'required|in:Diestro,Zurdo',
            'actividad_fisica'  => 'nullable|string|max:255',
            'frecuencia_semanal'=> 'nullable|integer',
            'nombre_padre'      => 'nullable|string|max:255',
            'nombre_madre'      => 'nullable|string|max:255',
            'nombre_acudiente'  => 'nullable|string|max:255',
            'parentesco'        => 'nullable|string|max:255',
            'lesiones'          => 'nullable|string',
            'alergias'          => 'nullable|string',
            'padece_enfermedad' => 'nullable|boolean',
            'enfermedad'        => 'nullable|string|max:255',
        ]);

        $ficha->update($validated);
        return redirect()->route('fichas.show', $ficha->id)
            ->with('success', 'Ficha Médica actualizada correctamente.');
    }

    /**
     * Elimina una ficha médica.
     */
    public function destroy(FichaMedica $ficha)
    {
        if ($ficha->user_id != Auth::id() && !(Auth::user()->role === 'superadmin' || Auth::user()->role === 'entrenador')) {
            abort(403, 'No tienes permiso para eliminar esta ficha médica.');
        }
        $ficha->delete();
        return redirect()->route('fichas.index')
            ->with('success', 'Ficha Médica eliminada correctamente.');
    }
}
