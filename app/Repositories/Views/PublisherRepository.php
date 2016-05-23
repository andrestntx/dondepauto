<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 1:22 PM
 */

namespace App\Repositories\Views;


use App\Repositories\BaseRepository;

class PublisherRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Views\Publisher';
    }

    /**
     * @return mixed
     */
    public function search()
    {
        return $this->model->with(['spaces.city'])->get();
    }

    /**
     * @param null $category_id
     * @param null $subCategory_id
     * @param null $format_id
     * @param null $city_id
     * @param string $column
     * @param string $id
     * @return mixed
     */
    public function publishersWithSpaces($category_id = null, $subCategory_id = null, $format_id = null, $city_id = null, $column = "company", $id = "id")
    {
        $query = $this->model
            ->join('espacios_ofrecidos_LIST', 'id_us_reg_LI', '=', 'id')
            ->groupBy('id')
            ->orderBy('company', 'asc');

        if(! is_null($format_id) && ! empty($format_id)) {
            $query->where("id_formato_LI", $format_id);
        }
        else if(! is_null($subCategory_id) && ! empty($subCategory_id)) {
            $query->where("id_subcat_LI", $subCategory_id);
        }
        else if(! is_null($category_id) && ! empty($category_id)) {
            $query->where("id_cat_LI", $category_id);
        }

        if(! is_null($city_id) && ! empty($city_id)) {
            $query->where("id_ciudad_LI", $city_id);
        }
        
        return $query->lists($column, $id)->all();
    }
}