<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:46 AM
 */

namespace App\Http\Controllers\Publisher;

use App\Entities\Platform\User;
use App\Facades\PublisherFacade;
use App\Facades\SpaceFacade;
use App\Http\Requests\RUser\Publisher\CompleteRequest;
use App\Http\Requests\RUser\Publisher\UpdateRequest;
use App\Services\PublisherService;
use Exception;
use Illuminate\Http\Request;

class PublishersController extends \App\Http\Controllers\Admin\PublishersController
{
    protected $facade;
    protected $spaceFacade;

    /**
     * [$routePrefix prefix route in more one response view]
     * @var string
     */
    protected $routePrefix = 'medios';
    /**
     * [$viewPath folder views Controller]
     * @var string
     */
    protected $viewPath = 'publisher';

    /**
     * [$modelName used in views]
     * @var string
     */
    protected $modelName = "publisher";

    /**
     * AdvertisersController constructor.
     * @param PublisherFacade $facade
     * @param PublisherService $service
     * @param SpaceFacade $spaceFacade
     */
    function __construct(PublisherFacade $facade, PublisherService $service, SpaceFacade $spaceFacade)
    {
        $this->facade = $facade;
        $this->service = $service;
        $this->spaceFacade = $spaceFacade;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function account(User $user)
    {
        if($user->complete_data) {
            return $this->view('account.form', [
                'publisher' => $user,
                'formData'  => $this->getSimpleFormData('update-account', $user)
            ]);
        }

        return $this->view('complete.form', [
            'publisher'     => $user,
            'formData'      => $this->getSimpleFormData('complete', $user)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CompleteRequest  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function complete(CompleteRequest $request, User $user)
    {        
        $this->facade->completeData($request->all(), $user);
        return redirect()->route('home');
    }

    /**
     * @param User $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function publish(User $user)
    {
        return $this->view('complete-thanks', ['publisher' => $user]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function firstSpace(User $user)
    {
        return $this->view('publish', ['publisher' => $user]);
    }

    /**
     * @param UpdateRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAccount(UpdateRequest $request, User $user)
    {
        $this->facade->updateModel($request->all(), $user);
        return $this->redirect('inventory', $user);
    }

    /**
     * @param $code
     * @return mixed
     */
    public function confirm($code)
    {
        $publisher = $this->facade->confirm($code);
        return redirect()->route('medios.account', $publisher);
    }
}