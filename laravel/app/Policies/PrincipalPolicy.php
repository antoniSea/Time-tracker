<?php

namespace App\Policies;

use App\Models\Principal;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PrincipalPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Principal $principal): bool
    {
        return $principal->user()->is($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Principal $principal): Response
    {
        return $principal->user()->is($user)
            ? Response::allow()
            : Response::deny('You do not own this principal.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Principal $principal): Response
    {
        return $principal->user()->is($user)
            ? Response::allow()
            : Response::deny('You do not own this principal.');
    }
}
