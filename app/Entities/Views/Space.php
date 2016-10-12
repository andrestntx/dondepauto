<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 1:31 PM
 */

namespace App\Entities\Views;

use App\Entities\Platform\Space\SpaceCity;
use App\Entities\Platform\Space\SpaceImpactScene;
use App\Entities\Views\Publisher;
use App\Entities\Views\Simple\Publisher as SimplePublisher;
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
        'publisher_signed_agreement_lang', 'publisher_signed_at_datatable', 'created_at_humans', 'created_at_date',
        'sub_category_name_format_name', 'commission_price', 'pivot_discount', 'pivot_discount_price', 'pivot_with_markup',
        'pivot_commission_price', 'pivot_markup', 'pivot_markup_price', 'pivot_commission_price', 'pivot_public_price',
        'pivot_minimal_price', 'pivot_title', 'pivot_description', 'percentage_markdown'
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(SpaceImage::class, 'id_espacio_LI', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cities()
    {
        return $this->belongsToMany(SpaceCity::class, 'city_space', 'space_id', 'city_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'publisher_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function simplePublisher()
    {
        return $this->belongsTo(SimplePublisher::class, 'publisher_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function impactScenes()
    {
        return $this->belongsToMany(SpaceImpactScene::class, 'impact_scene_space', 'space_id', 'impact_scene_id');
    }

    /**
     * @param $cityId
     * @return bool
     */
    public function hasCity($cityId)
    {
        return $this->cities->where('id_ciudad_LI', $cityId)->count() > 0;
    }

    public function hasImpactScene($impactSceneId)
    {
        return $this->impactScenes->where('id_tipo_lugar_LI', $impactSceneId)->count() > 0;
    }


    /**
     * @return array
     */
    public function getStatesAttribute()
    {
        return $this->simplePublisher->states;
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
    /*public function getDescriptionAttribute($value)
    {
        return strip_tags($value);
    }*/

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
    public function getSubCategoryNameFormatNameAttribute()
    {
        return ucwords(strtolower($this->sub_category_name . ' - ' . $this->format_name));
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
     * @return float
     */
    public function getCommissionAttribute()
    {
        return ($this->publisher_commission_rate / 100);
    }

    /**
     * @return mixed
     */
    public function getCommissionPriceAttribute()
    {
        return $this->minimal_price * $this->commission;
    }

    public function getDiscountAttribute($value)
    {
        return $value / 100;
    }

    /**
     * @param $value
     * @return float
     */
    public function getPercentageMarkdownAttribute($value)
    {
        if($value <= 0) {
            $value = $this->discount;
        }

        return round($value, 3);
    }

    /**
     * @param $value
     * @return float
     */
    public function getMinimalPriceAttribute($value)
    {
        if($this->discount > 0) {
            $value = $value - ($value * $this->discount);
        }

        return round($value, 3);
    }


    /**
     * @return float|mixed
     */
    public function getMarkupPriceAttribute()
    {
        if($this->percentage_markup == 0) {
            return $this->attributes['minimal_price'] * $this->discount;
        }

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
     * @return mixed
     */
    public function getCreatedAtDateAttribute()
    {
        return $this->created_at->format('d-M-y');
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

    /**
     * @return null
     */
    public function getPivotDiscountAttribute()
    {
        if($this->pivot && $this->pivot->discount) {
            return $this->pivot->discount;
        }

        return null;
    }

    /**
     * @return null
     */
    public function getPivotDescriptionAttribute()
    {
        if($this->pivot) {
            return $this->pivot->description;
        }

        return null;
    }

    /**
     * @return null
     */
    public function getPivotTitleAttribute()
    {
        if($this->pivot) {
            return $this->pivot->title;
        }

        return null;
    }

    /**
     * @return null
     */
    public function getPivotDiscountPriceAttribute()
    {
        if($discount = $this->pivot_discount) {
            return $this->public_price * $discount;
        }

        return null;
    }

    /**
     * @return null
     */
    public function getPivotMarkupAttribute()
    {
        if($this->pivot_discount) {
            return $this->percentage_markdown - $this->pivot_discount;
        }

        return $this->percentage_markdown;
    }

    /**
     * @return null
     */
    public function getPivotMarkupPriceAttribute()
    {
        if($this->pivot_discount) {
            return $this->markup_price - $this->pivot_discount_price;
        }

        return $this->markup_price;
    }


    /**
     * @return null
     */
    public function getPivotWithMarkupAttribute()
    {
        if($this->pivot && $this->pivot->with_markup >= 0) {
            return $this->pivot->with_markup;
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getPivotCommissionPriceAttribute()
    {
        return $this->pivot_minimal_price * $this->commission;
    }

    /**
     * @return mixed
     */
    public function getPivotPublicPriceAttribute()
    {
        if($this->pivot_discount) {
            return $this->public_price - $this->pivot_discount_price;
        }

        return $this->public_price;
    }

    /**
     * @return mixed
     */
    public function getPivotMinimalPriceAttribute()
    {
        if($this->pivot_with_markup) {
            return $this->minimal_price;
        }

        return $this->minimal_price + $this->pivot_markup_price;
    }
}