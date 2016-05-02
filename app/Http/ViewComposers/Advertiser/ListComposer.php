<?php

namespace App\Http\ViewComposers\Advertiser;

use App\Repositories\Platform\CityRepository;
use App\Repositories\Platform\EconomicActivityRepository;
use App\Repositories\UserRepository;
use Illuminate\Contracts\View\View;
use App\Http\ViewComposers\BaseComposer;

class ListComposer extends BaseComposer
{
    protected  $cityRepository;
    protected  $economicActivityRepository;

    function __construct(UserRepository $repository, CityRepository $cityRepository, EconomicActivityRepository $economicActivityRepository)
    {
        $this->repository = $repository;
        $this->cityRepository = $cityRepository;
        $this->economicActivityRepository = $economicActivityRepository;
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

        $view->with([
            'registrationStates' => $registrationStates,
            'cities' => $cities,
            'economicActivities' => $economicActivities
        ]);
    }
}