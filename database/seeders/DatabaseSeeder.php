<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Primero se crea el usuario
        $this->call(UserSeeder::class);

        // Se ejecutan los demás seeders
        $this->call([
            FichaMedicaSeeder::class,
            EjercicioSeeder::class,
            RecomendacionSeeder::class,
            RutinaSeeder::class,
            PlanNutricionalSeeder::class,
            ClaseSeeder::class,
            AsistenciaSeeder::class,
            EjercicioRutinaSeeder::class,
        ]);
    }
}
