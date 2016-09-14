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
        return $this->model->with(['proposals', 'favorites',  'logs', 'views', 'intentions', 'contacts' => function($query) {
            $query->orderBy("created_at", "desc");
        }, 'contacts.actions']);
    }

    /**
     * @param User $user
     * @param array $columns
     * @param array $search
     * @param null $intentionsInit
     * @param null $intentionsFinish
     * @return mixed
     */
    public function search(User $user = null, array $columns, array $search, $intentionsInit = null, $intentionsFinish = null)
    {
        $intentionsInit = '';
        $intentionsFinish = '';
        $advertiserQuery = null;
        $columnsSearch = ['intention_at' => null, 'created_at' => null, 'city_id' => null, 'economic_activity_id' => null];

        foreach($columns as $column) {
            if(array_key_exists($column['name'], $columnsSearch) && ! empty(trim($column['search']['value']))) {
                $columnsSearch[$column['name']] = trim($column['search']['value']);
            }
        }

        if (! is_null($columnsSearch['intention_at'])) {

            $dateRange = explode(',', $columnsSearch['intention_at']);
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
            }, 'proposals', 'logs', 'views', 'contacts' => function($query) {
                $query->orderBy("created_at", "desc");
            }, 'contacts.actions']);
        }
        else {
            $advertiserQuery = $this->defaultSearch();
        }

        $this->searchDateRange($columnsSearch['created_at'], 'created_at', 'created_at', $advertiserQuery);

        if (!is_null($columnsSearch['city_id'])) {
            $advertiserQuery->where('city_id', '=', $columnsSearch['city_id']);
        }
        if (!is_null($columnsSearch['economic_activity_id'])) {
            $advertiserQuery->where('economic_activity_id', '=', $columnsSearch['economic_activity_id']);
        }


        if(trim($search['value'])) {
            $value = $search['value'];
            $advertiserQuery->where(function ($query) use($value) {
                $query->where('company', 'LIKE', '%' . $value . '%')
                    //->orWhere('name', 'LIKE', '%' . $value . '%')
                    ->orWhere('comments', 'LIKE', '%' . $value . '%')
                    ->orWhere('email', 'LIKE', '%' . $value . '%');
            });
        }

        if(! is_null($user)) {
            $advertiserQuery->whereUserId($user->id);
        }

        $advertisers = $advertiserQuery->orderBy('created_at', 'desc')->get();

        //abort('404');

        //dd($advertisers);

        return $advertisers;
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
            if(trim($dateRange[1])) {
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