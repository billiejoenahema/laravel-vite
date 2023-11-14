<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Role;
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
        return $user->role === Role::ADMIN->value
            ? Response::allow()
            : Response::deny('権限がありません');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response
    {
        return $user->role === Role::ADMIN->value
            ? Response::allow()
            : Response::deny('権限がありません');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        return $user->role === Role::ADMIN->value
            ? Response::allow()
            : Response::deny('権限がありません');
    }
}
