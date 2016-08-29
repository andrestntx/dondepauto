<?php

namespace App\Http\ViewComposers\Publisher;

use App\Repositories\Platform\Space\SpaceCityRepository as CityRepository;
use App\Repositories\UserRepository;
use Illuminate\Contracts\View\View;
use App\Http\ViewComposers\BaseComposer;

class ListComposer extends BaseComposer
{
    protected  $cityRepository;

    function __construct(UserRepository $repository, CityRepository $cityRepository)
    {
        $this->repository = $repository;
        $this->cityRepository = $cityRepository;
    }
    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $registrationStates = \Lang::get('states.publisher');
        $cities = $this->cityRepository->citiesWithSpaces();

        $view->with([
            'registrationStates' => $registrationStates,
            'cities' => $cities
        ]);
    }
}