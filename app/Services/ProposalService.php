<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 18/04/2016
 * Time: 2:26 PM
 */

namespace App\Services;

use App\Entities\Platform\User;
use App\Repositories\Proposal\ProposalRepository;

class ProposalService extends ResourceService
{

    function __construct(ProposalRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param User $advertiser
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search(User $advertiser = null)
    {
        return ['data' => $this->repository->search($advertiser)];
    }
    
}