<?php

/**
 * Created by PhpStorm.
 * User: andrestntx
 * Date: 9/20/16
 * Time: 3:27 PM
 */

namespace App\Http\Controllers\Admin;


use App\Entities\Platform\User;
use App\Entities\Proposal\Proposal;
use App\Facades\AdvertiserFacade;
use App\Facades\ProposalFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Quote\StoreRequest;
use Illuminate\Http\Request;

class QuotesController extends Controller
{

    protected $advertiserFacade;
    protected $proposalFacade;

    /**
     * QuotesController constructor.
     * @param AdvertiserFacade $advertiserFacade
     * @param ProposalFacade $proposalFacade
     */
    public function __construct(AdvertiserFacade $advertiserFacade, ProposalFacade $proposalFacade)
    {
        $this->advertiserFacade = $advertiserFacade;
        $this->proposalFacade = $proposalFacade;
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

    /**
     * @param Request $request
     * @param Proposal $proposal
     * @return array
     */
    public function update(Request $request, Proposal $proposal)
    {
        \Log::info($request->all());
        $result = $this->advertiserFacade->updateQuote($proposal->quote, $request->all(), $request->get('questions'));
        \Log::info($result['quote']->cities);
        return array_merge($result, ['success' => 'true']);
    }
}