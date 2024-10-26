<?php

namespace App\Policies;

use App\Models\Pods;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use function Symfony\Component\Translation\t;

class PodsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pods $pods): bool
    {
        //
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->hasPermission('create-pod');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pods $pods): bool
    {
        //
        return $user->hasPermission('update-pod');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pods $pods): bool
    {
        //
        return $user->hasPermission('delete-pod');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pods $pods): bool
    {
        //
        return $user->hasPermission('restore-pod');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pods $pods): bool
    {
        //
        return $user->hasPermission('delete-pod-force');
    }
}
