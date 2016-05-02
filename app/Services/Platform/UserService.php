<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 13/04/2016
 * Time: 10:39 AM
 */

namespace App\Services\Platform;


use App\Entities\User;
use App\Repositories\Platform\UserRepository;
use App\Services\ResourceService;

class UserService extends ResourceService
{

    /**
     * UserService constructor.
     * @param UserRepository $repository
     */
    function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
}