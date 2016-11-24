<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 12/07/2016
 * Time: 6:22 PM
 */

namespace App\Repositories\File;

use App\Entities\Platform\User;
use App\Entities\Proposal\Proposal;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

class ProposalsRepository extends BaseRepository
{
    protected $path = "files/proposals";

    /**
     * @param Proposal $proposal
     * @return string
     */
    public function generateNameFile(Proposal $proposal)
    {
        return $proposal->id . '-' . Carbon::now()->getTimestamp() . '.pdf';
    }

    public function generateUrl(Proposal $proposal)
    {
        return $this->path . '/' . $this->generateNameFile($proposal);
    }


    /**
     * @param Proposal $proposal
     * @return string
     */
    public function generatePdf(Proposal $proposal)
    {
        $url = $this->generateUrl($proposal);

        \PDF::loadView('admin.proposals.preview.pdf', [
            'proposal'      => $proposal,
            'advertiser'    => $proposal->getViewAdvertiser()
        ])->setPaper('a4')->save($url);

        return '/' . $url;
    }
}