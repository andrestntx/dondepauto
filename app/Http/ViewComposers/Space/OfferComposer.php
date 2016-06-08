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

class OfferComposer extends BaseComposer
{
    protected $cityRepository;
    protected $categoryRepository;
    protected $subCategoryRepository;
    protected $impactSceneRepository;
    protected $periodRepository;
    protected $formatRepository;

    function __construct(SpaceCategoryRepository $categoryRepository, SpaceCityRepository $cityRepository, SpaceImpactSceneRepository $impactSceneRepository, 
                         SpacePeriodRepository $periodRepository, SpaceFormatRepository $formatRepository)
    {
        $this->categoryRepository       = $categoryRepository;
        $this->impactSceneRepository    = $impactSceneRepository;
        $this->cityRepository           = $cityRepository;
        $this->periodRepository         = $periodRepository;
        $this->formatRepository         = $formatRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $categories     = $this->categoryRepository->selectSubcategories();
        $scenes         = $this->impactSceneRepository->listsSelect();
        $cities         = $this->cityRepository->listsSelect();
        $periods        = $this->periodRepository->listsSelect();
        $formats        = $this->formatRepository->jsonFormats();

        $view->with([
            'formats'       => $formats,
            'categories'    => $categories,    
            'scenes'        => $scenes,
            'cities'        => $cities,
            'periods'       => $periods
        ]);
    }
}