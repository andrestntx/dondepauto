<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:14 AM
 */

namespace App\Entities\Platform\Space;


use App\Entities\Platform\Entity;

class SpaceCityZone extends Entity
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_zona_LI';

    protected $attr = ['name' => 'nombre_zona_LI', 'city_id' => 'id_ciudad_LI'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bd_zonas_ciudades_LIST';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(SpaceCity::class, 'id_ciudad_LI');
    }
}