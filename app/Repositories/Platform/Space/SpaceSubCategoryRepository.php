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
     * @param string $column
     * @param string $id
     * @return mixed
     */
    public function subCategoriesWithSpaces($category_id = null, $publisher_id = null, $column = "name_category_name", $id = "id")
    {
        $query = $this->model->with('category')
            ->join('bd_espacios_ofrecidos_LIST', 'bd_espacios_ofrecidos_LIST.id_subcat_LI', '=', 'bd_subcat_espacios_ofrecidos_LIST.id_subcat_LI')
            ->groupBy('bd_subcat_espacios_ofrecidos_LIST.id_subcat_LI');
        
        if(! is_null($category_id) && !empty($category_id) ){
            $query->where('bd_subcat_espacios_ofrecidos_LIST.id_cat_LI', $category_id);
        }
        if(! is_null($publisher_id) && !empty($publisher_id) ){
            $query->where('id_us_reg_LI', $publisher_id);
        }

        return $query->get()
            ->sortBy('category_name')
            ->lists($column, $id)
            ->all();
    }
    
}