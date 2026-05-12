<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        // Équipe 1
        $team1 = Team::create([
            'name'        => 'Équipe Dev',
            'description' => 'Équipe de développement web',
            'owner_id'    => 3,
        ]);

        // Ajouter les membres
        $team1->members()->attach([
            3 => ['role' => 'admin',  'joined_at' => now()],
            4 => ['role' => 'member', 'joined_at' => now()],
            5 => ['role' => 'member', 'joined_at' => now()],
        ]);

        // Équipe 2
        $team2 = Team::create([
            'name'        => 'Équipe Design',
            'description' => 'Équipe de design UI/UX',
            'owner_id'    => 3,
        ]);

        $team2->members()->attach([
            3 => ['role' => 'admin',  'joined_at' => now()],
            5 => ['role' => 'member', 'joined_at' => now()],
            6 => ['role' => 'member', 'joined_at' => now()],
        ]);
    }
}