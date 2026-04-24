<?php

namespace Database\Seeders;

use App\Models\PlanNutricional;
use App\Models\User;
use Illuminate\Database\Seeder;

class PlanNutricionalSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar específicamente el usuario "Usuario Demo"
        $user = User::where('email', 'usuario@gmail.com')->first();

        if ($user) {
            PlanNutricional::create([
                'user_id'       => $user->id,
                'nombre'        => 'Plan de Mantenimiento',
                'descripcion'   => 'Plan nutricional para mantener el peso ideal',
                'calorias_diarias'=> 2000,
                'recomendaciones'=> 'Incrementa el consumo de frutas y verduras.',
            ]);
        }
    }
}
