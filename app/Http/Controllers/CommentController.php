<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Task $task)
    {
        $comments = $task->comments()->with('user')->orderBy('created_at', 'asc')->get();
        return CommentResource::collection($comments);
    }

    public function store(Request $request, Task $task)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $comment = $task->comments()->create([
            'user_id' => $request->user()->id,
            'content' => $request->content,
        ]);

        return response()->json([
            'message' => 'Commentaire ajouté',
            'comment' => new CommentResource($comment->load('user')),
        ], 201);
    }

    public function destroy(Request $request, Comment $comment)
    {
        if ($comment->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $comment->delete();

        return response()->json([
            'message' => 'Commentaire supprimé',
        ]);
    }
}