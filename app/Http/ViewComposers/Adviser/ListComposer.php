<?php

namespace App\Http\ViewComposers\Adviser;

use App\Repositories\UserRepository;
use Illuminate\Contracts\View\View;
use App\Http\ViewComposers\BaseComposer;

class ListComposer extends BaseComposer
{
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
        $advisers = $this->repository->advisers();

        $view->with([
            'advisers' => $advisers,
        ]);
    }
}