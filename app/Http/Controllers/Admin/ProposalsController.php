<?php
/**
 * Created by PhpStorm.
 * User: andrestntx
 * Date: 9/20/16
 * Time: 3:27 PM
 */

namespace App\Http\Controllers\Admin;


use App\Entities\Platform\Space\Space;
use App\Facades\AdvertiserFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Proposal\AddSpaceRequest;
use Illuminate\Http\Request;

class ProposalsController extends Controller
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
     * @param Request $request
     * @return string
     */
    public function index(Request $request)
    {
        return view('admin.proposals.lists');
    }

    /**
     * @return mixed
     */
    public function search()
    {
        return \Datatables::of($this->advertiserFacade->searchProposals())->make(true);
    }

    /**
     * @param AddSpaceRequest $request
     * @param Space $space
     * @return array
     */
    public function add(AddSpaceRequest $request, Space $space)
    {
        //$this->advertiserFacade->
        return ['success' => 'true'];
    }
}