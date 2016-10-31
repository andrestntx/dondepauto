<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 18/04/2016
 * Time: 2:02 PM
 */

namespace App\Entities\Views;

use App\Entities\Proposal\Proposal;
use App\Entities\Proposal\Quote;
use Carbon\Carbon;

class Advertiser extends PUser
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'view_advertisers';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [/*'name', 'state', 'state_class', 'state_icon', 'state_id', 'count_intentions',
        'count_by_contact_intentions', 'count_sold_intentions', 'count_discarded_intentions', 'count_interest_intentions',
        'count_management_intentions', 'count_leads', 'created_at_humans', 'count_proposals', 'count_logs',
        'created_at_datatable', 'activated_at_datatable', 'last_log_login_at_datatable', 'states', 'last_login_at',
        'range_view_at_humans', 'count_views', 'has_logo', 'count_favorites', 'range_favorite_at_humans', 'has_contact_today'*/];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function intentions()
    {
        return $this->hasMany('App\Entities\Platform\Intention', 'id_us_anunciante_LI', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function proposals()
    {
        return $this->hasManyThrough(Proposal::class, Quote::class, 'advertiser_id', 'quote_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany('App\Entities\Platform\Contact', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function views()
    {
        return $this->hasMany('App\Entities\Platform\View', 'id_usuario_LI', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favorites()
    {
        return $this->belongsToMany('App\Entities\Platform\Space\Space', 'intereses_anunciantes_LI', 'id_usuario_LI', 'id_espacio_LI')
            ->withPivot('fecha_interes_LI');
    }

    /**
     * @return array
     */
    public function getStatesAttribute()
    {
        $count_logs = $this->count_logs;
        $count_views = $this->count_views;
        $count_favorites = $this->count_favorites;

        return  array_merge(parent::getStatesAttribute(), [
            'logs' => [
                'icon'  => 'fa fa-user',
                'class' => $this->getClass($count_logs),
                'text'  => 'Sesiones: ' . $count_logs,
                'date'  => $this->last_login_at_humans
            ],
            'views' => [
                'icon'  => 'fa fa-newspaper-o',
                'class' => $this->getClass($count_views),
                'text'  => 'Vistas de espacios: ' . $count_views,
                'date'  => $this->range_view_at_humans
            ],
            'favorites' => [
                'icon'  => 'fa fa-star',
                'class' => $this->getClass($count_favorites),
                'text'  => 'Favoritos: ' . $count_favorites,
                'date'  => $this->range_favorite_at_humans
            ]
        ]);
    }

    /**
     * @return mixed
     */
    public function getLastView()
    {
        return $this->views->max('view_at');
    }

    /**
     * @return mixed
     */
    public function getFirstView()
    {
        return $this->views->min('view_at');
    }

    /**
     * @return mixed
     */
    public function getLastFavorite()
    {
        return $this->favorites->max('favorite_at');
    }

    /**
     * @return mixed
     */
    public function getFirstFavorite()
    {
        return $this->favorites->min('favorite_at');
    }


    /**
     * @return null|static
     */
    public function getFirstViewAtAttribute()
    {
        if($firstView = $this->getFirstView())
        {
            return Carbon::createFromFormat('Y-m-d H:i:s', $firstView);
        }

        return null;
    }

    /**
     * @return null|static
     */
    public function getFirstFavoriteAtAttribute()
    {
        if($firstFavorite = $this->getFirstFavorite())
        {
            return Carbon::createFromFormat('Y-m-d H:i:s', $firstFavorite);
        }

        return null;
    }

    /**
     * @return null|static
     */
    public function getLastViewAtAttribute()
    {
        if($lastView = $this->getLastView())
        {
            return Carbon::createFromFormat('Y-m-d H:i:s', $lastView);
        }

        return null;
    }

    /**
     * @return null|static
     */
    public function getLastFavoriteAtAttribute()
    {
        if($lastFavorite = $this->getLastFavorite())
        {
            return Carbon::createFromFormat('Y-m-d H:i:s', $lastFavorite);
        }

        return null;
    }

    /**
     * @return string
     */
    public function getLastViewAtHumansAttribute()
    {
        if($lasViewAt = $this->last_view_at)
        {
            return $lasViewAt->format('d-M-y') . ' - ' . ucfirst($lasViewAt->diffForHumans());
        }

        return '';
    }

    /**
     * @return string
     */
    public function getLastFavoriteAtHumansAttribute()
    {
        if($lasFavoriteAt = $this->last_favorite_at)
        {
            return $lasFavoriteAt->format('d-M-y') . ' - ' . ucfirst($lasFavoriteAt->diffForHumans());
        }

        return '';
    }

    /**
     * @return mixed|string
     */
    public function getRangeViewAtHumansAttribute()
    {
        if($this->last_view_at && $this->count_views >= 2)
        {
            return $this->first_view_at->format('d-M-y') . ' - ' . $this->last_view_at->format('d-M-y');
        }
        else if($this->last_view_at)
        {
            return $this->last_view_at_humans;
        }

        return '';
    }

    /**
     * @return mixed|string
     */
    public function getRangeFavoriteAtHumansAttribute()
    {
        if($this->last_favorite_at && $this->count_favorites >= 2)
        {
            return $this->first_favorite_at->format('d-M-y') . ' - ' . $this->last_favorite_at->format('d-M-y');
        }
        else if($this->last_favorite_at)
        {
            return $this->last_favorite_at_humans;
        }

        return '';
    }


    /**
     * @return string
     */
    public function getCountViewsAttribute()
    {
        return $this->views->count();
    }

    /**
     * @return string
     */
    public function getCountFavoritesAttribute()
    {
        return $this->favorites->count();
    }
    
    /**
     * @return mixed
     */
    public function getCountIntentionsAttribute()
    {
        return $this->intentions->count();
    }

    /**
     * @return mixed
     */
    public function getCountProposalsAttribute()
    {
        return $this->proposals->count();
    }

    /**
     * @param string $state
     * @return mixed
     */
    protected function getCountIntentions($state = 'by_contact')
    {
        return $this->intentions->where('state', $state)->count();
    }

    /**
     * @return mixed
     */
    protected function getCountLeadsAttribute()
    {
        return $this->intentions->filter(function ($intention, $key) {
            return $intention->state != 'interest';
        })->count();
    }

    /**
     * @return mixed
     */
    public function getCountInterestIntentionsAttribute()
    {
        return $this->getCountIntentions('interest');
    }

    /**
     * @return mixed
     */
    public function getCountByContactIntentionsAttribute()
    {
        return $this->getCountIntentions();
    }

    /**
     * @return mixed
     */
    public function getCountManagementIntentionsAttribute()
    {
        return $this->getCountIntentions('management');
    }

    /**
     * @return mixed
     */
    public function getCountSoldIntentionsAttribute()
    {
        return $this->getCountIntentions('sold');
    }

    /**
     * @return mixed
     */
    public function getCountDiscardedIntentionsAttribute()
    {
        return $this->getCountIntentions('discarded');
    }

    /**
     * @return mixed
     */
    public function getCreatedAtHumansAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return bool
     */
    public function getHasContactTodayAttribute()
    {
        return $this->contacts->filter(function ($contact, $key) {
            return $contact->is_today;
        })->count() > 0;
    }
}