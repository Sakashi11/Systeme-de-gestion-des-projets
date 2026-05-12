<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    // Afficher le formulaire de création
    public function create()
    {
        $teams = Team::all();
        return view('admin.members.create', compact('teams'));
    }

    // Créer un membre
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users',
            'profession' => 'nullable|string|max:255',
            'team_id'    => 'required|exists:teams,id',
            'role'       => 'required|in:admin,member',
        ]);

        // Générer mot de passe automatique
        $password = Str::random(10);

        // Créer l'utilisateur
        $user = User::create([
            'name'                  => $request->name,
            'email'                 => $request->email,
            'password'              => Hash::make($password),
            'profession'            => $request->profession,
            'must_change_password'  => true,
        ]);

        // Ajouter à l'équipe
        $team = Team::find($request->team_id);
        $team->members()->attach($user->id, [
            'role'      => $request->role,
            'joined_at' => now(),
        ]);

        // Afficher le mot de passe généré
        return redirect('/admin/members/create')
               ->with('success', 'Membre créé avec succès !')
               ->with('generated_password', $password)
               ->with('generated_email', $request->email)
               ->with('generated_name', $request->name);
    }

    // Liste des membres
    public function index()
    {
        $users = User::with('teams')->latest()->get();
        return view('admin.members.index', compact('users'));
    }

    // Supprimer un membre
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Membre supprimé !');
    }
}