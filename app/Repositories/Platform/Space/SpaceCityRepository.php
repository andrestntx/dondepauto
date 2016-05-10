<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:21 AM
 */

namespace App\Repositories\Platform\Space;

use App\Repositories\BaseRepository;

class SpaceCityRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Platform\Space\SpaceCity';
    }

    /**
     * @param null $category_id
     * @param null $subCategory_id
     * @param null $format_id
     * @param string $column
     * @param string $id
     * @return mixed
     */
    public function citiesWithSpaces($category_id = null, $subCategory_id = null, $format_id = null,
                                     $column = "nombre_ciudad_LI", $id = "bd_ciudades_LIST.id_ciudad_LI")
    {
        $query = $this->model
            ->join('bd_espacios_ofrecidos_LIST', 'bd_espacios_ofrecidos_LIST.id_ciudad_LI', '=', 'bd_ciudades_LIST.id_ciudad_LI')
            ->groupBy('bd_ciudades_LIST.id_ciudad_LI')
            ->orderBy('nombre_ciudad_LI', 'asc');

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