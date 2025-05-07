<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Ejercicio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    /**
     * Muestra la vista del calendario de asistencia,
     * junto con la racha de días consecutivos.
     */
    public function index()
    {
        $user = Auth::user();

        // 1) Cargar ejercicios según rol
        if ($user->role === 'usuario') {
            $ids = User::whereIn('role', ['entrenador', 'superadmin'])->pluck('id');
            $ejercicios = Ejercicio::whereIn('user_id', $ids)->get();
        } else {
            $ejercicios = Ejercicio::where('user_id', $user->id)->get();
        }

        // 2) Obtener todas las fechas de asistencia del usuario
        $fechas = Asistencia::where('user_id', $user->id)
            ->orderByDesc('fecha')
            ->pluck('fecha')
            ->map(fn($f) => Carbon::parse($f)->startOfDay());

        $hoy    = Carbon::today();
        $streak = 0;
        $lost   = false;
        $dia    = $hoy->copy();

        // 3) Contar días consecutivos hacia atrás
        while ($fechas->contains($dia)) {
            $streak++;
            $dia = $dia->subDay();
        }

        // 4) Si no asistió hoy, perdió la racha
        if (! $fechas->contains($hoy)) {
            $lost = true;
        }

        // 5) Devolver la vista con todas las variables
        return view('asistencias.calendario', [
            'ejercicios'    => $ejercicios,
            'currentStreak' => $streak,
            'streakLost'    => $lost,
        ]);
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
            $titulo = $asistencia->ejercicio
                ? $asistencia->ejercicio->nombre_ejercicio
                : 'Gym';
            return [
                'title'  => $titulo,
                'start'  => $asistencia->fecha,
                'end'    => $asistencia->fecha,
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
            'ejercicio_id' => 'required|exists:ejercicios,id',
        ]);

        $ejercicio = Ejercicio::find($request->ejercicio_id);
        if (! $ejercicio) {
            return response()->json(['message' => 'Ejercicio no encontrado.'], 404);
        }

        if (
            Auth::user()->role === 'usuario' &&
            ! in_array($ejercicio->user->role, ['entrenador', 'superadmin'])
        ) {
            return response()->json(['message' => 'No tienes permiso para usar este ejercicio.'], 403);
        }

        $existe = Asistencia::where('user_id', Auth::id())
            ->where('fecha', $request->fecha)
            ->exists();

        if ($existe) {
            return response()->json(['message' => 'Ya registraste asistencia en esa fecha.'], 409);
        }

        Asistencia::create([
            'user_id'      => Auth::id(),
            'fecha'        => $request->fecha,
            'ejercicio_id' => $request->ejercicio_id,
        ]);

        return response()->json(['message' => '¡Excelente! Has marcado tu asistencia.'], 201);
    }
}
