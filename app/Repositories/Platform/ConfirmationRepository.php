<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 26/04/2016
 * Time: 9:13 AM
 */

namespace App\Repositories\Platform;


use App\Entities\Platform\User;
use App\Repositories\BaseRepository;

class ConfirmationRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Platform\Confirmation';
    }

    /**
     * @param User $user
     * @param $code
     * @return mixed
     */
    public function generateConfirmation(User $user, $code)
    {
        return $this->create([
            'user_id'   => $user->id,
            'code'      => $code,
            'active'    => false
        ]);
    }
}