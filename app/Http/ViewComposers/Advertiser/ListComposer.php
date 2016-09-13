<?php

namespace App\Http\ViewComposers\Advertiser;

use App\Repositories\Platform\ActionRepository;
use App\Repositories\Platform\CityRepository;
use App\Repositories\Platform\ContactRepository;
use App\Repositories\Platform\EconomicActivityRepository;
use App\Repositories\UserRepository;
use Illuminate\Contracts\View\View;
use App\Http\ViewComposers\BaseComposer;

class ListComposer extends BaseComposer
{
    protected  $cityRepository;
    protected  $economicActivityRepository;
    protected $actionRepository;
    protected $contactRepository;

    /**
     * ListComposer constructor.
     * @param UserRepository $repository
     * @param CityRepository $cityRepository
     * @param EconomicActivityRepository $economicActivityRepository
     * @param ActionRepository $actionRepository
     */
    function __construct(UserRepository $repository, CityRepository $cityRepository, EconomicActivityRepository $economicActivityRepository,
                         ActionRepository $actionRepository, ContactRepository $contactRepository)
    {
        $this->repository = $repository;
        $this->cityRepository = $cityRepository;
        $this->economicActivityRepository = $economicActivityRepository;
        $this->actionRepository = $actionRepository;
        $this->contactRepository = $contactRepository;
    }
    
    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $registrationStates = \Lang::get('states.registration');
        $cities = $this->cityRepository->citiesWithAdvertisers();
        $economicActivities = $this->economicActivityRepository->activitiesWithAdvertisers();
        $actions = $this->actionRepository->model->where('type', 'advertiser')->orWhere('type', 'all')->get();
        $actionsToday = $this->contactRepository->getActions('advertiser');

        $view->with([
            'registrationStates'    => $registrationStates,
            'cities'                => $cities,
            'economicActivities'    => $economicActivities,
            'actions'               => $actions,
            'actionsToday'          => $actionsToday
        ]);
    }
}