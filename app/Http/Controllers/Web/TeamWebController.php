<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamWebController extends Controller
{
    public function index()
    {
        if (Auth::user()->isSuperAdmin()) {
            $teams = Team::with('owner', 'members')->latest()->get();
        } else {
            $teams = Auth::user()->teams()->with('owner', 'members')->get();
        }
        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        $users = User::all();
        return view('teams.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'owner_id'    => 'required|exists:users,id',
        ]);

        $team = Team::create([
            'name'        => $request->name,
            'description' => $request->description,
            'owner_id'    => $request->owner_id,
        ]);

        $team->members()->syncWithoutDetaching([
            $request->owner_id => [
                'role'      => 'admin',
                'joined_at' => now(),
            ]
        ]);

        return redirect('/teams')->with('success', 'Équipe créée avec succès !');
    }

    public function show(Team $team)
    {
        $team->load('owner', 'members', 'projects');
        $users = User::all();
        return view('teams.show', compact('team', 'users'));
    }

    public function edit(Team $team)
    {
        $users = User::all();
        return view('teams.edit', compact('team', 'users'));
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'owner_id'    => 'required|exists:users,id',
        ]);

        $team->update([
            'name'        => $request->name,
            'description' => $request->description,
            'owner_id'    => $request->owner_id,
        ]);

        $team->members()->syncWithoutDetaching([
            $request->owner_id => [
                'role'      => 'admin',
                'joined_at' => now(),
            ]
        ]);

        return redirect('/teams')->with('success', 'Équipe mise à jour !');
    }

    public function destroy(Team $team)
    {
        $team->delete();
        return redirect('/teams')->with('success', 'Équipe supprimée !');
    }

    public function addMember(Request $request, Team $team)
    {
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

        return back()->with('success', 'Membre ajouté !');
    }

    public function removeMember(Team $team, $userId)
    {
        $team->members()->detach($userId);
        return back()->with('success', 'Membre retiré !');
    }
}