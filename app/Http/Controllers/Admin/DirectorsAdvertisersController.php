<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 27/04/2016
 * Time: 7:07 PM
 */

namespace App\Http\Controllers\Admin;


use App\Entities\User;
use App\Facades\AdvertiserFacade;
use App\Http\Controllers\ResourceController;
use Illuminate\Http\Request;

class DirectorsAdvertisersController extends ResourceController
{
    protected $facade;

    /**
     * [$routePrefix prefix route in more one response view]
     * @var string
     */
    protected $routePrefix = 'asesores.anunciantes';
    /**
     * [$viewPath folder views Controller]
     * @var string
     */
    protected $viewPath = 'admin.advisers';

    /**
     * AdvertisersController constructor.
     * @param AdvertiserFacade $facade
     */
    function __construct(AdvertiserFacade $facade)
    {
        $this->facade = $facade;
    }

    /**
     * Display a listing of the resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $this->authorize('advertisers', $user);
        $urlSearch = '/directores/' . $user->id . '/anunciantes/search';
        return $this->view('advertisers', [
            'adviser' => $user,
            'urlSearch' => $urlSearch
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, User $user)
    {
        $this->authorize('advertisers', $user);
        return ['data' => $this->facade->search($user)];
    }
}