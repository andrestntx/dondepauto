<?php

namespace App\Http\ViewComposers\Publisher;

use App\Repositories\Platform\CityRepository;
use Illuminate\Contracts\View\View;
use App\Http\ViewComposers\BaseComposer;

class FormComposer extends BaseComposer
{
    protected $cityRepository;

    function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $cities = $this->cityRepository->listsSelect();

        $view->with([
            'cities' => $cities,
        ]);
    }
}