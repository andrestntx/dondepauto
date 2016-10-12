<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:21 AM
 */

namespace App\Repositories\Platform;


use App\Entities\Platform\User;
use App\Repositories\BaseRepository;

class CityRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Platform\City';
    }

    /**
     * @param $role
     * @return mixed
     */
    protected function citiesWithUsers($role)
    {
        return $this->model
            ->join('us_reg_LIST', 'id_ciudad', '=', 'id_ciudad_LI')
            ->where('tipo_us_LI', User::getRole($role))
            ->groupBy('id_ciudad')
            ->orderBy('ciudad', 'asc')
            ->lists('ciudad', 'id_ciudad')
            ->all();
    }

    /**
     * @return mixed
     */
    public function citiesWithAdvertisers()
    {
        return $this->citiesWithUsers('advertiser');
    }
    
}