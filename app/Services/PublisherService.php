<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:50 AM
 */

namespace App\Services;

use App\Repositories\Platform\UserRepository;
use App\Repositories\Views\PublisherRepository;
use Illuminate\Database\Eloquent\Model;

class PublisherService extends ResourceService
{
    protected $viewRepository;

    /**
     * UserService constructor.
     * @param PublisherRepository $viewRepository
     * @param UserRepository $repository
     */
    function __construct(PublisherRepository $viewRepository, UserRepository $repository)
    {
        $this->viewRepository = $viewRepository;
        $this->repository = $repository;
    }


    /**
     * @param array $columns
     * @param array $search
     * @return mixed
     */
    public function search(array $columns, array $search)
    {
        return $this->viewRepository->search($columns, $search);
    }

    /**
     * @param array $data
     * @param Model $publisher
     * @return mixed
     */
    public function completeData(array $data, Model $publisher)
    {
        $data['complete_data'] = true;
        return $this->updateModel($data, $publisher);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createModel(array $data)
    {
        $data['role'] = 'publisher';
        $data['complete_data'] = false;
        return $this->repository->create($data);
    }

    /**
     * @param null $category_id
     * @param null $subCategory_id
     * @param null $format_id
     * @param null $city_id
     * @return mixed
     */
    public function searchWithSpaces($category_id = null, $subCategory_id = null, $format_id = null, $city_id = null)
    {
        return $this->viewRepository->publishersWithSpaces($category_id, $subCategory_id, $format_id, $city_id);
    }

    /**
     * @param $publisher
     * @return mixed
     */
    public function getSpaces($publisher)
    {
        return $this->repository->getSpaces($publisher);
    }

    /**
     * @param array $data
     * @param null $password
     * @return mixed
     */
    public function register(array $data, $password = null)
    {
        if(! is_null($password)) {
            $data['password'] = $password;
        }

        return $this->createModel($data);
    }
}