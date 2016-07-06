<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:14 AM
 */

namespace App\Entities\Platform\Space;

use App\Entities\Platform\Entity;

class SpaceImpactScene extends Entity
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_tipo_lugar_LI';

    protected $databaseTranslate = ['name' => 'nombre_tipo_lugar_LI'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tipos_lugares_ubicacion_espacios_LIST';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function spaces()
    {
        return $this->hasMany(Space::class, 'id_tipo_lugar_LI', 'id_tipo_lugar_ubicacion_LI');
    }


}