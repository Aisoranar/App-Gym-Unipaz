<?php

namespace Database\Seeders;

use App\Models\Ejercicio;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EjercicioSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if ($user) {
            $ejercicios = [
                [
                    'nombre_ejercicio' => 'Sentadillas',
                    'descripcion'      => 'Ejercicio de piernas para fortalecer los músculos.',
                    'series'           => 3,
                    'repeticiones'     => 12,
                    'duracion'         => 30,
                ],
                [
                    'nombre_ejercicio' => 'Flexiones de pecho',
                    'descripcion'      => 'Ejercicio para el pecho, hombros y tríceps.',
                    'series'           => 4,
                    'repeticiones'     => 15,
                    'duracion'         => 20,
                ],
                [
                    'nombre_ejercicio' => 'Abdominales',
                    'descripcion'      => 'Ejercicio para fortalecer el core.',
                    'series'           => 4,
                    'repeticiones'     => 20,
                    'duracion'         => 15,
                ],
                [
                    'nombre_ejercicio' => 'Bíceps con mancuernas',
                    'descripcion'      => 'Ejercicio para trabajar los músculos del brazo.',
                    'series'           => 3,
                    'repeticiones'     => 10,
                    'duracion'         => 25,
                ],
                [
                    'nombre_ejercicio' => 'Plancha',
                    'descripcion'      => 'Ejercicio isométrico para el abdomen.',
                    'series'           => 3,
                    'repeticiones'     => 1,
                    'duracion'         => 5, // duración por serie en minutos
                ],
            ];

            foreach ($ejercicios as $ejercicio) {
                Ejercicio::create([
                    'user_id'          => $user->id,
                    'nombre_ejercicio' => $ejercicio['nombre_ejercicio'],
                    'descripcion'      => $ejercicio['descripcion'],
                    'series'           => $ejercicio['series'],
                    'repeticiones'     => $ejercicio['repeticiones'],
                    'duracion'         => $ejercicio['duracion'],
                    'fecha'            => Carbon::today()->format('Y-m-d'),
                ]);
            }
        }
    }
}
