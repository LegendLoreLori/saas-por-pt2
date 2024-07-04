<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ListingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function index(User $user): bool
    {
        return $user->can('listing-browse');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(User $user, Listing $listing): bool
    {
        return $user->can('listing-show', $listing);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('listing-add');
    }

    /**
     * Determine whether the user can view management page for models.
     */
    public function manage(User $user): bool
    {
        return $user->can('manage-listings');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Listing $listing): Response
    {
        if ($user->can('manage-listings')) {
            return Response::allow();
        }

        if ($user->can('listing-edit')){
            return $user->id === $listing->user_id
                ? Response::allow()
                : Response::denyAsNotFound();
        }

        return Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Listing $listing): bool
    {
        if ($user->can('manage-listings')) {
            return true;
        }

        if ($user->can('listing-delete')) {
            return $user->id === $listing->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Listing $listing): bool
    {
        if ($user->can('manage-listings')) {
            return true;
        }

        if ($user->can('listing-delete')) {
            return $user->id === $listing->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function remove(User $user, Listing $listing): bool
    {
        if ($user->can('manage-listings')) {
            return true;
        }

        if ($user->can('listing-delete')) {
            return $user->id === $listing->user_id;
        }

        return false;
    }
}
