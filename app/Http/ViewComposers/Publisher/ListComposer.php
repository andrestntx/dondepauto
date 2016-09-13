<?php

namespace App\Http\ViewComposers\Publisher;

use App\Repositories\Platform\ActionRepository;
use App\Repositories\Platform\ContactRepository;
use App\Repositories\Platform\Space\SpaceCityRepository as CityRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use App\Http\ViewComposers\BaseComposer;

class ListComposer extends BaseComposer
{
    protected $cityRepository;
    protected $actionRepository;
    protected $contactRepository;

    /**
     * ListComposer constructor.
     * @param UserRepository $repository
     * @param CityRepository $cityRepository
     * @param ActionRepository $actionRepository
     */
    function __construct(UserRepository $repository, CityRepository $cityRepository, ActionRepository $actionRepository, ContactRepository $contactRepository)
    {
        $this->repository = $repository;
        $this->cityRepository = $cityRepository;
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
        $registrationStates = \Lang::get('states.publisher');

        $actions = $this->actionRepository->model->where('type', 'publisher')->orWhere('type', 'all')->get();
        $cities  = $this->cityRepository->citiesWithSpaces();
        $actionsToday = $this->contactRepository->getActions();

        $view->with([
            'registrationStates' => $registrationStates,
            'cities'  => $cities,
            'actions' => $actions,
            'actionsToday' => $actionsToday
        ]);
    }
}