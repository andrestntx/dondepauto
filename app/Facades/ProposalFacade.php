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
use App\Services\EmailService;
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
     * @param EmailService $emailService
     */
    public function __construct(ProposalService $service, SpaceService $spaceService, EmailService $emailService)
    {
        $this->service = $service;
        $this->spaceService = $spaceService;
        $this->emailService = $emailService;
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

    /**
     * @param Proposal $proposal
     * @param null $spaces
     * @return $this
     */
    public function select(Proposal $proposal, $spaces = null)
    {
        if(is_array($spaces) && count($spaces) > 0) {
            $this->service->selectSpaces($proposal, array_map("intval", $spaces));
            $this->emailService->notifyProposalSelected($proposal);
        }

        return $proposal;
    }

    /**
     * @param Proposal $proposal
     * @param null $spaces
     * @return $this
     */
    public function getSelected(Proposal $proposal, $spaces = null)
    {
        return $this->service->loadProposalSelected($proposal);
    }

    /**
     * @param Proposal $proposal
     * @return $this
     */
    public function getProposal(Proposal $proposal)
    {
        return $this->service->loadProposal($proposal);
    }

    /**
     * @param Proposal $proposal
     */
    public function send(Proposal $proposal)
    {
        $this->emailService->sendProposal($proposal, $proposal->getAdvertiser());
    }

    /**
     * @param Proposal $proposal
     * @param Space $space
     * @param int $select
     */
    public function selectSpace(Proposal $proposal, Space $space, $select)
    {
        $this->service->selectSpace($proposal, $space, $select);
    }
}