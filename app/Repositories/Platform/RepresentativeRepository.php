<?php
/**
 * Created by PhpStorm.
 * Users: Desarrollador 1
 * Date: 13/04/2016
 * Time: 10:26 AM
 */

namespace App\Repositories\Platform;


use App\Entities\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class RepresentativeRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Platform\Representative';
    }
}