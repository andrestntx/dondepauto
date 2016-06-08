<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 25/05/2016
 * Time: 6:09 PM
 */

namespace App\Http\Controllers\Auth;

use App\Facades\PublisherFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\RUser\Publisher\RegisterLandingRequest;

class PublisherController extends Controller
{
    protected $publisherFacade;

    /**
     * Create a new authentication controller instance.
     *
     * @param PublisherFacade $publisherFacade
     */
    public function __construct(PublisherFacade $publisherFacade)
    {
        $this->publisherFacade = $publisherFacade;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param RegisterLandingRequest $request
     * @return \Illuminate\Http\Response
     */
    public function registerLanding(RegisterLandingRequest $request)
    {
        return $this->publisherFacade->registerAutoPassword($request->all());
    }
}