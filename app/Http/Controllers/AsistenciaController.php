<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Ejercicio; // ✅ Importación agregada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    /**
     * Muestra la vista del calendario de asistencia.
     */
    public function index()
    {
        $ejercicios = Ejercicio::where('user_id', Auth::id())->get();
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

        $ejercicio = Ejercicio::where('id', $request->ejercicio_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$ejercicio) {
            return response()->json(['message' => 'Ejercicio no encontrado.'], 404);
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
