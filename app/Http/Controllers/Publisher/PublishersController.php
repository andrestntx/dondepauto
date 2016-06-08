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
use App\Http\Requests\RUser\Publisher\CompleteRequest;
use App\Http\Requests\RUser\Publisher\UpdateRequest;
use App\Services\PublisherService;

class PublishersController extends \App\Http\Controllers\Admin\PublishersController
{
    protected $facade;

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
     */
    function __construct(PublisherFacade $facade, PublisherService $service)
    {
        $this->facade = $facade;
        $this->service = $service;
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
            return $this->view('account', [
                'publisher' => $user,
                'formData'  => $this->getSimpleFormData('update-account', $user)
            ]);
        }

        return $this->view('complete', [
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
        return $this->redirect('publish', $user);
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
    public function publishCreate(User $user)
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