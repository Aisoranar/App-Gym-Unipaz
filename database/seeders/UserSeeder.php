<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'  => 'Aisor',
            'email' => 'aisor@gmail.com',
            'password' => bcrypt('aisor123'),
            'role'  => 'usuario', // Puedes cambiar este valor según tus necesidades
        ]);
    }
}
