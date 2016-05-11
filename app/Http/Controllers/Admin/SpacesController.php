<?php
/**
 * Created by PhpStorm.
 * Space: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:46 AM
 */

namespace App\Http\Controllers\Admin;

use App\Entities\Platform\Space\Space;
use App\Facades\SpaceFacade;
use App\Services\Space\SpaceService;

use App\Http\Controllers\ResourceController;
use App\Http\Requests\Space\StoreRequest;
use App\Http\Requests\Space\UpdateRequest;
use Illuminate\Http\Request;

class SpacesController extends ResourceController
{
    protected $facade;

    /**
     * [$routePrefix prefix route in more one response view]
     * @var string
     */
    protected $routePrefix = 'espacios';
    /**
     * [$viewPath folder views Controller]
     * @var string
     */
    protected $viewPath = 'admin.spaces';

    /**
     * [$modelName used in views]
     * @var string
     */
    protected $modelName = "space";

    /**
     * AdvertisersController constructor.
     * @param SpaceFacade $facade
     * @param SpaceService $service
     */
    function __construct(SpaceFacade $facade, SpaceService $service)
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
     * @param  Space  $space
     * @return \Illuminate\Http\Response
     */
    public function show(Space $space)
    {
        return $this->view('show', ['space' => $space]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Space  $space
     * @return \Illuminate\Http\Response
     */
    public function edit(Space $space)
    {
        return $this->view('form', [
            'space' => $space,
            'formData' => $this->getFormDataUpdate($space->id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  Space  $space
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Space $space)
    {
        $this->facade->updateModel($request->all(), $space);
        return $this->redirect('index');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  Space  $space
     * @return \Illuminate\Http\Response
     */
    public function destroy(Space $space)
    {
        $this->service->deleteModel($space);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function ajax(Request $request)
    {
        return [
            'success' => true,
            'inputs'  => $this->facade->ajax($request->get('category'), $request->get('sub_category'), $request->get('publisher'),
                $request->get('format'), $request->get('city'))
        ];
    }
    
}