<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'       => 'Admin User',
            'email'      => 'admin@example.com',
            'password'   => Hash::make('password123'),
            'profession' => 'Chef de projet',
        ]);

        User::create([
            'name'       => 'Alice Martin',
            'email'      => 'alice@example.com',
            'password'   => Hash::make('password123'),
            'profession' => 'Développeur',
        ]);

        User::create([
            'name'       => 'Bob Dupont',
            'email'      => 'bob@example.com',
            'password'   => Hash::make('password123'),
            'profession' => 'Designer',
        ]);

        User::create([
            'name'       => 'Claire Petit',
            'email'      => 'claire@example.com',
            'password'   => Hash::make('password123'),
            'profession' => 'Testeur',
        ]);
    }
}