<?php

namespace App\Http\Controllers;

use App\Models\FichaMedica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FichaMedicaController extends Controller
{
    /**
     * Muestra la lista de fichas médicas del usuario.
     */
    public function index()
    {
        $fichas = FichaMedica::where('user_id', Auth::id())->get();
        return view('fichas.index', compact('fichas'));
    }

    /**
     * Muestra el formulario para crear una ficha médica.
     */
    public function create()
    {
        return view('fichas.create');
    }

    /**
     * Almacena una nueva ficha médica.
     */
    public function store(Request $request)
    {
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
            // Los campos opcionales adicionales pueden validarse si los incluyes en el formulario:
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
        $validated['user_id'] = Auth::id();
        FichaMedica::create($validated);
        return redirect()->route('fichas.index')->with('success', 'Ficha Médica creada correctamente.');
    }

    /**
     * Muestra los detalles de una ficha médica.
     */
    public function show(FichaMedica $ficha)
    {
        if ($ficha->user_id != Auth::id()) {
            abort(403);
        }
        return view('fichas.show', compact('ficha'));
    }

    /**
     * Muestra el formulario para editar una ficha médica.
     */
    public function edit(FichaMedica $ficha)
    {
        if ($ficha->user_id != Auth::id()) {
            abort(403);
        }
        return view('fichas.edit', compact('ficha'));
    }

    /**
     * Actualiza la ficha médica.
     */
    public function update(Request $request, FichaMedica $ficha)
    {
        if ($ficha->user_id != Auth::id()) {
            abort(403);
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
        ]);
        $ficha->update($validated);
        return redirect()->route('fichas.index')->with('success', 'Ficha Médica actualizada correctamente.');
    }

    /**
     * Elimina una ficha médica.
     */
    public function destroy(FichaMedica $ficha)
    {
        if ($ficha->user_id != Auth::id()) {
            abort(403);
        }
        $ficha->delete();
        return redirect()->route('fichas.index')->with('success', 'Ficha Médica eliminada correctamente.');
    }
}
