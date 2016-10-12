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
use Illuminate\Database\Eloquent\Model;

class SpaceFormat extends Entity
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_formato_LI';

    protected $appends = ['id', 'name'];

    protected $databaseTranslate = ['name' => 'nombre_formato_LI', 'description' => 'descripcion_formato_LI', 'sub_category_id' => 'id_subcat_LI'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formatos_espacios_ofrecidos_LIST';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subCategory()
    {
        return $this->belongsTo(SpaceSubCategory::class, 'id_subcat_LI', 'id_subcat_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function spaces()
    {
        return $this->hasMany(Space::class, 'id_formato_LI', 'id_formato_LI');
    }

    /**
     * @return Model
     */
    public function getCategory()
    {
        return $this->subCategory->category;
    }

    /**
     * @return string
     */
    public function getCategoryNameAttribute()
    {
        return $this->getCategory()->name;
    }

    /**
     * @return string
     */
    public function getCategorySubCategoryNameAttribute()
    {
        return $this->subCategory->name . ' - ' . $this->category_name . ' - ' . $this->name;
    }

    /**
     * @param Builder $query
     * @param null $publisher_id
     * @return mixed
     */
    public function scopeJoinSpaces(Builder $query, $publisher_id = null)
    {
        if(! is_null($publisher_id)  && ! empty($publisher_id)) {
            return $query->join('espacios_ofrecidos_LIST', function ($join) use($publisher_id) {
                $join->on('formatos_espacios_ofrecidos_LIST.id_formato_LI', '=', 'formatos_espacios_ofrecidos_LIST.id_formato_LI')
                    ->where('espacios_ofrecidos_LIST.id_us_reg_LI', '=', $publisher_id);
            });
        }

        return $query->join('espacios_ofrecidos_LIST', 'espacios_ofrecidos_LIST.id_formato_LI', '=', 'formatos_espacios_ofrecidos_LIST.id_formato_LI');
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
     * @param $city_id
     * @return mixed
     */
    public function scopeJoinCities(Builder $query, $city_id)
    {
        return $query->join('city_space', function ($join) use($city_id) {
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
        return $query->groupBy('formatos_espacios_ofrecidos_LIST.id_formato_LI');
    }

    /**
     * @param Builder $query
     * @param $category_id
     * @return $this
     */
    public function scopeOfSubCategory(Builder $query, $category_id)
    {
        return $query->where('formatos_espacios_ofrecidos_LIST.id_subcat_LI', $category_id);
    }
}