<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function index(User $user): bool
    {
        return $user->can('user-browse');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->can('user-show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /*
     * Determine whether the user can view the edit page for the model.
     */
    public function edit(User $user, User $model): bool
    {
        if ($user->can(['manage-staff', 'user-edit'])) return true;
        if ($user->can(['manage-clients', 'user-edit'])) {
            return !$model->hasRole('admin');
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->can('user-edit')) {
            if ($user->can('manage-staff')) return true;
            if ($user->can('manage-clients')
                && !$model->hasRole('admin')) return true;
            return $user->id === $model->id;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        //
    }


    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        //
    }
}
