<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 1:31 PM
 */

namespace App\Entities\Views;


use Carbon\Carbon;

class Medium extends PUser
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
    protected $table = 'view_mediums';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name', 'state', 'state_class', 'state_icon', 'state_id', 'created_at_datatable',
        'last_log_login_at_datatable', 'signed_agreement_lang', 'space_city_names', 'activated_at_datatable',
        'signed_at_datatable', 'states', 'count_spaces', 'has_offers', 'last_offer_at_datatable'
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

    public function getSignedAgreementAttribute($value)
    {
        return $value == 'Si_fir_ac';
    }

    public function getCountSpacesAttribute()
    {
        return $this->spaces->count();
    }

    public function getLastOfferAttribute()
    {
        return $this->spaces->max('fecha_creacion_LI');
    }

    public function getHasOffersAttribute()
    {
        if($this->last_offer){
            return true;
        }

        return false;
    }

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

    public function getSignedAtDatatableAttribute()
    {
        if($this->signed_at) {
            return $this->signed_at->format('d/m/Y');
        }

        return '';
    }
    
    public function spaces()
    {
        return $this->hasMany('App\Entities\Platform\Space', 'id_us_reg_LI', 'id');
    }

    public function getSpaceCityNamesAttribute()
    {
        return $this->spaces->lists('city_name');
    }
}