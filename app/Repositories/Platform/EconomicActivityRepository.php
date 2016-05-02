<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 10:10 AM
 */

namespace App\Repositories\Platform;


use App\Entities\Platform\User;
use App\Repositories\BaseRepository;

class EconomicActivityRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Platform\EconomicActivity';
    }

    protected function activitiesWithUsers($role)
    {
        return $this->model
            ->join('bd_us_reg_LIST', 'id', '=', 'id_actividadEconomica_LI')
            ->where('tipo_us_LI', User::getRole($role))
            ->groupBy('id')
            ->lists('nombre', 'id')
            ->all();
    }

    public function activitiesWithAdvertisers()
    {
        return $this->activitiesWithUsers('advertiser');
    }
}