<?php

namespace Database\Seeders;

use App\Models\Recomendacion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RecomendacionSeeder extends Seeder
{
    public function run(): void
    {
        // Se obtiene un usuario con rol 'usuario' para asignarle la recomendación.
        $destinatario = User::where('role', 'usuario')->first();
        // Se obtiene un usuario con rol 'entrenador' o 'superadmin' para indicar quién crea la recomendación.
        $creador = User::whereIn('role', ['entrenador', 'superadmin'])->first();

        if ($destinatario && $creador) {
            Recomendacion::create([
                'user_id'   => $destinatario->id,
                'creado_por'=> $creador->id,
                'contenido' => 'Mantén una dieta balanceada y realiza ejercicio regularmente.',
                'fecha'     => Carbon::today()->format('Y-m-d'),
            ]);
        }
    }
}
