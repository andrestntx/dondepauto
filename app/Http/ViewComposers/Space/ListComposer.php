<?php

namespace App\Http\ViewComposers\Space;

use App\Repositories\Platform\Space\SpaceCityRepository;
use App\Repositories\Platform\Space\SpaceCategoryRepository;
use App\Repositories\Platform\Space\SpaceFormatRepository;
use App\Repositories\Platform\Space\SpaceImpactSceneRepository;
use App\Repositories\Platform\Space\SpaceSubCategoryRepository;
use App\Repositories\Views\PublisherRepository;
use Illuminate\Contracts\View\View;
use App\Http\ViewComposers\BaseComposer;

class ListComposer extends BaseComposer
{
    protected  $cityRepository;
    protected  $spaceCategoryRepository;
    protected  $spaceSubCategoryRepository;
    protected  $publisherRepository;
    protected  $spaceFormatRepository;
    protected  $impactSceneRepository;

    function __construct(SpaceCityRepository $cityRepository, SpaceCategoryRepository $spaceCategoryRepository,
                         SpaceSubCategoryRepository $spaceSubCategoryRepository, PublisherRepository $publisherRepository,
                        SpaceFormatRepository $spaceFormatRepository, SpaceImpactSceneRepository $impactSceneRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->spaceCategoryRepository = $spaceCategoryRepository;
        $this->spaceSubCategoryRepository = $spaceSubCategoryRepository;
        $this->publisherRepository = $publisherRepository;
        $this->spaceFormatRepository = $spaceFormatRepository;
        $this->impactSceneRepository = $impactSceneRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $publishers = $this->publisherRepository->publishersWithSpaces();
        $cities = $this->cityRepository->citiesWithSpaces();
        $categories = $this->spaceCategoryRepository->categoriesWithSpaces();
        $subCategories = $this->spaceSubCategoryRepository->subCategoriesWithSpaces();
        $formats =  $this->spaceFormatRepository->formatsWithSpaces();
        $scenes = $this->impactSceneRepository->scenesWithSpaces();

        $view->with([
            'publishers'       => $publishers,
            'cities'        => $cities,
            'categories'    => $categories,
            'subCategories' => $subCategories,
            'formats'       => $formats,
            'scenes'        => $scenes
        ]);
    }
}