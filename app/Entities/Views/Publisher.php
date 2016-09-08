<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 1:31 PM
 */

namespace App\Entities\Views;


use App\Entities\Platform\Representative;
use App\Repositories\File\PublisherDocumentsRepository;
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
    protected $appends = ['state', 'state_class', 'state_icon', 'state_id', 'created_at_datatable',
        'signed_agreement_lang', 'space_city_names', 'activated_at_datatable', 'documents_json',
        'signed_at_datatable', 'states', 'count_spaces', 'has_offers', 'last_offer_at_datatable', 'created_at_humans',
        'count_logs', 'last_login_at', 'has_logo', 'signed_at_date', 'repre_name', 'repre_doc', 'repre_email', 'repre_phone'
    ];

    /**
     * @return array
     */
    public function getStatesAttribute()
    {
        return  array_merge(parent::getStatesAttribute(), [
            'offers' => [
                'icon'  => 'fa fa-tags',
                'class' => $this->getClass($this->has_offers),
                'text'  => 'Ofertó',
                'date'  => $this->range_offers_at_humans
            ],
            'letter' => [
                'icon'  => 'fa fa-file-o',
                'class' => $this->getClass($this->has_letter, $this->has_documents),
                'text'  => 'Carta',
                'date'  => $this->letter_at_humans
            ],
            'docs' => [
                'icon'  => 'fa fa-file-pdf-o',
                'class' => $this->getClass($this->has_documents),
                'text'  => 'Documentos',
                'date'  => $this->documents_at_humans
            ],
            'agreement' => [
                'icon'  => 'fa fa-file-text-o',
                'class' => $this->getClass($this->signed_agreement),
                'text'  => 'Activo Proveedor',
                'date'  => $this->signed_at_humans
            ]
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany('App\Entities\Platform\Contact', 'user_id', 'id');
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
    public function getFirstOfferAttribute()
    {
        return $this->spaces->min('created_at');
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

    /**
     * @return string
     */
    public function getLastOfferAtHumansAttribute()
    {
        if($this->last_offer)
        {
            return Carbon::createFromFormat('Y-m-d H:i:s', $this->last_offer)->format('d-M-y');
        }

        return '';
    }

    /**
     * @return string
     */
    public function getFirstOfferAtHumansAttribute()
    {
        if($this->first_offer)
        {
            return Carbon::createFromFormat('Y-m-d H:i:s', $this->first_offer)->format('d-M-y');
        }

        return '';
    }

    /**
     * @return string
     */
    public function getRangeOffersAtHumansAttribute()
    {
        if($this->first_offer && $this->spaces->count() >= 2)
        {
            return $this->first_offer_at_humans . ' - ' . $this->last_offer_at_humans;
        }
        else if($this->first_offer) {
            return $this->first_offer_at_humans . ' - ' . ucfirst(Carbon::createFromFormat('Y-m-d H:i:s', $this->first_offer)->diffForHumans());
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
     * @return string
     */
    public function getSignedAtDateAttribute()
    {
        if($this->signed_at) {
            return $this->signed_at->format('Y-m-d');
        }

        return '';
    }

    /**
     * @return string
     */
    public function getSignedAtHumansAttribute()
    {
        if($this->signed_at && $this->signed_at->format('d-M-y') != '30-Nov--1') {
            return $this->signed_at->format('d-M-y') . ' - ' . ucfirst($this->signed_at->diffForHumans());
        }

        return '';
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function spacesView()
    {
        return $this->hasMany('App\Entities\Views\Space', 'publisher_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function spaces()
    {
        return $this->hasMany('App\Entities\Platform\Space\Space', 'id_us_reg_LI', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function representative()
    {
        return $this->hasOne(Representative::class, 'publisher_id', 'id');
    }

    /**
     * @return mixed
     */
    public function getSpaceCityNamesAttribute()
    {
        //return implode(",", $this->spaces->lists('city_name')->all());
        return '';
    }

    /**
     * @param $cityId
     * @return bool
     */
    public function hasSpaceCity($cityId = 0)
    {
        if($cityId > 0 && $this->spaces->where('city_id', $cityId)->count() > 0) {
            return true;
        }
        
        return false;
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

    /**
     * @return array
     */
    public function getDocuments()
    {
        $fileRepository = new PublisherDocumentsRepository();
        return $fileRepository->getDocumentsId($this->id);
    }

    /**
     * @return string
     */
    public function getDocumentsJsonAttribute()
    {
        return json_encode($this->getDocuments());
    }

    /**
     * @return bool
     */
    public function getHasDocumentsAttribute()
    {
        $fileRepository = new PublisherDocumentsRepository();
        return $fileRepository->hasFilesId($this->id);
    }

    /**
     * @return bool
     */
    public function getHasLetterAttribute()
    {
        $fileRepository = new PublisherDocumentsRepository();
        return $fileRepository->hasFileId($this->id,'letter-generated.pdf');
    }

    /**
     * @return mixed
     */
    public function getRepreNameAttribute()
    {
        if($this->representative) {
            return $this->representative->name;
        }

        return '';
    }

    /**
     * @return mixed
     */
    public function getRepreEmailAttribute()
    {
        if($this->representative) {
            return $this->representative->email;
        }

        return '';
    }

    /**
     * @return mixed
     */
    public function getRepreDocAttribute()
    {
        if($this->representative) {
            return $this->representative->doc;
        }

        return '';
    }

    /**
     * @return mixed
     */
    public function getReprePhoneAttribute()
    {
        if($this->representative) {
            return $this->representative->phone;
        }

        return '';
    }


    /**
     * @return null|static
     */
    public function getLetterAtAttribute()
    {
        $fileRepository = new PublisherDocumentsRepository();

        if($this->has_letter) {
            return Carbon::createFromTimestamp(filemtime($fileRepository->getDocumentId($this->id,'letter-generated')));
        }

        return null;
    }

    /**
     * @return string
     */
    public function getLetterAtHumansAttribute()
    {
        if($this->letter_at) {
            return $this->letter_at->format('d-M-y') . ' - ' . ucfirst($this->letter_at->diffForHumans());
        }

        return '';
    }


    /**
     * @return null|static
     */
    public function getDocumentsAtAttribute()
    {
        $fileRepository = new PublisherDocumentsRepository();

        if($this->has_documents) {
            return Carbon::createFromTimestamp(filemtime($fileRepository->getDocumentId($this->id, 'bank')));
        }

        return null;
    }


    /**
     * @return string
     */
    public function getDocumentsAtHumansAttribute()
    {
        if($this->documents_at) {
            return $this->documents_at->format('d-M-y') . ' - ' . ucfirst($this->documents_at->diffForHumans());
        }

        return '';
    }

}