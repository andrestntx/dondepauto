<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 18/05/2016
 * Time: 4:29 PM
 */

namespace App\Facades;


use App\Services\ProposalService;

class ProposalFacade
{
    private $service;

    /**
     * ProposalFacade constructor.
     * @param ProposalService $service
     */
    public function __construct(ProposalService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search()
    {
        return $this->service->search();
    }
}