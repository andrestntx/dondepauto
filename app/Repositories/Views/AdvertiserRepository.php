<?php

/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 18/04/2016
 * Time: 2:04 PM
 */

namespace App\Repositories\Views;

use App\Entities\User;
use App\Repositories\BaseRepository;
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
    
    public function search(User $user = null)
    {
        $advertisers = $this->model->with(['intentions', 'logs']);

        if(!is_null($user)) {
            $advertisers->whereUserId($user->id);
        }

        return $advertisers->get();
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