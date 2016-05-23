<?php
/**
 * Created by PhpStorm.
 * Users: Desarrollador 1
 * Date: 13/04/2016
 * Time: 10:26 AM
 */

namespace App\Repositories\Proposal;

use App\Entities\Platform\User;
use App\Repositories\BaseRepository;

class ProposalRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Proposal\Proposal';
    }

    /**
     * @param User $advertiser
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search(User $advertiser = null)
    {
        return collect([]);
    }
}