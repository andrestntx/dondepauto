<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 1:22 PM
 */

namespace App\Repositories\Views;


use App\Repositories\BaseRepository;

class MediumRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Views\Medium';
    }

    /**
     * @return mixed
     */
    public function search()
    {
        return $this->model->with(['logs', 'spaces.city'])->get();
    }
}