<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:14 AM
 */

namespace App\Entities\Platform;


class City extends Entity
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_ciudad';

    protected $attr = ['name' => 'ciudad', 'id' => 'id_ciudad'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ciudades';

    public function getNameAttribute()
    {
        return $this->ciudad;
    }

}