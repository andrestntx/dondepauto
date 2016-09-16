<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 15/04/2016
 * Time: 8:57 AM
 */

namespace App\Http\Controllers\Admin;

use App\Entities\Platform\User;
use App\Facades\AdvertiserFacade;
use App\Http\Controllers\ResourceController;
use App\Http\Requests\RUser\Advertiser\StoreRequest;
use App\Http\Requests\RUser\Advertiser\UpdateRequest;
use App\Services\AdvertiserService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdvertisersController extends ResourceController
{
    protected $facade;

    /**
     * [$routePrefix prefix route in more one response view]
     * @var string
     */
    protected $routePrefix = 'anunciantes';

    /**
     * [$viewPath folder views Controller]
     * @var string
     */
    protected $viewPath = 'admin.advertisers';

    /**
     * [$modelName used in views]
     * @var string
     */
    protected $modelName = "advertiser";

    /**
     * AdvertisersController constructor.
     * @param AdvertiserFacade $facade
     * @param AdvertiserService $service
     */
    function __construct(AdvertiserFacade $facade, AdvertiserService $service)
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
            //abort('500');


            return \Datatables::of($this->facade->search(null, $request->get('columns'), $request->get('search'), $request->get('init'), $request->get('finish')))
                ->filter(function ($instance) use ($request) {
                    $instance->collection = $instance->collection->filter(function ($advertiser) use ($request) {
                        $state = true;
                        $intentions = true;

                        $actions = null;
                        $action_id = null;
                        $action_start = null;
                        $action_end = null;
                        $hasActions = true;

                        foreach ($request->get('columns') as $column) {
                            if($column['name'] == 'state_id') {
                                $state = $advertiser->hasState($column['search']['value']);
                            }

                            if($column['name'] == 'intention_at' && trim($column['search']['value'])) {
                                if($advertiser->intentions->count() == 0) {
                                    $intentions = false;
                                }
                            }

                            if ($column['name'] == 'action' && trim($column['search']['value']) && trim($column['search']['value']) != "0") {
                                $action_id = trim($column['search']['value']);
                            }
                            if ($column['name'] == 'action_range' && trim($column['search']['value'])) {
                                $action_range = explode(',', $column['search']['value']);
                                $action_start = trim($action_range[0]);
                                $action_end   = trim($action_range[1]);
                            }

                        }

                        if($action_id || $action_start || $action_end) {
                            if($lastAction = $advertiser->getLastAction()) {
                                $hasActions = $lastAction->isActionAndIsInRange($action_id, $action_start, $action_end);
                            }
                            else {
                                $hasActions = false;
                            }
                        }

                        return $state && $intentions && $hasActions;
                    });
                })
                ->make(true);

        //return view('home');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function searchProposals(Request $request)
    {
        return ['data' => $this->facade->search(null, $request->get('init'), $request->get('finish'))];
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
        $this->facade->createAdvertiser($request->all());

        if($request->ajax()){
            return ['success' => 'true'];
        }

        return $this->redirect('index');
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $advertiser
     * @return \Illuminate\Http\Response
     */
    public function show(User $advertiser)
    {
        $advertiser->load('advertiser');
        $proposals = $this->facade->searchProposals($advertiser);
        
        return $this->view('show', ['advertiser' => $advertiser, 'proposals' => $proposals]);
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
            'advertiser'    => $user,
            'formData'      => $this->getFormDataUpdate($user->id)
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
     * @param Request $request
     * @param User $advertiser
     * @return array
     */
    public function updateAjax(Request $request, User $advertiser)
    {
        $advertiser = $this->facade->updateModelView($request->all(), $advertiser);

        return [
            'success'   => 'true',
            'user'      => $advertiser
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->facade->deleteAdvertiser($user);
        return ['success' => 'true'];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function unlinked()
    {
        return $this->facade->advertisersWithOutAdviser();
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeRole(User $user)
    {
        $this->facade->changeRole($user);
        return redirect()->route('medios.edit', $user);
    }


    /**
     * @param Request $request
     * @param User $advertiser
     * @return array
     */
    public function newContact(Request $request, User $advertiser)
    {
        $contact = $this->facade->createContact($advertiser, $request->all());
        return ['success' => 'true', 'contact' => $contact];
    }
}