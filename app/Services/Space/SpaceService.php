<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:50 AM
 */

namespace App\Services\Space;

use App\Repositories\Platform\Space\SpaceRepository;
use App\Repositories\Views\SpaceRepository as ViewSpaceRepository;
use App\Services\ResourceService;

class SpaceService extends ResourceService
{
    protected $viewRepository;

    /**
     * UserService constructor.
     * @param ViewSpaceRepository $viewRepository
     * @param SpaceRepository $repository
     */
    function __construct(ViewSpaceRepository $viewRepository, SpaceRepository $repository)
    {
        $this->viewRepository = $viewRepository;
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search()
    {
        return ['data' => $this->viewRepository->search()];
    }
}