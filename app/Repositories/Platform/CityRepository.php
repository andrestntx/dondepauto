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

    protected function citiesWithUsers($role)
    {
        return $this->model
            ->join('bd_us_reg_LIST', 'id_ciudad', '=', 'id_ciudad_LI')
            ->where('tipo_us_LI', User::getRole($role))
            ->groupBy('id_ciudad')
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

    /**
     * @return mixed
     */
    public function citiesWithSpaces($colunm = "ciudad", $id = "ciudad")
    {
        return $this->model
            ->join('bd_espacios_ofrecidos_LIST', 'id_ciudad', '=', 'id_ciudad_LI')
            ->groupBy('id_ciudad')
            ->lists($colunm, $id)
            ->all();
    }
    
}