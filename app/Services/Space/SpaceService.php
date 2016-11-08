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
use App\Entities\Platform\Space\SpaceImage;
use App\Entities\Platform\User;
use App\Entities\Proposal\Proposal;
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
     * @param $spaceId
     * @param Proposal|null $proposal
     * @return mixed|null
     */
    public function getViewSpace($spaceId, Proposal $proposal = null)
    {
        if($spaces = $this->search([], null, $spaceId, null, $proposal)) {
            return $spaces->first();
        }

        return null;
    }


    /**
     * @param array|null $columns
     * @param string $search
     * @param null $spaceId
     * @param User|null $publisher
     * @param Proposal|null $proposal
     * @return mixed
     */
    public function search(array $columns = null, $search = '', $spaceId = null, User $publisher = null, Proposal $proposal = null)
    {
        return $this->viewRepository->search($columns, $search, $spaceId, $publisher, $proposal);
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
     * @param array $keep_images
     * @return array
     */
    public function saveImages($images = [], Space $space, $keep_images = [])
    {
        $names = array();

        if(!is_null($keep_images) && is_array($keep_images) && count($keep_images) > 0) {
            $space->images()->whereNotIn('id_imagen_LI', $keep_images)->delete();
        }

        if(!is_null($images)) {
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
        }

        if($image = $space->images()->first()) {
            $this->repository->updateDetailThumb($space, $image->url_thumb_LI);
        }

        return $names;
    }

    /**
     * @param array $images
     * @param Space $space
     * @param Space $copySpace
     * @param array $keep_images
     * @return array
     */
    public function saveAndCopyImages($images = [], Space $space, Space $copySpace, $keep_images = [])
    {
        $copyImages = $this->imagesRepository->copyImages($copySpace->images, $keep_images);
        $space->images()->saveMany($copyImages);
        return $this->saveImages($images, $space, $space->images->lists('id'));
    }

    /**
     * @param array $data
     * @param SpaceFormat $format
     * @param User $publisher
     * @param bool $active
     * @return array
     */
    protected function getData(array $data, SpaceFormat $format, User $publisher, $active = true) {
        return $data + [
            'sub_category_id'   => $format->subCategory->id,
            'category_id'       => $format->getCategory()->id,
            'publisher_company' => $publisher->company,
            'active'            => $active,
            'publisher_id'      => $publisher->id
        ];
    }

    /**
     * @param array $data
     * @param SpaceFormat $format
     * @param User $publisher
     * @param bool $active
     * @return mixed
     */
    public function createSpace(array $data, SpaceFormat $format, User $publisher, $active = true)
    {
        return $this->repository->create($this->getData($data, $format, $publisher, $active));
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


    /**
     * @param Space $space
     * @param $points
     * @return bool
     */
    public function updatePoints(Space $space, $points)
    {
        return $this->repository->updatePoints($space, $points);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function countSpaces(User $user) 
    {
        return $this->repository->countSpaces($user);
    }

    /**
     * @return mixed
     */
    public function allSpaces()
    {
        return $this->repository->allSpaces();
    }

    /**
     * @param Space $space
     * @param bool $active
     * @return bool
     */
    public function activeSpace(Space $space, $active = true) 
    {
        return $this->repository->active($space, $active);
    }
}