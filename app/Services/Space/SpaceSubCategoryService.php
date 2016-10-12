<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:50 AM
 */

namespace App\Services\Space;

use App\Repositories\Platform\Space\SpaceSubCategoryRepository;
use App\Services\ResourceService;

class SpaceSubCategoryService extends ResourceService
{

    /**
     * SpaceService constructor.
     * @param SpaceSubCategoryRepository $repository
     */
    function __construct(SpaceSubCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param null $category_id
     * @param null $publisher_id
     * @param null $city_id
     * @param null $scene_id
     * @return mixed
     */
    public function searchWithSpaces($category_id = null, $publisher_id = null, $city_id = null, $scene_id = null)
    {
        return $this->repository->subCategoriesWithSpaces($category_id, $publisher_id, $city_id, $scene_id, $column = "name_category_name", $id = "id",
            ["subcat_espacios_ofrecidos_LIST.nombre_subcat_LI", "subcat_espacios_ofrecidos_LIST.id_subcat_LI", "subcat_espacios_ofrecidos_LIST.id_cat_LI"]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCategoryId($id)
    {
        return $this->getModel($id)->category_id;
    }
    
}