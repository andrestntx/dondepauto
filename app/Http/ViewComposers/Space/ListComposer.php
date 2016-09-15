<?php

namespace App\Http\ViewComposers\Space;

use App\Repositories\Platform\Space\SpaceCityRepository;
use App\Repositories\Platform\Space\SpaceCategoryRepository;
use App\Repositories\Platform\Space\SpaceFormatRepository;
use App\Repositories\Platform\Space\SpaceImpactSceneRepository;
use App\Repositories\Platform\Space\SpaceSubCategoryRepository;
use App\Repositories\Platform\UserRepository;
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
    protected  $userRepository;

    function __construct(SpaceCityRepository $cityRepository, SpaceCategoryRepository $spaceCategoryRepository,
                         SpaceSubCategoryRepository $spaceSubCategoryRepository, PublisherRepository $publisherRepository,
                        SpaceFormatRepository $spaceFormatRepository, SpaceImpactSceneRepository $impactSceneRepository,
                        UserRepository $userRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->spaceCategoryRepository = $spaceCategoryRepository;
        $this->spaceSubCategoryRepository = $spaceSubCategoryRepository;
        $this->publisherRepository = $publisherRepository;
        $this->spaceFormatRepository = $spaceFormatRepository;
        $this->impactSceneRepository = $impactSceneRepository;
        $this->userRepository = $userRepository;
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

        $advertisers = $this->userRepository->model
            ->select("id_us_LI", "email_us_LI", "empresa_us_LI", "nombre_us_LI", "apellido_us_LI", "tipo_us_LI")
            ->role("advertiser")
            ->get()
            ->lists("select_email", "id")
            ->all();

        $view->with([
            'publishers'    => $publishers,
            'advertisers'   => $advertisers,
            'cities'        => $cities,
            'categories'    => $categories,
            'subCategories' => $subCategories,
            'formats'       => $formats,
            'scenes'        => $scenes
        ]);
    }
}