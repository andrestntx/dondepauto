<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:46 AM
 */

namespace App\Http\Controllers\Publisher;

use App\Entities\Platform\Space\Space;
use App\Entities\Platform\User;
use App\Facades\PublisherFacade;
use App\Facades\SpaceFacade;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResourceController;
use App\Http\Requests\RUser\Publisher\CompleteRequest;
use App\Http\Requests\RUser\Publisher\UpdateRequest;
use App\Services\MixpanelService;
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

    protected $mixpanelService;

    /**
     * AdvertisersController constructor.
     * @param PublisherFacade $facade
     * @param PublisherService $service
     * @param SpaceFacade $spaceFacade
     */
    function __construct(PublisherFacade $facade, PublisherService $service, SpaceFacade $spaceFacade, MixpanelService $mixpanelService)
    {
        $this->facade = $facade;
        $this->service = $service;
        $this->spaceFacade = $spaceFacade;
        $this->mixpanelService = $mixpanelService;
    }

    /**
     * @param User $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function index(User $user)
    {
        $user->load(['spaces.format.subCategory.category', 'spaces.cities', 'spaces.audiences', 'spaces.images', 'spaces.impactScenes']);
        return $this->view('lists', ['publisher' => $user]);
    }

    /**
     * @param User $user
     * @param Space $space
     * @return array
     */
    public function show(User $user, Space $space)
    {
        return $this->view('show', ['publisher' => $user, 'space' => $space]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function create(User $user)
    {
        $this->mixpanelService->track("FORMULARIO_PUBLICACION_ESPACIO", $user);
        $route = ['medios.espacios.store', $user];
        $type = 'POST';

        return $this->view('form', ['publisher' => $user, 'space' => new Space(), 'route' => $route, 'type' => $type]);
    }

    /**
     * @param User $publisher
     * @return \Illuminate\Auth\Access\Response
     */
    public function firstCreate(User $publisher)
    {
        if($publisher->has_offers) {
            return redirect()->route('medios.espacios.create', $publisher);
        }

        return view('publisher.home-no-spaces')->with('publisher', $publisher);
    }

    /**
     * @param User $user
     * @param Space $space
     * @return \Illuminate\Auth\Access\Response
     */
    public function edit(User $user, Space $space)
    {
        $space->load('format.subCategory.formats');
        $formats = $space->format->subCategory->formats->lists('name', 'id')->all();
        $route = ['medios.espacios.update', $user, $space];
        $type = 'POST';
        
        return $this->view('form', ['publisher' => $user, 'space' => $space, 'spaceFormats' => $formats, 'route' => $route, 'type' => $type]);
    }

    /**
     * @param User $user
     * @param Space $space
     * @return \Illuminate\Auth\Access\Response
     */
    public function duplicate(User $user, Space $space)
    {
        $space->load('format.subCategory.formats');
        $formats = $space->format->subCategory->formats->lists('name', 'id')->all();
        $route = ['medios.espacios.post-duplicate', $user, $space];
        $type = 'POST';

        return $this->view('form', ['publisher' => $user, 'space' => $space, 'spaceFormats' => $formats, 'route' => $route, 'type' => $type]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function store(Request $request, User $user)
    {
        try {
            $space = $this->spaceFacade->createModel($request->all(), $request->file('images'), $user);
        } catch (Exception $e) {
            \Log::info("error al crear oferta == " . $e->getMessage());
            return ['result' => 'false', 'route' => route('home'), 'error' => $e->getCode(), 'error_text' => $e->getMessage()];
        }

        $this->mixpanelService->track("ESPACIO_PUBLICITARIO_CREADO", $user);

        if($this->spaceFacade->countSpaces($user) == 1) {
            \Alert::success($user->company)->details('Haz creado una nueva oferta para presentar a clientes DóndePauto. Publica más ofertas y actívate como Proveedor!');
            return ['result' => 'true', 'route' => route('medios.agreement', $user)];
        }

        \Alert::success($user->company)->details('Haz creado una nueva oferta. Publica más ofertas y aumenta tus posibilidades de ventas');
        return ['result' => 'true', 'route' => route('medios.espacios.index', $user)];
    }

    /**
     * @param Request $request
     * @param User $user
     * @param Space $space
     * @return array
     */
    public function update(Request $request, User $user, Space $space)
    {
        \Log::info($request->all());

        try {
            $this->spaceFacade->updateModel($request->all(), $request->file('images'), $request->get('keep_images'), $space);
        } catch (Exception $e) {
            \Log::info($e);
            return ['result' => 'false', 'route' => route('home')];
        }

        if($this->spaceFacade->countSpaces($user) == 1) {
            return ['result' => 'true', 'route' => route('medios.agreement', $user)];
        }

        return ['result' => 'true', 'route' => route('medios.espacios.show', [$user, $space])];
    }

    /**
     * @param Request $request
     * @param User $user
     * @param Space $space
     * @return \Illuminate\Auth\Access\Response
     */
    public function postDuplicate(Request $request, User $user, Space $space)
    {
        try {
            $space = $this->spaceFacade->duplicateModel($request->all(), $request->file('images'), $request->get('keep_images'), $user, $space);
        } catch (Exception $e) {
            \Log::info($e);
            return ['result' => 'false', 'route' => route('home')];
        }

        \Alert::success($user->company)->details('Haz creado una nueva oferta. Publica más ofertas y aumenta tus posibilidades de ventas');
        return ['result' => 'true', 'route' => route('medios.espacios.show', [$user, $space])];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function updateAllPoints(Request $request)
    {
        $this->spaceFacade->recalculateAllPoints();
        return ['result' => 'true'];
    }

    /**
     * @param Request $request
     * @param User $user
     * @return array
     */
    public function updatePoints(Request $request, User $user)
    {
        $this->spaceFacade->recalculateAllPoints();
        return ['result' => 'true'];
    }

    /**
     * @param Request $request
     * @param User $user
     * @param Space $space
     * @return array
     */
    public function active(Request $request, User $user, Space $space)
    {
        $this->spaceFacade->activeSpace($space, true);
        return ['result' => 'true'];
    }

    /**
     * @param Request $request
     * @param User $user
     * @param Space $space
     * @return array
     */
    public function inactive(Request $request, User $user, Space $space)
    {
        $this->spaceFacade->activeSpace($space, false);
        return ['result' => 'true'];
    }

    /**
     * @param Request $request
     * @param User $user
     * @param Space $space
     * @return array
     */
    public function enable(Request $request, User $user, Space $space)
    {
        $this->spaceFacade->activeSpace($space, $request->get('active'), $request->get('option'));
        return ['success' => 'true'];
    }


    /**
     * @param Request $request
     * @param User $user
     * @param Space $space
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, User $user, Space $space)
    {
        $this->spaceFacade->deleteSpace($space);
        return ['success' => 'true'];
        //return redirect()->route("medios.espacios.index", $user);
    }

}