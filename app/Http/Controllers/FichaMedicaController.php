<?php

namespace App\Http\Controllers;

use App\Models\FichaMedica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FichaMedicaController extends Controller
{
    /**
     * Muestra las fichas médicas:
     * - Si el usuario es superadmin o entrenador, muestra todas (con opción de búsqueda).
     * - Si es usuario normal, se muestra solo la ficha correspondiente o se redirige a crear en caso de no existir.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->get('search');

        if ($user->role === 'superadmin' || $user->role === 'entrenador') {
            $query = FichaMedica::query();
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('apellidos', 'LIKE', "%{$search}%");
                });
            }
            $fichas = $query->orderBy('id', 'ASC')->get();
            return view('fichas.listaficha', compact('fichas'));
        }

        // Para usuario normal se obtiene solo la ficha que le pertenece.
        $ficha = FichaMedica::where('user_id', $user->id)->first();
        if ($ficha) {
            return view('fichas.show', compact('ficha'));
        }
        return redirect()->route('fichas.create')->with('error', 'No tienes ficha médica. Por favor, crea una.');
    }

    /**
     * Muestra el formulario para crear una ficha médica.
     * Solo se permite si el usuario aún no tiene ficha.
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
     * Se asigna automáticamente el user_id y el nombre del usuario autenticado.
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

        // Se asignan los campos que definen la relación con el usuario.
        $validated['user_id'] = Auth::id();
        $validated['nombre'] = Auth::user()->name;

        $ficha = FichaMedica::create($validated);
        return redirect()->route('fichas.show', $ficha->id)
            ->with('success', 'Ficha Médica creada correctamente.');
    }

    /**
     * Muestra los detalles de la ficha médica.
     */
    public function show(FichaMedica $ficha)
    {
        // Solo el dueño o usuarios con rol especial pueden ver la ficha.
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
        // Se valida que sólo el dueño o roles especiales puedan editar.
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
        // Se comprueba el permiso para actualizar.
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

        // No se permite cambiar el usuario asociado.
        $ficha->update($validated);
        return redirect()->route('fichas.show', $ficha->id)
            ->with('success', 'Ficha Médica actualizada correctamente.');
    }

    /**
     * Elimina una ficha médica.
     */
    public function destroy(FichaMedica $ficha)
    {
        // Solo el dueño o roles especiales pueden eliminar la ficha.
        if ($ficha->user_id != Auth::id() && !(Auth::user()->role === 'superadmin' || Auth::user()->role === 'entrenador')) {
            abort(403, 'No tienes permiso para eliminar esta ficha médica.');
        }
        $ficha->delete();
        return redirect()->route('fichas.index')
            ->with('success', 'Ficha Médica eliminada correctamente.');
    }
}
