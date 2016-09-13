<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:21 AM
 */

namespace App\Repositories\Platform;

use App\Repositories\BaseRepository;
use Carbon\Carbon;

class ContactRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Platform\Contact';
    }


    public function getActions($role = 'publisher', $init = null, $finish = null)
    {
        if(is_null($init) && is_null($finish)) {
            $init = Carbon::today()->toDateString();
            $finish = Carbon::tomorrow()->toDateString();
        }

        return $this->model
            ->with(['actions', 'user'])
            ->whereHas('actions', function($query) use ($init, $finish) {
                return $query->where('action_contact.action_at', '>=', $init)
                    ->where('action_contact.action_at', '<', $finish);
            })
            ->whereHas('user', function($query) use ($role) {
                return $query->role($role);
            })
            ->get();
    }
}