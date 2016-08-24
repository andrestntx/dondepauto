<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 1:31 PM
 */

namespace App\Entities\Views;

use App\Entities\Platform\Space\SpaceCity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Entities\Platform\Space\SpaceImage;

class Space extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'publisher_signed_at'];


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
    protected $appends = ['publisher_name', 'category_sub_category', 'commission', 'markup_price', 'public_price',
        'publisher_signed_agreement_lang', 'publisher_signed_at_datatable', 'created_at_humans'
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(SpaceImage::class, 'id_espacio_LI', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(SpaceCity::class, 'city_id');
    }

    public function getFirstImage()
    {
        return $this->images->first();
    }
    
    /**
     * Return the Full Name
     * @return string
     */
    public function getPublisherNameAttribute()
    {
        return ucwords(strtolower($this->publisher_first_name . ' ' . $this->publisher_last_name));
    }

    /**
     * @param $value
     * @return string
     */
    public function getDescriptionAttribute($value)
    {
        return strip_tags($value);
    }

    /**
     * Return the Company Name Uppercase
     * @param $value
     * @return string
     */
    public function getPublisherCompanyAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    /**
     * Return the Category and SubCategory
     * @return string
     */
    public function getCategorySubCategoryAttribute()
    {
        return ucwords(strtolower($this->category_name . ' - ' . $this->sub_category_name));
    }

    /**
     * @return string
     */
    public function getCommissionAttribute()
    {
        return '0.15';
    }

    public function getPercentageMarkdownAttribute($value)
    {
        return round($value, 3);
    }

    public function getMarkupPriceAttribute()
    {
        return round($this->minimal_price * $this->percentage_markup);
    }

    public function getPublicPriceAttribute()
    {
        return $this->minimal_price + $this->markup_price;
    }

    /**
     * @return string
     */
    public function getPublisherEconomicActivityNameAttribute($value)
    {
        if($value) {
            return $value;
        }

        return 'Sin registrar';
    }

    public function getPublisherSignedAgreementLangAttribute()
    {
        if($this->publisher_signed_agreement)
        {
            return 'Si';
        }

        return 'No';
    }

    /**
     * @return string
     */
    public function getPublisherSignedAtDatatableAttribute()
    {
        if($this->publisher_signed_at) {
            return $this->publisher_signed_at->format('d/m/Y');
        }

        return '';
    }

    /**
     * @return string
     */
    public function getNameAttribute($value)
    {
        return ucfirst(strtolower($value));
    }

    /**
     * @return mixed
     */
    public function getCreatedAtHumansAttribute()
    {
        return $this->created_at->diffForHumans();    
    }

    /**
     * @return string
     */
    public function getThumbAttribute()
    {
        if($this->getFirstImage()) {
            return $this->getFirstImage()->thumb;    
        }
        
        return 'http://www.dondepauto.co/images/marketplace/marketplaceItemDefaultThumb_219.jpg';
    }
}