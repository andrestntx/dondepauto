<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:21 AM
 */

namespace App\Repositories\Platform\Space;

use App\Repositories\BaseRepository;

class SpaceSubCategoryRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Platform\Space\SpaceSubCategory';
    }


    /**
     * @param null $category_id
     * @param null $publisher_id
     * @param null $city_id
     * @param null $scene_id
     * @param string $column
     * @param string $id
     * @param null $select
     * @return mixed
     */
    public function subCategoriesWithSpaces($category_id = null, $publisher_id = null, $city_id = null, $scene_id = null, $column = "name_category_name", $id = "id", $select = null)
    {
        if(is_null($select)) {
            $select = [$column, $id];
        }

        $query = $this->model->with('category')
            ->select($select)
            ->joinSpaces($publisher_id)
            ->groupById();

        if(! is_null($city_id) && !empty($city_id) ){
            $query->joinCities($city_id);
        }
        if(! is_null($scene_id) && !empty($scene_id) ){
            $query->joinScenes($scene_id);
        }
        if(! is_null($category_id) && !empty($category_id) ){
            $query->ofCategory($category_id);
        }

        return $query->get()
            ->sortBy('category_name')
            ->lists($column, $id)
            ->all();
    }
    
}