<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:14 AM
 */

namespace App\Entities\Platform\Space;

use App\Entities\Platform\Entity;
use Illuminate\Database\Eloquent\Builder;

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

    /**
     * @param Builder $query
     * @param null $publisher_id
     * @return mixed
     */
    public function scopeJoinSpaces(Builder $query, $publisher_id = null)
    {
        $query->join('impact_scene_space', 'impact_scene_space.impact_scene_id', '=', 'tipos_lugares_ubicacion_espacios_LIST.id_tipo_lugar_LI');

        if(! is_null($publisher_id)  && ! empty($publisher_id)) {
            return $query->join('espacios_ofrecidos_LIST', function ($join) use($publisher_id) {
                $join->on('impact_scene_space.space_id', '=', 'espacios_ofrecidos_LIST.id_espacio_LI')
                    ->where('espacios_ofrecidos_LIST.id_us_reg_LI', '=', $publisher_id);
            });
        }

        return $query->join('espacios_ofrecidos_LIST', 'espacios_ofrecidos_LIST.id_espacio_LI', '=', 'impact_scene_space.space_id');
    }

    /**
     * @param Builder $query
     * @param $city_id
     */
    public function scopeJoinCities(Builder $query, $city_id)
    {
        $query->join('city_space', function ($join) use($city_id) {
            $join->on('city_space.space_id', '=', 'espacios_ofrecidos_LIST.id_espacio_LI')
                ->where('city_space.city_id', '=', $city_id);
        });
    }

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeGroupById(Builder $query)
    {
        return $query->groupBy('tipos_lugares_ubicacion_espacios_LIST.id_tipo_lugar_LI');
    }

}