<?php

namespace Database\Seeders;

use App\Models\Rutina;
use App\Models\User;
use Illuminate\Database\Seeder;

class RutinaSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if ($user) {
            Rutina::create([
                'user_id'         => $user->id,
                'nombre'          => 'Rutina de Prueba',
                'descripcion'     => 'Rutina para probar la funcionalidad de control de entrenamientos.',
                'dias'            => json_encode(['Lunes', 'Miércoles', 'Viernes']), // ✅ Convertir a JSON
                'fecha_inicio'    => now()->format('Y-m-d'),
                'fecha_fin'       => now()->addMonth()->format('Y-m-d'),
                'hora_inicio'     => '07:00:00',
                'hora_fin'        => '08:00:00',
                'estado'          => 'pendiente',
                'objetivo'        => 'Mejorar resistencia',
                'intensidad'      => 'media',
                'notas'           => 'Iniciar de forma gradual.'
            ]);
        }
    }
}
