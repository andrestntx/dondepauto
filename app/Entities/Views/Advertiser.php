<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 18/04/2016
 * Time: 2:02 PM
 */

namespace App\Entities\Views;

class Advertiser extends PUser
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'view_advertisers';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name', 'state', 'state_class', 'state_icon', 'state_id', 'count_intentions',
        'count_by_contact_intentions', 'count_sold_intentions', 'count_discarded_intentions', 'count_interest_intentions',
        'count_management_intentions', 'count_leads',
        'created_at_datatable', 'activated_at_datatable', 'last_log_login_at_datatable', 'states'];

    /**
     * @return mixed
     */
    public function getCountIntentionsAttribute()
    {
        return $this->intentions->count();
    }

    /**
     * @param string $state
     * @return mixed
     */
    protected function getCountIntentions($state = 'by_contact')
    {
        return $this->intentions->where('state', $state)->count();
    }

    /**
     * @return mixed
     */
    protected function getCountLeadsAttribute()
    {
        return $this->intentions->filter(function ($intention, $key) {
            return $intention->state != 'interest';
        })->count();
    }

    /**
     * @return mixed
     */
    public function getCountInterestIntentionsAttribute()
    {
        return $this->getCountIntentions('interest');
    }

    /**
     * @return mixed
     */
    public function getCountByContactIntentionsAttribute()
    {
        return $this->getCountIntentions();
    }

    /**
     * @return mixed
     */
    public function getCountManagementIntentionsAttribute()
    {
        return $this->getCountIntentions('management');
    }

    /**
     * @return mixed
     */
    public function getCountSoldIntentionsAttribute()
    {
        return $this->getCountIntentions('sold');
    }

    /**
     * @return mixed
     */
    public function getCountDiscardedIntentionsAttribute()
    {
        return $this->getCountIntentions('discarded');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function intentions()
    {
        return $this->hasMany('App\Entities\Platform\Intention', 'id_us_anunciante_LI', 'id');
    }

}