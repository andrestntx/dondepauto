<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 26/04/2016
 * Time: 5:48 PM
 */

namespace App\Entities\Platform\Space;


use App\Entities\Platform\Entity;
use App\Entities\Platform\User;
use App\Entities\Proposal\Proposal;

use App\Entities\Views\SpacePrice;
use App\Entities\Proposal\SpacePrice as ProposalSpacePrice;

use App\Services\Space\SpacePointsService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Space extends Entity
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_espacio_LI';

    protected $pointsService;

    protected  $prices;
    protected  $proposalPrices;


    protected $fillable = ['name', 'description', 'address', 'impact', 'impact_agency', 'minimal_price', 'public_price', 'margin', 'period', 'dimension',
        'city_id','format_id', 'sub_category_id', 'category_id', 'impact_scene_id','alcohol_restriction','snuff_restriction','policy_restriction', 'sex_restriction',
        'youtube', 'discount', 'publisher_company', 'more_audiences', 'active', 'publisher_id', 'religion_restriction', 'points'
    ];

    protected $databaseTranslate = ['name' => 'nombre_espacio_LI', 'description' => 'descripcion_espacio_LI', 'address' => 'direccion_ubicacion_LI',
        'impact' => 'impacto_espacio_LI', 'impact_agency' => 'agencia_impactos_LI', 'minimal_price' => 'precio_espacio_LI', 'dimension' => 'dimensiones_espacio_LI',
        'period' => 'periodo_servicio_espacio_LI', 'city_id' => 'id_ciudad_LI', 'format_id' => 'id_formato_LI', 'youtube' => 'link_youtube_LI',
        'impact_scene_id' => 'id_tipo_lugar_ubicacion_LI', 'alcohol_restriction' => 'restringeAlcohol_LI', 'discount' => 'descuento_espacio_LI',
        'snuff_restriction' => 'restringeTabaco_LI', 'policy_restriction' => 'restringePolitica_LI', 'sex_restriction' =>  'restringeSexo_LI',
            'more_audiences' => 'tags_espacio_LI', 'publisher_id' => 'id_us_reg_LI', 'religion_restriction' => 'restringeReligion_LI',
        'publisher_company' => 'nombre_empresa_proveedora_espacio_LI', 'public_price' => 'precio_margen_espacio_LI', 'margin' => 'porcentaje_precio_margen_espacio_LI',
        'category_id' => 'id_cat_LI', 'sub_category_id' => 'id_subcat_LI', 'percentage_markup' => 'porcentaje_precio_margen_espacio_LI',
        'active' => 'espacio_activo_LI', 'private' => 'espacio_privado_LI', 'points' => 'puntaje_LI', 'created_at' => 'fecha_creacion_LI'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['public_price',
        'alcohol_restriction',
        'snuff_restriction', 'policy_restriction', 'publisher_company',
        'minimal_price',
        'address', 'name', 'id', 'publisher_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['descripcion_espacio_LI'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'espacios_ofrecidos_LIST';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'fecha_creacion_LI';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const UPDATED_AT = null;

    /**
     * Space constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->prices = new SpacePrice($this);
        $this->proposalPrices = new ProposalSpacePrice($this, $this->prices);
    }
    
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('is_deleted', function(Builder $builder) {
            $builder->where('espacio_eliminado_LI', '!=', 'Si_el');
        });
    }

    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (array_key_exists($key, $this->attributes) || $this->hasGetMutator($key)) {
            return $this->getAttributeValue($key);
        }

        $databaseTranslate = parent::getAttribute($this->getTranslateOrOriginalKey($key));

        return $databaseTranslate;
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function proposals()
    {
        return $this->belongsToMany(Proposal::class)->withPivot('copy');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cities()
    {
        return $this->belongsToMany(SpaceCity::class, 'city_space', 'space_id', 'city_id');
    }

    /**
     * @return mixed
     */
    public function getCitiesListAttribute()
    {
        return $this->cities->lists('id')->all();
    }

    public function hasCity($cityId)
    {
        return $this->cities->where('id_ciudad_LI', $cityId)->count() > 0;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function audiences()
    {
        return $this->belongsToMany(Audience::class, 'audience_space', 'space_id', 'audience_id');
    }


    /**
     * @return mixed
     */
    public function getAudiencesListAttribute()
    {
        return $this->audiences->lists('id')->all();
    }

    /**
     * @return string
     */
    public function getAudiencesArray()
    {
        $array = [];
        $audienceTypes = $this->audiences->groupBy('audience_type_id');

        foreach($audienceTypes as $audiences) {
            $array[$audiences->first()->type->name] = $audiences->implode('name', ', ');
        }


        return $array;
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
    public function getFirstImageUrlAttribute()
    {
        if($this->images->count() > 0) {
            return $this->images->first()->url;
        }

        return '#';
    }

    /**
     * @return mixed
     */
    public function getImagesListAttribute()
    {
        return $this->images->map(function ($item, $key) {
            return ['url' => $item->thumb, 'name' => $item->id_imagen_LI];
        })->toJson();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function impactScenes()
    {
        return $this->belongsToMany(SpaceImpactScene::class, 'impact_scene_space', 'space_id', 'impact_scene_id');
    }

    /**
     * @return mixed
     */
    public function getImpactScenesListAttribute()
    {
        return $this->impactScenes->lists('id')->all();
    }

    /**
     * @param $value
     * @return string
     */
    protected function getSlug($value) {
        $slug = strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($value, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
        return $slug . '-' . rand(111111,999999);
    }

    /**
     * @param $value
     */
    protected function setUrlAttribute($value) {
        $this->urlTag = $this->getSlug($value);
    }


    /**
     * @param bool $value
     * @return bool
     */
    public function setDelete($value = true)
    {
        if($value) {
            $this->espacio_eliminado_LI = "Si_el";
        }
        else {
            $this->espacio_eliminado_LI = "Si_el";
        }

        return $this->save();
    }

    /**
     * @return string
     */
    protected function getUrlMarketplaceAttribute()
    {
        return 'http://www.dondepauto.co/espacio-publicitario/' . $this->urlTag;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function copy()
    {
        return $this->hasOne(Space::class, 'copy_id', 'id_espacio_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function zone()
    {
        return $this->belongsTo(SpaceCityZone::class, 'id_zona_ciudad_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(SpaceCity::class, 'id_espacio_LI', 'id_ciudad_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subCategory()
    {
        return $this->belongsTo(SpaceSubCategory::class, 'id_subcat_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function format()
    {
        return $this->belongsTo(SpaceFormat::class, 'id_formato_LI', 'id_formato_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function publisher()
    {
        return $this->belongsTo(User::class, 'id_us_reg_LI', 'id_us_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(SpaceImage::class, 'id_espacio_LI', 'id_espacio_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function space()
    {
        return $this->hasOne('App\Entities\Views\Space', 'id', 'id_espacio_LI');
    }

    /**
     * @return Model
     */
    public function getCity()
    {
        if($this->zone){
            return $this->zone->city;
        }

        return $this->city;
    }

    public function getFormatNameAttribute() {
        if($this->format) {
            return $this->format->name;    
        }
        
        return '';
    }

    /**
     * @return Model
     */
    public function getSubCategory()
    {
        if($this->format) {
            return $this->format->subCategory;    
        }
        
        return null;
    }

    /**
     * @return Model
     */
    public function getCategory()
    {
        if($subCategory = $this->getSubCategory()) {
            return $subCategory->category;
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getCategoryNameAttribute()
    {
        if($category = $this->getCategory()) {
            return $category->name;
        }

        return '';
    }

    /**
     * @return mixed
     */
    public function getSubCategoryNameAttribute()
    {
        if($subCategory = $this->getSubCategory()) {
            return $subCategory->name;
        }

        return '';
    }

    /**
     * @return int|mixed
     */
    public function getNewPointsAttribute()
    {
        $this->pointsService = new SpacePointsService();
        return round($this->pointsService->calculatePoints($this));
    }
    
    public function getRulesJsonAttribute()
    {
        $this->pointsService = new SpacePointsService();
        return json_encode($this->pointsService->getRulePoints($this));
    }

    /**
     * @param $value
     */
    public function setActiveAttribute($value)
    {
        if($value) {
            $this->espacio_activo_LI = 'Si_act';
        }
        else {
            $this->espacio_activo_LI = 'No_act';
        }
    }

    /**
     * @return bool
     */
    public function getActiveAttribute()
    {
        if($this->espacio_activo_LI == 'Si_act') {
            return true;
        }

        return false;
    }

    /**
     * @param $value
     */
    public function setSnuffRestrictionAttribute($value)
    {
        $this->setRestriction($value, 'restringeTabaco_LI');
    }

    /**
     * @param $value
     */
    public function setAlcoholRestrictionAttribute($value)
    {
         $this->setRestriction($value, 'restringeAlcohol_LI');
    }

    /**
     * @param $value
     */
    public function setPolicyRestrictionAttribute($value)
    {
        $this->setRestriction($value, 'restringePolitica_LI');
    }

    /**
     * @param $value
     */
    public function setSexRestrictionAttribute($value)
    {
        $this->setRestriction($value, 'restringeSexo_LI');
    }

    /**
     * @param $value
     */
    public function setReligionRestrictionAttribute($value)
    {
        $this->setRestriction($value, 'restringeReligion_LI');
    }


    /**
     * @param $column
     * @return bool
     */
    public function isRestriction($column)
    {
        if($column == 'S') {
            return true;
        }

        return false;
    }


    /**
     * @return bool
     */
    public function getSnuffRestrictionBoolAttribute()
    {
        return $this->isRestriction($this->snuff_restriction);
    }

    /**
     * @return bool
     */
    public function getAlcoholRestrictionBoolAttribute()
    {
        return $this->isRestriction($this->alcohol_restriction);
    }

    /**
     * @return bool
     */
    public function getPolicyRestrictionBoolAttribute()
    {
        return $this->isRestriction($this->policy_restriction);
    }

    /**
     * @return bool
     */
    public function getSexRestrictionBoolAttribute()
    {
        return $this->isRestriction($this->sex_restriction);
    }

    /**
     * @return bool
     */
    public function getReligionRestrictionBoolAttribute()
    {
        return $this->isRestriction($this->religion_restriction);
    }

    /**
     * @param $value
     * @param $column
     */
    public function setRestriction($value, $column)
    {
        \Log::info(' set ' . $value . ' - ' . $column);
        if($value) {
            $this->attributes[$column] = 'S';
        }
        else {
            $this->attributes[$column] = 'N';
        }
    }

    /**
     * @return mixed
     */
    public function getFormats()
    {
        return $this->format->subCategory->formats->lists('name', 'id')->all();
    }

    /**
     * @return string
     */
    public function getViewAtAttribute()
    {
        if($this->pivot) {
            return $this->pivot->fechaVisualizacion_LI;
        }

        return '';
    }

    /**
     * @return string
     */
    public function getFavoriteAtAttribute()
    {
        if($this->pivot) {
            return $this->pivot->fecha_interes_LI;
        }

        return '';
    }


    /**
     * @return float
     */
    public function getPercentageMarkdownAttribute()
    {
        $value = (((1 / (1 + $this->percentage_markup)) - 1) * -1);

        if($value == 0) {
            $value = $this->discount;
        }

        return round($value, 3);
    }

}