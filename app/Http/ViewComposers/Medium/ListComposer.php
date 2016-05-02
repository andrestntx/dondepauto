<?php

namespace App\Http\ViewComposers\Medium;

use App\Repositories\Platform\CityRepository;
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
        $registrationStates = \Lang::get('states.registration');
        $cities = $this->cityRepository->citiesWithSpaces();

        $view->with([
            'registrationStates' => $registrationStates,
            'cities' => $cities
        ]);
    }
}