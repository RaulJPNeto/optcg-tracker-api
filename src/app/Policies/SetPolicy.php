<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\CardSet;
use App\Models\User;

class SetPolicy
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
    public function view(User $user, CardSet $cardSet): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::ADMIN, UserRole::EDITOR]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CardSet $cardSet): bool
    {
        return in_array($user->role, [UserRole::ADMIN, UserRole::EDITOR]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CardSet $cardSet): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CardSet $cardSet): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CardSet $cardSet): bool
    {
        return false;
    }
}
