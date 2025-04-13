<?php

namespace Database\Seeders;

use App\Models\FichaMedica;
use App\Models\User;
use Illuminate\Database\Seeder;

class FichaMedicaSeeder extends Seeder
{
    public function run(): void
    {
        // Se utiliza el primer usuario creado como ejemplo
        $user = User::first();

        if ($user) {
            FichaMedica::create([
                'user_id'         => $user->id,
                'apellidos'       => 'Doe',
                'nombre'          => 'John',
                'fecha_nacimiento'=> '1980-01-01',
                'edad'            => 40,
                'sexo'            => 'M',
                'domicilio'       => 'Calle Falsa 123',
                'barrio'          => 'Centro',
                'telefonos'       => '123456789',
                'tipo_sangre'     => 'O',
                'factor_rh'       => 'Positivo',
                'lateralidad'     => 'Diestro',
                'actividad_fisica'=> 'Moderada',
                'frecuencia_semanal'=> 3,
                'nombre_padre'    => 'Nombre del Padre',
                'nombre_madre'    => 'Nombre de la Madre',
                'nombre_acudiente'=> 'Nombre del Acudiente',
                'parentesco'      => 'Hermano',
                'lesiones'        => 'Ninguna',
                'alergias'        => 'Ninguna',
                'padece_enfermedad'=> false,
                'enfermedad'      => null,
            ]);
        }
    }
}
