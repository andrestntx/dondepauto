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
use Carbon\Carbon;

class ProposalService extends ResourceService
{

    function __construct(ProposalRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Proposal $proposal
     */
    public function send(Proposal $proposal)
    {
        $this->updateModel([
            'send_at' => Carbon::now()->toDateTimeString()
        ], $proposal);
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
     * @return $this
     */
    public function loadProposalSelected(Proposal $proposal)
    {
        return $proposal->load(['quote.advertiser', 'viewSpaces' => function($query) {
            $query->where("selected", true);
        }]);
    }


    /**
     * @param Proposal $proposal
     * @param array $spaceIds
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function selectSpaces(Proposal $proposal, array $spaceIds)
    {
        $spacesNotIn = $this->repository->getSpacesIdNotIn($proposal, $spaceIds);
        $this->repository->syncSpaces($proposal, $spacesNotIn, ['selected' => 0]);
        $this->repository->syncSpaces($proposal, $spaceIds, ['selected' => 1]);
        return $this->repository->getSelectedSpaces($proposal);
    }

    /**
     * @param Proposal $proposal
     * @param Space $space
     * @param int $select
     */
    public function selectSpace(Proposal $proposal, Space $space, $select)
    {
        $this->repository->selectSpace($proposal, $space, $select);
    }
    
}