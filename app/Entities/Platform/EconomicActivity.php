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
    protected $table = 'actividades_economicas_LIST';

    protected $databaseTranslate = ['name' => 'nombre'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name'];

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
}