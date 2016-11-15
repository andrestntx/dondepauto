<?php

namespace App\Http\ViewComposers\Proposal;

use App\Repositories\Platform\ActionRepository;
use App\Repositories\Platform\CityRepository;
use App\Repositories\Platform\TagRepository;
use Illuminate\Contracts\View\View;
use App\Http\ViewComposers\BaseComposer;

class ShowComposer extends BaseComposer
{
    protected $actionRepository;
    protected $tagRepository;
    protected $cityRepository;

    /**
     * ListComposer constructor.
     * @param ActionRepository $actionRepository
     * @param TagRepository $tagRepository
     * @param CityRepository $cityRepository
     */
    function __construct(ActionRepository $actionRepository, TagRepository $tagRepository, CityRepository $cityRepository)
    {
        $this->actionRepository = $actionRepository;
        $this->tagRepository = $tagRepository;
        $this->cityRepository = $cityRepository;
    }
    
    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $actions    = $this->actionRepository->model->with('contacts')->where('type', 'proposal')->orWhere('type', 'all')->lists('name', 'id')->all();
        $tags       = $this->tagRepository->model->where('type', 'publisher')->orWhere('type', 'all')->lists('name', 'id')->all();
        $cities     = $this->cityRepository->citiesWithAdvertisers();

        $view->with([
            'actionsAdvertiser' => $actions,
            'tags'              => $tags,
            'cities'            => $cities
        ]);
    }
}