<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 18/04/2016
 * Time: 2:02 PM
 */

namespace App\Entities\Views;

use Carbon\Carbon;

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
        'count_management_intentions', 'count_leads', 'created_at_humans', 'count_proposals', 'count_logs',
        'created_at_datatable', 'activated_at_datatable', 'last_log_login_at_datatable', 'states', 'last_login_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function intentions()
    {
        return $this->hasMany('App\Entities\Platform\Intention', 'id_us_anunciante_LI', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proposals()
    {
        return $this->hasMany('App\Entities\Proposal\Proposal', 'advertiser_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany('App\Entities\Platform\Contact', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function views()
    {
        return $this->belongsToMany('App\Entities\Platform\Space\Space', 'visualizacion_espacios_ofrecidos_LIST', 'id_usuario_LI', 'idEspacio_LI')
            ->withPivot('fechaVisualizacion_LI');
    }

    /**
     * @return array
     */
    public function getStatesAttribute()
    {
        /*$count_logs = $this->count_logs;
        $count_views = $this->count_views;*/

        return  array_merge(parent::getStatesAttribute(), [
            /*'logs' => [
                'icon'  => 'fa fa-tags',
                'class' => $this->getClass($count_logs),
                'text'  => 'Sesiones: ' . $count_logs,
                'date'  => $this->last_login_at_humans
            ],
            'views' => [
                'icon'  => 'fa fa-file-o',
                'class' => $this->getClass($count_views),
                'text'  => 'Vistas de espacios: ' . $count_views,
                'date'  => $this->last_view_at_humans
            ]*/
        ]);
    }

    /**
     * @return mixed
     */
    public function getLastView()
    {
        return $this->views->max('view_at');
    }


    /**
     * @return string
     */
    public function getLastViewAtHumansAttribute()
    {
        if($lasView = $this->getLastView())
        {
            return Carbon::createFromFormat('Y-m-d H:i:s', $lasView)->format('d-M-y');
        }

        return '';
    }

    /**
     * @return string
     */
    public function getCountViewsAttribute()
    {
        return $this->views->count();
    }
    
    /**
     * @return mixed
     */
    public function getCountIntentionsAttribute()
    {
        return $this->intentions->count();
    }

    /**
     * @return mixed
     */
    public function getCountProposalsAttribute()
    {
        return $this->proposals->count();
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
     * @return mixed
     */
    public function getCreatedAtHumansAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

}