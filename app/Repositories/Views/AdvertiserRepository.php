<?php

/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 18/04/2016
 * Time: 2:04 PM
 */

namespace App\Repositories\Views;

use App\Entities\Platform\Intention;
use App\Entities\User;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class AdvertiserRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Views\Advertiser';
    }

    /**
     * @return mixed
     */
    public function advertisersWithProposals()
    {
        return $this->model
            ->join('quotes', 'quotes.advertiser_id', '=', 'view_advertisers.id')
            ->join('proposals', function($join) {
                return $join->on('proposals.quote_id', '=', 'quotes.id')
                    ->whereNull('proposals.deleted_at');
            })
            ->groupBy('view_advertisers.id')
            ->lists('view_advertisers.company', 'view_advertisers.id')
            ->all();
    }


    /**
     * @return Collection
     */
    public function advertisersWithOutAdviser()
    {
        return $this->model
            ->whereNull('user_id')
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function defaultSearch()
    {
        return $this->model->with(['proposals.viewSpaces', 'favorites',  'logs', 'views', 'intentions', 'contacts' => function($query) {
            $query->orderBy("created_at", "desc");
        }, 'contacts.actions']);
    }

    /**
     * @param User $user
     * @param array $data
     * @param $search
     * @param $intentionsInit
     * @param $intentionsFinish
     * @return Collection
     */
    public function search(User $user = null, array $data, $search = '', $intentionsInit = '', $intentionsFinish = '')
    {
        $advertiserQuery    = null;

        if (! empty($data['intention_at'])) {

            $dateRange = explode(',', $data['intention_at']);
            if(trim($dateRange[0])) {
                $intentionsInit = Carbon::createFromFormat('d/m/Y', $dateRange[0])->toDateString();
            }
            if(trim($dateRange[1])) {
                $intentionsFinish = Carbon::createFromFormat('d/m/Y', $dateRange[1])->toDateString();;
            }

            $advertiserQuery = $this->model->with(['intentions' => function($query) use($intentionsInit, $intentionsFinish) {
                $query->where(function($q) use ($intentionsInit, $intentionsFinish){
                    if(! empty($intentionsInit)) {
                        $q->whereDate('url_fecha_intencion_LI', '>=', $intentionsInit);
                    }
                    if(! empty($intentionsFinish)) {
                        $q->whereDate('url_fecha_intencion_LI', '<=', $intentionsFinish)
                            ->whereDate('url_fecha_intencion_LI', '!=', '0000-00-00');
                    }
                })->orWhere(function($q) use ($intentionsInit, $intentionsFinish){
                        if(! empty($intentionsFinish)) {
                            $q->whereDate('fecha_envio_intencion_LI', '>=', $intentionsInit);
                        }
                        if(! empty($intentionsFinish)) {
                            $q->whereDate('fecha_envio_intencion_LI', '<=', $intentionsFinish)
                                ->whereDate('fecha_envio_intencion_LI', '!=', '0000-00-00');
                        }
                    });
            }, 'proposals', 'logs', 'favorites', 'views', 'contacts' => function($query) {
                $query->orderBy("created_at", "desc");
            }, 'contacts.actions']);
        }
        else {
            $advertiserQuery = $this->defaultSearch();
        }

        $this->searchDateRange($data['created_at'], 'created_at', 'created_at', $advertiserQuery);

        if (! empty($data['city_id'])) {
            $advertiserQuery->where('city_id', '=', $data['city_id']);
        }
        if (! empty($data['economic_activity_id'])) {
            $advertiserQuery->where('economic_activity_id', '=', $data['economic_activity_id']);
        }

        if(! empty($search)) {
            $advertiserQuery->where(function ($query) use($search) {
                $query->where('company', 'LIKE', '%' . $search . '%')
                    ->orWhere('first_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('comments', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }

        if(! empty($user)) {
            $advertiserQuery->whereUserId($user->id);
        }

        return $advertiserQuery->orderBy('created_at', 'desc')->take(20)->get();
    }

    /**
     * @param $dates
     * @param $search
     * @param $name
     * @param $advertiserQuery
     */
    protected function searchDateRange($dates, $search, $name, &$advertiserQuery)
    {
        if (! is_null($dates)) {
            $dateRange = explode(',', $dates);
            if(trim($dateRange[0])) {
                $advertiserQuery->where($name, '>=', Carbon::createFromFormat('d/m/Y', $dateRange[0])->toDateString());
            }
            if(count($dateRange) > 1 && trim($dateRange[1])) {
                $advertiserQuery->where($name, '<=', Carbon::createFromFormat('d/m/Y', $dateRange[1])->toDateString());
            }
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAdvertiser($id)
    {
        return $this->defaultSearch()->whereId($id)->get()->first();
    }
}