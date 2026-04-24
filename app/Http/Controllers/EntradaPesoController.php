<?php

namespace App\Http\Controllers;

use App\Models\EntradaPeso;
use Illuminate\Http\Request;

class EntradaPesoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Ahora el parámetro se llama `entrada`
        $this->middleware('can:view,entrada')->only('show');
        $this->middleware('can:update,entrada')->only(['edit','update']);
        $this->middleware('can:delete,entrada')->only('destroy');
    }

    public function index()
    {
        $entradas = EntradaPeso::where('user_id', auth()->id())
            ->orderBy('fecha', 'desc')
            ->get();

        $total = $entradas->count();
        $promedioImc = $entradas->avg('imc');
        $ultima = $entradas->first();

        $sugerencia = '';
        if ($ultima) {
            switch ($ultima->estado_peso) {
                case 'Bajo peso':
                    $sugerencia = 'Aumenta tu consumo de calorías con alimentos ricos en nutrientes.';
                    break;
                case 'Normal':
                    $sugerencia = 'Mantén tu peso con actividad física regular y dieta balanceada.';
                    break;
                case 'Sobrepeso':
                    $sugerencia = 'Incorpora más cardio y controla las porciones en tus comidas.';
                    break;
                case 'Obesidad':
                    $sugerencia = 'Consulta con un profesional en nutrición y sigue un plan específico.';
                    break;
            }
        }

        return view('entradas_peso.index', compact('entradas', 'total', 'promedioImc', 'sugerencia'));
    }

    public function create()
    {
        return view('entradas_peso.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'peso_actual_kg' => 'required|numeric|min:1|max:300',
            'peso_ideal_kg'  => 'nullable|numeric|min:1|max:300',
            'altura_cm'      => 'required|integer|min:50|max:250',
            'fecha'          => 'required|date',
        ], [
            'altura_cm.min' => 'La altura debe ser al menos 50 cm (0.5 m).',
            'altura_cm.max' => 'La altura no puede superar 250 cm (2.5 m).',
            'peso_actual_kg.min' => 'El peso debe ser al menos 1 kg.',
        ]);

        [$imc, $estado] = $this->calcularImcEstado(
            $datos['peso_actual_kg'],
            $datos['altura_cm']
        );

        EntradaPeso::create([
            'user_id'        => auth()->id(),
            'peso_actual_kg' => $datos['peso_actual_kg'],
            'peso_ideal_kg'  => $datos['peso_ideal_kg'],
            'altura_cm'      => $datos['altura_cm'],
            'imc'            => $imc,
            'estado_peso'    => $estado,
            'fecha'          => $datos['fecha'],
        ]);

        return redirect()->route('entradas-peso.index')
                         ->with('success', 'Registro de peso agregado.');
    }

    public function show(EntradaPeso $entrada)
    {
        $this->authorize('view', $entrada);
        return view('entradas_peso.show', compact('entrada'));
    }

    public function edit(EntradaPeso $entrada)
    {
        $this->authorize('update', $entrada);
        return view('entradas_peso.edit', compact('entrada'));
    }

    public function update(Request $request, EntradaPeso $entrada)
    {
        $this->authorize('update', $entrada);

        $datos = $request->validate([
            'peso_actual_kg' => 'required|numeric|min:1|max:300',
            'peso_ideal_kg'  => 'nullable|numeric|min:1|max:300',
            'altura_cm'      => 'required|integer|min:50|max:250',
            'fecha'          => 'required|date',
        ], [
            'altura_cm.min' => 'La altura debe ser al menos 50 cm (0.5 m).',
            'altura_cm.max' => 'La altura no puede superar 250 cm (2.5 m).',
        ]);

        [$imc, $estado] = $this->calcularImcEstado(
            $datos['peso_actual_kg'],
            $datos['altura_cm']
        );

        $entrada->update(array_merge($datos, [
            'imc'         => $imc,
            'estado_peso' => $estado,
        ]));

        return redirect()->route('entradas-peso.index')
                         ->with('success', 'Registro de peso actualizado.');
    }

    public function destroy(EntradaPeso $entrada)
    {
        $this->authorize('delete', $entrada);
        $entrada->delete();

        return redirect()->route('entradas-peso.index')
                         ->with('success', 'Registro de peso eliminado.');
    }

    private function calcularImcEstado(float $peso, int $alturaCm): array
    {
        $alturaM = $alturaCm / 100;
        $imc = round($peso / ($alturaM ** 2), 2);

        if ($imc < 18.5) {
            $estado = 'Bajo peso';
        } elseif ($imc < 25) {
            $estado = 'Normal';
        } elseif ($imc < 30) {
            $estado = 'Sobrepeso';
        } else {
            $estado = 'Obesidad';
        }

        return [$imc, $estado];
    }
}
