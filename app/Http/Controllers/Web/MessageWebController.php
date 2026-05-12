<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageWebController extends Controller
{
    public function index()
    {
        $teams = Auth::user()->teams()->with('messages.sender')->get();
        $selectedTeam = $teams->first();
        $messages = $selectedTeam ? $selectedTeam->messages()->with('sender')->orderBy('created_at')->get() : collect();
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