<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembreController extends Controller
{
    // Dashboard Membre
    public function dashboard()
    {
        $user    = Auth::user();
        $teams   = $user->teams()->with('projects', 'members')->get();
        $myTasks = $user->tasks()->with('project')->latest()->take(5)->get();

        $stats = [
            'teams'      => $teams->count(),
            'tasks'      => $user->tasks()->count(),
            'tasks_done' => $user->tasks()->where('status', 'done')->count(),
            'in_progress'=> $user->tasks()->where('status', 'in_progress')->count(),
        ];

        return view('membre.dashboard', compact('user', 'teams', 'myTasks', 'stats'));
    }

    // Mes tâches
    public function mesTaches()
    {
        $tasks = Auth::user()->tasks()->with('project')->latest()->get();
        return view('membre.taches', compact('tasks'));
    }

    // Modifier statut tâche
    public function updateStatut(Request $request, Task $task)
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

    // Ajouter commentaire
    public function addComment(Request $request, Task $task)
    {
        if (!Auth::user()->isSuperAdmin() && !Auth::user()->teams()->where('teams.id', $task->project->team_id)->exists()) {
            abort(403, 'Accès interdit. Vous ne faites pas partie de l’équipe de ce projet.');
        }

        $request->validate([
            'content' => 'required|string',
        ]);

        $task->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Commentaire ajouté !');
    }
}