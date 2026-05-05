<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request, Team $team)
    {
        $projects = $team->projects()->with('tasks')->get();
        return ProjectResource::collection($projects);
    }

    public function store(StoreProjectRequest $request, Team $team)
    {
        $project = $team->projects()->create($request->only(
            'name', 'description', 'status', 'start_date', 'end_date'
        ));

        return response()->json([
            'message' => 'Projet créé avec succès',
            'project' => new ProjectResource($project),
        ], 201);
    }

    public function show(Project $project)
    {
        return new ProjectResource(
            $project->load('team', 'tasks.assignee', 'files')
        );
    }

    public function update(StoreProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $project->update($request->only(
            'name', 'description', 'status', 'start_date', 'end_date'
        ));

        return response()->json([
            'message' => 'Projet mis à jour',
            'project' => new ProjectResource($project),
        ]);
    }

    public function destroy(Request $request, Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();

        return response()->json([
            'message' => 'Projet supprimé',
        ]);
    }
}