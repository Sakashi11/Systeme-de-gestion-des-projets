<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Team;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $team1 = Team::where('name', 'Équipe Dev')->first();
        $team2 = Team::where('name', 'Équipe Design')->first();

        Project::create([
            'team_id'     => $team1->id,
            'name'        => 'Site Web E-commerce',
            'description' => 'Développement du site e-commerce',
            'status'      => 'active',
            'start_date'  => '2026-05-01',
            'end_date'    => '2026-08-01',
        ]);

        Project::create([
            'team_id'     => $team1->id,
            'name'        => 'Application Mobile',
            'description' => 'Développement de l\'application mobile',
            'status'      => 'planning',
            'start_date'  => '2026-06-01',
            'end_date'    => '2026-12-01',
        ]);

        Project::create([
            'team_id'     => $team2->id,
            'name'        => 'Refonte UI',
            'description' => 'Refonte de l\'interface utilisateur',
            'status'      => 'active',
            'start_date'  => '2026-05-01',
            'end_date'    => '2026-07-01',
        ]);
    }
}