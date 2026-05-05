<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Project;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function teamProductivity(Team $team)
    {
        $members = $team->members()->with(['tasks' => function ($query) use ($team) {
            $query->whereHas('project', function ($q) use ($team) {
                $q->where('team_id', $team->id);
            });
        }])->get();

        $report = $members->map(function ($member) {
            $tasks = $member->tasks;
            return [
                'user'         => $member->name,
                'total_tasks'  => $tasks->count(),
                'done'         => $tasks->where('status', 'done')->count(),
                'in_progress'  => $tasks->where('status', 'in_progress')->count(),
                'todo'         => $tasks->where('status', 'todo')->count(),
                'productivity' => $tasks->count() > 0
                    ? round(($tasks->where('status', 'done')->count() / $tasks->count()) * 100)
                    : 0,
            ];
        });

        return response()->json($report);
    }

    public function projectProgress(Project $project)
    {
        $tasks = $project->tasks;

        return response()->json([
            'project'     => $project->name,
            'status'      => $project->status,
            'progress'    => $project->progress,
            'total_tasks' => $tasks->count(),
            'done'        => $tasks->where('status', 'done')->count(),
            'in_progress' => $tasks->where('status', 'in_progress')->count(),
            'review'      => $tasks->where('status', 'review')->count(),
            'todo'        => $tasks->where('status', 'todo')->count(),
            'start_date'  => $project->start_date,
            'end_date'    => $project->end_date,
        ]);
    }
}