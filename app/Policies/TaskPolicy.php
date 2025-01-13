<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Everyone can view tasks (filtered in controller)
    }

    public function view(User $user, Task $task): bool
    {
        return $user->hasRole(['admin', 'manager']) || 
               $task->assigned_to === $user->id || 
               $task->created_by === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'manager']);
    }

    public function update(User $user, Task $task): bool
    {
        return $user->hasRole(['admin', 'manager']) || 
               $task->assigned_to === $user->id;
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->hasRole(['admin']);
    }
}