<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::create([
            'name'       => 'Admin',
            'prenom'     => 'Super',
            'email'      => 'admin@example.com',
            'password'   => Hash::make('password123'),
            'code'       => 'ADMIN2026',
            'profession' => 'Administrateur',
            'role'       => 'super_admin',
        ]);

        // Chef de Projet
        User::create([
            'name'       => 'Martin',
            'prenom'     => 'Alice',
            'email'      => 'alice@example.com',
            'password'   => Hash::make('password123'),
            'code'       => Str::upper(Str::random(8)),
            'profession' => 'Chef de Projet',
            'role'       => 'chef_projet',
        ]);

        // Membres
        User::create([
            'name'       => 'Dupont',
            'prenom'     => 'Bob',
            'email'      => 'bob@example.com',
            'password'   => Hash::make('password123'),
            'code'       => Str::upper(Str::random(8)),
            'profession' => 'Développeur',
            'role'       => 'membre',
        ]);

        User::create([
            'name'       => 'Petit',
            'prenom'     => 'Claire',
            'email'      => 'claire@example.com',
            'password'   => Hash::make('password123'),
            'code'       => Str::upper(Str::random(8)),
            'profession' => 'Designer',
            'role'       => 'membre',
        ]);
    }
}