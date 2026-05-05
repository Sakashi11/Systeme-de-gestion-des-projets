<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Message;
use App\Http\Resources\MessageResource;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Team $team)
    {
        $messages = $team->messages()
                        ->with('sender')
                        ->orderBy('created_at', 'asc')
                        ->get();

        return MessageResource::collection($messages);
    }

    public function store(Request $request, Team $team)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $message = $team->messages()->create([
            'sender_id' => $request->user()->id,
            'content'   => $request->content,
        ]);

        return response()->json([
            'message' => 'Message envoyé',
            'data'    => new MessageResource($message->load('sender')),
        ], 201);
    }

    public function destroy(Request $request, Message $message)
    {
        if ($message->sender_id !== $request->user()->id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $message->delete();

        return response()->json([
            'message' => 'Message supprimé',
        ]);
    }
}