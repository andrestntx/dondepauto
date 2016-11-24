<?php

namespace App\Http\ViewComposers\Publisher;

use App\Repositories\Platform\UserRepository;
use Illuminate\Contracts\View\View;
use App\Http\ViewComposers\BaseComposer;

class ShowComposer extends BaseComposer
{
    protected $cityRepository;
    protected $actionRepository;
    protected $contactRepository;

    /**
     * ListComposer constructor.
     * @param UserRepository $repository
     */
    function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $advertisers = $this->repository->model
            ->select("id_us_LI", "email_us_LI", "empresa_us_LI", "nombre_us_LI", "apellido_us_LI", "tipo_us_LI")
            ->orderBy("tipo_us_LI", "asc")
            ->get()
            ->lists("role_select_email", "id")
            ->all();

        $view->with([
            'advertisers' => $advertisers
        ]);
    }
}