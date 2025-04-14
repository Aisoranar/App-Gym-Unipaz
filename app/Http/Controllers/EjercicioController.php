<?php

namespace App\Http\Controllers;

use App\Models\Ejercicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EjercicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    
        // Solo 'entrenador' y 'superadmin' pueden crear/editar/borrar
        $this->middleware('role:entrenador,superadmin')
             ->except(['index', 'show']);
    }
    

    public function index()
    {
        // Los usuarios ven solo sus propios ejercicios
        $ejercicios = Ejercicio::where('user_id', Auth::id())
            ->orderBy('fecha', 'desc')
            ->get();

        return view('ejercicios.index', compact('ejercicios'));
    }

    public function create()
    {
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
            'foto'               => 'nullable|image|max:2048',        // max 2MB
            'video'              => 'nullable|mimetypes:video/mp4|max:10240', // max 10MB
        ]);

        $validated['user_id'] = Auth::id();

        // Subida de archivos
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
        abort_if($ejercicio->user_id != Auth::id(), 403);

        return view('ejercicios.show', compact('ejercicio'));
    }

    public function edit(Ejercicio $ejercicio)
    {
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

        // Reemplazo de archivos si vienen nuevos
        if ($request->hasFile('foto')) {
            // borrar anterior
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

        // borrar archivos asociados
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
