<?php

/**
 * Created by PhpStorm.
 * User: andrestntx
 * Date: 9/20/16
 * Time: 3:27 PM
 */

namespace App\Http\Controllers\Admin;


use App\Entities\Platform\User;
use App\Facades\AdvertiserFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Quote\StoreRequest;

class QuotesController extends Controller
{

    protected $advertiserFacade;

    /**
     * QuotesController constructor.
     * @param AdvertiserFacade $advertiserFacade
     */
    public function __construct(AdvertiserFacade $advertiserFacade)
    {
        $this->advertiserFacade = $advertiserFacade;
    }

    /**
     * @param StoreRequest $request
     * @param User $advertiser
     * @return array
     */
    public function store(StoreRequest $request, User $advertiser)
    {
        $result = $this->advertiserFacade->createQuote($advertiser, $request->all(), $request->get('questions'), $request->get('action_date'), $request->get('contact_type'));
        return array_merge($result, ['success' => 'true']);
    }
}