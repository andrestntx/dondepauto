<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 18/05/2016
 * Time: 4:29 PM
 */

namespace App\Facades;


use App\Entities\Platform\Space\Space;
use App\Entities\Proposal\Proposal;
use App\Services\ProposalService;
use App\Services\Space\SpaceService;

class ProposalFacade
{
    private $service;
    protected $spaceService;

    /**
     * ProposalFacade constructor.
     * @param ProposalService $service
     * @param SpaceService $spaceService
     */
    public function __construct(ProposalService $service, SpaceService $spaceService)
    {
        $this->service = $service;
        $this->spaceService = $spaceService;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search()
    {
        return $this->service->search();
    }

    /**
     * @param Proposal $proposal
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchSpaces(Proposal $proposal, array $columns)
    {
        return $this->spaceService->search(null, null, $proposal, $columns);
    }

    public function addProposalsSpace(Space $space, array $proposalIds)
    {
        $space->proposals()->attach($proposalIds);
    }


    /**
     * @param Proposal $proposal
     * @param Space $space
     * @param array $data
     * @return mixed|null
     */
    public function discount(Proposal $proposal, Space $space, array $data)
    {
        $this->service->discount($proposal, $space, $data);
        return $this->spaceService->getViewSpace($space->id, $proposal);
    }
}