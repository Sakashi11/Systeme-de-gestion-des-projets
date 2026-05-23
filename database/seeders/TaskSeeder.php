<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $alice  = User::where('email', 'alice@example.com')->first();
        $bob    = User::where('email', 'bob@example.com')->first();
        $claire = User::where('email', 'claire@example.com')->first();

        $project1 = Project::where('name', 'Site Web E-commerce')->first();
        $project2 = Project::where('name', 'Refonte UI')->first();

        // Tâches projet 1
        Task::create([
            'project_id'  => $project1->id,
            'assigned_to' => $bob->id,
            'created_by'  => $alice->id,
            'title'       => 'Créer la page d\'accueil',
            'description' => 'Design et développement de la page d\'accueil',
            'status'      => 'done',
            'priority'    => 'high',
            'due_date'    => '2026-05-15',
        ]);

        Task::create([
            'project_id'  => $project1->id,
            'assigned_to' => $bob->id,
            'created_by'  => $alice->id,
            'title'       => 'Créer la page produits',
            'description' => 'Liste et détails des produits',
            'status'      => 'in_progress',
            'priority'    => 'high',
            'due_date'    => '2026-05-30',
        ]);

        Task::create([
            'project_id'  => $project1->id,
            'assigned_to' => $claire->id,
            'created_by'  => $alice->id,
            'title'       => 'Intégrer le paiement',
            'description' => 'Intégration Stripe',
            'status'      => 'todo',
            'priority'    => 'urgent',
            'due_date'    => '2026-06-15',
        ]);

        // Tâches projet 2
        Task::create([
            'project_id'  => $project2->id,
            'assigned_to' => $claire->id,
            'created_by'  => $alice->id,
            'title'       => 'Maquettes Dashboard',
            'description' => 'Créer les maquettes du dashboard',
            'status'      => 'in_progress',
            'priority'    => 'medium',
            'due_date'    => '2026-05-20',
        ]);
    }
}