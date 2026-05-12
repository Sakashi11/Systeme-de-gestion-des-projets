<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Team;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    private function createTeamWithUser()
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

        return [$user, $token, $team];
    }

    public function test_user_can_create_project()
    {
        [$user, $token, $team] = $this->createTeamWithUser();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->postJson('/api/teams/' . $team->id . '/projects', [
                             'name'        => 'Projet Test',
                             'description' => 'Description du projet',
                             'status'      => 'active',
                             'start_date'  => '2026-05-01',
                             'end_date'    => '2026-08-01',
                         ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'project' => ['id', 'name', 'status'],
                 ]);
    }

    public function test_user_can_list_projects()
    {
        [$user, $token, $team] = $this->createTeamWithUser();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->getJson('/api/teams/' . $team->id . '/projects');

        $response->assertStatus(200);
    }

    public function test_user_can_update_project()
    {
        [$user, $token, $team] = $this->createTeamWithUser();

        $project = Project::create([
            'team_id' => $team->id,
            'name'    => 'Projet Test',
            'status'  => 'planning',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->putJson('/api/projects/' . $project->id, [
                             'name'   => 'Projet Modifié',
                             'status' => 'active',
                         ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Projet mis à jour']);
    }

    public function test_user_can_delete_project()
    {
        [$user, $token, $team] = $this->createTeamWithUser();

        $project = Project::create([
            'team_id' => $team->id,
            'name'    => 'Projet Test',
            'status'  => 'planning',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->deleteJson('/api/projects/' . $project->id);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Projet supprimé']);
    }
}