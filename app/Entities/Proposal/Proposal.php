<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 18/05/2016
 * Time: 4:14 PM
 */

namespace App\Entities\Proposal;

use App\Entities\Platform\Contact;
use App\Entities\Platform\Space\Space;
use App\Entities\Views\Audience;
use App\Entities\Views\City;
use App\Entities\Views\ImpactScene;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proposal extends Model
{
    use SoftDeletes;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'quote_id', 'send_at', 'observations', 'expiration_days'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['send_at', 'deleted_at'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['days', 'advertiser_name', 'advertiser_company', 'created_at_datatable', 'send_at_datatable', 'expires_at_datatable', 'expires_at_days', 'count_spaces',
        "pivot_total", "pivot_total_cost", "total_discount_price", "total_discount", "pivot_total_income_price", "pivot_total_income",
        "pivot_total_markup_price", "pivot_total_markup", "pivot_total_commission_price", "pivot_total_commission",
        "total", "total_cost", "total_income_price", "total_markup_price", "total_commission_price", "total_commission"
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function spaces()
    {
        return $this->belongsToMany(Space::class)->withPivot(['discount', 'with_markup', 'title', 'description', 'selected']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function viewSpaces()
    {
        return $this->belongsToMany(\App\Entities\Views\Space::class)->withPivot(['discount', 'with_markup', 'title', 'description', 'selected']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function spaceAudiences()
    {
        return $this->hasMany(Audience::class, 'proposal_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany(City::class, 'proposal_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function impactScenes()
    {
        return $this->hasMany(ImpactScene::class, 'proposal_id');
    }

    /**
     * @return string
     */
    public function getStateAttribute()
    {
        if($this->contacts->count() > 0) {
            return $this->contacts->sortByDesc('created_at')->first()->action->state;
        }

        return 'En construcción';
    }

    /**
     * @return mixed
     */
    public function getCountSpacesAttribute()
    {
        return $this->viewSpaces->count();
    }

    /**
     * @return mixed
     */
    public function getAdvertiser()
    {
        return $this->quote->advertiser;
    }

    /**
     * @return mixed
     */
    public function getAudiences()
    {
        return $this->quote->audiences;
    }

    /**
     * @return string
     */
    public function getAudiencesArray()
    {
        $array = [];

        if($audienceTypes = $this->getAudiences()) {
            $audienceTypes = $audienceTypes->groupBy('audience_type_id');

            foreach($audienceTypes as $audiences) {
                $array[$audiences->first()->type->name] = [
                    'names' => $audiences->sortBy('name')->implode('name', ', '),
                    'img'       => $audiences->first()->type->image
                ];
            }
        }

        return $array;
    }

    /**
     * @return mixed
     */
    public function getViewAdvertiser()
    {
        return $this->quote->viewAdvertiser;
    }

    /**
     * @return string
     */
    public function getAdvertiserTitleAttribute()
    {
        return $this->advertiser_name . ' - ' . $this->title . " - " . ucfirst($this->created_at->diffForHumans());
    }

    /**
     * @return mixed
     */
    public function getAdvertiserNameAttribute()
    {
        return $this->getAdvertiser()->first_name . ' ' . $this->getAdvertiser()->last_name;
    }

    /**
     * @return mixed
     */
    public function getAdvertiserCompanyAttribute()
    {
        return ucfirst($this->getAdvertiser()->company);
    }

    /**
     * @return mixed
     */
    public function getDaysAttribute()
    {
        if($this->send_at) {
            return $this->send_at->diffInDays();
        }

        return '';
    }

    /**
     * @return mixed
     */
    public function getCreatedAtDatatableAttribute()
    {
        return $this->created_at->format('d-M');
    }

    /**
     * @return mixed
     */
    public function getSendAtDatatableAttribute()
    {
        if($this->send_at) {
            return $this->send_at->format('d-M');
        }

        return '';
    }

    /**
     * @return mixed
     */
    public function getCreatedAtDateAttribute()
    {
        return $this->created_at->format('d-M-y');
    }

    /**
     * @return mixed
     */
    public function getSendAtDateAttribute()
    {
        if($this->send_at) {
            return $this->send_at->format('d-M-y');
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getExpiresAtAttribute()
    {
        if($this->send_at) {
            return $this->send_at->addDays(25);
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getExpiresAtDatetimeAttribute()
    {
        if($this->expires_at) {
            return $this->expires_at->toDateTimeString();
        }

        return '';
    }

    /**
     * @return mixed
     */
    public function getExpiresAtDatatableAttribute()
    {
        if($this->expires_at) {
            return $this->expires_at->format('d-M');
        }

        return '';
    }

    /**
     * @return mixed
     */
    public function getExpiresAtDaysAttribute()
    {
        if($this->expires_at) {
            return $this->expires_at->diffInDays(null, false) * -1;
        }

        return '';
    }

    /**
     * @return mixed
     */
    public function getTotalAttribute()
    {
        return $this->viewSpaces->sum('prices_public_price');
    }

    /**
     * @return mixed
     */
    public function getTotalCostAttribute()
    {
        return $this->viewSpaces->sum('prices_minimal_price');
    }

    /**
     * @return mixed
     */
    public function getTotalDiscountAttribute()
    {
        if($this->total > 0) {
            return round($this->total_discount_price / $this->total, 3);
        }

        return 0;
    }

    /**
     * @return mixed
     */
    public function getTotalDiscountPriceAttribute()
    {
        return $this->viewSpaces->sum('proposal_prices_discount_price');
    }

    /**
     * @return mixed
     */
    public function getPivotTotalAttribute()
    {
        return $this->viewSpaces->sum('proposal_prices_public_price');
    }

    /**
     * @return mixed
     */
    public function getPivotTotalIvaAttribute()
    {
        return $this->pivot_total * env('IVA');
    }

    /**
     * @return mixed
     */
    public function getPivotTotalWithIvaAttribute()
    {
        return $this->pivot_total + $this->pivot_total_iva;
    }

    /**
     * @return mixed
     */
    public function getPivotTotalCostAttribute()
    {
        return $this->viewSpaces->sum('proposal_prices_minimal_price');
    }

    /**
     * @return mixed
     */
    public function getTotalIncomePriceAttribute()
    {
        return $this->total_markup_price + $this->total_commission_price;
    }

    /**
     * @return mixed
     */
    public function getTotalIncomeAttribute()
    {
        if($this->total > 0) {
            return round($this->total_income_price / $this->total, 3);
        }

        return 0;
    }

    /**
     * @return mixed
     */
    public function getPivotTotalIncomePriceAttribute()
    {
        return $this->pivot_total_markup_price + $this->pivot_total_commission_price;
    }

    /**
     * @return mixed
     */
    public function getPivotTotalIncomeAttribute()
    {
        if($this->pivot_total > 0) {
            return round($this->pivot_total_income_price / $this->pivot_total, 3);
        }

        return 0;
    }

    /**
     * @return mixed
     */
    public function getTotalMarkupPriceAttribute()
    {
        return $this->viewSpaces->sum('prices_markup_price');
    }

    /**
     * @return mixed
     */
    public function getPivotTotalMarkupPriceAttribute()
    {
        return $this->viewSpaces->sum('proposal_prices_markup_price');
    }

    /**
     * @return mixed
     */
    public function getTotalMarkupAttribute()
    {
        if($this->total > 0) {
            return round($this->total_markup_price / $this->total, 3);
        }

        return 0;
    }

    /**
     * @return mixed
     */
    public function getPivotTotalMarkupAttribute()
    {
        if($this->total > 0) {
            return round($this->pivot_total_markup_price / $this->total, 3);
        }

        return 0;
    }

    /**
     * @return mixed
     */
    public function getTotalCommissionAttribute()
    {
        if($this->total_cost > 0) {
            return round($this->total_commission_price / $this->total_cost, 3);
        }

        return 0;
    }

    /**
     * @return mixed
     */
    public function getTotalCommissionPriceAttribute()
    {
        return $this->viewSpaces->sum('prices_commission_price');
    }

    /**
     * @return mixed
     */
    public function getPivotTotalCommissionAttribute()
    {
        if($this->pivot_total_cost > 0) {
            return round($this->pivot_total_commission_price / $this->pivot_total_cost, 3);
        }

        return 0;
    }

    /**
     * @return mixed
     */
    public function getPivotTotalCommissionPriceAttribute()
    {
        return $this->viewSpaces->sum('proposal_prices_commission_price');
    }

}