<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:21 AM
 */

namespace App\Repositories\Platform\Space;

use App\Repositories\BaseRepository;

class SpaceCategoryRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Platform\Space\SpaceCategory';
    }
    
    /**
     * @param string $column
     * @param string $id
     * @return mixed
     */
    public function categoriesWithSpaces($column = "nombre_cat_LI", $id = "cat_espacios_ofrecidos_LIST.id_cat_LI")
    {
        return $this->model
            ->join('subcat_espacios_ofrecidos_LIST', 'subcat_espacios_ofrecidos_LIST.id_cat_LI', '=', 'cat_espacios_ofrecidos_LIST.id_cat_LI')
            ->join('espacios_ofrecidos_LIST', 'espacios_ofrecidos_LIST.id_subcat_LI', '=', 'subcat_espacios_ofrecidos_LIST.id_subcat_LI')
            ->groupBy('cat_espacios_ofrecidos_LIST.id_cat_LI')
            ->lists($column, $id)
            ->all();
    }
    
    public function selectSubcategories()
    {
        $categories = $this->model->with('subCategories')->orderBy('nombre_cat_LI')->get();
        $select = [];

        foreach ($categories as $category) {
            $select[$category->name] = [];
            foreach ($category->subCategories->sortBy('nombre_subcat_LI') as $subCategory) {
                $select[$category->name][$subCategory->id] = $subCategory->name;
            }
        }
        
        return $select;
    }
    
}