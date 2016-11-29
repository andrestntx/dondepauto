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
     * @param bool $syncBool
     * @return mixed
     */
    public function updateModel(array $data, Model $entity, $syncBool = true)
    {
        return $this->repository->update($data, $entity, $syncBool);
    }

    /**
     * @param array $data
     * @param Model|null $entity
     * @return mixed
     */
    public function createOrUpdateModel(array $data, Model $entity = null)
    {
        if(is_null($entity)) {
            return $this->repository->create($data);    
        }

        return $this->repository->update($data, $entity);
    }

    /**
     * @param $entity
     * @param bool $force
     * @return bool
     */
    public function deleteModel($entity, $force = false)
    {
        try {
            $this->repository->delete($entity, $force);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * @param $entity
     * @return mixed
     */
    public function restoreModel(&$entity)
    {
        return $entity->restore();
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function findDelete($key, $value)
    {
        return $this->repository->findDelete($key, $value);
    }

}