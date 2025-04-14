<?php

namespace App\Http\Controllers;

use App\Models\Ejercicio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EjercicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // Solo entrenadores y superadmin pueden crear, editar y borrar
        $this->middleware('role:entrenador,superadmin')
             ->except(['index', 'show']);
    }
    
    public function index()
    {
        $user = Auth::user();
        
        // Si el usuario es entrenador o superadmin, se muestran todos los ejercicios.
        if ($user->role === 'entrenador' || $user->role === 'superadmin') {
            $ejercicios = Ejercicio::orderBy('fecha', 'desc')->get();
        } else {
            // Si el usuario tiene rol "usuario", se muestran sólo los ejercicios creados por entrenadores o superadmin.
            $ids = User::whereIn('role', ['entrenador', 'superadmin'])->pluck('id');
            $ejercicios = Ejercicio::whereIn('user_id', $ids)
                ->orderBy('fecha', 'desc')
                ->get();
        }

        return view('ejercicios.index', compact('ejercicios'));
    }

    public function create()
    {
        // Este método solo lo pueden acceder entrenadores y superadmin (middleware aplicado)
        return view('ejercicios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_ejercicio'   => 'required|string|max:255',
            'descripcion'        => 'nullable|string',
            'nivel_dificultad'   => 'required|in:Baja,Media,Alta',
            'grupo_muscular'     => 'nullable|string|max:100',
            'series'             => 'nullable|integer',
            'repeticiones'       => 'nullable|integer',
            'calorias_aprox'     => 'nullable|integer',
            'duracion'           => 'nullable|integer',
            'fecha'              => 'required|date',
            'foto'               => 'nullable|image|max:2048',        // máximo 2MB
            'video'              => 'nullable|mimetypes:video/mp4|max:10240', // máximo 10MB
        ]);

        $validated['user_id'] = Auth::id();

        // Subida de archivos (foto y video)
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')
                ->store('ejercicios/fotos', 'public');
        }
        if ($request->hasFile('video')) {
            $validated['video'] = $request->file('video')
                ->store('ejercicios/videos', 'public');
        }

        Ejercicio::create($validated);

        return redirect()->route('ejercicios.index')
                         ->with('success', 'Ejercicio registrado correctamente.');
    }

    public function show(Ejercicio $ejercicio)
    {
        $user = Auth::user();

        // Para usuarios normales, permitir ver solo si el ejercicio fue creado por entrenador o superadmin.
        if ($user->role === 'usuario') {
            // Accedemos al creador del ejercicio mediante la relación (ver modelo Ejercicio).
            if ($ejercicio->user->role === 'usuario') {
                abort(403, 'No tienes permiso para ver este ejercicio.');
            }
        }
        return view('ejercicios.show', compact('ejercicio'));
    }

    public function edit(Ejercicio $ejercicio)
    {
        // El middleware ya restringe este método, pero se verifica de forma extra.
        abort_if($ejercicio->user_id != Auth::id(), 403);

        return view('ejercicios.edit', compact('ejercicio'));
    }

    public function update(Request $request, Ejercicio $ejercicio)
    {
        abort_if($ejercicio->user_id != Auth::id(), 403);

        $validated = $request->validate([
            'nombre_ejercicio'   => 'required|string|max:255',
            'descripcion'        => 'nullable|string',
            'nivel_dificultad'   => 'required|in:Baja,Media,Alta',
            'grupo_muscular'     => 'nullable|string|max:100',
            'series'             => 'nullable|integer',
            'repeticiones'       => 'nullable|integer',
            'calorias_aprox'     => 'nullable|integer',
            'duracion'           => 'nullable|integer',
            'fecha'              => 'required|date',
            'foto'               => 'nullable|image|max:2048',
            'video'              => 'nullable|mimetypes:video/mp4|max:10240',
        ]);

        // Reemplazo de archivos, si se actualiza alguno, borrando el anterior
        if ($request->hasFile('foto')) {
            if ($ejercicio->foto) {
                Storage::disk('public')->delete($ejercicio->foto);
            }
            $validated['foto'] = $request->file('foto')
                ->store('ejercicios/fotos', 'public');
        }
        if ($request->hasFile('video')) {
            if ($ejercicio->video) {
                Storage::disk('public')->delete($ejercicio->video);
            }
            $validated['video'] = $request->file('video')
                ->store('ejercicios/videos', 'public');
        }

        $ejercicio->update($validated);

        return redirect()->route('ejercicios.index')
                         ->with('success', 'Ejercicio actualizado correctamente.');
    }

    public function destroy(Ejercicio $ejercicio)
    {
        abort_if($ejercicio->user_id != Auth::id(), 403);

        // Borrar archivos asociados, de existir
        if ($ejercicio->foto) {
            Storage::disk('public')->delete($ejercicio->foto);
        }
        if ($ejercicio->video) {
            Storage::disk('public')->delete($ejercicio->video);
        }

        $ejercicio->delete();

        return redirect()->route('ejercicios.index')
                         ->with('success', 'Ejercicio eliminado correctamente.');
    }
}
