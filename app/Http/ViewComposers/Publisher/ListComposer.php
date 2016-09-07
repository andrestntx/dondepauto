<?php

namespace App\Http\ViewComposers\Publisher;

use App\Repositories\Platform\ActionRepository;
use App\Repositories\Platform\Space\SpaceCityRepository as CityRepository;
use App\Repositories\UserRepository;
use Illuminate\Contracts\View\View;
use App\Http\ViewComposers\BaseComposer;

class ListComposer extends BaseComposer
{
    protected $cityRepository;
    protected $actionRepository;

    /**
     * ListComposer constructor.
     * @param UserRepository $repository
     * @param CityRepository $cityRepository
     * @param ActionRepository $actionRepository
     */
    function __construct(UserRepository $repository, CityRepository $cityRepository, ActionRepository $actionRepository)
    {
        $this->repository = $repository;
        $this->cityRepository = $cityRepository;
        $this->actionRepository = $actionRepository;
    }
    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $registrationStates = \Lang::get('states.publisher');

        $actions = $this->actionRepository->all();
        $cities  = $this->cityRepository->citiesWithSpaces();

        $view->with([
            'registrationStates' => $registrationStates,
            'cities'  => $cities,
            'actions' => $actions
        ]);
    }
}