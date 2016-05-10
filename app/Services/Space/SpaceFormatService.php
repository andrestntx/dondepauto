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

    public function searchWithSpaces($subCategory_id = null)
    {
        return $this->repository->formatsWithSpaces($subCategory_id);
    }
}