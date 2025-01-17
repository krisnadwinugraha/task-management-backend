<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Everyone can view users (filtered in controller)
    }

    public function view(User $user): bool
    {
        return $user->hasRole(['admin', 'manager']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'manager']);
    }

    public function update(User $user): bool
    {
        return $user->hasRole(['admin', 'manager']);
    }

    public function delete(User $user): bool
    {
        return $user->hasRole(['admin']);
    }
}
