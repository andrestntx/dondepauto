<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:21 AM
 */

namespace App\Repositories\Platform\Space;


use App\Repositories\BaseRepository;

class SpaceRepository extends BaseRepository
{
	protected $boolFillable = ['alcohol_restriction', 'snuff_restriction', 'policy_restriction'];

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Platform\Space\Space';
    }

    /**
     * @param array $data
     * @param Model $entity
     * @return mixed
     */
    public function update(array $data, $entity)
    {
        parent::update($data, $entity);

        $entity->sub_category_id 	= $entity->format->subCategory->id;
        $entity->category_id 		= $entity->format->getCategory()->id; 

        if($entity->save()) {
            return $entity;
        }

        return false;
    }
    
}