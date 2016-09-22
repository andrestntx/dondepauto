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
     * @param null $spaceId
     * @param array $columns
     * @return mixed
     */
    public function search(User $publisher = null, $spaceId = null, array $columns = [])
    {
        $query = $this->model->whereIsDelete(0)->with(['images']);

        if(!is_null($publisher)) {
            $query->wherePublisherId($publisher->id);
        }
        if(!is_null($spaceId)){
            $query->whereId($spaceId);
        }

        foreach ($columns as $column) {
            if ($column['name'] == 'impact_scene_id' && trim($column['search']['value'])) {
                $query->where('impact_scene_id', '=', $column['search']['value']);
            }
        }

        return $query->orderBy('created_at', 'desc');
    }
}