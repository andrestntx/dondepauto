<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:48 AM
 */

namespace App\Facades;

use App\Services\MediumService;
use App\Services\Space\SpaceCategoryService;
use App\Services\Space\SpaceCityService;
use App\Services\Space\SpaceFormatService;
use App\Services\Space\SpaceService;
use App\Services\Space\SpaceSubCategoryService;
use Illuminate\Database\Eloquent\Model;

class SpaceFacade
{
    protected $service;
    protected $subCategoryService;
    protected $formatService;
    protected $categoryService;
    protected $cityService;
    protected $mediumService;

    public function __construct(SpaceService $service, SpaceSubCategoryService $subCategoryService, SpaceFormatService $formatService,
        SpaceCategoryService $categoryService, SpaceCityService $cityService, MediumService $mediumService)
    {
        $this->service = $service;
        $this->subCategoryService = $subCategoryService;
        $this->formatService = $formatService;
        $this->categoryService = $categoryService;
        $this->cityService = $cityService;
        $this->mediumService = $mediumService;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search()
    {
        return $this->service->search();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createModel(array $data)
    {
        return $this->service->createModel($data);        
    }

    /**
     * @param array $data
     * @param Model $space
     * @return mixed
     */
    public function updateModel(array $data, Model $space)
    {
        return $this->service->updateModel($data, $space);
    }

    /**
     * @param null $category_id
     * @param null $subCategory_id
     * @param null $medium_id
     * @param null $format_id
     * @param null $city_id
     * @return array
     */
    public function ajax($category_id = null, $subCategory_id = null, $medium_id = null, $format_id = null, $city_id = null)
    {
        $result = [];

        if(is_null($format_id) || empty($format_id)) {
            if(is_null($subCategory_id) || empty($subCategory_id)) {
                $result['sub_categories'] = $this->subCategoryService->searchWithSpaces($category_id, $medium_id);
            }
            else {
                $result['formats'] = $this->formatService->searchWithSpaces($subCategory_id);
            }
        }

        if(is_null($city_id) || empty($city_id)) {
            $result['cities'] = $this->cityService->searchWithSpaces($category_id, $subCategory_id, $format_id);
        }

        $result['mediums']        = $this->mediumService->searchWithSpaces($category_id, $subCategory_id, $format_id, $city_id);

        return $result;
    }
}