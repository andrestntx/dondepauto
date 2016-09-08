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
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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
                    $dates = true;

                    /** @var $actions */
                    $actions = null;
                    $action_id = null;
                    $action_start = null;
                    $action_end = null;
                    $hasActions = true;

                    /** @var $hasLogo */
                    $hasLogo = true;

                    foreach ($request->get('columns') as $column) {
                        if($column['name'] == 'state_id') {
                            $state = $publisher->hasState($column['search']['value']);
                        }
                        if($column['name'] == 'has_offers' && $column['search']['value'] == 'true') {
                            $hasOffers = $publisher->has_offers;
                        }
                        if($column['name'] == 'has_logo') {
                            if($column['search']['value'] == 'true') {
                                $hasLogo = $publisher->has_logo == true;
                            }
                            else if($column['search']['value'] == 'false') {
                                $hasLogo = $publisher->has_logo == false;
                            }
                        }
                        if($column['name'] == 'space_city_names' && trim($column['search']['value'])) {
                            $cities = $publisher->hasSpaceCity(intval($column['search']['value']));
                        }
                        if ($column['name'] == 'last_offer_at_datatable' && trim($column['search']['value'])) {
                            $dateRange = explode(',', $column['search']['value']);

                            if(trim($dateRange[0])) {
                                $dates = strtotime($publisher->last_offer) >= strtotime(Carbon::createFromFormat('d/m/Y', $dateRange[0])->toDateString());
                            }
                            if(trim($dateRange[1])) {
                                $dates = $dates && (strtotime($publisher->last_offer) <= strtotime(Carbon::createFromFormat('d/m/Y', $dateRange[1])->toDateString()));
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
                        if($publisher->contacts->count() > 0) {
                            $actions = $publisher->contacts->filter(function ($contact) use ($action_id, $action_start, $action_end) {
                                if($action = $contact->actions->first()) {
                                    return $action->isActionAndIsInRange($action_id, $action_start, $action_end);
                                }
                            });

                            if($actions->count() == 0) {
                                $hasActions = false;
                            }
                        }
                        else {
                            $hasActions = false;
                        }
                    }

                    return $state && $hasOffers && $cities && $dates && $hasActions && $hasLogo;
                });
            })
            ->make(true);

       // return view('home');
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
        $this->facade->createPublisher($request->all());
        return ['success' => 'true'];
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
     * @param Request $request
     * @param User $publisher
     * @return array
     */
    public function updateAjax(Request $request, User $publisher)
    {
        $publisher = $this->facade->updateModelView($request->all(), $publisher);

        return [
            'success' => 'true',
            'user' => $publisher
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
        $this->facade->deletePublisher($user);
        return ['success' => 'true'];
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

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeRole(User $user)
    {
        $this->facade->changeRole($user);
        return redirect()->route('anunciantes.edit', $user);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return array
     */
    public function checkAgreement(Request $request, User $user)
    {
        $this->facade->setAgreement($user, $request->get('agreement'));
        return ['success' => 'true'];
    }

    /**
     * @param Request $request
     * @param User $publisher
     * @return array
     */
    public function changeDocuments(Request $request, User $publisher)
    {
        \Log::info('está llegando');
        \Log::info($request->get('change_documents'));
        $this->facade->setChangeDocuments($publisher, $request->get('change_documents'));
        return ['success' => 'true'];
    }
    
}