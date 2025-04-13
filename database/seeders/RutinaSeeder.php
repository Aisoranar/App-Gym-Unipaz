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
                'nombre'          => 'Rutina Básica',
                'descripcion'     => 'Rutina para principiantes',
                'dias_por_semana' => 3,
            ]);
        }
    }
}
