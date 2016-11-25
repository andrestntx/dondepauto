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
     * @return mixed
     */
    public function citiesWithProposals()
    {
        return $this->model
            ->joinSpaces()
            ->join('proposal_space', 'proposal_space.space_id', '=', 'espacios_ofrecidos_LIST.id_espacio_LI')
            ->groupById()
            ->lists('ciudades_LIST.nombre_ciudad_LI', 'ciudades_LIST.id_ciudad_LI')
            ->all();
    }

    /**
     * @param null $category_id
     * @param null $subCategory_id
     * @param null $format_id
     * @param null $publisher_id
     * @param null $scene_id
     * @param string $column
     * @param string $id
     * @param null $select
     * @return mixed
     */
    public function citiesWithSpaces($category_id = null, $subCategory_id = null, $format_id = null, $publisher_id = null, $scene_id = null,
                                     $column = "nombre_ciudad_LI", $id = "ciudades_LIST.id_ciudad_LI", $select = null)
    {
        if(is_null($select)) {
            $select = [$column, $id];
        }

        $query = $this->model
            ->select($select)
            ->joinSpaces($publisher_id)
            ->groupById()
            ->orderBy('nombre_ciudad_LI', 'asc');

        if(! is_null($scene_id) && !empty($scene_id) ){
            $query->joinScenes($scene_id);
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