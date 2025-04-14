<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Ejercicio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    /**
     * Muestra la vista del calendario de asistencia.
     */
    public function index()
    {
        $user = Auth::user();

        // Si el usuario es normal, se muestran los ejercicios creados por entrenadores y superadmin,
        // ya que ellos son los que pueden crear ejercicios para realizar.
        if ($user->role === 'usuario') {
            $ids = User::whereIn('role', ['entrenador', 'superadmin'])->pluck('id');
            $ejercicios = Ejercicio::whereIn('user_id', $ids)->get();
        } else {
            // Si el usuario es entrenador o superadmin, se muestran sus propios ejercicios.
            $ejercicios = Ejercicio::where('user_id', $user->id)->get();
        }

        return view('asistencias.calendario', compact('ejercicios'));
    }

    /**
     * Retorna los eventos de asistencia en formato JSON para FullCalendar.
     */
    public function eventos()
    {
        $asistencias = Asistencia::with('ejercicio')
            ->where('user_id', Auth::id())
            ->get();

        $eventos = $asistencias->map(function ($asistencia) {
            // Si el ejercicio está definido, usamos su nombre, de lo contrario se muestra "Gym"
            $titulo = $asistencia->ejercicio ? $asistencia->ejercicio->nombre_ejercicio : 'Gym';
            return [
                'title'  => $titulo,
                'start'  => $asistencia->fecha,
                'allDay' => true,
            ];
        });

        return response()->json($eventos);
    }

    /**
     * Registra la asistencia en la fecha proporcionada y evita duplicados.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha'        => 'required|date',
            'ejercicio_id' => 'required|exists:ejercicios,id'
        ]);

        // Verifica que el ejercicio corresponda al usuario actual o,
        // en caso de usuario normal, que el ejercicio pertenezca a un entrenador o superadmin
        $ejercicio = Ejercicio::where('id', $request->ejercicio_id)
            ->first();

        if (!$ejercicio) {
            return response()->json(['message' => 'Ejercicio no encontrado.'], 404);
        }

        // Si el usuario normal intenta registrar un ejercicio que NO fue creado por entrenador o superadmin, se rechaza.
        if (Auth::user()->role === 'usuario' && !in_array($ejercicio->user->role, ['entrenador', 'superadmin'])) {
            return response()->json(['message' => 'No tienes permiso para registrar asistencia con este ejercicio.'], 403);
        }

        $existe = Asistencia::where('user_id', Auth::id())
            ->where('fecha', $request->fecha)
            ->first();

        if ($existe) {
            return response()->json(['message' => 'Ya registraste asistencia en esa fecha.'], 409);
        }

        Asistencia::create([
            'user_id'      => Auth::id(),
            'fecha'        => $request->fecha,
            'ejercicio_id' => $request->ejercicio_id,
        ]);

        return response()->json(['message' => 'Asistencia registrada correctamente.'], 201);
    }
}
