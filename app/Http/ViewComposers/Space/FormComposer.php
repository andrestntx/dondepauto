<?php

namespace App\Http\ViewComposers\Space;

use App\Repositories\Platform\Space\SpaceCategoryRepository;
use App\Repositories\Platform\Space\SpaceSubCategoryRepository;
use App\Repositories\Platform\Space\SpaceFormatRepository;
use App\Repositories\Platform\Space\SpaceCityRepository;
use App\Repositories\Platform\Space\SpaceImpactSceneRepository;
use App\Repositories\Platform\Space\SpacePeriodRepository;


use Illuminate\Contracts\View\View;
use App\Http\ViewComposers\BaseComposer;

class FormComposer extends BaseComposer
{
    protected $cityRepository;
    protected $categoryRepository;
    protected $subCategoryRepository;
    protected $formatRepository;
    protected $impactSceneRepository;
    protected $periodRepository;

    function __construct(SpaceFormatRepository $formatRepository, SpaceCityRepository $cityRepository, SpaceImpactSceneRepository $impactSceneRepository, SpacePeriodRepository $periodRepository)
    {
        $this->formatRepository         = $formatRepository;
        $this->impactSceneRepository    = $impactSceneRepository;
        $this->cityRepository           = $cityRepository;
        $this->periodRepository         = $periodRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $formats        = $this->formatRepository->listsSelectComplete();
        $scenes         = $this->impactSceneRepository->listsSelect();
        $cities         = $this->cityRepository->listsSelect();
        $periods        = $this->periodRepository->listsSelect();

        $view->with([
            'formats'       => $formats,
            'scenes'        => $scenes,
            'cities'        => $cities,
            'periods'       => $periods
        ]);
    }
}