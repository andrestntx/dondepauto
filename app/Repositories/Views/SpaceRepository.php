<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 1:22 PM
 */

namespace App\Repositories\Views;


use App\Entities\Platform\User;
use App\Repositories\BaseRepository;

class SpaceRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Views\Space';
    }

    /**
     * @param User $publisher
     * @return mixed
     */
    public function search(User $publisher = null)
    {
        $query = $this->model->whereIsDelete(0)->with(['images']);

        if(!is_null($publisher)) {
            $query->wherePublisherId($publisher->id);
        }

        return $query->orderBy('created_at', 'desc');
    }
}