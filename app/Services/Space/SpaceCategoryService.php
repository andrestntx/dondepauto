<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:50 AM
 */

namespace App\Services\Space;

use App\Repositories\Platform\Space\SpaceCategoryRepository;
use App\Services\ResourceService;

class SpaceCategoryService extends ResourceService
{
    protected $viewRepository;


    /**
     * SpaceService constructor.
     * @param SpaceCategoryRepository $repository
     */
    function __construct(SpaceCategoryRepository $repository)
    {
        $this->repository = $repository;
    }
    
}