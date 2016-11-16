<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:21 AM
 */

namespace App\Repositories\Platform;


use App\Entities\Platform\User;
use App\Repositories\BaseRepository;

class ActionRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Platform\Action';
    }

    protected function listsOfType($type = 'advertiser')
    {
        return $this->model->ofUser($type)->lists('name', 'id')->all();
    }

    /**
     * @return mixed
     */
    public function listsAdvertiser()
    {
        return $this->listsOfType();
    }

    /**
     * @return mixed
     */
    public function listsPublisher()
    {
        return $this->listsOfType('publisher');
    }
}