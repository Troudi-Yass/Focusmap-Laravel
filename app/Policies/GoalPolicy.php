<?php

namespace App\Policies;

use App\Models\Goal;
use App\Models\User;

class GoalPolicy
{
    /**
     * Determine if the user can view any goals.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view goals list
    }

    /**
     * Determine if the user can view the goal.
     */
    public function view(User $user, Goal $goal): bool
    {
        return $user->id === $goal->user_id;
    }

    /**
     * Determine if the user can create goals.
     */
    public function create(User $user): bool
    {
        return true; // All authenticated users can create goals
    }

    /**
     * Determine if the user can update the goal.
     */
    public function update(User $user, Goal $goal): bool
    {
        return $user->id === $goal->user_id;
    }

    /**
     * Determine if the user can delete the goal.
     */
    public function delete(User $user, Goal $goal): bool
    {
        return $user->id === $goal->user_id;
    }

    /**
     * Determine if the user can restore the goal.
     */
    public function restore(User $user, Goal $goal): bool
    {
        return $user->id === $goal->user_id;
    }

    /**
     * Determine if the user can permanently delete the goal.
     */
    public function forceDelete(User $user, Goal $goal): bool
    {
        return $user->id === $goal->user_id;
    }
}