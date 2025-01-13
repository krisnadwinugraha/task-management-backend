<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskComment;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;

class TaskCommentController extends Controller
{
    public function index(Task $task)
    {
        $this->authorize('view', $task);
        
        $comments = $task->comments()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return CommentResource::collection($comments);
    }

    public function store(Request $request, Task $task)
    {
        $this->authorize('view', $task);

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = $task->comments()->create([
            'content' => $validated['content'],
            'user_id' => $request->user()->id,
        ]);

        return new CommentResource($comment->load('user'));
    }

    public function destroy(Task $task, TaskComment $comment)
    {
        $this->authorize('delete', $comment);
        
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}