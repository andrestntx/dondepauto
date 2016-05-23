<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:14 AM
 */

namespace App\Entities\Platform\Space;


use App\Entities\Platform\City;

class SpaceCity extends City
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_ciudad_LI';

    protected $databaseTranslate = ['name' => 'nombre_ciudad_LI'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ciudades_LIST';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function zones()
    {
        return $this->hasMany(SpaceCityZone::class, 'id_zona_LI', 'id_zona_LI');
    }
}