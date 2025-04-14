<?php

namespace Database\Seeders;

use App\Models\Ejercicio;
use App\Models\User;
use Illuminate\Database\Seeder;

class EjercicioSeeder extends Seeder
{
    public function run(): void
    {
        // Obtenemos todos los usuarios con rol "entrenador" o "superadmin"
        $usuarios = User::whereIn('role', ['entrenador', 'superadmin'])->get();

        if ($usuarios->isEmpty()) {
            $this->command->info('No hay usuarios con rol entrenador o superadmin para asignar ejercicios.');
            return;
        }

        // Crear 10 ejercicios de ejemplo
        for ($i = 1; $i <= 10; $i++) {
            // Selecciona al azar un usuario de los entrenadores y superadmin
            $usuario = $usuarios->random();
            
            // Lista de niveles posibles
            $niveles = ['Baja', 'Media', 'Alta'];

            Ejercicio::create([
                'user_id'           => $usuario->id,
                'nombre_ejercicio'  => "Ejercicio $i",
                'descripcion'       => "Descripción detallada del Ejercicio $i. Este ejercicio está diseñado para mejorar la fuerza y la resistencia.",
                'nivel_dificultad'  => $niveles[array_rand($niveles)],
                'grupo_muscular'    => "Grupo muscular " . (($i % 4) + 1), // Ejemplo: grupo muscular 1, 2, 3, 4
                'series'            => rand(3, 5),
                'repeticiones'      => rand(8, 15),
                'calorias_aprox'    => rand(50, 150),
                'duracion'          => rand(10, 60), // en minutos
                'fecha'             => now()->subDays(rand(0, 30))->format('Y-m-d'),
                'foto'              => null, // Sin foto, pero se puede modificar para asignar una ruta de ejemplo
                'video'             => null, // Sin video, pero se puede modificar para asignar una ruta de ejemplo
            ]);
        }
    }
}
