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
     * @param User $publisher
     * @param Model|null $entity
     * @return mixed
     */
    public function createOrUpdate(array $data, User $publisher, Model $entity = null)
    {
        return $this->createOrUpdateModel($data + ['publisher_id' => $publisher->id], $entity);
    }
    
}