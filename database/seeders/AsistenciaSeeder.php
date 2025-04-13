<?php

namespace Database\Seeders;

use App\Models\Asistencia;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AsistenciaSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if ($user) {
            Asistencia::create([
                'user_id'   => $user->id,
                'fecha'     => Carbon::today()->format('Y-m-d'),
                'rutina_id' => null, // Puedes asignar un id de rutina si lo deseas
            ]);
        }
    }
}
