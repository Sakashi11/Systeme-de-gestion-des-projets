<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChefProjetController extends Controller
{
    // Dashboard Chef de Projet
    public function dashboard()
    {
        $user    = Auth::user();
        $teams   = $user->teams()->with('projects', 'members')->get();
        $myTasks = Task::whereHas('project', function($q) use ($teams) {
                        $q->whereIn('team_id', $teams->pluck('id'));
                    })->with('project', 'assignee')->latest()->take(5)->get();
        $projects = $teams->flatMap->projects->take(5);

        $stats = [
            'teams'    => $teams->count(),
            'projects' => $teams->flatMap->projects->count(),
            'tasks'    => Task::whereHas('project', function($q) use ($teams) {
                              $q->whereIn('team_id', $teams->pluck('id'));
                          })->count(),
            'membres'  => $teams->flatMap->members->unique('id')->count(),
        ];

        return view('chef.dashboard', compact('user', 'teams', 'myTasks', 'projects', 'stats'));
    }

    // Liste des membres de son équipe
    public function membres()
    {
        $user = Auth::user();
        if ($user->isSuperAdmin()) {
            $membres = User::all();
            $teams   = Team::all();
        } else {
            $teams   = $user->teams()->with('members')->get();
            $membres = $teams->flatMap->members->unique('id');
        }
        return view('chef.membres', compact('membres', 'teams'));
    }

    // Liste des projets de son équipe
    public function projets()
    {
        $user = Auth::user();
        if ($user->isSuperAdmin()) {
            $projects = Project::with('team')->withCount('tasks')->latest()->get();
        } else {
            $teams = $user->teams()->with('projects')->get();
            $projects = $teams->flatMap->projects;
            $projects = $projects->load('team')->loadCount('tasks')->sortByDesc('created_at')->values();
        }

        return view('chef.projets', compact('projects'));
    }

    // Liste des tâches de son équipe
    public function taches()
    {
        $user = Auth::user();
        if ($user->isSuperAdmin()) {
            $projects = Project::all();
            $membres  = User::all();
        } else {
            $teams    = $user->teams()->with('projects', 'members')->get();
            $projects = $teams->flatMap->projects;
            $membres  = $teams->flatMap->members->unique('id');
        }

        return view('chef.create_tache', compact('projects', 'membres'));
    }

    // Stocker une tâche
    public function storeTache(Request $request)
    {
        $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'priority'    => 'in:low,medium,high,urgent',
            'due_date'    => 'nullable|date',
        ]);

        $project = Project::findOrFail($request->project_id);
        if (!Auth::user()->isSuperAdmin() && !Auth::user()->teams()->where('teams.id', $project->team_id)->exists()) {
            abort(403, 'Accès interdit. Ce projet ne fait pas partie de vos équipes.');
        }

        Task::create([
            'project_id'  => $request->project_id,
            'title'       => $request->title,
            'description' => $request->description,
            'assigned_to' => $request->assigned_to,
            'created_by'  => Auth::id(),
            'priority'    => $request->priority ?? 'medium',
            'due_date'    => $request->due_date,
            'status'      => 'todo',
        ]);

        return redirect('/chef/taches')->with('success', 'Tâche créée avec succès !');
    }

    // Modifier statut tâche
    public function updateStatutTache(Request $request, Task $task)
    {
        if ($task->assigned_to !== Auth::id()) {
            abort(403, 'Accès interdit. Seul l’assigné à la tâche peut modifier son statut.');
        }

        $request->validate([
            'status' => 'required|in:todo,in_progress,review,done',
        ]);

        $task->update(['status' => $request->status]);

        return back()->with('success', 'Statut mis à jour !');
    }

    // Supprimer une tâche
    public function deleteTache(Task $task)
    {
        if (!Auth::user()->isSuperAdmin() && !Auth::user()->teams()->where('teams.id', $task->project->team_id)->exists()) {
            abort(403, 'Accès interdit. Cette tâche ne fait pas partie de vos équipes.');
        }

        $task->delete();
        return back()->with('success', 'Tâche supprimée !');
    }
}