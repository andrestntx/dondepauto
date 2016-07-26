<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:14 AM
 */

namespace App\Entities\Platform;


class Bank extends Entity
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'banks';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function banks()
    {
        return $this->belongsToMany('App\Entities\Platform\User', 'bank_user', 'bank_id', 'publisher_id');
    }
}