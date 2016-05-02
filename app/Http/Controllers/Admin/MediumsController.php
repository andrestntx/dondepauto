<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:46 AM
 */

namespace App\Http\Controllers\Admin;

use App\Entities\Platform\User;
use App\Facades\MediumFacade;
use App\Http\Controllers\ResourceController;
use App\Http\Requests\RUser\Medium\StoreRequest;
use App\Http\Requests\RUser\Medium\UpdateRequest;
use App\Services\MediumService;
use Illuminate\Http\Request;

class MediumsController extends ResourceController
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
    protected $viewPath = 'admin.mediums';

    /**
     * [$modelName used in views]
     * @var string
     */
    protected $modelName = "medium";

    /**
     * AdvertisersController constructor.
     * @param MediumFacade $facade
     * @param MediumService $service
     */
    function __construct(MediumFacade $facade, MediumService $service)
    {
        $this->facade = $facade;
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
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        return $this->facade->search();
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
        $this->facade->createModel($request->all());
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
            'medium' => $user,
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
        $this->facade->updateModel($request->all(), $user);
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