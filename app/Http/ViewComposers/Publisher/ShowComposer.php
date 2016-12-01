<?php

namespace App\Http\ViewComposers\Publisher;

use App\Repositories\Platform\TagRepository;
use App\Repositories\Platform\UserRepository;
use App\Repositories\Proposal\ProposalRepository;
use Illuminate\Contracts\View\View;
use App\Http\ViewComposers\BaseComposer;

class ShowComposer extends BaseComposer
{
    protected $cityRepository;
    protected $actionRepository;
    protected $contactRepository;
    protected $proposalRepository;
    protected $tagRepository;

    /**
     * ListComposer constructor.
     * @param UserRepository $repository
     * @param ProposalRepository $proposalRepository
     */
    function __construct(UserRepository $repository, ProposalRepository $proposalRepository, TagRepository $tagRepository)
    {
        $this->repository = $repository;
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
        $proposals = $this->proposalRepository->model
            ->with(['quote.advertiser'])
            ->get()
            ->sortByDesc("created_at")
            ->lists("advertiser_title", "id")
            ->all();

        $advertisers = $this->repository->model
            ->select("id_us_LI", "email_us_LI", "empresa_us_LI", "nombre_us_LI", "apellido_us_LI", "tipo_us_LI")
            ->orderBy("tipo_us_LI", "asc")
            ->get()
            ->lists("role_select_email", "id")
            ->all();

        $tags = $this->tagRepository->model->where('type', 'space')->orWhere('type', 'all')->lists('name', 'id')->all();

        $view->with([
            'advertisers' => $advertisers,
            'proposals' => $proposals,
            'tags'  => $tags
        ]);
    }
}