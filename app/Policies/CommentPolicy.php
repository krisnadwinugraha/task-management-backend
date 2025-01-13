<?php

namespace App\Policies;

use App\Models\TaskComment;
use App\Models\User;

class CommentPolicy
{
    public function delete(User $user, TaskComment $comment): bool
    {
        return $user->hasRole('admin') || $comment->user_id === $user->id;
    }
}