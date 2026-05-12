<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index(Project $project)
    {
        $tasks = $project->tasks()->with('assignee', 'creator', 'comments')->get();
        return TaskResource::collection($tasks);
    }

    public function store(StoreTaskRequest $request, Project $project)
    {
        $task = $project->tasks()->create([
            'title'       => $request->title,
            'description' => $request->description,
            'assigned_to' => $request->assigned_to,
            'created_by'  => $request->user()->id,
            'priority'    => $request->priority ?? 'medium',
            'due_date'    => $request->due_date,
            'status'      => 'todo',
        ]);

        return response()->json([
            'message' => 'Tâche créée avec succès',
            'task'    => new TaskResource($task->load('assignee', 'creator')),
        ], 201);
    }

    public function show(Task $task)
    {
        return new TaskResource($task->load('assignee', 'creator', 'comments.user'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $task->update($request->only(
            'title', 'description', 'assigned_to', 'priority', 'due_date', 'status'
        ));

        return response()->json([
            'message' => 'Tâche mise à jour',
            'task'    => new TaskResource($task->load('assignee', 'creator')),
        ]);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:todo,in_progress,review,done',
        ]);

        $task->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Statut mis à jour',
            'task'    => new TaskResource($task),
        ]);
    }

    public function destroy(Request $request, Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return response()->json([
            'message' => 'Tâche supprimée',
        ]);
    }
}