<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 1:31 PM
 */

namespace App\Entities\Views;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'view_spaces';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];
}