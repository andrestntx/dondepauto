<?php

namespace App\Policies;

use App\Entities\Platform\ConfigModule;
use App\Entities\User;
use App\Entities\Platform\User as PlatformUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlatformUserPolicy
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
     * @param PlatformUser $publisher
     * @return bool
     */
    public function agreement(User $user, PlatformUser $publisher)
    {
        if($user->user_platform_id == $publisher->id && $publisher->complete_data && ! $publisher->in_verification && ( $publisher->in_update_documents || ! $publisher->has_documents) ) {
            return true;
        }
    }

    /**
     * @param User $user
     * @param PlatformUser $publisher
     * @return bool
     */
    public function proposals(User $user, PlatformUser $publisher)
    {
        $directContact  = ConfigModule::getStartConfig('direct_contact');

        if($user->user_platform_id == $publisher->id && $directContact && $publisher->direct_contact) {
            return true;
        }

        return true;
    }

    /**
     * @param User $user
     * @param PlatformUser $publisher
     * @return bool
     */
    public function changeAgreement(User $user, PlatformUser $publisher)
    {
        if ($user->user_platform_id == $publisher->id && ($publisher->has_signed_agreement || $publisher->in_verification)) {
            return true;
        }
    }

    /**
     * @param User $user
     * @param PlatformUser $publisher
     * @return bool
     */
    public function account(User $user, PlatformUser $publisher)
    {
        if($user->user_platform_id == $publisher->id && ! $publisher->complete_data) {
            return true;
        }
    }

    /**
     * @param User $user
     * @param PlatformUser $publisher
     * @return bool
     */
    public function inventory(User $user, PlatformUser $publisher)
    {
        if($user->user_platform_id == $publisher->id && $publisher->complete_data) {
            return true;
        }
    }
}
