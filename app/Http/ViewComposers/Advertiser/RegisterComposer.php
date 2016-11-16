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

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with([
            'actionsPublisher'      => $this->actionRepository->listsPublisher(),
            'actionsAdvertiser'     => $this->actionRepository->listsAdvertiser()
        ]);
    }
}