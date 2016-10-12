<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:50 AM
 */

namespace App\Services\Space;

use App\Repositories\Platform\Space\SpaceFormatRepository;
use App\Services\ResourceService;

class SpaceFormatService extends ResourceService
{
    protected $viewRepository;


    /**
     * SpaceService constructor.
     * @param SpaceFormatRepository $repository
     */
    function __construct(SpaceFormatRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param null $subCategory_id
     * @param null $publisher_id
     * @param null $city_id
     * @param null $scene_id
     * @return mixed
     */
    public function searchWithSpaces($subCategory_id = null, $publisher_id = null, $city_id = null, $scene_id = null)
    {
        return $this->repository->formatsWithSpaces($subCategory_id, $publisher_id, $city_id, $scene_id);
    }
}