<?php

namespace App\Policies;

use App\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

    /**
     * @param User $user
     * @param $ability
     * @return bool
     */
    public function before(User $user, $ability)
    {
        if ($user->isAdmin() || $user->isDirector()) {
            return true;
        }
    }

    /**
     * @param User $user
     * @param User $userEdit
     * @return bool
     */
    public function advertisers(User $user, User $userEdit)
    {
        if($user->id == $userEdit->id) {
            return true;
        }
    }
}
