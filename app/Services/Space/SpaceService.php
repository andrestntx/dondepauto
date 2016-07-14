<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:50 AM
 */

namespace App\Services\Space;

use App\Entities\Platform\Space\Space;
use App\Entities\Platform\Space\SpaceFormat;
use App\Entities\Platform\User;
use App\Repositories\File\SpaceImagesRepository;
use App\Repositories\Platform\Space\SpaceRepository;
use App\Repositories\Views\SpaceRepository as ViewSpaceRepository;
use App\Services\ResourceService;

class SpaceService extends ResourceService
{
    protected $viewRepository;
    protected $imagesRepository;

    /**
     * UserService constructor.
     * @param ViewSpaceRepository $viewRepository
     * @param SpaceRepository $repository
     * @param SpaceImagesRepository $imagesRepository
     */
    function __construct(ViewSpaceRepository $viewRepository, SpaceRepository $repository, SpaceImagesRepository $imagesRepository)
    {
        $this->viewRepository = $viewRepository;
        $this->repository = $repository;
        $this->imagesRepository = $imagesRepository;
    }

    /**
     * @param User $publisher
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search(User $publisher = null)
    {
        return $this->viewRepository->search($publisher);
    }

    /**
     * @param Space $space
     * @return string
     */
    protected function generateImageName(Space $space) 
    {
        return $space->id . '_' . rand(1,9000000000000) . '.jpg';
    }
    

    /**
     * @param array $images
     * @param Space $space
     * @return array
     */
    public function saveImages(array $images, Space $space)
    {
        $names = array();
        $space->images()->delete();

        foreach ($images as $key => $image) {
            $name = $this->generateImageName($space);
            array_push($names, $name);

            if($key == 0) {
                $this->imagesRepository->saveSpaceImage($image, $name, true);
                $this->repository->updateDetailThumb($space, $name);
            }
            else {
                $this->imagesRepository->saveSpaceImage($image, $name);
            }

            $this->repository->createImage($space, $name);
        }
        
        return $names;
    }

    /**
     * @param array $data
     * @param SpaceFormat $format
     * @param User $publisher
     * @param bool $active
     * @return array
     */
    protected function getData(array $data, SpaceFormat $format, User $publisher, $active = true) {
        $activeString = 'Si_act';
        
        if( ! $active) {
            $activeString = 'No_act';
        }
        
        return $data + [
            'sub_category_id'   => $format->subCategory->id,
            'category_id'       => $format->getCategory()->id,
            'publisher_company' => $publisher->company,
            'active'            => $activeString,
            'publisher_id'      => $publisher->id
        ];
    }

    /**
     * @param array $data
     * @param SpaceFormat $format
     * @param User $publisher
     * @return mixed
     */
    public function createSpace(array $data, SpaceFormat $format, User $publisher)
    {
        return $this->repository->create($this->getData($data, $format, $publisher));
    }

    /**
     * @param array $data
     * @param SpaceFormat $format
     * @param Space $space
     * @return mixed
     */
    public function updateSpace(array $data, SpaceFormat $format, Space $space)
    {
        return $this->repository->update($this->getData($data, $format, $space->publisher), $space);
    }

    public function countSpaces(User $user) 
    {
        return $this->repository->countSpaces($user);
    }
}