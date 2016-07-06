<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 1:31 PM
 */

namespace App\Entities\Views;


use Carbon\Carbon;

class Publisher extends PUser
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'activated_at', 'signed_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'view_publishers';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name', 'state', 'state_class', 'state_icon', 'state_id', 'created_at_datatable',
        'last_log_login_at_datatable', 'signed_agreement_lang', 'space_city_names', 'activated_at_datatable',
        'signed_at_datatable', 'states', 'count_spaces', 'has_offers', 'last_offer_at_datatable', 'created_at_humans'
    ];

    public function getStatesAttribute()
    {
        return  array_merge(parent::getStatesAttribute(), [
            'agreement' => [
                'icon'  => 'fa fa-file-text-o',
                'class' => $this->getClass($this->signed_agreement),
                'text'  => 'Firmó acuerdo'
            ],
            'offers' => [
                'icon'  => 'fa fa-tags',
                'class' => $this->getClass($this->has_offers),
                'text'  => 'Ofertó'
            ],
        ]);
    }

    /**
     * @return mixed
     */
    public function getCountSpacesAttribute()
    {
        return $this->spaces->count();
    }

    /**
     * @return mixed
     */
    public function getLastOfferAttribute()
    {
        return $this->spaces->max('created_at');
    }

    /**
     * @return bool
     */
    public function getHasOffersAttribute()
    {
        if($this->last_offer){
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getLastOfferAtDatatableAttribute()
    {
        if($this->last_offer)
        {
            return Carbon::createFromFormat('Y-m-d H:i:s', $this->last_offer)->format('d/m/Y');
        }

        return '';
    }

    public function getSignedAgreementLangAttribute()
    {
        if($this->signed_agreement)
        {
            return 'Si';
        }

        return 'No';
    }

    /**
     * @return string
     */
    public function getSignedAtDatatableAttribute()
    {
        if($this->signed_at) {
            return $this->signed_at->format('d/m/Y');
        }

        return '';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function spaces()
    {
        return $this->hasMany('App\Entities\Views\Space', 'publisher_id', 'id');
    }

    /**
     * @return mixed
     */
    public function getSpaceCityNamesAttribute()
    {
        return implode(",", $this->spaces->lists('city_name')->all());
    }

    /**
     * @return string
     */
    public function getEconomicActivityNameAttribute($value)
    {
        if($value) {
            return $value;
        }

        return 'Sin registrar';
    }

    /**
     * @return mixed
     */
    public function getCreatedAtHumansAttribute()
    {
        return $this->created_at->diffForHumans();
    }

}