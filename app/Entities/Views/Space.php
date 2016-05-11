<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 1:31 PM
 */

namespace App\Entities\Views;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

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
    protected $appends = ['publisher_name', 'category_sub_category', 'commission', 'markup_price', 'public_price'];
    
    
    /**
     * Return the Full Name
     * @return string
     */
    public function getPublisherNameAttribute()
    {
        return ucwords(strtolower($this->publisher_first_name . ' ' . $this->publisher_last_name));
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

}