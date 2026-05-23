<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Team;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // Dashboard admin
    public function dashboard()
    {
        $stats = [
            'users'    => User::count(),
            'teams'    => Team::count(),
            'projects' => Project::count(),
            'tasks'    => Task::count(),
            'done'     => Task::where('status', 'done')->count(),
        ];

        $recentUsers    = User::latest()->take(5)->get();
        $recentProjects = Project::with('team')->latest()->take(5)->get();
        $teams          = Team::all();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentProjects'));
    }

    // Afficher formulaire création utilisateur
    public function createUser()
    {
        $teams = Team::all();
        return view('admin.create_user', compact('teams'));
    }

    // Créer un utilisateur
    public function storeUser(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'prenom'         => 'required|string|max:255',
            'email'          => 'required|email|unique:users',
            'date_naissance' => 'required|date',
            'profession'     => 'nullable|string|max:255',
            'role'           => 'required|in:super_admin,chef_projet,membre',
            'team_id'        => 'nullable|exists:teams,id',
        ]);

        // Générer code automatique
        $code = Str::upper(Str::random(8));

        $user = User::create([
            'name'                 => $request->name,
            'prenom'               => $request->prenom,
            'email'                => $request->email,
            'date_naissance'       => $request->date_naissance,
            'profession'           => $request->profession,
            'role'                 => $request->role,
            'code'                 => $code,
            'password'             => Hash::make($code),
            'must_change_password' => true,
        ]);

        // Ajouter à une équipe si sélectionnée
        if ($request->team_id) {
            $team = Team::find($request->team_id);
            $team->members()->attach($user->id, [
                'role'      => $request->role == 'chef_projet' ? 'admin' : 'member',
                'joined_at' => now(),
            ]);
        }

        return redirect('/admin/users/create')
               ->with('success', 'Utilisateur créé avec succès !')
               ->with('generated_code', $code)
               ->with('generated_email', $request->email)
               ->with('generated_name', $request->prenom . ' ' . $request->name);
    }

    // Gestion des utilisateurs
    public function users()
    {
        $users = User::with('teams')->withCount('tasks')->latest()->get();
        return view('admin.users', compact('users'));
    }

    // Supprimer un utilisateur
    public function deleteUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte !');
        }
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé !');
    }

    // Gestion des équipes
    public function teams()
    {
        $teams = Team::with('owner', 'members')->withCount('projects')->latest()->get();
        return view('admin.teams', compact('teams'));
    }

    // Supprimer une équipe
    public function deleteTeam(Team $team)
    {
        $team->delete();
        return back()->with('success', 'Équipe supprimée !');
    }

    // Gestion des projets
    public function projects()
    {
        $projects = Project::with('team')->withCount('tasks')->latest()->get();
        return view('admin.projects', compact('projects'));
    }

    // Supprimer un projet
    public function deleteProject(Project $project)
    {
        $project->delete();
        return back()->with('success', 'Projet supprimé !');
    }

    // Rapports
    public function reports()
    {
        $teams = Team::with(['members', 'projects.tasks'])->get();

        $reports = $teams->map(function ($team) {
            $tasks      = $team->projects->flatMap->tasks;
            $totalTasks = $tasks->count();
            return [
                'team'         => $team->name,
                'members'      => $team->members->count(),
                'projects'     => $team->projects->count(),
                'total_tasks'  => $totalTasks,
                'done'         => $tasks->where('status', 'done')->count(),
                'in_progress'  => $tasks->where('status', 'in_progress')->count(),
                'todo'         => $tasks->where('status', 'todo')->count(),
                'productivity' => $totalTasks > 0
                    ? round(($tasks->where('status', 'done')->count() / $totalTasks) * 100)
                    : 0,
            ];
        });

        return view('admin.reports', compact('reports'));
    }
}