<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 1:31 PM
 */

namespace App\Entities\Views;

use App\Entities\Platform\Space\Audience;
use App\Entities\Platform\Space\SpaceCity;
use App\Entities\Platform\Space\SpaceImpactScene;
use App\Entities\Proposal\Proposal;
use App\Entities\Proposal\SpacePrice as ProposalSpacePrice;

use App\Entities\Views\Simple\Publisher as SimplePublisher;
use Illuminate\Database\Eloquent\Model;
use App\Entities\Platform\Space\SpaceImage;
use Illuminate\Support\Str;

class Space extends Model
{
    protected $prices;
    protected $proposalPrices;

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
    protected $appends = ['publisher_name', 'category_sub_category',
        'publisher_signed_agreement_lang', 'publisher_signed_at_datatable', 'created_at_humans', 'created_at_date',
        'sub_category_name_format_name',  'audiences_array', 'pivot_title', 'pivot_description', 'city_names', 'impact_scene_names',

        'prices_markup_price', 'prices_public_price', 'prices_markup_per', 'prices_commission_price', 'prices_commission_per',
        'prices_minimal_price', 'prices_initial_price',

        'proposal_prices_discount', 'proposal_prices_discount_price', 'proposal_prices_with_markup',
        'proposal_prices_commission_price', 'proposal_prices_markup', 'proposal_prices_markup_price',
        'proposal_prices_public_price', 'proposal_prices_minimal_price', 'proposal_prices_gain_price'
    ];

    /**
     * Space constructor.
     */
    public function __construct()
    {
        $this->prices = new SpacePrice($this);
        $this->proposalPrices = new ProposalSpacePrice($this, $this->prices);
    }

    /**
     * Determine if a get mutator exists for an attribute.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasGetMutator($key)
    {
        return (
            Str::startsWith($key, 'prices_') ||
            Str::startsWith($key, 'proposal_prices_') ||
            method_exists($this, 'get'.Str::studly($key).'Attribute')
        );
    }

    /**
     * Get the value of an attribute using its mutator.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function mutateAttribute($key, $value)
    {
        if(Str::startsWith($key, 'prices_')) {
            return $this->prices->{'get'.Str::studly(Str::replaceFirst('prices_', '', $key))}($value);
        }
        else if(Str::startsWith($key, 'proposal_prices_')) {
            return $this->proposalPrices->{'get'.Str::studly(Str::replaceFirst('proposal_prices_', '', $key))}($value);
        }

        return $this->{'get'.Str::studly($key).'Attribute'}($value);
    }

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
    public function audiences()
    {
        return $this->belongsToMany(Audience::class, 'audience_space', 'space_id', 'audience_id');
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function proposals()
    {
        return $this->belongsToMany(Proposal::class)->withPivot(['discount', 'with_markup', 'title', 'description', 'selected']);
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

    public function getCityNamesAttribute()
    {
        return $this->cities->implode('nombre_ciudad_LI', ', ');
    }

    public function getImpactSceneNamesAttribute()
    {
        return $this->impactScenes->implode('nombre_tipo_lugar_LI', ', ');
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
     * @return string
     */
    public function getAudiencesArrayAttribute()
    {
        $array = [];
        $audienceTypes = $this->audiences->groupBy('audience_type_id');

        foreach($audienceTypes as $audiences) {
            $type = $audiences->first()->type;
            $array[$type->name]['audiences'] = $audiences->implode('name', ', ');
            $array[$type->name]['image'] = $type->image;
        }


        return $array;
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
     * @return string
     */
    public function getFirstImageAttribute()
    {
        if($this->getFirstImage()) {
            return $this->getFirstImage()->url;
        }

        return 'http://www.dondepauto.co/images/marketplace/marketplaceItemDefaultThumb_219.jpg';
    }

    /**
     * @return string
     */
    protected function getUrlMarketplaceAttribute()
    {
        return 'http://www.dondepauto.co/espacio-publicitario/' . $this->url;
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


}