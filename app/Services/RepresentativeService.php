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
        if(empty($data['doc'])) {
            $data['doc'] = $publisher->doc;
        }

        if(empty($data['email'])) {
            $data['email'] = $publisher->email;
        }

        return $data;
    }

    /**
     * @param array $data
     * @param User $publisher
     * @param Model|null $entity
     * @return mixed
     */
    public function createOrUpdate(array $data, User $publisher, Model $entity = null)
    {
        return $this->createOrUpdateModel($this->getData($data, $publisher) + ['publisher_id' => $publisher->id], $entity);
    }
    
}