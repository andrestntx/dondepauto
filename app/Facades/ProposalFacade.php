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
use App\Services\Space\SpaceFormatService;
use App\Services\Space\SpaceService;

class ProposalFacade
{
    private $service;
    protected $spaceService;
    protected $formatService;
    protected $spaceFacade;

    /**
     * ProposalFacade constructor.
     * @param ProposalService $service
     * @param SpaceService $spaceService
     * @param EmailService $emailService
     * @param SpaceFormatService $formatService
     * @param SpaceFacade $spaceFacade
     */
    public function __construct(ProposalService $service, SpaceService $spaceService, EmailService $emailService,
        SpaceFormatService $formatService, SpaceFacade $spaceFacade)
    {
        $this->service = $service;
        $this->spaceService = $spaceService;
        $this->emailService = $emailService;
        $this->formatService = $formatService;
        $this->spaceFacade = $spaceFacade;
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

    /**
     * @param Space $space
     * @param array $proposalIds
     */
    public function addProposalsSpace(Space $space, array $proposalIds)
    {
        $space->proposals()->attach($proposalIds);
    }

    /**
     * @param Space $space
     * @param array $proposalIds
     */
    public function removeProposalsSpace(Space $space, array $proposalIds)
    {
        $space->proposals()->detach($proposalIds);
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
     * @param null $spaceIds
     * @return $this
     */
    public function select(Proposal $proposal, $spaceIds = null)
    {
        if(is_array($spaceIds) && count($spaceIds) > 0) {
            $spaces = $this->service->selectSpaces($proposal, array_map("intval", $spaceIds));
            $this->emailService->notifyProposalSelected($proposal, $spaces);
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
        $this->service->send($proposal);
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

    /**
     * @param array $data
     * @param array $images
     * @param array $keep_images
     * @param Proposal $proposal
     * @param Space $copySpace
     * @return mixed
     */
    public function duplicateSpace(array $data, $images = [], $keep_images = [], Proposal $proposal, Space $copySpace)
    {
        $format = $this->formatService->getModel($data['format_id']);
        $space  = $this->spaceService->createSpace($data, $format, $copySpace->publisher, false);
        $this->spaceService->saveAndCopyImages($images, $space, $copySpace, $keep_images);
        $this->spaceFacade->recalculatePoints($space);

        $copySpace = $proposal->spaces->where('id', $copySpace->id)->first();

        $this->removeProposalsSpace($copySpace, [$proposal->id]);
        $this->addProposalsSpace($space, [$proposal->id => [
            'selected' => $copySpace->pivot->selected,
            'title' => $copySpace->pivot->title,
            'description' => $copySpace->pivot->description,
        ]]);

        return $space;
    }

    /**
     * @param Proposal $proposal
     * @return ProposalFacade
     */
    public function getProposalWithSelectedSpaces(Proposal $proposal)
    {
        $proposalWithSelectedSpaces = clone $proposal;
        return $this->getSelected($proposalWithSelectedSpaces);
    }

    /**
     * @param Proposal $proposal
     */
    public function delete(Proposal $proposal)
    {
        $this->service->deleteModel($proposal);
    }
}