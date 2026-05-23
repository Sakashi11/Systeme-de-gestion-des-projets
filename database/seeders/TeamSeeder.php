<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();
        $alice = User::where('email', 'alice@example.com')->first();
        $bob   = User::where('email', 'bob@example.com')->first();
        $claire = User::where('email', 'claire@example.com')->first();

        // Équipe 1
        $team1 = Team::create([
            'name'        => 'Équipe Dev',
            'description' => 'Équipe de développement web',
            'owner_id'    => $alice->id,
        ]);

        $team1->members()->attach([
            $alice->id  => ['role' => 'admin',  'joined_at' => now()],
            $bob->id    => ['role' => 'member', 'joined_at' => now()],
            $claire->id => ['role' => 'member', 'joined_at' => now()],
        ]);

        // Équipe 2
        $team2 = Team::create([
            'name'        => 'Équipe Design',
            'description' => 'Équipe de design UI/UX',
            'owner_id'    => $admin->id,
        ]);

        $team2->members()->attach([
            $admin->id  => ['role' => 'admin',  'joined_at' => now()],
            $claire->id => ['role' => 'member', 'joined_at' => now()],
        ]);
    }
}