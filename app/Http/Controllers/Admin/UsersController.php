<?php
/**
 * Created by PhpStorm.
 * Users: andrestntx
 */
namespace App\Http\Controllers\Admin;

use App\Entities\User;
use App\Entities\Platform\User as UserPlatform;
use App\Facades\AdvertiserFacade;
use App\Facades\PublisherFacade;
use App\Http\Controllers\ResourceController;
use App\Http\Requests\RUser\StoreRequest;
use App\Http\Requests\RUser\TagRequest;
use App\Http\Requests\RUser\UpdateRequest;
use App\Services\MailchimpService;
use App\Services\UserService;

class UsersController extends ResourceController
{
    /**
     * [$routePrefix prefix route in more one response view]
     * @var string
     */
    protected $routePrefix = 'usuarios';
    /**
     * [$viewPath folder views Controller]
     * @var string
     */
    protected $viewPath = 'admin.users';
    /**
     * [$modelName used in views]
     * @var string
     */
    protected $modelName = "user";

    protected $mailchimpService;
    protected $publisherFacade;
    protected $advertiserFacade;

    /**
     * UsersController constructor.
     * @param UserService $service
     * @param MailchimpService $mailchimpService
     * @param PublisherFacade $publisherFacade
     * @param AdvertiserFacade $advertiserFacade
     */
    function __construct(UserService $service, MailchimpService $mailchimpService, PublisherFacade $publisherFacade, AdvertiserFacade $advertiserFacade)
    {
        $this->service = $service;
        $this->mailchimpService = $mailchimpService;
        $this->advertiserFacade = $advertiserFacade;
        $this->publisherFacade  = $publisherFacade;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->view('lists');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->defaultCreate();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $this->service->createModel($request->all());
        return $this->redirect('index');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->view('show', ['user' => $user]);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return $this->view('form', [
            'user' => $user,
            'formData' => $this->getFormDataUpdate($user->id)
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, User $user)
    {
        $this->service->updateModel($request->all(), $user);
        return $this->redirect('index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->service->deleteModel($user);
    }


    /**
     * @param UserPlatform $user
     * @return array
     */
    public function syncMailchimp(UserPlatform $user)
    {
        $this->mailchimpService->syncUser($user);
        return ['success' => 'true'];
    }


    /**
     * @param UserPlatform $user
     * @return array
     */
    public function search(UserPlatform $user)
    {
        if($user->isPublisher()) {
            return ['publisher' => $this->publisherFacade->getPublisher($user)];
        }

        return ['advertiser' => $this->advertiserFacade->getAdvertiser($user)];
    }

    /**
     * @param TagRequest $request
     * @param UserPlatform $user
     * @return mixed
     */
    public function tag(TagRequest $request, UserPlatform $user)
    {
        $this->service->updateModel(['tag_id' => $request->get('tag_id')], $user);
        return ['success' => 'true'];
    }
}