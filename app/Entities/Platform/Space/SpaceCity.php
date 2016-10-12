<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:14 AM
 */

namespace App\Entities\Platform\Space;


use App\Entities\Platform\City;
use Illuminate\Database\Eloquent\Builder;

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

    /**
     * @param Builder $query
     * @param null $publisher_id
     * @return mixed
     */
    public function scopeJoinSpaces(Builder $query, $publisher_id = null)
    {
        $query->join('city_space', 'city_space.city_id', '=', 'ciudades_LIST.id_ciudad_LI');

        if(! is_null($publisher_id) && ! empty($publisher_id)) {
            return $query->join('espacios_ofrecidos_LIST', function ($join) use($publisher_id) {
                $join->on('city_space.space_id', '=', 'espacios_ofrecidos_LIST.id_espacio_LI')
                    ->where('espacios_ofrecidos_LIST.id_us_reg_LI', '=', $publisher_id);
            });
        }

        return $query->join('espacios_ofrecidos_LIST', 'espacios_ofrecidos_LIST.id_espacio_LI', '=', 'city_space.space_id');
    }

    /**
     * @param Builder $query
     * @param $scene_id
     * @return mixed
     */
    public function scopeJoinScenes(Builder $query, $scene_id)
    {
        return $query->join('impact_scene_space', function ($join) use($scene_id) {
            $join->on('impact_scene_space.space_id', '=', 'espacios_ofrecidos_LIST.id_espacio_LI')
                ->where('impact_scene_space.impact_scene_id', '=', $scene_id);
        });
    }

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeGroupById(Builder $query)
    {
        return $query->groupBy('ciudades_LIST.id_ciudad_LI');
    }

}