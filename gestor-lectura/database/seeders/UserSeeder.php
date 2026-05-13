<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1 Admin
        User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@gestor.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // 2 Usuarios ordinarios
        User::create([
            'name'     => 'Juan Pérez',
            'email'    => 'juan@gestor.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        User::create([
            'name'     => 'María López',
            'email'    => 'maria@gestor.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        // Usuarios extra para completar los 10 registros mínimos
        $extras = [
            ['name' => 'Carlos Ruiz',     'email' => 'carlos@gestor.com'],
            ['name' => 'Ana García',      'email' => 'ana@gestor.com'],
            ['name' => 'Luis Martínez',   'email' => 'luis@gestor.com'],
            ['name' => 'Sofia Torres',    'email' => 'sofia@gestor.com'],
            ['name' => 'Pedro Sánchez',   'email' => 'pedro@gestor.com'],
            ['name' => 'Laura Jiménez',   'email' => 'laura@gestor.com'],
            ['name' => 'Diego Herrera',   'email' => 'diego@gestor.com'],
        ];

        foreach ($extras as $extra) {
            User::create([
                'name'     => $extra['name'],
                'email'    => $extra['email'],
                'password' => Hash::make('password'),
                'role'     => 'user',
            ]);
        }
    }
}