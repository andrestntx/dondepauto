<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 18/04/2016
 * Time: 2:26 PM
 */

namespace App\Services;

use App\Entities\Platform\Space\Space;
use App\Entities\Platform\User;
use App\Entities\Proposal\Proposal;
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
        return $this->repository->search($advertiser);
    }

    /**
     * @param Proposal $proposal
     * @param Space $space
     * @param array $data
     * @return array
     */
    public function discount(Proposal $proposal, Space $space, array $data)
    {
        return $this->repository->sync($proposal, $space, $data);
    }

    /**
     * @param Proposal $proposal
     * @return $this
     */
    public function loadProposal(Proposal $proposal)
    {
        return $proposal->load(['quote.advertiser', 'viewSpaces']);
    }

    /**
     * @param Proposal $proposal
     * @param array $spacesId
     * @return $this
     */
    public function loadProposalSpaces(Proposal $proposal, array $spacesId)
    {
        return $proposal->load(['quote.advertiser', 'viewSpaces' => function($query) use ($spacesId) {
            $query->whereIn("view_spaces.id", $spacesId);
        }]);
    }
    
}