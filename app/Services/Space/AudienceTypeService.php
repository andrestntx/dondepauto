<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:50 AM
 */

namespace App\Services\Space;

use App\Repositories\Platform\Space\AudienceTypeRepository;
use App\Services\ResourceService;

class AudienceTypeService extends ResourceService
{

    function __construct(AudienceTypeRepository $repository)
    {
        $this->repository = $repository;
    }
    
}