<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:14 AM
 */

namespace App\Entities\Platform;


class Locality extends Entity
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_localidad_li';

    protected $attr = ['name' => 'nombre_localidad_LI', 'city_id' => 'id_ciudad_LI'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bd_localidades_LITS';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'id_ciudad_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function neighborhoods()
    {
        return $this->hasMany(Neighborhood::class, 'id_ciudad_LI', 'id_ciudad_LI');
    }
}