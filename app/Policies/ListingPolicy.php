<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\User;

class ListingPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Listing $listing): bool
    {
        return $listing->user->role !== 'suspended' && $listing->status == true || $this->admin($user, $listing);
    }


    public function create(User $user): bool
    {
        return $user->role !== 'suspended';
    }

    /**
     * Determine whether the user can modify the model.
     */
    public function modify(User $user, Listing $listing): bool
    {
        return $user->id === $listing->user_id && $user->role !== 'suspended' || $this->admin($user, $listing);
    }

    public function admin(User $user, Listing $listing): bool 
    {
        return $user->isAdmin();
    }
}
