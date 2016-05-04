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
     * @param User|null $user
     * @param null $intentionsInit
     * @param null $intentionsFinish
     * @return Collection|static[]
     */
    public function search(User $user = null, $intentionsInit = null, $intentionsFinish = null)
    {
        if(!is_null($intentionsInit) && !empty($intentionsInit)) {
            $intentionsInit = Carbon::createFromFormat('d/m/Y', $intentionsInit)->toDateString();
        }
        if(!is_null($intentionsFinish) && !empty($intentionsFinish)) {
            $intentionsFinish = Carbon::createFromFormat('d/m/Y', $intentionsFinish)->toDateString();
        }

        $advertisers = $this->model->with([
            'intentions' => function($query) use($intentionsInit, $intentionsFinish) {
                $query->where(function($q) use ($intentionsInit, $intentionsFinish){
                    if(! empty($intentionsInit)) {
                        $q->whereDate('url_fecha_intencion_LI', '>=', $intentionsInit);
                    }
                    if(! empty($intentionsFinish)) {
                        $q->whereDate('url_fecha_intencion_LI', '<=', $intentionsFinish)
                            ->whereDate('url_fecha_intencion_LI', '!=', '0000-00-00');
                    }
                })
                ->orWhere(function($q) use ($intentionsInit, $intentionsFinish){
                    if(! empty($intentionsFinish)) {
                        $q->whereDate('fecha_envio_intencion_LI', '>=', $intentionsInit);
                    }
                    if(! empty($intentionsFinish)) {
                        $q->whereDate('fecha_envio_intencion_LI', '<=', $intentionsFinish)
                            ->whereDate('fecha_envio_intencion_LI', '!=', '0000-00-00');
                    }
                });
            },
            'logs']);

        if(!is_null($user)) {
            $advertisers->whereUserId($user->id);
        }

        $advertisers = $advertisers->get();

        if(!empty($intentionsInit) || !empty($intentionsFinish)) {
           $advertisers = $advertisers->filter(function ($advertiser) {
                return $advertiser->intentions->count() > 0;
           });
        }

        return array_values($advertisers->toArray());
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
}