<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:21 AM
 */

namespace App\Repositories\Platform\Space;

use App\Repositories\BaseRepository;

class AudienceTypeRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Platform\Space\AudienceType';
    }

    /**
     * @return array
     */
    public function selectAudiences()
    {
        $types = $this->model->with('audiences')->orderBy('name')->get();
        $select = [];

        foreach ($types as $type) {
            $select[$type->name] = [];
            foreach ($type->audiences->sortBy('name') as $audience) {
                $select[$type->name][$audience->id] = $audience->name;
            }
        }

        return $select;
    }
}