<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:46 AM
 */

namespace App\Http\Controllers\Admin;

use App\Entities\Platform\User;
use App\Facades\PublisherFacade;
use App\Http\Controllers\ResourceController;
use App\Http\Requests\RUser\Publisher\StoreRequest;
use App\Http\Requests\RUser\Publisher\UpdateRequest;
use App\Services\PublisherService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublishersController extends ResourceController
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
    protected $viewPath = 'admin.publishers';

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
        return \Datatables::of($this->facade->search($request->get('columns'), $request->get('search')))
            ->filter(function ($instance) use ($request) {
                
                $instance->collection = $instance->collection->filter(function ($publisher) use ($request) {
                    $state = true;
                    $hasOffers = true;
                    $cities = true;

                    foreach ($request->get('columns') as $column) {
                        if($column['name'] == 'state_id') {
                            $state = $publisher->hasState($column['search']['value']);
                        }
                        if($column['name'] == 'has_offers' && $column['search']['value'] == 'true') {
                            $hasOffers = $publisher->has_offers;
                        }
                        if($column['name'] == 'space_city_names' && trim($column['search']['value'])) {
                            $cities = $publisher->hasSpaceCity(intval($column['search']['value']));

                        }
                    }
                    return $state && $hasOffers && $cities;
                });
            })
            ->make(true);

        return view('home');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param User $publisher
     * @return \Illuminate\Http\Response
     */
    public function searchSpaces(Request $request, User $publisher)
    {
        return \Datatables::of($this->facade->searchSpaces($publisher))->make(true);
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
     * @param  User  $publisher
     * @return \Illuminate\Http\Response
     */
    public function show(User $publisher)
    {
        $publisher->load('publisher');
        $spaces = $this->facade->getSpaces($publisher);

        return $this->view('show', ['publisher' => $publisher, 'spaces' => $spaces]);
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
            'publisher' => $user,
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
        return $this->redirect('show', $user);
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
     * @param $code
     * @return mixed
     */
    public function confirm($code)
    {
        $publisher = $this->facade->confirm($code);
        return redirect()->route('medios.account', $publisher);
    }
    
}