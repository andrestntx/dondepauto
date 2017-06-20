<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:46 AM
 */

namespace App\Http\Controllers\Admin;

use App\Entities\Platform\User;
use App\Facades\DatatableFacade;
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
    protected $datatableFacade;

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
     * PublishersController constructor.
     * @param PublisherFacade $facade
     * @param PublisherService $service
     * @param DatatableFacade $datatableFacade
     */
    function __construct(PublisherFacade $facade, PublisherService $service, DatatableFacade $datatableFacade)
    {
        $this->facade = $facade;
        $this->service = $service;
        $this->datatableFacade = $datatableFacade;
    }

    /**
     * @param User $publisher
     * @return $this
     */
    public function dashboard(User $publisher)
    {
        $publisher->load(['spaces.audiences', 'spaces.impactScenes', 'spaces.images', 'spaces.cities']);
        return view('publisher.dashboard')->with('publisher', $publisher);
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
     * @param $id
     * @return array
     */
    public function getStates($id)
    {
        return ['states' => $this->facade->getStates($id)];
    }

    /**
     * @param User $publisher
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProposals(User $publisher)
    {
        return view('publisher.proposals');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        return $this->datatableFacade->searchPublishers($request->get('columns'), $request->get('search')['value'], $request->all());
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
        return $this->datatableFacade->searchSpaces($request->get('columns'), $request->get('search')['value'], null, $publisher, null, $request->all());
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
        $this->facade->setChangeDocuments($publisher, $request->get('change_documents'));
        return ['success' => 'true'];
    }
    
}