<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario con rol "usuario"
        User::create([
            'name'     => 'Aisor',
            'email'    => 'aisor@gmail.com',
            'password' => bcrypt('aisor123'),
            'role'     => 'usuario',
        ]);

        // Usuario con rol "entrenador"
        User::create([
            'name'     => 'Alex',
            'email'    => 'alex@gmail.com',
            'password' => bcrypt('aisor123'),
            'role'     => 'entrenador',
        ]);

        // Usuario con rol "superadmin"
        User::create([
            'name'     => 'Anaya',
            'email'    => 'anaya@gmail.com',
            'password' => bcrypt('aisor123'),
            'role'     => 'superadmin',
        ]);
    }
}
