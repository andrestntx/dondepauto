<?php
/**
 * Created by PhpStorm.
 * User: andrestntx
 * Date: 11/1/16
 * Time: 2:48 PM
 */

namespace App\Http\Controllers\Admin;


use App\Entities\Platform\Space\Space;
use App\Entities\Proposal\Proposal;
use App\Facades\ProposalFacade;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProposalSpacesController extends Controller
{
    protected $proposalFacade;

    /**
     * ProposalSpacesController constructor.
     * @param $proposalFacade
     */
    public function __construct(ProposalFacade $proposalFacade)
    {
        $this->proposalFacade = $proposalFacade;
    }

    public function edit(Proposal $proposal, Space $space)
    {
        $space->load('format.subCategory.formats');

        return view('admin.proposals.spaces.form')->with([
            'publisher'     => $space->publisher,
            'space'         => $space,
            'proposal'      => $proposal,
            'spaceFormats'  => $space->format->subCategory->formats->lists('name', 'id')->all(),
            'route'         => ['medios.espacios.update', $space->publisher, $space],
            'type'          => 'POST'
        ]);
    }


    /**
     * @param Request $request
     * @param Proposal $proposal
     * @param Space $space
     * @return \Illuminate\Auth\Access\Response
     */
    public function postDuplicate(Request $request, Proposal $proposal, Space $space)
    {
        try {
            $space = $this->proposalFacade->duplicateSpace($request->all(), $request->file('images'), $request->get('keep_images'), $proposal, $space);
        } catch (Exception $e) {
            \Log::info($e);
            return ['result' => 'false', 'route' => route('home')];
        }

        return ['result' => 'true'];
    }
}