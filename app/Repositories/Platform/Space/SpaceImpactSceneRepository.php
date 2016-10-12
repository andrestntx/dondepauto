<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:21 AM
 */

namespace App\Repositories\Platform\Space;

use App\Repositories\BaseRepository;

class SpaceImpactSceneRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Platform\Space\SpaceImpactScene';
    }


    /**
     * @param null $category_id
     * @param null $subCategory_id
     * @param null $format_id
     * @param null $publisher_id
     * @param null $city_id
     * @param string $column
     * @param string $id
     * @param null $select
     * @return mixed
     */
    public function scenesWithSpaces($category_id = null, $subCategory_id = null, $format_id = null, $publisher_id = null, $city_id = null,
                                     $column = "nombre_tipo_lugar_LI", $id = "tipos_lugares_ubicacion_espacios_LIST.id_tipo_lugar_LI", $select = null)
    {
        if(is_null($select)) {
            $select = [$column, $id];
        }

        $query = $this->model
            ->select($select)
            ->joinSpaces($publisher_id)
            ->groupById()
            ->orderBy($column, 'asc');

        if(! is_null($city_id) && !empty($city_id) ){
            $query->joinCities($city_id);
        }

        if(! is_null($format_id) && ! empty($format_id)) {
            $query->where("id_formato_LI", $format_id);
        }
        else if(! is_null($subCategory_id) && ! empty($subCategory_id)) {
            $query->where("id_subcat_LI", $subCategory_id);
        }
        else if(! is_null($category_id) && ! empty($category_id)) {
            $query->where("id_cat_LI", $category_id);
        }

        return $query->lists($column, $id)->all();
    }
    
}