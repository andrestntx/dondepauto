<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 18/05/2016
 * Time: 4:14 PM
 */

namespace App\Entities\Proposal;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'quote_id'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['days', 'advertiser_name', 'created_at_datatable', 'expires_at_datatable', 'expires_at_days'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    /**
     * @return mixed
     */
    public function getAdvertiser()
    {
        return $this->quote->advertiser;
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
    public function getDaysAttribute()
    {
        return $this->created_at->diffInDays();
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
    public function getExpiresAtAttribute()
    {
        return $this->created_at->addDays(25);
    }

    /**
     * @return mixed
     */
    public function getExpiresAtDatetimeAttribute()
    {
        return $this->expires_at->toDateTimeString();
    }

    /**
     * @return mixed
     */
    public function getExpiresAtDatatableAttribute()
    {
        return $this->expires_at->format('d-M');
    }

    /**
     * @return mixed
     */
    public function getExpiresAtDaysAttribute()
    {
        return $this->expires_at->diffInDays();
    }


}