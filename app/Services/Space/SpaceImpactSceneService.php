<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:50 AM
 */

namespace App\Services\Space;

use App\Repositories\Platform\Space\SpaceImpactSceneRepository;
use App\Services\ResourceService;

class SpaceImpactSceneService extends ResourceService
{

    /**
     * SpaceService constructor.
     * @param SpaceImpactSceneRepository $repository
     */
    function __construct(SpaceImpactSceneRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param null $category_id
     * @param null $sub_category_id
     * @param null $format_id
     * @param null $publisher_id
     * @param null $city_id
     * @return mixed
     */
    public function searchWithSpaces($category_id = null, $sub_category_id = null, $format_id = null, $publisher_id = null, $city_id = null)
    {
        return $this->repository->scenesWithSpaces($category_id, $sub_category_id, $format_id,  $publisher_id, $city_id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCategoryId($id)
    {
        return $this->getModel($id)->category_id;
    }
    
}