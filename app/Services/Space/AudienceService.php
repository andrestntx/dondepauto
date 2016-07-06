<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:50 AM
 */

namespace App\Services\Space;

use App\Repositories\Platform\Space\AudienceRepository;
use App\Services\ResourceService;

class AudienceService extends ResourceService
{


    /**
     * AudienceService constructor.
     * @param AudienceRepository $repository
     */
    function __construct(AudienceRepository $repository)
    {
        $this->repository = $repository;
    }
}