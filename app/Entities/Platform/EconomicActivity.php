<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 10:10 AM
 */

namespace App\Entities\Platform;


class EconomicActivity extends Entity
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bd_actividades_economicas_LIST';

    protected $attr = ['name' => 'nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function advertisers()
    {
        return $this->hasMany('App\Entities\Views\Advertiser', 'economic_activity_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Entities\Platform\User', 'id_actividadEconomica_LI', 'id');
    }

    /**
     * @return mixed
     */
    public function getNameAttribute()
    {
        return $this->nombre;
    }
}