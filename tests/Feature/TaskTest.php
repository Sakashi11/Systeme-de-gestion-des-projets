<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Team;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    private function createProjectWithUser()
    {
        $user  = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $team = Team::create([
            'name'     => 'Équipe Test',
            'owner_id' => $user->id,
        ]);

        $team->members()->attach($user->id, [
            'role'      => 'admin',
            'joined_at' => now(),
        ]);

        $project = Project::create([
            'team_id' => $team->id,
            'name'    => 'Projet Test',
            'status'  => 'active',
        ]);

        return [$user, $token, $team, $project];
    }

    public function test_user_can_create_task()
    {
        [$user, $token, $team, $project] = $this->createProjectWithUser();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->postJson('/api/projects/' . $project->id . '/tasks', [
                             'title'       => 'Tâche Test',
                             'description' => 'Description de la tâche',
                             'priority'    => 'high',
                             'due_date'    => '2026-06-01',
                         ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'task' => ['id', 'title', 'status', 'priority'],
                 ]);
    }

    public function test_user_can_update_task_status()
    {
        [$user, $token, $team, $project] = $this->createProjectWithUser();

        $task = Task::create([
            'project_id' => $project->id,
            'created_by' => $user->id,
            'title'      => 'Tâche Test',
            'status'     => 'todo',
            'priority'   => 'medium',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->patchJson('/api/tasks/' . $task->id . '/status', [
                             'status' => 'in_progress',
                         ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Statut mis à jour']);
    }

    public function test_user_can_delete_task()
    {
        [$user, $token, $team, $project] = $this->createProjectWithUser();

        $task = Task::create([
            'project_id' => $project->id,
            'created_by' => $user->id,
            'title'      => 'Tâche Test',
            'status'     => 'todo',
            'priority'   => 'medium',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->deleteJson('/api/tasks/' . $task->id);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Tâche supprimée']);
    }

    public function test_task_requires_title()
    {
        [$user, $token, $team, $project] = $this->createProjectWithUser();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->postJson('/api/projects/' . $project->id . '/tasks', [
                             'description' => 'Sans titre',
                         ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title']);
    }
}