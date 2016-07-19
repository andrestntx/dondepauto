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
use App\Services\Space\SpacePointsService;
use App\Services\Space\SpaceService;
use App\Services\Space\SpaceSubCategoryService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SpaceFacade
{
    protected $service;
    protected $subCategoryService;
    protected $formatService;
    protected $categoryService;
    protected $cityService;
    protected $publisherService;
    protected $spacePointsService;

    public function __construct(SpaceService $service, SpaceSubCategoryService $subCategoryService, SpaceFormatService $formatService,
        SpaceCategoryService $categoryService, SpaceCityService $cityService, PublisherService $publisherService, SpacePointsService $spacePointsService)
    {
        $this->service = $service;
        $this->subCategoryService = $subCategoryService;
        $this->formatService = $formatService;
        $this->categoryService = $categoryService;
        $this->cityService = $cityService;
        $this->publisherService = $publisherService;
        $this->spacePointsService = $spacePointsService;
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
        $this->recalculatePoints($space);

        return $space;
    }

    /**
     * @param array $data
     * @param array $images
     * @param array $keep_images
     * @param User $publisher
     * @param Space $copySpace
     * @return mixed
     */
    public function duplicateModel(array $data, $images = [], $keep_images = [], User $publisher, Space $copySpace)
    {
        $format = $this->formatService->getModel($data['format_id']);
        $space  = $this->service->createSpace($data, $format, $publisher);
        $this->service->saveAndCopyImages($images, $space, $copySpace, $keep_images);
        
        $this->recalculatePoints($space);

        return $space;
    }


    /**
     * @param array $data
     * @param array $images
     * @param array $keep_images
     * @param Space $space
     * @return Space|mixed
     */
    public function updateModel(array $data, $images = [], $keep_images = [], Space $space)
    {
        $format = $this->formatService->getModel($data['format_id']);
        $space  = $this->service->updateSpace($data, $format, $space);
        $this->service->saveImages($images, $space, $keep_images);

        $this->recalculatePoints($space);

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

    /**
     * @param User $user
     * @return mixed
     */
    public function countSpaces(User $user)
    {
        return $this->service->countSpaces($user);
    }

    /**
     * @param Space $space
     * @return mixed
     */
    public function recalculatePoints(Space $space) 
    {
        $points = $this->spacePointsService->calculatePoints($space);
        return $this->service->updateModel(['points' => $points], $space);
    }

    /**
     * @param User $publisher
     * @return mixed
     */
    public function recalculatePublisherPoints(User $publisher)
    {
        return $this->recalculateSpacesPoints($publisher->spaces);
    }

    /**
     * @return mixed
     */
    public function recalculateAllPoints()
    {
        return $this->recalculateSpacesPoints($this->service->allSpaces());
    }

    /**
     * @param Collection $spaces
     * @return mixed
     */
    public function recalculateSpacesPoints(Collection $spaces)
    {
        foreach ($spaces as $space) {
            $this->recalculatePoints($space);
        }

        return $spaces;
    }

    /**
     * @param Space $space
     * @param bool $active
     */
    public function activeSpace(Space $space, $active = true)
    {
        $this->service->activeSpace($space, $active);
    }
}