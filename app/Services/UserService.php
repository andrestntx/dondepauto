<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 13/04/2016
 * Time: 10:39 AM
 */

namespace App\Services;


use App\Entities\User;
use App\Entities\Platform\User as RUser;
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
     * @param null $password
     * @param RUser $publisher
     * @return mixed
     */
    public function createPublisher(array $data, $password = null, RUser $publisher)
    {
        if(! is_null($password)) {
            $data['password'] = $password;    
        }
        
        $data['user_platform_id'] = $publisher->id;
        return $this->createUserWithRole($data, 'publisher');
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

    /**
     * @param array $data
     * @return array
     */
    public function divideName(array &$data)
    {
        if(!array_key_exists('first_name', $data) && array_key_exists('name', $data)){
            $names = explode(' ', $data['name']);
            $data['first_name'] = array_shift($names);
            $data['last_name']  = implode(' ', $names);
        }

        return $data;
    }
    
}