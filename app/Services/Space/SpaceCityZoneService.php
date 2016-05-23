<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:50 AM
 */

namespace App\Services\Space;

use App\Repositories\Platform\Space\SpaceCityZoneRepository;
use App\Services\ResourceService;

class SpaceCityZoneService extends ResourceService
{
    protected $viewRepository;


    /**
     * SpaceService constructor.
     * @param SpaceCityZoneRepository $repository
     */
    function __construct(SpaceCityZoneRepository $repository)
    {
        $this->repository = $repository;
    }
    
}