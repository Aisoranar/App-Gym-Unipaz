<?php

namespace App\Http\Controllers;

use App\Models\QrCodeSession;
use App\Models\QrScan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QrCodeSessionController extends Controller
{
    // Constructor para aplicar middleware de autenticación
    public function __construct()
    {
        $this->middleware('auth');
        // Ahora enterCode, scanForm y scanSubmit quedan fuera del middleware role:entrenador
        $this->middleware('role:entrenador')
             ->except(['enterCode', 'scanForm', 'scanSubmit']);
    }
    

    // Mostrar listado de sesiones QR creadas por el entrenador autenticado
    public function index()
    {
        $sessions = QrCodeSession::where('user_id', auth()->id())->get();
        return view('qr_sessions.index', compact('sessions'));
    }

    // Mostrar formulario para crear una nueva sesión QR
    public function create()
    {
        return view('qr_sessions.create');
    }

    // Guardar nueva sesión QR en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'activo' => 'nullable|boolean',
        ]);

        // Generar código único para el QR
        do {
            $codigo = Str::upper(Str::random(8));
        } while (QrCodeSession::where('codigo', $codigo)->exists());

        QrCodeSession::create([
            'user_id' => auth()->id(),
            'nombre' => $request->nombre,
            'activo' => $request->activo ? true : false,
            'codigo' => $codigo,
        ]);

        return redirect()->route('qr-sessions.index')
                         ->with('success', 'Sesión QR creada correctamente.');
    }

    // Mostrar formulario de edición para una sesión QR existente
    public function edit($id)
    {
        $session = QrCodeSession::findOrFail($id);
        // Verificar que el usuario autenticado es el creador (entrenador) de la sesión
        if ($session->user_id !== auth()->id()) {
            abort(403);
        }
        return view('qr_sessions.edit', compact('session'));
    }

    // Actualizar los datos de una sesión QR
    public function update(Request $request, $id)
    {
        $session = QrCodeSession::findOrFail($id);
        if ($session->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'activo' => 'nullable|boolean',
        ]);

        $session->update([
            'nombre' => $request->nombre,
            'activo' => $request->activo ? true : false,
        ]);

        return redirect()->route('qr-sessions.index')
                         ->with('success', 'Sesión QR actualizada correctamente.');
    }

    // Eliminar una sesión QR y sus escaneos asociados
    public function destroy($id)
    {
        $session = QrCodeSession::findOrFail($id);
        if ($session->user_id !== auth()->id()) {
            abort(403);
        }

        // Eliminamos escaneos asociados (cascade)
        $session->scans()->delete();
        $session->delete();

        return redirect()->route('qr-sessions.index')
                         ->with('success', 'Sesión QR eliminada correctamente.');
    }

    // Activar o desactivar una sesión QR
    public function toggle($id)
    {
        $session = QrCodeSession::findOrFail($id);
        if ($session->user_id !== auth()->id()) {
            abort(403);
        }

        $session->activo = !$session->activo;
        $session->save();

        $msg = $session->activo ? 'Sesión QR activada.' : 'Sesión QR desactivada.';
        return redirect()->route('qr-sessions.index')
                         ->with('success', $msg);
    }

    // Mostrar detalles de una sesión QR, incluyendo lista de escaneos agrupados por fecha
    public function show($id)
    {
        $session = QrCodeSession::with('scans.user')->findOrFail($id);
        if ($session->user_id !== auth()->id()) {
            abort(403);
        }

        // Agrupar escaneos por fecha
        $scansByDate = $session->scans->groupBy('fecha');
        return view('qr_sessions.show', compact('session', 'scansByDate'));
    }

    // Mostrar formulario de escaneo de QR (usuario)
// En QrCodeSessionController
public function enterCode()
{
    return view('qr_sessions.enter_code');
}

public function scanForm(Request $request)
{
    $codigo = $request->query('codigo');
    $session = QrCodeSession::where('codigo', $codigo)->first();
    if (!$session || !$session->activo) {
        return redirect()->back()->with('error', 'Código QR inválido o inactivo.');
    }
    return view('qr_sessions.scan', compact('session'));
}


    // Procesar el escaneo y guardar la asistencia
    public function scanSubmit(Request $request)
    {
        $request->validate([
            'qr_code_session_id' => 'required|exists:qr_code_sessions,id',
            'carrera' => 'required|string|max:255',
            'actividad' => 'required|string|max:255',
            'fecha' => 'required|date',
        ]);

        $session = QrCodeSession::findOrFail($request->qr_code_session_id);
        if (!$session->activo) {
            return redirect()->back()->with('error', 'Sesión QR inactiva.');
        }

        QrScan::create([
            'usuario_id' => auth()->id(),
            'qr_code_session_id' => $session->id,
            'carrera' => $request->carrera,
            'actividad' => $request->actividad,
            'fecha' => $request->fecha,
        ]);

        return redirect()->route('qr-sessions.scan-form', $session->codigo)
                         ->with('success', 'Asistencia registrada correctamente.');
    }
    
}
