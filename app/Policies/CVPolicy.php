<?php

namespace App\Policies;

use App\User;
use App\CV;
use Illuminate\Auth\Access\HandlesAuthorization;

class CVPolicy
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
