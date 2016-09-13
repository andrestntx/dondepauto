<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:50 AM
 */

namespace App\Services;

use App\Entities\Platform\User;
use App\Repositories\Platform\RepresentativeRepository;
use Illuminate\Database\Eloquent\Model;

class RepresentativeService extends ResourceService
{
    function __construct(RepresentativeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * @param $publisher
     * @return array
     */
    protected function getData(array &$data, $publisher)
    {
        if(empty($data['name'])) {
            $data['name'] = $publisher->full_name;
        }

        if(empty($data['phone'])) {
            $data['phone'] = $publisher->cel;
        }

        if(empty($data['email'])) {
            $data['email'] = $publisher->email;
        }

        return $data;
    }

    protected function getEntity($email, $doc, $entity = null)
    {
        if(is_null($entity)) {
            $entity = $this->repository->findRepre($email, $doc);
        }

        return $entity;
    }

    /**
     * @param array $data
     * @param User $publisher
     * @param Model|null $entity
     * @return mixed
     */
    public function createOrUpdate(array $data, User $publisher, Model $entity = null)
    {
        if( ! empty($data['email']) || ! empty($data['doc']) || ! empty($data['phone']) || ! empty($data['name'])) {
            $data = $this->getData($data, $publisher);
            $entity = $this->getEntity($data['email'], $data['doc'], $entity);
            $entity = $this->createOrUpdateModel($data, $entity);
            $publisher->representative()->associate($entity);
        }

        return null;
    }
}