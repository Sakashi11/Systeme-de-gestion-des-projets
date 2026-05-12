<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        // Tâches projet 2
        Task::create([
            'project_id'  => 2,
            'assigned_to' => 4,
            'created_by'  => 3,
            'title'       => 'Créer la page d\'accueil',
            'description' => 'Design et développement de la page d\'accueil',
            'status'      => 'done',
            'priority'    => 'high',
            'due_date'    => '2026-05-15',
        ]);

        Task::create([
            'project_id'  => 2,
            'assigned_to' => 4,
            'created_by'  => 3,
            'title'       => 'Créer la page produits',
            'description' => 'Liste et détails des produits',
            'status'      => 'in_progress',
            'priority'    => 'high',
            'due_date'    => '2026-05-30',
        ]);

        Task::create([
            'project_id'  => 2,
            'assigned_to' => 5,
            'created_by'  => 3,
            'title'       => 'Intégrer le paiement',
            'description' => 'Intégration Stripe',
            'status'      => 'todo',
            'priority'    => 'urgent',
            'due_date'    => '2026-06-15',
        ]);

        // Tâches projet 3
        Task::create([
            'project_id'  => 3,
            'assigned_to' => 5,
            'created_by'  => 3,
            'title'       => 'Maquettes Dashboard',
            'description' => 'Créer les maquettes du dashboard',
            'status'      => 'in_progress',
            'priority'    => 'medium',
            'due_date'    => '2026-05-20',
        ]);
    }
}