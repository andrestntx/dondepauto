<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:50 AM
 */

namespace App\Services\Space;

use App\Repositories\Platform\Space\SpaceCityRepository;
use App\Services\ResourceService;

class SpaceCityService extends ResourceService
{
    protected $viewRepository;


    /**
     * SpaceService constructor.
     * @param SpaceCityRepository $repository
     */
    function __construct(SpaceCityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param null $category_id
     * @param null $subCategory_id
     * @param null $format_id
     * @return mixed
     */
    public function searchWithSpaces($category_id = null, $subCategory_id = null, $format_id = null)
    {
        return $this->repository->citiesWithSpaces($category_id, $subCategory_id, $format_id);
    }
    
}