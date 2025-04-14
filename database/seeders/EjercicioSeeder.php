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
                    'nombre_ejercicio'  => 'Sentadillas',
                    'descripcion'       => 'Ejercicio de piernas para fortalecer los músculos.',
                    'nivel_dificultad'  => 'Media',
                    'grupo_muscular'    => 'Piernas',
                    'series'            => 3,
                    'repeticiones'      => 12,
                    'calorias_aprox'    => 50,
                    'duracion'          => 30,
                    'foto'              => null,
                    'video'             => null,
                ],
                [
                    'nombre_ejercicio'  => 'Flexiones de pecho',
                    'descripcion'       => 'Ejercicio para el pecho, hombros y tríceps.',
                    'nivel_dificultad'  => 'Alta',
                    'grupo_muscular'    => 'Pecho',
                    'series'            => 4,
                    'repeticiones'      => 15,
                    'calorias_aprox'    => 60,
                    'duracion'          => 20,
                    'foto'              => null,
                    'video'             => null,
                ],
                [
                    'nombre_ejercicio'  => 'Abdominales',
                    'descripcion'       => 'Ejercicio para fortalecer el core.',
                    'nivel_dificultad'  => 'Media',
                    'grupo_muscular'    => 'Abdomen',
                    'series'            => 4,
                    'repeticiones'      => 20,
                    'calorias_aprox'    => 40,
                    'duracion'          => 15,
                    'foto'              => null,
                    'video'             => null,
                ],
                [
                    'nombre_ejercicio'  => 'Bíceps con mancuernas',
                    'descripcion'       => 'Ejercicio para trabajar los músculos del brazo.',
                    'nivel_dificultad'  => 'Baja',
                    'grupo_muscular'    => 'Brazos',
                    'series'            => 3,
                    'repeticiones'      => 10,
                    'calorias_aprox'    => 35,
                    'duracion'          => 25,
                    'foto'              => null,
                    'video'             => null,
                ],
                [
                    'nombre_ejercicio'  => 'Plancha',
                    'descripcion'       => 'Ejercicio isométrico para el abdomen.',
                    'nivel_dificultad'  => 'Alta',
                    'grupo_muscular'    => 'Core',
                    'series'            => 3,
                    'repeticiones'      => 1,
                    'calorias_aprox'    => 20,
                    'duracion'          => 5, // minutos por serie
                    'foto'              => null,
                    'video'             => null,
                ],
            ];

            foreach ($ejercicios as $ejercicio) {
                Ejercicio::create(array_merge($ejercicio, [
                    'user_id' => $user->id,
                    'fecha'   => Carbon::today()->format('Y-m-d'),
                ]));
            }
        }
    }
}
