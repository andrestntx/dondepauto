<?php

namespace App\Http\ViewComposers\Space;

use App\Repositories\Platform\Space\SpaceCityRepository;
use App\Repositories\Platform\Space\SpaceCategoryRepository;
use App\Repositories\Platform\Space\SpaceFormatRepository;
use App\Repositories\Platform\Space\SpaceSubCategoryRepository;
use App\Repositories\Views\MediumRepository;
use Illuminate\Contracts\View\View;
use App\Http\ViewComposers\BaseComposer;

class ListComposer extends BaseComposer
{
    protected  $cityRepository;
    protected  $spaceCategoryRepository;
    protected  $spaceSubCategoryRepository;
    protected  $mediumRepository;
    protected  $spaceFormatRepository;

    function __construct(SpaceCityRepository $cityRepository, SpaceCategoryRepository $spaceCategoryRepository,
                         SpaceSubCategoryRepository $spaceSubCategoryRepository, MediumRepository $mediumRepository,
                        SpaceFormatRepository $spaceFormatRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->spaceCategoryRepository = $spaceCategoryRepository;
        $this->spaceSubCategoryRepository = $spaceSubCategoryRepository;
        $this->mediumRepository = $mediumRepository;
        $this->spaceFormatRepository = $spaceFormatRepository;
    }
    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $mediums = $this->mediumRepository->mediumsWithSpaces();
        $cities = $this->cityRepository->citiesWithSpaces();
        $categories = $this->spaceCategoryRepository->categoriesWithSpaces();
        $subCategories = $this->spaceSubCategoryRepository->subCategoriesWithSpaces();
        $formats =  $this->spaceFormatRepository->formatsWithSpaces();

        $view->with([
            'mediums'       => $mediums,
            'cities'        => $cities,
            'categories'    => $categories,
            'subCategories' => $subCategories,
            'formats'       => $formats
        ]);
    }
}