<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ejercicio;
use App\Models\Rutina;

class EjercicioRutinaSeeder extends Seeder
{
    public function run(): void
    {
        $ejercicio = Ejercicio::first();
        $rutina    = Rutina::first();

        if ($ejercicio && $rutina) {
            // Se asigna el ejercicio a la rutina
            $rutina->ejercicios()->attach($ejercicio->id);
        }
    }
}
