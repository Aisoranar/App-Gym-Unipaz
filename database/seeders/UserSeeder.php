<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario normal (rol: usuario)
        User::create([
            'name'     => 'Usuario Demo',
            'email'    => 'usuario@gmail.com',
            'password' => bcrypt('password123'),
            'role'     => 'usuario',
        ]);

        // Entrenador (rol: entrenador)
        User::create([
            'name'     => 'Entrenador Demo',
            'email'    => 'entrenador@gmail.com',
            'password' => bcrypt('password123'),
            'role'     => 'entrenador',
        ]);

        // Administrador (rol: superadmin)
        User::create([
            'name'     => 'Admin Demo',
            'email'    => 'superadmin@gmail.com',
            'password' => bcrypt('password123'),
            'role'     => 'superadmin',
        ]);
    }
}
