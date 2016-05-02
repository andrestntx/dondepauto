<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class ResourceService {
    /**
     * @var BaseRepository
     */
    protected $repository;

    /**
     * @return mixed
     */
    public function listModels()
    {
        return $this->repository->paginate();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function newModel(array $data = array())
    {
        return $this->repository->newModel($data);
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function getModel($id = null) {
        return $this->repository->find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createModel(array $data)
    {
        return $this->repository->create($data);
    }
    
    /**
     * @param array $data
     * @param Model $entity
     * @return mixed
     */
    public function updateModel(array $data, Model $entity)
    {
        return $this->repository->update($data, $entity);
    }

    /**
     * @param $entity
     * @return bool
     */
    public function deleteModel($entity)
    {
        try {
            $this->repository->delete($entity);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}