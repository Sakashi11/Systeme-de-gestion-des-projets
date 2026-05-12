<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectWebController extends Controller
{
    public function index()
    {
    $teams    = Auth::user()->teams()->with('projects.team')->get();
    $projects = $teams->flatMap->projects;
    return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $teams = Auth::user()->teams;
        return view('projects.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'team_id'     => 'required|exists:teams,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'in:planning,active,on_hold,completed',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
        ]);

        Project::create($request->only(
            'team_id', 'name', 'description', 'status', 'start_date', 'end_date'
        ));

        return redirect('/projects')->with('success', 'Projet créé avec succès !');
    }

    public function show(Project $project)
    {
        $project->load('team', 'tasks.assignee', 'files');
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $teams = Auth::user()->teams;
        return view('projects.edit', compact('project', 'teams'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'in:planning,active,on_hold,completed',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
        ]);

        $project->update($request->only(
            'name', 'description', 'status', 'start_date', 'end_date'
        ));

        return redirect('/projects')->with('success', 'Projet mis à jour !');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect('/projects')->with('success', 'Projet supprimé !');
    }
}