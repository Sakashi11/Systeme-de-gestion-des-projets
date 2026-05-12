<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Http\Resources\TeamResource;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TeamController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $teams = $request->user()->teams()->with('owner', 'members')->get();
        return TeamResource::collection($teams);
    }

    public function store(StoreTeamRequest $request)
    {
        $team = Team::create([
            'name'        => $request->name,
            'description' => $request->description,
            'owner_id'    => $request->user()->id,
        ]);

        $team->members()->attach($request->user()->id, [
            'role'      => 'admin',
            'joined_at' => now(),
        ]);

        return response()->json([
            'message' => 'Équipe créée avec succès',
            'team'    => new TeamResource($team->load('owner', 'members')),
        ], 201);
    }

    public function show(Request $request, Team $team)
    {
        $this->authorize('view', $team);
        return new TeamResource($team->load('owner', 'members', 'projects'));
    }

    public function update(UpdateTeamRequest $request, Team $team)
    {
        $this->authorize('update', $team);
        $team->update($request->only('name', 'description'));

        return response()->json([
            'message' => 'Équipe mise à jour',
            'team'    => new TeamResource($team),
        ]);
    }

    public function destroy(Request $request, Team $team)
    {
        $this->authorize('delete', $team);
        $team->delete();

        return response()->json([
            'message' => 'Équipe supprimée',
        ]);
    }

    public function addMember(Request $request, Team $team)
    {
        $this->authorize('update', $team);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role'    => 'in:admin,member',
        ]);

        $team->members()->syncWithoutDetaching([
            $request->user_id => [
                'role'      => $request->role ?? 'member',
                'joined_at' => now(),
            ]
        ]);

        return response()->json([
            'message' => 'Membre ajouté avec succès',
        ]);
    }

    public function removeMember(Request $request, Team $team, $userId)
    {
        $this->authorize('update', $team);
        $team->members()->detach($userId);

        return response()->json([
            'message' => 'Membre retiré avec succès',
        ]);
    }
}