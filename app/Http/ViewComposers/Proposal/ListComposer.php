<?php

namespace App\Http\ViewComposers\Proposal;

use App\Repositories\Platform\ActionRepository;
use App\Repositories\Platform\Space\SpaceCityRepository as CityRepository;
use App\Repositories\Platform\TagRepository;
use App\Repositories\Views\AdvertiserRepository;
use App\Repositories\Views\PublisherRepository;
use App\Repositories\Views\SpaceRepository;
use Illuminate\Contracts\View\View;
use App\Http\ViewComposers\BaseComposer;

class ListComposer extends BaseComposer
{
    protected $actionRepository;
    protected $cityRepository;
    protected $spaceRepository;
    protected $advertiserRepository;
    protected $publisherRepository;

    /**
     * ListComposer constructor.
     * @param ActionRepository $actionRepository
     * @param CityRepository $cityRepository
     * @param AdvertiserRepository $advertiserRepository
     * @param PublisherRepository $publisherRepository
     * @param SpaceRepository $spaceRepository
     */
    function __construct(ActionRepository $actionRepository, CityRepository $cityRepository, AdvertiserRepository $advertiserRepository,
                         PublisherRepository $publisherRepository, SpaceRepository $spaceRepository)
    {
        $this->actionRepository = $actionRepository;
        $this->cityRepository = $cityRepository;
        $this->spaceRepository = $spaceRepository;
        $this->advertiserRepository = $advertiserRepository;
        $this->publisherRepository = $publisherRepository;
    }
    
    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $states         = $this->actionRepository->statesWithProposals();
        $cities         = $this->cityRepository->citiesWithProposals();
        $publishers     = $this->publisherRepository->publishersWithProposals();
        $advertisers    = $this->advertiserRepository->advertisersWithProposals();
        $spaces         = $this->spaceRepository->spacesWithProposals();

        $view->with([
            'states'        => $states,
            'cities'        => $cities,
            'publishers'    => $publishers,
            'advertisers'   => $advertisers,
            'spaces'        => $spaces
        ]);
    }
}