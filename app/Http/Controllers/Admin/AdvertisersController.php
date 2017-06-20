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
use App\Facades\DatatableFacade;
use App\Http\Controllers\ResourceController;
use App\Http\Requests\RUser\Advertiser\StoreRequest;
use App\Http\Requests\RUser\Advertiser\UpdateRequest;
use App\Services\AdvertiserService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdvertisersController extends ResourceController
{
    protected $facade;
    protected $datatableFacade;

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
     * @param DatatableFacade $datatableFacade
     */
    function __construct(AdvertiserFacade $facade, AdvertiserService $service, DatatableFacade $datatableFacade)
    {
        $this->facade = $facade;
        $this->service = $service;
        $this->datatableFacade = $datatableFacade;
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
        return response()->json($this->datatableFacade->searchAdvertisers(
            null, 
            $request->get('columns'), 
            $request->get('search')['value'], 
            $request->get('init'), 
            $request->get('finish'), 
            $request->all()
        ));
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
        $advertiser = $this->facade->updateModel($request->all(), $user);

        if($request->ajax()){
            return ['success' => 'true', 'advertiser' => $advertiser];
        }

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