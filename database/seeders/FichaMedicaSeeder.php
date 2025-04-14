<?php

namespace Database\Seeders;

use App\Models\FichaMedica;
use App\Models\User;
use Illuminate\Database\Seeder;

class FichaMedicaSeeder extends Seeder
{
    public function run(): void
    {
        // Nombres de los usuarios para los que se creará una ficha médica
        $userNames = ['Aisor', 'Alex', 'Anaya'];

        foreach ($userNames as $userName) {
            // Buscamos el usuario según el nombre
            $user = User::where('name', $userName)->first();

            if ($user) {
                // Definimos datos de ejemplo diferenciados para cada usuario
                if ($user->name === 'Aisor') {
                    $data = [
                        'user_id'           => $user->id,
                        'apellidos'         => 'Martínez',
                        'nombre'            => $user->name,
                        'fecha_nacimiento'  => '1990-03-15',
                        'edad'              => 33,
                        'sexo'              => 'M',
                        'domicilio'         => 'Calle Falsa 123',
                        'barrio'            => 'Centro',
                        'telefonos'         => '555-1234',
                        'tipo_sangre'       => 'O',
                        'factor_rh'         => 'Positivo',
                        'lateralidad'       => 'Diestro',
                        'actividad_fisica'  => 'Alta',
                        'frecuencia_semanal'=> 4,
                        'nombre_padre'      => 'Pedro Martínez',
                        'nombre_madre'      => 'María Pérez',
                        'nombre_acudiente'  => 'Carmen López',
                        'parentesco'        => 'Hermana',
                        'lesiones'          => 'Ninguna',
                        'alergias'          => 'Penicilina',
                        'padece_enfermedad' => false,
                        'enfermedad'        => null,
                    ];
                } elseif ($user->name === 'Alex') {
                    $data = [
                        'user_id'           => $user->id,
                        'apellidos'         => 'García',
                        'nombre'            => $user->name,
                        'fecha_nacimiento'  => '1985-07-20',
                        'edad'              => 38,
                        'sexo'              => 'M',
                        'domicilio'         => 'Avenida Siempre Viva 456',
                        'barrio'            => 'Norte',
                        'telefonos'         => '555-5678',
                        'tipo_sangre'       => 'A',
                        'factor_rh'         => 'Negativo',
                        'lateralidad'       => 'Diestro',
                        'actividad_fisica'  => 'Moderada',
                        'frecuencia_semanal'=> 3,
                        'nombre_padre'      => 'Jorge García',
                        'nombre_madre'      => 'Luisa Díaz',
                        'nombre_acudiente'  => 'Carlos Méndez',
                        'parentesco'        => 'Tío',
                        'lesiones'          => 'Lesión de rodilla',
                        'alergias'          => 'Ninguna',
                        'padece_enfermedad' => true,
                        'enfermedad'        => 'Hipertensión',
                    ];
                } elseif ($user->name === 'Anaya') {
                    $data = [
                        'user_id'           => $user->id,
                        'apellidos'         => 'Rodríguez',
                        'nombre'            => $user->name,
                        'fecha_nacimiento'  => '1980-12-05',
                        'edad'              => 42,
                        'sexo'              => 'F',
                        'domicilio'         => 'Boulevard de los Sueños Rotos 789',
                        'barrio'            => 'Sur',
                        'telefonos'         => '555-9012',
                        'tipo_sangre'       => 'B',
                        'factor_rh'         => 'Positivo',
                        'lateralidad'       => 'Zurdo',
                        'actividad_fisica'  => 'Baja',
                        'frecuencia_semanal'=> 2,
                        'nombre_padre'      => 'Ricardo Rodríguez',
                        'nombre_madre'      => 'Elena Márquez',
                        'nombre_acudiente'  => 'Miguel Torres',
                        'parentesco'        => 'Primo',
                        'lesiones'          => 'Ninguna',
                        'alergias'          => 'Alergia a frutos secos',
                        'padece_enfermedad' => false,
                        'enfermedad'        => null,
                    ];
                }

                // Se crea la ficha médica para el usuario
                FichaMedica::create($data);
            }
        }
    }
}
