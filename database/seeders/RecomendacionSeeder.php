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
        $user = User::first();

        if ($user) {
            Recomendacion::create([
                'user_id'  => $user->id,
                'contenido'=> 'Mantén una dieta balanceada y realiza ejercicio regularmente.',
                'fecha'    => Carbon::today()->format('Y-m-d'),
            ]);
        }
    }
}
