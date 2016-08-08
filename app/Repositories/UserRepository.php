<?php
/**
 * Created by PhpStorm.
 * Users: Desarrollador 1
 * Date: 13/04/2016
 * Time: 10:26 AM
 */

namespace App\Repositories;


use App\Entities\User;

class UserRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\User';
    }

    /**
     * @return mixed
     */
    public function advisers()
    {
        return $this->getAllOfRole('adviser');  
    }

    /**
     * @return mixed
     */
    public function directors()
    {
        return $this->getAllOfRole('director');
    }

    /**
     * @param $role
     * @return mixed
     */
    protected function getAllOfRole($role)
    {
        return $this->model->role($role)->get();
    }

    /**
     * @param array $data
     * @param $role
     * @return mixed
     */
    public function createWithRole(array $data, $role)
    {
        $user = $this->newModel();
        $user->fill($data);
        $user->role = $role;
        $user->save();
        
        return $user;
    }


    /**
     * @param User $user
     * @return mixed
     */
    public function scopeAdvertisers(User $user)
    {
        return $user->clients()->role('advertiser');
    }
    
    /**
     * @param User $user
     * @return mixed
     */
    public function advertisers(User $user)
    {
        return $this->scopeAdvertisers($user)->get();
    }

    /**
     * @param string $role
     * @param string $column
     * @param string|null $key
     * @return mixed
     */
    function listsSelectUsers($role = 'adviser', $column = "name", $key = "id")
    {
        return $this->model->role($role)->get()->lists($column, $key)->all();
    }

    /**
     * @param string $column
     * @param string|null $key
     * @return mixed
     */
    function listsSelectAdvisers($column = "name", $key = "id")
    {
        return $this->listsSelectUsers();
    }

    /**
     * @param string $column
     * @param string|null $key
     * @return mixed
     */
    function listsSelectDirectors($column = "name", $key = "id")
    {
        return $this->listsSelectUsers('director');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function changeRole(User $user, $role)
    {
        $user->role = $role;
        return $user->save();
    }
}