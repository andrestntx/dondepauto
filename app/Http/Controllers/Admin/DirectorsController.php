<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 13/04/2016
 * Time: 11:00 AM
 */

namespace App\Http\Controllers\Admin;


use App\Entities\User;
use App\Http\Requests\Director\LinkRequest;
use App\Http\Requests\Director\UnLinkRequest;
use App\Http\Requests\RUser\StoreRequest;
use App\Services\UserService;
use App\Facades\DirectorFacade;

class DirectorsController extends UsersController
{
    protected $facade;

    /**
     * [$routePrefix prefix route in more one response view]
     * @var string
     */
    protected $routePrefix = 'directores';
    /**
     * [$viewPath folder views Controller]
     * @var string
     */
    protected $viewPath = 'admin.directors';

    /**
     * DirectorsController constructor.
     * @param UserService $service
     * @param DirectorFacade $facade
     */
    function __construct(UserService $service, DirectorFacade $facade)
    {
        $this->service = $service;
        $this->facade = $facade;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $this->service->createDirector($request->all());
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
        return $this->view('show', [
            'user'          => $user,
            'advertisers'   => $this->facade->advertisers($user)
        ]);
    }


    /**
     * @param UnLinkRequest $request
     * @param User $user
     * @return array
     */
    public function unlink(UnLinkRequest $request, User $user)
    {
        $this->facade->unlinkAdvertisers($request->get('advertisers'), $user);
        return [
            'success' => true,
            'message' => 'Anunciantes desvinculados'
        ];
    }

    /**
     * @param LinkRequest $request
     * @param User $user
     * @return array
     */
    public function link(LinkRequest $request, User $user)
    {
        $this->facade->linkAdvertisers($request->get('advertisers'), $user);
        return [
            'success' => true,
            'message' => 'Anunciantes asignados'
        ];
    }


}