<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class NoticePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->role === User::ROLE_ADMIN
            ? Response::allow()
            : Response::deny('権限がありません');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response
    {
        return $user->role === User::ROLE_ADMIN
            ? Response::allow()
            : Response::deny('権限がありません');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        return $user->role === User::ROLE_ADMIN
            ? Response::allow()
            : Response::deny('権限がありません');
    }
}
