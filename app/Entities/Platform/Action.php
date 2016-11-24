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
    protected $appends = ['action_at', 'action_at_date', 'action_at_humans'];

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
            if($this->pivot->action_at == '0000-00-00 00:00:00') {
                return '';
            }

            return Carbon::createFromFormat('Y-m-d H:i:s', $this->pivot->action_at)->format('d-M-y \- h:i A');
        }

        return '';
    }

    /**
     * @return null|string
     */
    public function getActionAtTimeAttribute()
    {
        if($this->pivot) {
            if($this->pivot->action_at == '0000-00-00 00:00:00') {
                return '';
            }

            return Carbon::createFromFormat('Y-m-d H:i:s', $this->pivot->action_at)->format('g:i A');
        }

        return '';
    }

    /**
     * @return null|string
     */
    public function getActionAtDatetimeAttribute()
    {
        if($this->pivot) {
            if($this->pivot->action_at == '0000-00-00 00:00:00') {
                return '';
            }

            return Carbon::createFromFormat('Y-m-d H:i:s', $this->pivot->action_at)->toDateTimeString();
        }

        return '';
    }

    /**
     * @return null|string
     */
    public function getActionAtDateAttribute()
    {
        if($this->pivot) {
            if($this->pivot->action_at == '0000-00-00 00:00:00') {
                return '';
            }

            return Carbon::createFromFormat('Y-m-d H:i:s', $this->pivot->action_at)->format('d-M-y');
        }

        return '';
    }

    /**
     * @return null|string
     */
    public function getActionAtSimpleDateAttribute()
    {
        if($this->pivot) {
            if($this->pivot->action_at == '0000-00-00 00:00:00') {
                return '';
            }

            return Carbon::createFromFormat('Y-m-d H:i:s', $this->pivot->action_at)->toDateString();
        }

        return '';
    }

    /**
     * @return null|string
     */
    public function getActionAtHumansAttribute()
    {
        if($this->pivot) {
            if($this->pivot->action_at == '0000-00-00 00:00:00') {
                return '';
            }

            return ucfirst(Carbon::createFromFormat('Y-m-d H:i:s', $this->pivot->action_at)->diffForHumans());
        }

        return '';
    }

    /**
     * @param null $start
     * @param null $end
     * @return bool
     */
    public function isInRange($start = null, $end = null)
    {
        $action_at = $this->action_at_simple_date;

        if($start && $end) {
            return strtotime($action_at) >= strtotime($start) && strtotime($action_at) <= strtotime($end);
        }
        else if($start) {
            return strtotime($action_at) >= strtotime($start);
        }
        else if ($end) {
            return strtotime($action_at) <= strtotime($end);
        }

        return true;
    }

    /**
     * @param null $id
     * @param null $start
     * @param null $end
     * @return bool
     */
    public function isActionAndIsInRange($id = null, $start = null, $end = null)
    {
        if(!is_null($id) && !empty($id)) {
            return $this->id == $id && $this->isInRange($start, $end);
        }

        return $this->isInRange($start, $end);
    }

    /**
     * @param $query
     * @param string $type
     * @return mixed
     */
    public function scopeOfUser($query, $type = 'advertiser')
    {
        return $query->where(function($query) use ($type) {
            return $query->where('type', $type)
                ->orWhere('type', 'all')
                ->orWhere('type', 'users');
            });
    }

}