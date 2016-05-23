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

    public function searchWithSpaces($category_id = null, $publisher_id = null)
    {
        return $this->repository->subCategoriesWithSpaces($category_id, $publisher_id);
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