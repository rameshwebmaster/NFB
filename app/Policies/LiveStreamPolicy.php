<?php

namespace App\Policies;

use App\Stream;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LiveStreamPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before($user, $ability)
    {
        if ($user->role == 'admin') {
            return true;
        }
    }

    public function viewMenu(User $user)
    {
        return $user->role == 'doctor';
    }

}
