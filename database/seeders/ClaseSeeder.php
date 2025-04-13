<?php

namespace Database\Seeders;

use App\Models\Clase;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ClaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if ($user) {
            Clase::create([
                'user_id'    => $user->id,
                'titulo'     => 'Clase de Yoga',
                'descripcion'=> 'Mejora tu flexibilidad y reduce el estrés',
                'fecha'      => Carbon::today()->format('Y-m-d'),
                'hora_inicio'=> '10:00:00',
                'hora_fin'   => '11:00:00',
            ]);
        }
    }
}
