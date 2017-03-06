<?php

namespace App\Policies;

use App\Attachment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MediaPolicy
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
        return $user->role == 'content-manager';
    }
}
