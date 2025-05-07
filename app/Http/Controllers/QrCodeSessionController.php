<?php

namespace App\Http\Controllers;

use App\Models\QrCodeSession;
use App\Models\QrScan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // simplesoftwareio/simple-qrcode
use Illuminate\Support\Facades\Storage;

class QrCodeSessionController extends Controller
{
    /**
     * Constructor para aplicar middleware de autenticación y roles.
     * Solo los entrenadores pueden gestionar (index, create, store, edit, update, destroy, toggle, show).
     * enterCode, scanForm y scanSubmit quedan fuera del middleware role:entrenador.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:entrenador')
             ->except(['enterCode', 'scanForm', 'scanSubmit']);
    }

    /**
     * Mostrar listado de sesiones QR creadas por el entrenador autenticado.
     */
    public function index()
    {
        $sessions = QrCodeSession::where('user_id', auth()->id())->get();
        return view('qr_sessions.index', compact('sessions'));
    }

    /**
     * Mostrar formulario para crear una nueva sesión QR.
     */
    public function create()
    {
        return view('qr_sessions.create');
    }

    /**
     * Guardar nueva sesión QR en la base de datos con código único
     * y generar la imagen del código QR para escanearlo.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'activo' => 'nullable|boolean',
        ]);

        // Generar código único
        do {
            $codigo = Str::upper(Str::random(8));
        } while (QrCodeSession::where('codigo', $codigo)->exists());

        // Crear la sesión en BD
        $session = QrCodeSession::create([
            'user_id'  => auth()->id(),
            'nombre'   => $request->nombre,
            'activo'   => $request->activo ? true : false,
            'codigo'   => $codigo,
        ]);

        // Generar QR en formato SVG (evita dependencia Imagick)
        $qrContent = url("/qr/scan/{$codigo}");
        $svg = QrCode::format('svg')
                     ->size(300)
                     ->errorCorrection('H')
                     ->generate($qrContent);

        // Guardar el SVG en storage/app/public/qrcodes/{codigo}.svg
        $filename = "qrcodes/{$codigo}.svg";
        Storage::disk('public')->put($filename, $svg);

        // Guardar la ruta relativa en el modelo y actualizar
        $session->qr_image = $filename;
        $session->save();

        return redirect()->route('qr-sessions.index')
                         ->with('success', "Sesión QR creada correctamente. Código: {$codigo}");
    }

    /**
     * Mostrar formulario de edición para una sesión QR existente.
     */
    public function edit($id)
    {
        $session = QrCodeSession::findOrFail($id);
        if ($session->user_id !== auth()->id()) {
            abort(403);
        }
        return view('qr_sessions.edit', compact('session'));
    }

    /**
     * Actualizar los datos de una sesión QR.
     */
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

    /**
     * Eliminar una sesión QR y sus escaneos asociados.
     */
    public function destroy($id)
    {
        $session = QrCodeSession::findOrFail($id);
        if ($session->user_id !== auth()->id()) {
            abort(403);
        }

        // Eliminar imagen SVG del código QR
        if ($session->qr_image) {
            Storage::disk('public')->delete($session->qr_image);
        }

        // Eliminar escaneos asociados y la sesión
        $session->scans()->delete();
        $session->delete();

        return redirect()->route('qr-sessions.index')
                         ->with('success', 'Sesión QR eliminada correctamente.');
    }

    /**
     * Activar o desactivar una sesión QR.
     */
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

    /**
     * Mostrar detalles de una sesión QR, incluyendo lista de escaneos agrupados
     * y la imagen del código QR generado.
     */
    public function show($id)
    {
        $session = QrCodeSession::with('scans.user')->findOrFail($id);
        if ($session->user_id !== auth()->id()) {
            abort(403);
        }

        $scansByDate = $session->scans->groupBy('fecha');
        return view('qr_sessions.show', compact('session', 'scansByDate'));
    }

    /**
     * Formulario para que el usuario ingrese o escanee el código QR.
     */
    public function enterCode()
    {
        return view('qr_sessions.enter_code');
    }

    /**
     * Validar el código QR y mostrar formulario de escaneo.
     */
    public function scanForm(Request $request)
    {
        $codigo  = $request->query('codigo');
        $session = QrCodeSession::where('codigo', $codigo)->first();

        if (!$session) {
            return redirect()->back()->with('error', 'El código no existe.');
        }
        if (!$session->activo) {
            return redirect()->back()->with('error', 'Este código está deshabilitado.');
        }

        return view('qr_sessions.scan', compact('session'));
    }

    /**
     * Procesar el escaneo y guardar la asistencia.
     */
    public function scanSubmit(Request $request)
    {
        $request->validate([
            'qr_code_session_id' => 'required|exists:qr_code_sessions,id',
            'carrera'            => 'required|string|max:255',
            'actividad'          => 'required|string|max:255',
            'fecha'              => 'required|date',
        ]);

        $session = QrCodeSession::findOrFail($request->qr_code_session_id);
        if (!$session->activo) {
            return redirect()->back()->with('error', 'No puedes registrar: sesión deshabilitada.');
        }

        try {
            QrScan::create([
                'usuario_id'         => auth()->id(),
                'qr_code_session_id' => $session->id,
                'carrera'            => $request->carrera,
                'actividad'          => $request->actividad,
                'fecha'              => $request->fecha,
            ]);

            return redirect()->route('qr-sessions.scan-form', $session->codigo)
                             ->with('success', 'Asistencia registrada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Ocurrió un problema: ' . $e->getMessage());
        }
    }
}
