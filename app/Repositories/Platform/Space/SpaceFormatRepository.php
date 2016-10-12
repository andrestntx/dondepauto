<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:21 AM
 */

namespace App\Repositories\Platform\Space;


use App\Repositories\BaseRepository;

class SpaceFormatRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Platform\Space\SpaceFormat';
    }


    /**
     * @param null $subCategory_id
     * @param null $publisher_id
     * @param null $city_id
     * @param null $scene_id
     * @param string $column
     * @param string $id
     * @return mixed
     */
    public function formatsWithSpaces($subCategory_id = null, $publisher_id = null, $city_id = null, $scene_id = null,
                                      $column = "nombre_formato_LI", $id = "formatos_espacios_ofrecidos_LIST.id_formato_LI")
    {
        $query = $this->model
            ->joinSpaces($publisher_id)
            ->groupById()
            ->orderBy('nombre_formato_LI', 'asc');

        if(! is_null($city_id) && !empty($city_id) ){
            $query->joinCities($city_id);
        }

        if(! is_null($scene_id) && !empty($scene_id) ) {
            $query->joinScenes($scene_id);
        }

        if(! is_null($subCategory_id) && ! empty($subCategory_id) ){
            $query->ofSubCategory($subCategory_id);
        }

        return $query->lists($column, $id)->all();
    }

    public function listsSelectComplete()
    {
        $key  = $this->model->getKeyName();

        return $this->model
            ->with(['subCategory.category'])
            ->get()
            ->sortBy('category_sub_category_name')
            ->lists('category_sub_category_name', $key)
            ->all();
    }

    public function jsonFormats()
    {
        return $this->model->select('nombre_formato_LI', 'id_formato_LI', 'id_subcat_LI')->get()->groupBy('id_subcat_LI')->toJson();
    }
}