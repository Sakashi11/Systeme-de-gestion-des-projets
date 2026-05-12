<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::create([
            'team_id'     => 2,
            'name'        => 'Site Web E-commerce',
            'description' => 'Développement du site e-commerce',
            'status'      => 'active',
            'start_date'  => '2026-05-01',
            'end_date'    => '2026-08-01',
        ]);

        Project::create([
            'team_id'     => 2,
            'name'        => 'Application Mobile',
            'description' => 'Développement de l\'application mobile',
            'status'      => 'planning',
            'start_date'  => '2026-06-01',
            'end_date'    => '2026-12-01',
        ]);

        Project::create([
            'team_id'     => 3,
            'name'        => 'Refonte UI',
            'description' => 'Refonte de l\'interface utilisateur',
            'status'      => 'active',
            'start_date'  => '2026-05-01',
            'end_date'    => '2026-07-01',
        ]);
    }
}