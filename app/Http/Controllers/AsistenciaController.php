<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    /**
     * Muestra la vista del calendario de asistencia.
     */
    public function index()
    {
        return view('asistencias.calendario');
    }
    
    /**
     * Retorna los eventos de asistencia en formato JSON para FullCalendar.
     */
    public function eventos()
    {
        $asistencias = Asistencia::where('user_id', Auth::id())->get();

        $eventos = $asistencias->map(function ($asistencia) {
            return [
                'title'  => 'Gym',
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
            'fecha' => 'required|date',
        ]);
        
        // Verificamos si ya existe asistencia para el día
        $existe = Asistencia::where('user_id', Auth::id())
            ->where('fecha', $request->fecha)
            ->first();
        
        if ($existe) {
            return response()->json(['message' => 'Ya registraste asistencia en esa fecha.'], 409);
        }
        
        Asistencia::create([
            'user_id' => Auth::id(),
            'fecha'   => $request->fecha,
        ]);
        
        return response()->json(['message' => 'Asistencia registrada correctamente.'], 201);
    }
}
