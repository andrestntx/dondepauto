<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:14 AM
 */

namespace App\Entities\Platform;


use Carbon\Carbon;

class Action extends Entity
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
    protected $table = 'actions';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['action_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function contacts()
    {
        return $this->belongsToMany('App\Entities\Platform\Contact', 'action_contact', 'action_id', 'contact_id');
    }

    /**
     * @return null|string
     */
    public function getActionAtAttribute()
    {
        if($this->pivot) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $this->pivot->action_at)->format('d-M-Y h:i A');
        }

        return null;
    }

}