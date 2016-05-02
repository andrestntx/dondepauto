<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 13/04/2016
 * Time: 10:39 AM
 */

namespace App\Services;


use App\Entities\User;
use App\Repositories\UserRepository;

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

    /**
     * @param array $data
     * @return mixed
     */
    public function createAdviser(array $data)
    {
        return $this->createUserWithRole($data, 'adviser');
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createDirector(array $data)
    {
        return $this->createUserWithRole($data, 'director');
    }

    /**
     * @param array $data
     * @param $role
     * @return mixed
     */
    protected function createUserWithRole(array $data, $role)
    {
        return $this->repository->createWithRole($data, $role);
    }

    /**
     * Get the advertisers for the adviser.
     * @param User $user
     * @return mixed
     */
    public function advertisers(User $user)
    {
        return $this->repository->advertisers($user);
    }
    
}