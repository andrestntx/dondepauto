<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 26/04/2016
 * Time: 5:48 PM
 */

namespace App\Entities\Platform\Space\Simple;


use App\Entities\Platform\Entity;
use App\Entities\Platform\User;
use App\Entities\Proposal\Proposal;
use App\Services\Space\SpacePointsService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Space extends \App\Entities\Platform\Space\Space
{

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];
}