<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:46 AM
 */

namespace App\Http\Controllers\Publisher;

use App\Entities\Platform\User;
use App\Facades\PublisherFacade;
use App\Facades\SpaceFacade;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResourceController;
use App\Http\Requests\RUser\Publisher\CompleteRequest;
use App\Http\Requests\RUser\Publisher\UpdateRequest;
use App\Services\PublisherService;
use Exception;
use Illuminate\Http\Request;

class PublishersSpacesController extends ResourceController
{
    protected $facade;
    protected $spaceFacade;

    /**
     * [$routePrefix prefix route in more one response view]
     * @var string
     */
    protected $routePrefix = 'medios.espacios';
    /**
     * [$viewPath folder views Controller]
     * @var string
     */
    protected $viewPath = 'publisher.spaces';

    /**
     * [$modelName used in views]
     * @var string
     */
    protected $modelName = "publisher";

    /**
     * AdvertisersController constructor.
     * @param PublisherFacade $facade
     * @param PublisherService $service
     * @param SpaceFacade $spaceFacade
     */
    function __construct(PublisherFacade $facade, PublisherService $service, SpaceFacade $spaceFacade)
    {
        $this->facade = $facade;
        $this->service = $service;
        $this->spaceFacade = $spaceFacade;
    }

    /**
     * @param User $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function index(User $user)
    {
        return $this->view('lists', ['publisher' => $user]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function create(User $user)
    {
        return $this->view('form', ['publisher' => $user]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function store(Request $request, User $user)
    {
        try {
            $this->spaceFacade->createModel($request->all(), $request->file('images'), $user);
        } catch (Exception $e) {
            return ['result' => 'false'];
        }

        if($this->spaceFacade->countSpaces($user) == 1) {
            return ['result' => 'true', 'route' => route('medios.agreement', $user)];
        }

        return ['result' => 'true', 'route' => route('home')];
    }
}