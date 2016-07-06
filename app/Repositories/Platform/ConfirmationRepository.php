<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 26/04/2016
 * Time: 9:13 AM
 */

namespace App\Repositories\Platform;


use App\Entities\Platform\Confirmation;
use App\Entities\Platform\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * @param $code
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findOrFailByCode($code)
    {
        return $this->findOrFailBy($this->model->getTranslateOrOriginalKey('code'), $code);
    }

    /**
     * @param $code
     * @return boolean
     */
    public function isActive($code)
    {
        return $this->findOrFailByCode($code)->active;
    } 

    /**
     * @param $code
     * @return User
     */
    public function confirm($code)
    {
        $confirmation = $this->findOrFailByCode($code);
        return $this->confirmModel($confirmation);
    }


    /**
     * @param Model $confirmation
     * @return User
     */
    public function confirmModel(Model $confirmation)
    {
        $confirmation->active = true;
        $confirmation->save();

        return $confirmation->user;
    }

    /**
     * @param $code
     * @return User
     */
    public function getUser($code)
    {
        return $this->findOrFailByCode($code)->user;
    }
}