<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageWebController extends Controller
{
    public function index(Request $request)
    {
        $teams = Auth::user()->teams()->withCount('messages')->get();
        $selectedTeamId = $request->query('team');
        $selectedTeam = $teams->firstWhere('id', $selectedTeamId) ?? $teams->first();

        $teamIds = $teams->pluck('id');
        $messagesQuery = Message::whereIn('team_id', $teamIds)->with('sender', 'team');

        if ($selectedTeam) {
            $messagesQuery->where('team_id', $selectedTeam->id);
        }

        $messages = $messagesQuery->orderBy('created_at', 'desc')->get();

        return view('messages.index', compact('teams', 'selectedTeam', 'messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'team_id' => 'required|exists:teams,id',
            'content' => 'required|string',
        ]);

        Message::create([
            'team_id'   => $request->team_id,
            'sender_id' => Auth::id(),
            'content'   => $request->content,
        ]);

        return back()->with('success', 'Message envoyé !');
    }
}