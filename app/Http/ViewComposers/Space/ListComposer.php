<?php

namespace App\Http\ViewComposers\Space;

use App\Repositories\Platform\Space\SpaceCityRepository;
use App\Repositories\Platform\Space\SpaceCategoryRepository;
use App\Repositories\Platform\Space\SpaceFormatRepository;
use App\Repositories\Platform\Space\SpaceImpactSceneRepository;
use App\Repositories\Platform\TagRepository;
use App\Repositories\Proposal\ProposalRepository;
use App\Repositories\Platform\UserRepository;
use App\Repositories\Views\PublisherRepository;
use App\Services\Space\SpaceSubCategoryService;
use Illuminate\Contracts\View\View;
use App\Http\ViewComposers\BaseComposer;

class ListComposer extends BaseComposer
{
    protected  $cityRepository;
    protected  $spaceCategoryRepository;
    protected  $spaceSubCategoryService;
    protected  $publisherRepository;
    protected  $spaceFormatRepository;
    protected  $impactSceneRepository;
    protected  $userRepository;
    protected  $proposalRepository;
    protected  $tagRepository;

    function __construct(SpaceCityRepository $cityRepository, SpaceCategoryRepository $spaceCategoryRepository,
                         SpaceSubCategoryService $spaceSubCategoryService, PublisherRepository $publisherRepository,
                        SpaceFormatRepository $spaceFormatRepository, SpaceImpactSceneRepository $impactSceneRepository,
                        UserRepository $userRepository, ProposalRepository $proposalRepository, TagRepository $tagRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->spaceCategoryRepository = $spaceCategoryRepository;
        $this->spaceSubCategoryService = $spaceSubCategoryService;
        $this->publisherRepository = $publisherRepository;
        $this->spaceFormatRepository = $spaceFormatRepository;
        $this->impactSceneRepository = $impactSceneRepository;
        $this->userRepository = $userRepository;
        $this->proposalRepository = $proposalRepository;
        $this->tagRepository = $tagRepository;
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
        $subCategories = $this->spaceSubCategoryService->searchWithSpaces();
        $formats =  $this->spaceFormatRepository->formatsWithSpaces();
        $scenes = $this->impactSceneRepository->scenesWithSpaces();
        $proposals = $this->proposalRepository->model
            ->with(['quote.advertiser'])
            ->get()
            ->sortByDesc("created_at")
            ->lists("advertiser_title", "id")
            ->all();

        $advertisers = $this->userRepository->model
            ->select("id_us_LI", "email_us_LI", "empresa_us_LI", "nombre_us_LI", "apellido_us_LI", "tipo_us_LI")
            ->orderBy("tipo_us_LI", "asc")
            ->get()
            ->lists("role_select_email", "id")
            ->all();

        $tags           = $this->tagRepository->model->where('type', 'space')->orWhere('type', 'all')->lists('name', 'id')->all();

        $view->with([
            'publishers'    => $publishers,
            'advertisers'   => $advertisers,
            'cities'        => $cities,
            'categories'    => $categories,
            'subCategories' => $subCategories,
            'formats'       => $formats,
            'scenes'        => $scenes,
            'proposals'     => $proposals,
            'tags'          => $tags
        ]);
    }
}