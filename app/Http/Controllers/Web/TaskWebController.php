<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskWebController extends Controller
{
    public function index()
    {
        $tasks = Auth::user()->tasks()->with('project')->latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        if (Auth::user()->isSuperAdmin()) {
            $projects = Project::all();
        } else {
            $teams    = Auth::user()->teams()->with('projects')->get();
            $projects = $teams->flatMap->projects;
        }
        $users    = User::all();
        return view('tasks.create', compact('projects', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'priority'    => 'in:low,medium,high,urgent',
            'due_date'    => 'nullable|date',
        ]);

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

        return redirect('/tasks')->with('success', 'Tâche créée avec succès !');
    }

    public function show(Task $task)
    {
        $task->load('project', 'assignee', 'creator', 'comments.user');
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        if (Auth::user()->isSuperAdmin()) {
            $projects = Project::all();
        } else {
            $teams    = Auth::user()->teams()->with('projects')->get();
            $projects = $teams->flatMap->projects;
        }
        $users    = User::all();
        return view('tasks.edit', compact('task', 'projects', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'priority'    => 'in:low,medium,high,urgent',
            'due_date'    => 'nullable|date',
            'status'      => 'nullable|in:todo,in_progress,review,done',
        ]);

        $data = $request->only(
            'title', 'description', 'assigned_to', 'priority', 'due_date'
        );

        if (Auth::id() === $task->assigned_to && $request->has('status')) {
            $data['status'] = $request->status;
        }

        $task->update($data);

        return redirect('/tasks')->with('success', 'Tâche mise à jour !');
    }

    public function updateStatus(Request $request, Task $task)
    {
        if ($task->assigned_to !== Auth::id()) {
            abort(403, 'Accès interdit. Seul l’assigné à la tâche peut modifier son statut.');
        }

        $request->validate([
            'status' => 'required|in:todo,in_progress,review,done',
        ]);

        $task->update(['status' => $request->status]);

        return back()->with('success', 'Statut de la tâche mis à jour !');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect('/tasks')->with('success', 'Tâche supprimée !');
    }
}