<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:48 AM
 */

namespace App\Facades;

use App\Entities\Platform\Space\Space;
use App\Entities\Platform\User;
use App\Services\PublisherService;
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
    protected $publisherService;

    public function __construct(SpaceService $service, SpaceSubCategoryService $subCategoryService, SpaceFormatService $formatService,
        SpaceCategoryService $categoryService, SpaceCityService $cityService, PublisherService $publisherService)
    {
        $this->service = $service;
        $this->subCategoryService = $subCategoryService;
        $this->formatService = $formatService;
        $this->categoryService = $categoryService;
        $this->cityService = $cityService;
        $this->publisherService = $publisherService;
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
     * @param array $images
     * @param User $publisher
     * @return mixed
     */
    public function createModel(array $data, array $images = null, User $publisher)
    {
        $format = $this->formatService->getModel($data['format_id']);
        $space  = $this->service->createSpace($data, $format, $publisher);
        
        if($images) {
            $imageNames = $this->service->saveImages($data['images'], $space);
        }
        
        return $space;
    }


    /**
     * @param array $data
     * @param array|null $images
     * @param Space $space
     * @return Space|mixed
     */
    public function updateModel(array $data, array $images = null, Space $space)
    {
        $format = $this->formatService->getModel($data['format_id']);
        $space  = $this->service->updateSpace($data, $format, $space);

        if($images) {
            $imageNames = $this->service->saveImages($data['images'], $space);
        }
        
        return $space;
    }

    /**
     * @param null $category_id
     * @param null $subCategory_id
     * @param null $publisher_id
     * @param null $format_id
     * @param null $city_id
     * @return array
     */
    public function ajax($category_id = null, $subCategory_id = null, $publisher_id = null, $format_id = null, $city_id = null)
    {
        $result = [];

        if(is_null($format_id) || empty($format_id)) {
            if( is_null($subCategory_id) || empty($subCategory_id)) {
                $result['sub_categories'] = $this->subCategoryService->searchWithSpaces($category_id, $publisher_id);
            }
            else {
                $result['formats'] = $this->formatService->searchWithSpaces($subCategory_id);
            }
        }

        if(is_null($city_id) || empty($city_id)) {
            $result['cities'] = $this->cityService->searchWithSpaces($category_id, $subCategory_id, $format_id);
        }

        $result['publishers']        = $this->publisherService->searchWithSpaces($category_id, $subCategory_id, $format_id, $city_id);

        return $result;
    }

    public function countSpaces(User $user) 
    {
        return $this->service->countSpaces($user);
    }
}