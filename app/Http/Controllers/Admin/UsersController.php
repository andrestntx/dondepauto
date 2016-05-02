<?php
/**
 * Created by PhpStorm.
 * Users: andrestntx
 */
namespace App\Http\Controllers\Admin;

use App\Entities\User;
use App\Http\Controllers\ResourceController;
use App\Http\Requests\RUser\StoreRequest;
use App\Http\Requests\RUser\UpdateRequest;
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
    /**
     * UsersController constructor.
     * @param UserService $service
     */
    function __construct(UserService $service)
    {
        $this->service = $service;
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
}