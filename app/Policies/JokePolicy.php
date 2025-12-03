<?php

namespace App\Policies;

use App\Models\Joke;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JokePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Joke $joke): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['client','staff','admin','super-user']);
    }

    public function update(User $user, Joke $joke): bool
    {
        if ($user->hasRole('client')) {
            return $joke->user_id === $user->id;
        }

        if ($user->hasAnyRole(['staff','admin'])) {
            return true;
        }

        return $user->hasRole('super-user');
    }

    public function delete(User $user, Joke $joke): bool
    {
        if ($user->hasRole('client')) {
            return $joke->user_id === $user->id;
        }

        if ($user->hasRole('staff')) {
            return $joke->user_id === $user->id;
        }

        return $user->hasAnyRole(['admin','super-user']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Joke $joke): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Joke $joke): bool
    {
        return false;
    }
}
