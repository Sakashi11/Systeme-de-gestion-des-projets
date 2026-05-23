<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user     = Auth::user();
        $teams    = $user->teams()->with('projects', 'members')->get();
        $myTasks  = $user->tasks()->with('project')->latest()->take(5)->get();
        $projects = $teams->flatMap->projects->take(5);

        $stats = [
            'teams'      => $teams->count(),
            'projects'   => $teams->flatMap->projects->count(),
            'tasks'      => $user->tasks()->count(),
            'tasks_done' => $user->tasks()->where('status', 'done')->count(),
        ];

        return view('dashboard', compact('user', 'teams', 'myTasks', 'projects', 'stats'));
    }
}