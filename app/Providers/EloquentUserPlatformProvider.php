<?php
/**
 * Created by PhpStorm.
 * User: andrestntx
 * Date: 7/27/16
 * Time: 10:03 AM
 */

namespace App\Providers;


use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class EloquentUserPlatformProvider extends EloquentUserProvider
{
    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain = $credentials['password'];

        return (crypt($plain, $user->getAuthPassword()) == $user->getAuthPassword());
    }

}