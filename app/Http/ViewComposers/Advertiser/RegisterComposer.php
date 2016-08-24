<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 25/04/2016
 * Time: 9:39 AM
 */

namespace App\Http\ViewComposers\Advertiser;

use App\Repositories\Platform\ActionRepository;
use Illuminate\Contracts\View\View;

class RegisterComposer
{
    protected $actionRepository;

    function __construct(ActionRepository $actionRepository)
    {
        $this->actionRepository = $actionRepository;
    }

    public function compose(View $view)
    {
        $actions = $this->actionRepository->all();

        $view->with([
            'actionsPublisher'  => $actions->where('type', 'publisher')->lists('name', 'id')->all(),
            'actionsAdvertiser'  => $actions->where('type', 'advertiser')->lists('name', 'id')->all()
        ]);
    }
}