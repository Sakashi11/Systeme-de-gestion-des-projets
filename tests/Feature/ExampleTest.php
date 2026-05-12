<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsUser()
    {
        $user  = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;
        return [$user, $token];
    }

    public function test_user_can_create_team()
    {
        [$user, $token] = $this->actingAsUser();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->postJson('/api/teams', [
                             'name'        => 'Équipe Test',
                             'description' => 'Description test',
                         ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'team' => ['id', 'name', 'description'],
                 ]);
    }

    public function test_user_can_list_teams()
    {
        [$user, $token] = $this->actingAsUser();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->getJson('/api/teams');

        $response->assertStatus(200);
    }

    public function test_owner_can_update_team()
    {
        [$user, $token] = $this->actingAsUser();

        $team = Team::create([
            'name'     => 'Équipe Test',
            'owner_id' => $user->id,
        ]);

        $team->members()->attach($user->id, [
            'role'      => 'admin',
            'joined_at' => now(),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->putJson('/api/teams/' . $team->id, [
                             'name' => 'Équipe Modifiée',
                         ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Équipe mise à jour']);
    }

    public function test_non_member_cannot_update_team()
    {
        [$user, $token]   = $this->actingAsUser();
        [$other, $token2] = $this->actingAsUser();

        $team = Team::create([
            'name'     => 'Équipe Test',
            'owner_id' => $user->id,
        ]);

        $team->members()->attach($user->id, [
            'role'      => 'admin',
            'joined_at' => now(),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token2)
                         ->putJson('/api/teams/' . $team->id, [
                             'name' => 'Équipe Hackée',
                         ]);

        $response->assertStatus(403);
    }

    public function test_owner_can_delete_team()
    {
        [$user, $token] = $this->actingAsUser();

        $team = Team::create([
            'name'     => 'Équipe Test',
            'owner_id' => $user->id,
        ]);

        $team->members()->attach($user->id, [
            'role'      => 'admin',
            'joined_at' => now(),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->deleteJson('/api/teams/' . $team->id);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Équipe supprimée']);
    }
}